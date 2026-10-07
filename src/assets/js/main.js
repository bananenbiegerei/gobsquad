import Swiper from 'swiper';
$(document).ready(function ($) {
  // Drilldown working in reveal with this
  $("#drilldownMenu").detach().appendTo("#ddMenu");

  // Initialize new Swiper on each .swiper-container
  $('.swiper-container.swiper-current-projects').each(function () {
    new Swiper(this, {
      loop: true,
      pagination: {
        el: $(this).find('.swiper-pagination'),
        dynamicBullets: false
      },
      navigation: {
        nextEl: $(this).find('.swiper-button-next'),
        prevEl: $(this).find('.swiper-button-prev'),
      },
      spaceBetween: 30,
      autoHeight: true,
      slidesPerView: 4,
      breakpoints: {
        1024: {
          slidesPerView: 3,
        },
        768: {
          slidesPerView: 2,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 15,
        }
      }
    })
  })
  // Initialize new Swiper on each .swiper-container
  $('.swiper-container.swiper-dates').each(function () {
    new Swiper(this, {
      loop: false,
      pagination: {
        el: $(this).find('.swiper-pagination'),
        dynamicBullets: false
      },
      navigation: {
        nextEl: $(this).find('.swiper-button-next'),
        prevEl: $(this).find('.swiper-button-prev'),
      },
      spaceBetween: 30,
      autoHeight: false,
      slidesPerView: 4,
      breakpoints: {
        1024: {
          slidesPerView: 4,
        },
        768: {
          slidesPerView: 2,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 15,
        }
      }
    })
  })
  $('.swiper-container.swiper-flex').each(function () {
    new Swiper(this, {
      // pagination: {
      //   el: $(this).find('.swiper-pagination'),
      //   dynamicBullets: false
      // },
      loop: true,
      navigation: {
        nextEl: $(this).find('.swiper-button-next'),
        prevEl: $(this).find('.swiper-button-prev'),
      },
      spaceBetween: 30,
      autoHeight: true,
    })
  })
  $('.swiper-container.project-gallery').each(function () {
    new Swiper(this, {
      // pagination: {
      //   el: $(this).find('.swiper-pagination'),
      //   dynamicBullets: false
      // },
      // slidesPerView: 'auto',
      // spaceBetween: 30,
      loop: true,
      navigation: {
        nextEl: $(this).find('.swiper-button-next'),
        prevEl: $(this).find('.swiper-button-prev'),
      },
      spaceBetween: 0,
      autoHeight: true,
      on: {
        slideChangeTransitionEnd: function () {
          // Höhe des aktuellen Slides messen und Wrapper anpassen
          requestAnimationFrame(() => {
            const currentSlide = this.slides[this.activeIndex];
            const currentSlideHeight = currentSlide.getBoundingClientRect().height;
            console.log("Aktuelle Slide-Höhe:", currentSlideHeight); // Debugging

            // Wrapper-Höhe setzen
            this.$wrapperEl[0].style.height = currentSlideHeight + 'px';
          });
        }
      },
      // preloadImages: true,
      //speed: 1000,
      // autoplay: {
      //   delay: 5000,
      // },
    })
  })
  //
});
