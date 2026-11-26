/*
 * Toggle tema terang/gelap untuk storefront dan panel admin.
 * Pilihan disimpan di localStorage ("theme"); jika belum ada, ikut preferensi OS.
 */
(function () {
  'use strict';

  var KEY = 'theme';
  var root = document.documentElement;

  function stored() {
    try {
      var value = localStorage.getItem(KEY);
      return value === 'dark' || value === 'light' ? value : null;
    } catch (e) {
      return null;
    }
  }

  function preferred() {
    var value = stored();
    if (value) {
      return value;
    }
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }

  function paint(mode) {
    root.setAttribute('data-bs-theme', mode);

    var buttons = document.querySelectorAll('.js-theme-toggle');
    for (var i = 0; i < buttons.length; i++) {
      var button = buttons[i];
      var icon = button.querySelector('i');
      if (icon) {
        icon.className = 'fa ' + (mode === 'dark' ? 'fa-sun' : 'fa-moon');
      }
      button.setAttribute('aria-label', mode === 'dark' ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
      button.setAttribute('title', mode === 'dark' ? 'Mode terang' : 'Mode gelap');
      button.setAttribute('aria-pressed', mode === 'dark' ? 'true' : 'false');
    }
  }

  function apply(mode) {
    try {
      localStorage.setItem(KEY, mode);
    } catch (e) {
      /* localStorage bisa diblokir; tema tetap berlaku untuk sesi ini */
    }
    paint(mode);
  }

  window.tokoTheme = {
    get: function () {
      return root.getAttribute('data-bs-theme') === 'dark' ? 'dark' : 'light';
    },
    set: apply,
    toggle: function () {
      apply(window.tokoTheme.get() === 'dark' ? 'light' : 'dark');
    }
  };

  paint(preferred());

  function bind() {
    var buttons = document.querySelectorAll('.js-theme-toggle');
    for (var i = 0; i < buttons.length; i++) {
      buttons[i].addEventListener('click', function (event) {
        event.preventDefault();
        window.tokoTheme.toggle();
      });
    }
    paint(window.tokoTheme.get());
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bind);
  } else {
    bind();
  }
})();
