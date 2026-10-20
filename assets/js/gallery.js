/**
 * גלריית תמונות עם Lightbox
 * Efi Paz - efipaz.com
 *
 * - Lightbox לתמונות ולסרטונים (.gallery__item עם href לקובץ המלא)
 * - ניווט במקלדת (חצים לפי כיוון המסך, ESC), החלקה במובייל, כפתורים
 * - קיפול קטגוריות (.gallery-section)
 * - אין תלות בספריות; תמונות נטענות עם loading="lazy" של הדפדפן
 */
(function () {
  'use strict';

  var items = [];      // [{src, type: 'image'|'video', alt}]
  var index = 0;
  var box = null;
  var opener = null;
  var touchStartX = 0;
  var rtl = (document.documentElement.getAttribute('dir') || 'rtl') === 'rtl';
  var he = (document.documentElement.lang || 'he') === 'he';
  var T = he
    ? { close: 'סגור', prev: 'הקודם', next: 'הבא', hint: 'החלק לניווט', error: 'התמונה לא נטענה', open: 'פתח בחלון חדש' }
    : { close: 'Close', prev: 'Previous', next: 'Next', hint: 'Swipe to navigate', error: 'Image failed to load', open: 'Open in new tab' };

  function create() {
    if (box) return;
    box = document.createElement('div');
    box.className = 'lightbox';
    box.setAttribute('role', 'dialog');
    box.setAttribute('aria-modal', 'true');
    box.setAttribute('aria-label', he ? 'תצוגת תמונה' : 'Image viewer');
    box.innerHTML =
      '<div class="lightbox__content">' +
      '  <img class="lightbox__img" src="" alt="">' +
      '  <video class="lightbox__video" controls playsinline hidden></video>' +
      '  <div class="lightbox__loader"></div>' +
      '  <p class="lightbox__error" hidden></p>' +
      '</div>' +
      '<button type="button" class="lightbox__close" aria-label="' + T.close + '"></button>' +
      '<button type="button" class="lightbox__prev" aria-label="' + T.prev + '"></button>' +
      '<button type="button" class="lightbox__next" aria-label="' + T.next + '"></button>' +
      '<div class="lightbox__counter" aria-live="polite"></div>' +
      '<a class="lightbox__open" href="#" target="_blank" rel="noopener">' + T.open + '</a>' +
      '<div class="lightbox__swipe-hint">' + T.hint + '</div>';
    document.body.appendChild(box);

    box.querySelector('.lightbox__close').addEventListener('click', close);
    // on-screen buttons are placed physically: ‹ on the left, › on the right.
    // In RTL "next" is to the left, so the left button advances.
    box.querySelector('.lightbox__prev').addEventListener('click', rtl ? next : prev);
    box.querySelector('.lightbox__next').addEventListener('click', rtl ? prev : next);
    box.addEventListener('click', function (e) { if (e.target === box) close(); });
    box.addEventListener('touchstart', function (e) { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
    box.addEventListener('touchend', function (e) {
      var diff = touchStartX - e.changedTouches[0].screenX;
      if (Math.abs(diff) < 50) return;
      // swiping toward the start of the reading direction goes forward
      if (diff > 0) { rtl ? prev() : next(); } else { rtl ? next() : prev(); }
    }, { passive: true });
    document.addEventListener('keydown', onKey);
  }

  function open(list, i) {
    create();
    opener = document.activeElement;
    items = list;
    index = i;
    show();
    box.classList.add('is-active');
    document.body.style.overflow = 'hidden';
    box.querySelector('.lightbox__close').focus();
  }

  function close() {
    if (!box) return;
    box.classList.remove('is-active');
    document.body.style.overflow = '';
    if (opener && opener.focus) { opener.focus(); }
    opener = null;
    var v = box.querySelector('.lightbox__video');
    v.pause();
    v.removeAttribute('src');
  }

  function show() {
    var it = items[index];
    var img = box.querySelector('.lightbox__img');
    var vid = box.querySelector('.lightbox__video');
    var loader = box.querySelector('.lightbox__loader');
    var err = box.querySelector('.lightbox__error');
    err.hidden = true;
    box.querySelector('.lightbox__counter').textContent = (index + 1) + ' / ' + items.length;
    box.querySelector('.lightbox__open').href = it.src;
    var single = items.length < 2;
    box.querySelector('.lightbox__prev').hidden = single;
    box.querySelector('.lightbox__next').hidden = single;

    if (it.type === 'video') {
      img.hidden = true;
      img.removeAttribute('src');
      loader.hidden = true;
      vid.hidden = false;
      vid.src = it.src;
      vid.play().catch(function () {});
      return;
    }
    vid.pause();
    vid.hidden = true;
    vid.removeAttribute('src');
    img.hidden = false;
    img.classList.remove('loaded');
    loader.hidden = false;
    img.alt = it.alt || '';
    img.onload = function () { img.classList.add('loaded'); loader.hidden = true; };
    img.onerror = function () { loader.hidden = true; err.textContent = T.error; err.hidden = false; };
    img.src = it.src;
  }

  function prev() { index = (index - 1 + items.length) % items.length; show(); }
  function next() { index = (index + 1) % items.length; show(); }

  function onKey(e) {
    if (!box || !box.classList.contains('is-active')) return;
    if (e.key === 'Tab') {
      var f = box.querySelectorAll('button:not([hidden]), a[href], video:not([hidden])');
      if (!f.length) return;
      var first = f[0], last = f[f.length - 1];
      if (e.shiftKey && document.activeElement === first) { e.preventDefault(); last.focus(); }
      else if (!e.shiftKey && document.activeElement === last) { e.preventDefault(); first.focus(); }
      return;
    }
    if (e.key === 'Escape') close();
    else if (e.key === 'ArrowLeft') { rtl ? next() : prev(); }
    else if (e.key === 'ArrowRight') { rtl ? prev() : next(); }
  }

  function isVideo(url) { return /\.(mp4|m4v|webm|mov)(\?.*)?$/i.test(url); }

  function initGallery() {
    var all = document.querySelectorAll('.gallery__item');
    Array.prototype.forEach.call(all, function (item) {
      item.addEventListener('click', function (e) {
        var gallery = item.closest('.gallery, .gallery--full, .gallery-section__content');
        var nodes = gallery ? gallery.querySelectorAll('.gallery__item') : all;
        var list = [];
        var clicked = 0;
        Array.prototype.forEach.call(nodes, function (el) {
          var img = el.querySelector('img');
          var src = el.getAttribute('href') || (img && img.getAttribute('src'));
          if (!src) return;
          if (el === item) clicked = list.length;
          list.push({ src: el.href || src, type: isVideo(src) ? 'video' : 'image', alt: img ? img.alt : '' });
        });
        if (!list.length) return;
        e.preventDefault();
        open(list, clicked);
      });
    });
  }

  function initCollapsible() {
    Array.prototype.forEach.call(document.querySelectorAll('.gallery-section'), function (section) {
      var header = section.querySelector('.gallery-section__header');
      if (!header) return;
      header.setAttribute('role', 'button');
      header.setAttribute('tabindex', '0');
      var toggle = function () {
        section.classList.toggle('is-collapsed');
        header.setAttribute('aria-expanded', section.classList.contains('is-collapsed') ? 'false' : 'true');
      };
      header.addEventListener('click', toggle);
      header.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); } });
    });
  }

  function initRecordings() {
    // archive.org players load only on request (iframes are heavy)
    Array.prototype.forEach.call(document.querySelectorAll('.recording__play'), function (btn) {
      btn.addEventListener('click', function () {
        var card = btn.closest('.recording');
        var holder = card && card.querySelector('.recording__player');
        var src = card && card.getAttribute('data-embed');
        if (!holder || !src || !/^https:\/\/archive\.org\/embed\//.test(src)) return;
        if (!holder.firstChild) {
          var f = document.createElement('iframe');
          f.src = src + '?playlist=1&list_height=540';
          f.setAttribute('allowfullscreen', '');
          f.setAttribute('loading', 'lazy');
          f.title = card.querySelector('.card__title').textContent;
          holder.appendChild(f);
        }
        btn.hidden = true;
      });
    });
  }

  function init() { initGallery(); initCollapsible(); initRecordings(); }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();
})();
