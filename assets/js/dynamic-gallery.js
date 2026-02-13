/**
 * Dynamic Gallery Loader
 * Automatically displays new travel galleries from travel/gallery-manifest.json
 * Efi uploads a folder with images + info.txt → gallery card appears on travel.html
 *
 * Convention: Only galleries with info.txt are processed.
 * Existing galleries (india, myanmar, japan) are not affected.
 *
 * Graceful degradation: if manifest is missing or corrupt,
 * nothing happens - existing static content remains untouched.
 */

(function() {
  'use strict';

  var CONTAINER_ID = 'dynamic-galleries';

  // Detect if we're in a subdirectory (like en/)
  var isSubdir = window.location.pathname.includes('/en/');
  var basePath = isSubdir ? '../' : '';
  var MANIFEST_URL = basePath + 'travel/gallery-manifest.json';

  // Detect language from HTML lang attribute
  var isEnglish = document.documentElement.lang === 'en';

  document.addEventListener('DOMContentLoaded', function() {
    var container = document.getElementById(CONTAINER_ID);
    if (!container) return;

    loadGalleries(container);
  });

  async function loadGalleries(container) {
    try {
      var response = await fetch(MANIFEST_URL);
      if (!response.ok) return;

      var manifest = await response.json();
      if (!manifest.galleries || manifest.galleries.length === 0) return;

      manifest.galleries.forEach(function(gallery) {
        container.appendChild(createGalleryCard(gallery));
      });

    } catch (error) {
      console.warn('Could not load gallery manifest:', error);
    }
  }

  function createGalleryCard(gallery) {
    var card = document.createElement('a');
    card.href = basePath + 'travel/' + encodeURIComponent(gallery.id) + '/index.html';
    card.className = 'card';

    var countText = gallery.imageCount + ' צילומים';
    var description = gallery.description || countText;

    var html = '';
    if (gallery.cover) {
      html += '<div class="card__image">';
      html += '<img src="' + basePath + gallery.cover + '" alt="' + gallery.title + '" loading="lazy">';
      html += '</div>';
    }

    html += '<div class="card__content">';
    html += '<h3 class="card__title">' + gallery.title + '</h3>';
    html += '<p class="card__text">' + description + '</p>';
    var linkText = isEnglish ? 'View gallery' : 'לגלריה';
    html += '<span class="card__link">' + linkText + '</span>';
    html += '</div>';

    card.innerHTML = html;
    return card;
  }
})();
