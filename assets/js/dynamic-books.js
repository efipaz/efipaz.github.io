/**
 * Dynamic Books Loader
 * Automatically displays books from books/manifest.json
 * No manual HTML editing needed - just upload files to books/
 * Supports both Hebrew (root) and English (en/) pages
 */

(function() {
  'use strict';

  const BOOKS_CONTAINER_ID = 'books-container';

  // Detect if we're in a subdirectory (like en/)
  const isSubdir = window.location.pathname.includes('/en/');
  const basePath = isSubdir ? '../' : '';
  const MANIFEST_URL = basePath + 'books/manifest.json';

  // Detect language from HTML lang attribute
  const isEnglish = document.documentElement.lang === 'en';

  // Load and display books when DOM is ready
  document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById(BOOKS_CONTAINER_ID);
    if (!container) return;

    loadBooks(container);
  });

  async function loadBooks(container) {
    try {
      const response = await fetch(MANIFEST_URL);
      if (!response.ok) {
        console.warn('No books manifest found, using static content');
        return;
      }

      const manifest = await response.json();
      if (!manifest.books || manifest.books.length === 0) {
        return;
      }

      // Replace container content with dynamic books
      container.innerHTML = '';

      manifest.books.forEach(book => {
        container.appendChild(createBookCard(book));
      });

    } catch (error) {
      console.warn('Could not load books manifest:', error);
      // Keep existing static content as fallback
    }
  }

  function createBookCard(book) {
    const card = document.createElement('a');
    // Adjust path for subdirectory
    card.href = basePath + book.path;
    card.className = book.cover ? 'card card--with-image' : 'card';

    let html = '';

    if (book.cover) {
      html += `
        <div class="card__image">
          <img src="${basePath}${book.cover}" alt="${book.title}" loading="lazy">
        </div>
      `;
    }

    // Use appropriate language for link text
    const linkText = isEnglish ? `Read (${book.type})` : `לספר (${book.type})`;

    html += `
      <div class="card__content">
        <h3 class="card__title">${book.title}</h3>
        <p class="card__text">${book.description || ''}</p>
        <span class="card__link">${linkText}</span>
      </div>
    `;

    card.innerHTML = html;
    return card;
  }
})();
