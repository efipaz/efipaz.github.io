/**
 * Dynamic Books Loader
 * Automatically displays books from books/manifest.json
 * No manual HTML editing needed - just upload files to books/
 */

(function() {
  'use strict';

  const MANIFEST_URL = 'books/manifest.json';
  const BOOKS_CONTAINER_ID = 'books-container';

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
      // Container already has class="cards", just replace inner content
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
    card.href = book.path;
    card.className = book.cover ? 'card card--with-image' : 'card';

    let html = '';

    if (book.cover) {
      html += `
        <div class="card__image">
          <img src="${book.cover}" alt="${book.title}" loading="lazy">
        </div>
      `;
    }

    html += `
      <div class="card__content">
        <h3 class="card__title">${book.title}</h3>
        <p class="card__text">${book.description || ''}</p>
        <span class="card__link">לספר (${book.type})</span>
      </div>
    `;

    card.innerHTML = html;
    return card;
  }
})();
