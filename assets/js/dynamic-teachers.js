/**
 * Dynamic Teachers Loader
 * Automatically displays teacher cards from teachers/manifest.json
 * Efi creates a folder with info.json + portrait → teacher card appears
 *
 * Convention: Only directories with info.json are processed.
 * Existing teachers (krishnamurti, watts, demello) keep their static HTML.
 *
 * Graceful degradation: if manifest is missing or corrupt,
 * nothing happens - existing static content remains untouched.
 */

(function() {
  'use strict';

  var CONTAINER_ID = 'dynamic-teachers';

  // Detect if we're in a subdirectory (like en/)
  var isSubdir = window.location.pathname.includes('/en/');
  var basePath = isSubdir ? '../' : '';
  var MANIFEST_URL = basePath + 'teachers/manifest.json';

  // Detect language from HTML lang attribute
  var isEnglish = document.documentElement.lang === 'en';

  document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById(CONTAINER_ID);
    if (!container) return;

    loadTeachers(container);
  });

  async function loadTeachers(container) {
    try {
      var response = await fetch(MANIFEST_URL);
      if (!response.ok) return;

      var manifest = await response.json();
      if (!manifest.teachers || manifest.teachers.length === 0) return;

      manifest.teachers.forEach(function(teacher) {
        container.appendChild(createTeacherCard(teacher));
      });

    } catch (error) {
      console.warn('Could not load teachers manifest:', error);
    }
  }

  function createTeacherCard(teacher) {
    var card = document.createElement('div');
    card.className = 'person-card mb-4';
    if (teacher.id) {
      card.id = teacher.id;
    }

    var html = '';

    // Portrait image
    html += '<div class="person-card__image">';
    if (teacher.portrait) {
      html += '<img src="' + basePath + teacher.portrait + '" alt="' + teacher.name + '">';
    }
    html += '</div>';

    // Content
    html += '<div>';
    var displayName = (isEnglish && teacher.name_en) ? teacher.name_en : teacher.name;
    html += '<h3 class="person-card__name">' + displayName + '</h3>';

    if (teacher.dates || teacher.role) {
      var meta = [];
      if (teacher.dates) meta.push(teacher.dates);
      if (teacher.role) meta.push(teacher.role);
      html += '<p class="person-card__dates">' + meta.join(' | ') + '</p>';
    }

    if (teacher.bio) {
      html += '<p class="person-card__bio">' + teacher.bio + '</p>';
    }

    if (teacher.link) {
      var linkText = isEnglish ? 'View content' : 'לתכנים';
      html += '<a href="' + basePath + teacher.link + '" class="btn mt-2">' + linkText + '</a>';
    }

    html += '</div>';

    card.innerHTML = html;
    return card;
  }
})();
