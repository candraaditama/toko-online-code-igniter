/*
 * Compatibility shim: lets legacy Bootstrap 3 / AdminLTE 2 markup keep working
 * on Bootstrap 5.3 + AdminLTE 4.
 *
 * - data-toggle/target/dismiss/ride/slide/parent -> data-bs-*
 * - glyphicon-* -> Font Awesome 6 (v4 shim names)
 * - legacy alert markup -> Bootstrap 5 dismissible alert
 */
(function () {
  'use strict';

  var ATTRIBUTES = {
    'data-toggle': 'data-bs-toggle',
    'data-target': 'data-bs-target',
    'data-dismiss': 'data-bs-dismiss',
    'data-ride': 'data-bs-ride',
    'data-slide': 'data-bs-slide',
    'data-slide-to': 'data-bs-slide-to',
    'data-parent': 'data-bs-parent',
    'data-interval': 'data-bs-interval',
    'data-keyboard': 'data-bs-keyboard',
    'data-backdrop': 'data-bs-backdrop',
    'data-focus': 'data-bs-focus'
  };

  var GLYPHICONS = {
    'chevron-right': 'fa-chevron-right',
    'chevron-left': 'fa-chevron-left',
    'chevron-up': 'fa-chevron-up',
    'chevron-down': 'fa-chevron-down',
    'th-list': 'fa-list',
    'list': 'fa-list',
    'share': 'fa-share',
    'quote': 'fa-quote-left',
    'picture': 'fa-image',
    'pencil': 'fa-pen',
    'indent-right': 'fa-indent',
    'indent-left': 'fa-outdent',
    'font': 'fa-font',
    'user': 'fa-user',
    'star': 'fa-star',
    'lock': 'fa-lock',
    'arrow-right': 'fa-arrow-right',
    'arrow-left': 'fa-arrow-left',
    'arrow-up': 'fa-arrow-up',
    'arrow-down': 'fa-arrow-down',
    'search': 'fa-magnifying-glass',
    'plus': 'fa-plus',
    'minus': 'fa-minus',
    'ok': 'fa-check',
    'remove': 'fa-xmark',
    'trash': 'fa-trash',
    'edit': 'fa-pen',
    'download': 'fa-download',
    'download-alt': 'fa-download',
    'print': 'fa-print',
    'calendar': 'fa-calendar',
    'time': 'fa-clock',
    'envelope': 'fa-envelope',
    'phone': 'fa-phone',
    'home': 'fa-house',
    'cog': 'fa-gear',
    'refresh': 'fa-rotate',
    'repeat': 'fa-repeat',
    'exclamation-sign': 'fa-circle-exclamation',
    'warning-sign': 'fa-triangle-exclamation',
    'info-sign': 'fa-circle-info',
    'check': 'fa-check',
    'menu-hamburger': 'fa-bars',
    'dashboard': 'fa-gauge-high',
    'shopping-cart': 'fa-cart-shopping',
    'eye-open': 'fa-eye',
    'zoom-in': 'fa-magnifying-glass-plus',
    'filter': 'fa-filter',
    'sort': 'fa-sort',
    'file': 'fa-file',
    'folder-open': 'fa-folder-open',
    'folder-close': 'fa-folder',
    'upload': 'fa-upload',
    'floppy-disk': 'fa-floppy-disk',
    'send': 'fa-paper-plane',
    'log-out': 'fa-right-from-bracket',
    'off': 'fa-power-off',
    'ban-circle': 'fa-ban',
    'transfer': 'fa-right-left',
    'stats': 'fa-chart-simple',
    'tasks': 'fa-list-check',
    'tag': 'fa-tag',
    'tags': 'fa-tags',
    'comment': 'fa-comment',
    'pushpin': 'fa-thumbtack',
    'paperclip': 'fa-paperclip',
    'credit-card': 'fa-credit-card',
    'truck': 'fa-truck',
    'map-marker': 'fa-location-dot',
    'phone-alt': 'fa-phone',
    'question-sign': 'fa-circle-question',
    'play': 'fa-play',
    'stop': 'fa-stop'
  };

  function shimAttributes(root) {
    var elements = root.querySelectorAll('[data-toggle],[data-target],[data-dismiss],[data-ride],[data-slide],[data-slide-to],[data-parent],[data-interval],[data-keyboard],[data-backdrop],[data-focus]');
    Array.prototype.forEach.call(elements, function (el) {
      Object.keys(ATTRIBUTES).forEach(function (legacy) {
        var value = el.getAttribute(legacy);
        if (value !== null) {
          el.setAttribute(ATTRIBUTES[legacy], value);
          el.removeAttribute(legacy);
        }
      });
    });
  }

  function shimGlyphicons(root) {
    var icons = root.querySelectorAll('.glyphicon');
    Array.prototype.forEach.call(icons, function (el) {
      var replacement = null;
      var classes = el.className.split(/\s+/);
      classes.forEach(function (cls) {
        if (cls.indexOf('glyphicon-') === 0 && GLYPHICONS[cls.slice('glyphicon-'.length)]) {
          replacement = GLYPHICONS[cls.slice('glyphicon-'.length)];
        }
      });
      el.classList.remove('glyphicon');
      Array.prototype.forEach.call(classes.slice(), function (cls) {
        if (cls.indexOf('glyphicon-') === 0) {
          el.classList.remove(cls);
        }
      });
      if (replacement) {
        el.classList.add('fa', replacement);
      }
    });
  }

  function shimAlerts(root) {
    var alerts = root.querySelectorAll('.alert-dismissable, .alert-dismissible');
    Array.prototype.forEach.call(alerts, function (el) {
      el.classList.add('alert-dismissible');
      var button = el.querySelector('[data-bs-dismiss="alert"], .close');
      if (button) {
        if (!button.hasAttribute('data-bs-dismiss')) {
          button.setAttribute('data-bs-dismiss', 'alert');
        }
        if (!button.classList.contains('btn-close')) {
          button.classList.add('btn-close');
          if (/^\s*[\u00d7xX]?\s*$/.test(button.textContent)) {
            button.textContent = '';
          }
        }
        button.setAttribute('aria-label', 'Close');
      }
    });
  }

  function shimDropdownParents(root) {
    var toggles = root.querySelectorAll('[data-bs-toggle="dropdown"]');
    Array.prototype.forEach.call(toggles, function (el) {
      var parent = el.parentElement;
      if (!parent) {
        return;
      }
      if (!parent.classList.contains('dropdown') && !parent.classList.contains('btn-group') && !parent.classList.contains('nav-item')) {
        parent.classList.add('dropdown');
      }
    });
  }

  function enhance(root) {
    shimAttributes(root);
    shimGlyphicons(root);
    shimAlerts(root);
    shimDropdownParents(root);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function () {
      enhance(document);
    });
  } else {
    enhance(document);
  }

  window.legacyBootstrapEnhance = enhance;
})();
