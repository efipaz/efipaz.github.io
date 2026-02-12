/**
 * Dynamic Gallery Loader
 * Automatically displays galleries from galleries/manifest.json
 * Efi uploads a folder with images -> gallery appears automatically
 *
 * Usage: Add <div id="galleries-container"></div> to your page
 * For a specific gallery: <div id="gallery-container" data-gallery="gallery-name"></div>
 */

(function() {
  'use strict';

  const GALLERIES_LIST_ID = 'galleries-container';
  const GALLERY_VIEW_ID = 'gallery-container';

  // Detect if we're in a subdirectory
  const pathParts = window.location.pathname.split('/');
  const isSubdir = pathParts.includes('en') || pathParts.includes('galleries');
  const basePath = isSubdir ? '../' : '';
  const MANIFEST_URL = basePath + 'galleries/manifest.json';

  // Detect language
  const isEnglish = document.documentElement.lang === 'en';

  document.addEventListener('DOMContentLoaded', function() {
    // Check for galleries list container
    const listContainer = document.getElementById(GALLERIES_LIST_ID);
    if (listContainer) {
      loadGalleriesList(listContainer);
    }

    // Check for single gallery view
    const galleryContainer = document.getElementById(GALLERY_VIEW_ID);
    if (galleryContainer) {
      const galleryId = galleryContainer.dataset.gallery;
      if (galleryId) {
        loadGallery(galleryContainer, galleryId);
      }
    }
  });

  async function loadGalleriesList(container) {
    try {
      const response = await fetch(MANIFEST_URL);
      if (!response.ok) {
        console.warn('No galleries manifest found');
        return;
      }

      const manifest = await response.json();
      if (!manifest.galleries || manifest.galleries.length === 0) {
        return;
      }

      container.innerHTML = '';

      const grid = document.createElement('div');
      grid.className = 'cards';

      manifest.galleries.forEach(gallery => {
        grid.appendChild(createGalleryCard(gallery));
      });

      container.appendChild(grid);

    } catch (error) {
      console.warn('Could not load galleries:', error);
    }
  }

  function createGalleryCard(gallery) {
    const card = document.createElement('a');
    card.href = basePath + 'galleries/' + gallery.id + '/index.html';
    card.className = 'card card--with-image';

    const coverSrc = gallery.cover ? basePath + gallery.cover : '';
    const imageCount = isEnglish ? `${gallery.totalImages} photos` : `${gallery.totalImages} תמונות`;

    card.innerHTML = `
      <div class="card__image">
        ${coverSrc ? `<img src="${coverSrc}" alt="${gallery.name}" loading="lazy">` : ''}
      </div>
      <div class="card__content">
        <h3 class="card__title">${gallery.name}</h3>
        <p class="card__text">${gallery.description || ''}</p>
        <span class="card__link">${imageCount}</span>
      </div>
    `;

    return card;
  }

  async function loadGallery(container, galleryId) {
    try {
      const response = await fetch(MANIFEST_URL);
      if (!response.ok) return;

      const manifest = await response.json();
      const gallery = manifest.galleries.find(g => g.id === galleryId);

      if (!gallery) {
        console.warn('Gallery not found:', galleryId);
        return;
      }

      container.innerHTML = '';

      // If gallery has categories, show them
      if (gallery.categories && gallery.categories.length > 0) {
        gallery.categories.forEach(category => {
          if (category.images && category.images.length > 0) {
            // Category title
            const title = document.createElement('h3');
            title.className = 'gallery-category-title';
            title.textContent = category.name;
            container.appendChild(title);

            // Images grid
            const grid = document.createElement('div');
            grid.className = 'gallery gallery--full';

            category.images.forEach(img => {
              const imgPath = basePath + 'galleries/' + galleryId + '/' + category.name + '/' + img;
              grid.appendChild(createGalleryImage(imgPath, img));
            });

            container.appendChild(grid);
          }
        });
      }

    } catch (error) {
      console.warn('Could not load gallery:', error);
    }
  }

  function createGalleryImage(src, alt) {
    const link = document.createElement('a');
    link.href = src;
    link.className = 'gallery__item';

    link.innerHTML = `<img src="${src}" alt="${alt}" loading="lazy">`;

    return link;
  }
})();
