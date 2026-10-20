/**
 * PDF viewer for efipaz.com — pdf.js 4.x (pinned, jsDelivr) with a plain fallback.
 *
 * URL: viewer.html?file=<site-relative path to a .pdf>
 * Pages are laid out at their real size, drawn only while near the viewport and released
 * when far away, so a 200-page book works on a phone. If pdf.js cannot load, an <iframe>
 * fallback shows the file with the browser's own viewer.
 *
 * pdf.js 3.x mangled the embedded Hebrew fonts of the old Word-generated books; 4.x renders them correctly.
 */
(function () {
  'use strict';

  var PDFJS_VERSION = '4.10.38';
  var CDN = 'https://cdn.jsdelivr.net/npm/pdfjs-dist@' + PDFJS_VERSION + '/';
  var base = window.VIEWER_BASE || '';
  var he = (window.VIEWER_LANG || 'he') === 'he';
  var T = he
    ? { bad: 'לא נמצא קובץ להצגה.', fail: 'לא הצלחתי להציג את הקובץ כאן. אפשר להוריד אותו או לפתוח בחלון חדש.', page: 'עמוד', loading: 'טוען…', dl: 'להורדת הקובץ (PDF)', open: 'פתיחה בחלון חדש', end: 'סוף הקובץ' }
    : { bad: 'No file to show.', fail: 'The file could not be displayed here. You can download it or open it in a new tab.', page: 'Page', loading: 'Loading…', dl: 'Download the file (PDF)', open: 'Open in a new tab', end: 'End of file' };

  var pagesEl = document.getElementById('pages');
  var titleEl = document.getElementById('title');
  var pageEl = document.getElementById('page');
  var bar = document.querySelector('.viewer__bar');

  function msg(text) { pagesEl.innerHTML = ''; var p = document.createElement('p'); p.className = 'viewer__msg'; p.textContent = text; pagesEl.appendChild(p); }

  // --- validate the requested file: same site, relative, a PDF, no path tricks
  var file = new URLSearchParams(location.search).get('file') || '';  // already decoded once
  var segs = file.split('/');
  var ok = file && /\.pdf$/i.test(file) && segs.indexOf('..') === -1 && segs.indexOf('') === -1 &&
    file.indexOf(':') === -1 && file.indexOf('\\') === -1;
  if (!ok) { bar.setAttribute('data-empty', '1'); msg(T.bad); return; }

  var url = base + file.split('/').map(encodeURIComponent).join('/');
  var name = file.split('/').pop().replace(/\.pdf$/i, '').replace(/_/g, ' ');
  titleEl.textContent = name;
  document.title = name + ' | ' + (he ? 'אפי פז' : 'Efi Paz');
  // Every file keeps a download link, but not in the toolbar: it sits under the last page (and in the fallback).
  function links(label) {
    var row = document.createElement('p'); row.className = 'viewer__end';
    if (label) { var l = document.createElement('span'); l.textContent = label + ' · '; row.appendChild(l); }
    var dl = document.createElement('a'); dl.href = url; dl.setAttribute('download', file.split('/').pop()); dl.textContent = T.dl; row.appendChild(dl);
    row.appendChild(document.createTextNode(' · '));
    var op = document.createElement('a'); op.href = url; op.target = '_blank'; op.rel = 'noopener'; op.textContent = T.open; row.appendChild(op);
    return row;
  }

  function fallback() {
    pagesEl.innerHTML = '';
    var p = document.createElement('p'); p.className = 'viewer__msg'; p.textContent = T.fail; pagesEl.appendChild(p);
    pagesEl.appendChild(links(''));
    var f = document.createElement('iframe'); f.className = 'viewer__fallback'; f.src = url; f.title = name; pagesEl.appendChild(f);
  }

  // --- load pdf.js (ES module build)
  var pdfjsLib = null;
  try {
    (new Function('u', 'return import(u)'))(CDN + 'build/pdf.min.mjs').then(function (mod) {
      pdfjsLib = mod;
      pdfjsLib.GlobalWorkerOptions.workerSrc = CDN + 'build/pdf.worker.min.mjs';
      var task = pdfjsLib.getDocument({ url: url, cMapUrl: CDN + 'cmaps/', cMapPacked: true, standardFontDataUrl: CDN + 'standard_fonts/', disableFontFace: true });
      task.onProgress = function (p) {  // big books on a slow phone: show that something is happening
        if (p.total) { var m = pagesEl.querySelector('.viewer__msg'); if (m) m.textContent = T.loading + ' ' + Math.min(99, Math.round(p.loaded / p.total * 100)) + '%'; }
      };
      return task.promise;
    }).then(render, fallback);
  } catch (e) { fallback(); }

  // --- layout + lazy rendering
  var pdf = null;
  var observer = null;
  // Zoom is the browser's own (pinch / Ctrl+wheel). Pages are re-drawn at the zoomed resolution so they stay sharp.
  function dpr() {
    var z = (window.visualViewport && window.visualViewport.scale) || 1;
    // phones keep a lower cap: canvas memory on iOS is limited and 4-8 pages stay drawn
    return Math.min((window.devicePixelRatio || 1) * z, window.innerWidth < 700 ? 2 : 3);
  }
  var VISIBLE_MARGIN = '150% 0px';  // render pages within 1.5 screens of the viewport, release the rest

  function render(doc) {
    pdf = doc;
    pagesEl.innerHTML = '';
    pdf.getPage(1).then(function (p1) {
      var vp1 = p1.getViewport({ scale: 1 });
      var ratio = vp1.height / vp1.width;
      for (var i = 1; i <= pdf.numPages; i++) {
        var c = document.createElement('canvas');
        c.className = 'viewer__canvas';
        c.setAttribute('data-page', i);
        c.setAttribute('aria-label', T.page + ' ' + i);
        c.dataset.ratio = ratio;
        pagesEl.appendChild(c);
      }
      pagesEl.appendChild(links(T.end));
      layout();
      observer = new IntersectionObserver(onVisible, { rootMargin: VISIBLE_MARGIN });
      Array.prototype.forEach.call(pagesEl.querySelectorAll('canvas'), function (c) { observer.observe(c); });
      pagesEl.addEventListener('scroll', updateCounter, { passive: true });
      window.addEventListener('scroll', updateCounter, { passive: true });
      var t;
      window.addEventListener('resize', function () { clearTimeout(t); t = setTimeout(relayout, 200); });
      if (window.visualViewport) window.visualViewport.addEventListener('resize', function () { clearTimeout(t); t = setTimeout(relayout, 300); });
      updateCounter();
    }, fallback);
  }

  function columnWidth() { return Math.min(pagesEl.clientWidth - 24, 900); }

  function layout() {
    var width = columnWidth();
    Array.prototype.forEach.call(pagesEl.querySelectorAll('canvas'), function (c) {
      c.style.width = Math.floor(width) + 'px';
      c.style.height = Math.floor(width * parseFloat(c.dataset.ratio || 1.4)) + 'px';
    });
  }

  function relayout() {
    layout();
    Array.prototype.forEach.call(pagesEl.querySelectorAll('canvas'), function (c) {
      c.dataset.drawnWidth = '';
      if (c.dataset.visible === '1') draw(c);
    });
  }

  function onVisible(entries) {
    entries.forEach(function (en) {
      var c = en.target;
      if (en.isIntersecting) { c.dataset.visible = '1'; draw(c); }
      else { c.dataset.visible = ''; release(c); }
    });
  }

  function release(c) {
    if (c.width) { c.width = 0; c.height = 0; c.dataset.drawnWidth = ''; }
  }

  function draw(canvas) {
    if (!pdf || canvas.dataset.rendering === '1') return;
    var width = columnWidth();
    var ratio = dpr();
    if (canvas.dataset.drawnWidth === String(Math.floor(width)) && canvas.dataset.drawnDpr === String(ratio) && canvas.width) return;
    canvas.dataset.rendering = '1';
    pdf.getPage(parseInt(canvas.getAttribute('data-page'), 10)).then(function (page) {
      var vp = page.getViewport({ scale: 1 });
      var v = page.getViewport({ scale: width / vp.width });
      canvas.width = Math.floor(v.width * ratio);
      canvas.height = Math.floor(v.height * ratio);
      canvas.style.width = Math.floor(v.width) + 'px';
      canvas.style.height = Math.floor(v.height) + 'px';
      canvas.dataset.ratio = v.height / v.width;
      var ctx = canvas.getContext('2d');
      ctx.setTransform(ratio, 0, 0, ratio, 0, 0);
      return page.render({ canvasContext: ctx, viewport: v }).promise;
    }).then(function () {
      canvas.dataset.drawnWidth = String(Math.floor(width)); canvas.dataset.drawnDpr = String(ratio); canvas.dataset.rendering = ''; updateCounter();
      // zoomed or resized while this page was rendering: draw it again at the current size
      if (canvas.dataset.visible === '1' && (Math.floor(columnWidth()) !== Math.floor(width) || dpr() !== ratio)) draw(canvas);
    },
            function () { canvas.dataset.rendering = ''; });
  }

  function updateCounter() {
    if (!pdf) return;
    var canvases = pagesEl.querySelectorAll('canvas');
    var mid = window.innerHeight / 2;
    var current = 1;
    for (var i = 0; i < canvases.length; i++) {
      var r = canvases[i].getBoundingClientRect();
      if (r.top <= mid) current = i + 1; else break;
    }
    pageEl.textContent = current + ' / ' + pdf.numPages;
  }

})();
