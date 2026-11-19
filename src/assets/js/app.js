import '../css/app.css';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import Swiper from 'swiper';
import { A11y, Keyboard, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/a11y';
/* After Swiper’s own CSS so our caret/nav overrides win (unlayered). */
import '../css/swiper.css';
import '@fortawesome/fontawesome-free/css/fontawesome.css';
import '@fortawesome/fontawesome-free/css/solid.css';
import '@fortawesome/fontawesome-free/css/brands.css';

Alpine.plugin(collapse);

/*
 * Project detail tabs (single-projects.php) — WAI-ARIA tabs pattern with a
 * roving tabindex: Left/Right cycle, Home/End jump, selection follows focus.
 */
Alpine.data('projectTabs', (initial) => ({
  activeTab: initial,
  select(id) {
    this.activeTab = id;
  },
  onKeydown(e) {
    const keys = ['ArrowLeft', 'ArrowRight', 'Home', 'End'];
    if (!keys.includes(e.key)) return;
    const tabs = Array.from(this.$el.querySelectorAll('[role="tab"]'));
    const current = tabs.indexOf(document.activeElement);
    if (current === -1) return;
    e.preventDefault();
    let next = current;
    if (e.key === 'ArrowRight') next = (current + 1) % tabs.length;
    if (e.key === 'ArrowLeft') next = (current - 1 + tabs.length) % tabs.length;
    if (e.key === 'Home') next = 0;
    if (e.key === 'End') next = tabs.length - 1;
    tabs[next].focus();
    this.select(tabs[next].getAttribute('aria-controls'));
  },
}));

window.Alpine = Alpine;
Alpine.start();

/*
 * Mobile drilldown (same disclosure idea as desktop): caret toggle opens the
 * submenu and moves focus to its first link. Escape closes that branch and
 * returns focus to its caret (without closing the whole off-canvas).
 */
document.querySelectorAll('#mobile-navigation .drilldown-item.menu-item-has-children').forEach((item) => {
  const toggle = item.querySelector(':scope > .drilldown-control .submenu-toggle');
  const submenu = item.querySelector(':scope > .drilldown-submenu');
  if (!toggle || !submenu) return;

  const setOpen = (open) => {
    item.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  };

  toggle.addEventListener('click', () => {
    const willOpen = !item.classList.contains('is-open');
    setOpen(willOpen);
    if (willOpen) {
      submenu.querySelector('a')?.focus();
    }
  });

  item.addEventListener('keydown', (e) => {
    if (e.key !== 'Escape' || !item.classList.contains('is-open')) return;
    e.preventDefault();
    e.stopPropagation();
    setOpen(false);
    toggle.focus();
  });
});

/*
 * Desktop navigation dropdowns (disclosure pattern, markup from
 * insertcart_walker in functions/menu.php). Hover reveal is pure CSS; this
 * adds the keyboard side matching Figma tab order:
 *  - Tab 1: parent link (submenu stays closed)
 *  - Tab 2: caret <button> (still closed until activated)
 *  - Tab 3+: submenu links only after the toggle opens `.is-open`
 *  - Escape closes and returns focus to the toggle
 *  - ArrowDown opens and moves into the submenu; ArrowUp moves back
 *  - focus leaving the item closes it
 */
document.querySelectorAll('.top-menu .menu-item-has-children').forEach((item) => {
  const toggle = item.querySelector('.submenu-toggle');
  const submenu = item.querySelector(':scope > .dropdown-submenu');
  if (!toggle || !submenu) return;

  const setOpen = (open) => {
    item.classList.toggle('is-open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  };

  toggle.addEventListener('click', () => {
    const willOpen = !item.classList.contains('is-open');
    setOpen(willOpen);
    if (willOpen) {
      submenu.querySelector('a')?.focus();
    }
  });

  item.addEventListener('focusout', (e) => {
    if (!item.contains(e.relatedTarget)) setOpen(false);
  });
  item.addEventListener('mouseenter', () => toggle.setAttribute('aria-expanded', 'true'));
  item.addEventListener('mouseleave', () => {
    if (!item.classList.contains('is-open')) toggle.setAttribute('aria-expanded', 'false');
  });

  item.addEventListener('keydown', (e) => {
    const links = Array.from(submenu.querySelectorAll('a'));
    const idx = links.indexOf(document.activeElement);
    if (e.key === 'Escape') {
      e.preventDefault();
      setOpen(false);
      toggle.focus();
    } else if (e.key === 'ArrowDown') {
      e.preventDefault();
      setOpen(true);
      (links[idx + 1] || links[0])?.focus();
    } else if (e.key === 'ArrowUp' && idx > -1) {
      e.preventDefault();
      (links[idx - 1] || toggle).focus();
    }
  });
});

/*
 * Third-party embeds (Elfsight Instagram feed, Facebook page plugin) inject
 * role="progressbar" loaders without an accessible name (axe:
 * aria-progressbar-name). We can't change their markup, so label any
 * unnamed progressbar as it appears.
 */
const labelProgressbars = (root) => {
  root.querySelectorAll?.('[role="progressbar"]:not([aria-label]):not([aria-labelledby])').forEach((el) => {
    el.setAttribute('aria-label', 'Loading');
  });
};
labelProgressbars(document);
new MutationObserver((mutations) => {
  mutations.forEach((m) => m.addedNodes.forEach((n) => n.nodeType === 1 && labelProgressbars(n)));
}).observe(document.body, { childList: true, subtree: true });

function initSwiperGroup(selector, options) {
  document.querySelectorAll(selector).forEach((el) => {
    const { pagination, ...rest } = options;
    new Swiper(el, {
      modules: [A11y, Keyboard, Navigation, Pagination],
      a11y: true,
      keyboard: {
        enabled: true,
        onlyInViewport: true,
      },
      navigation: {
        nextEl: el.querySelector('.swiper-button-next'),
        prevEl: el.querySelector('.swiper-button-prev'),
        addIcons: false,
      },
      pagination: pagination
        ? { el: el.querySelector('.swiper-pagination'), dynamicBullets: false }
        : false,
      ...rest,
    });
  });
}

initSwiperGroup('.swiper.swiper-current-projects', {
  loop: true,
  pagination: true,
  spaceBetween: 30,
  autoHeight: true,
  slidesPerView: 4,
  breakpoints: {
    1024: { slidesPerView: 3 },
    768: { slidesPerView: 2 },
    640: { slidesPerView: 2, spaceBetween: 15 },
  },
});

initSwiperGroup('.swiper.swiper-dates', {
  loop: false,
  pagination: true,
  spaceBetween: 30,
  autoHeight: false,
  slidesPerView: 3,
  breakpoints: {
    1024: { slidesPerView: 3 },
    768: { slidesPerView: 2 },
    640: { slidesPerView: 2, spaceBetween: 15 },
  },
});

initSwiperGroup('.swiper.swiper-flex', {
  loop: true,
  pagination: false,
  spaceBetween: 30,
  autoHeight: true,
});

document.querySelectorAll('.swiper.project-gallery').forEach((el) => {
  new Swiper(el, {
    modules: [A11y, Keyboard, Navigation],
    a11y: true,
    keyboard: {
      enabled: true,
      onlyInViewport: true,
    },
    navigation: {
      nextEl: el.querySelector('.swiper-button-next'),
      prevEl: el.querySelector('.swiper-button-prev'),
      addIcons: false,
    },
    loop: true,
    spaceBetween: 0,
    autoHeight: true,
    on: {
      slideChangeTransitionEnd(swiper) {
        requestAnimationFrame(() => {
          const currentSlide = swiper.slides[swiper.activeIndex];
          const height = currentSlide.getBoundingClientRect().height;
          swiper.wrapperEl.style.height = height + 'px';
        });
      },
    },
  });
});

/**
 * Shop loop: after AJAX add-to-cart, move focus to the injected "View basket"
 * link so keyboard users stay on the archive with a clear next step.
 */
function initAjaxAddToCartFocus() {
  const $ = window.jQuery;
  if (!$ || !$.fn) {
    return;
  }

$(document.body).on('added_to_cart', (_event, _fragments, _cartHash, $button) => {
    const button = $button && $button[0];
    if (!button) {
      return;
    }

    requestAnimationFrame(() => {
      const actions = button.closest('.product-card__actions') || button.parentElement;
      const viewBasket = actions && actions.querySelector('a.added_to_cart');
      if (viewBasket instanceof HTMLElement) {
        viewBasket.focus();
      }
    });
  });
}

initAjaxAddToCartFocus();
