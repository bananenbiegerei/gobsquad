import '../css/app.css';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

Alpine.plugin(collapse);
window.Alpine = Alpine;
Alpine.start();

// Mobile drilldown menu: the submenu toggle is a native <details>/<summary>,
// but the link inside <summary> must navigate without also toggling it.
document.querySelectorAll('.drilldown-link').forEach((link) => {
  link.addEventListener('click', (e) => e.stopPropagation());
});

function initSwiperGroup(selector, options) {
  document.querySelectorAll(selector).forEach((el) => {
    const { pagination, ...rest } = options;
    new Swiper(el, {
      modules: [Navigation, Pagination],
      navigation: {
        nextEl: el.querySelector('.swiper-button-next'),
        prevEl: el.querySelector('.swiper-button-prev'),
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
  slidesPerView: 4,
  breakpoints: {
    1024: { slidesPerView: 4 },
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
    modules: [Navigation],
    navigation: {
      nextEl: el.querySelector('.swiper-button-next'),
      prevEl: el.querySelector('.swiper-button-prev'),
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
