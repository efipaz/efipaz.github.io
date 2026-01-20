/**
 * גלריית תמונות עם Lightbox
 * Efi Paz - efipaz.com
 *
 * תכונות:
 * - Lightbox עם ניווט
 * - תמיכה ב-touch swipe במובייל
 * - מקלדת (חצים, ESC)
 * - קיפול קטגוריות
 *
 * הערה: Lazy loading מתבצע ע"י הדפדפן באמצעות loading="lazy"
 */

(function() {
  'use strict';

  // ===== Lightbox =====
  let currentImages = [];
  let currentIndex = 0;
  let lightboxEl = null;
  let touchStartX = 0;
  let touchEndX = 0;

  function createLightbox() {
    if (lightboxEl) return;

    lightboxEl = document.createElement('div');
    lightboxEl.className = 'lightbox';
    lightboxEl.innerHTML = `
      <div class="lightbox__content">
        <img class="lightbox__img" src="" alt="">
        <div class="lightbox__loader"></div>
      </div>
      <button class="lightbox__close" aria-label="סגור"></button>
      <button class="lightbox__prev" aria-label="קודם"></button>
      <button class="lightbox__next" aria-label="הבא"></button>
      <div class="lightbox__counter"></div>
      <div class="lightbox__swipe-hint">החלק לניווט</div>
    `;

    document.body.appendChild(lightboxEl);

    // אירועים
    lightboxEl.querySelector('.lightbox__close').addEventListener('click', closeLightbox);
    lightboxEl.querySelector('.lightbox__prev').addEventListener('click', showPrev);
    lightboxEl.querySelector('.lightbox__next').addEventListener('click', showNext);
    lightboxEl.addEventListener('click', (e) => {
      if (e.target === lightboxEl) closeLightbox();
    });

    // Touch events למובייל
    lightboxEl.addEventListener('touchstart', handleTouchStart, { passive: true });
    lightboxEl.addEventListener('touchend', handleTouchEnd, { passive: true });

    // מקלדת
    document.addEventListener('keydown', handleKeyboard);
  }

  function openLightbox(images, index) {
    createLightbox();
    currentImages = images;
    currentIndex = index;
    showImage(currentIndex);
    lightboxEl.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox() {
    if (!lightboxEl) return;
    lightboxEl.classList.remove('is-active');
    document.body.style.overflow = '';
  }

  function showImage(index) {
    const img = lightboxEl.querySelector('.lightbox__img');
    const counter = lightboxEl.querySelector('.lightbox__counter');

    img.classList.remove('loaded');
    img.src = currentImages[index];
    img.onload = () => img.classList.add('loaded');

    counter.textContent = `${index + 1} / ${currentImages.length}`;
  }

  function showPrev() {
    currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
    showImage(currentIndex);
  }

  function showNext() {
    currentIndex = (currentIndex + 1) % currentImages.length;
    showImage(currentIndex);
  }

  function handleKeyboard(e) {
    if (!lightboxEl || !lightboxEl.classList.contains('is-active')) return;

    switch (e.key) {
      case 'Escape':
        closeLightbox();
        break;
      case 'ArrowLeft':
        showNext(); // RTL - שמאל = הבא
        break;
      case 'ArrowRight':
        showPrev(); // RTL - ימין = קודם
        break;
    }
  }

  function handleTouchStart(e) {
    touchStartX = e.changedTouches[0].screenX;
  }

  function handleTouchEnd(e) {
    touchEndX = e.changedTouches[0].screenX;
    handleSwipe();
  }

  function handleSwipe() {
    const diff = touchStartX - touchEndX;
    const minSwipe = 50;

    if (Math.abs(diff) > minSwipe) {
      if (diff > 0) {
        showNext();
      } else {
        showPrev();
      }
    }
  }

  // ===== אתחול גלריה =====
  function initGallery() {
    const galleryItems = document.querySelectorAll('.gallery__item');

    galleryItems.forEach((item) => {
      item.addEventListener('click', (e) => {
        e.preventDefault();

        // מצא את כל התמונות בגלריה הנוכחית
        const gallery = item.closest('.gallery, .gallery--full, .gallery-section__content');
        const items = gallery ? gallery.querySelectorAll('.gallery__item') : galleryItems;

        // קבל את ה-URL של התמונות (מה-href או מה-src)
        const images = Array.from(items).map(el =>
          el.href || el.querySelector('img')?.src
        ).filter(Boolean);

        // מצא את האינדקס הנכון
        const clickedIndex = Array.from(items).indexOf(item);

        openLightbox(images, clickedIndex >= 0 ? clickedIndex : 0);
      });
    });
  }

  // ===== קיפול קטגוריות =====
  function initCollapsible() {
    const sections = document.querySelectorAll('.gallery-section');

    sections.forEach(section => {
      const header = section.querySelector('.gallery-section__header');
      if (header) {
        header.addEventListener('click', () => {
          section.classList.toggle('is-collapsed');
        });
      }
    });
  }

  // ===== אתחול =====
  function init() {
    initGallery();
    initCollapsible();
  }

  // הפעל כשהדף מוכן
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
