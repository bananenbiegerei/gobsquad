<div class="flex items-center gap-x-6 sm:gap-x-8">
  <div class="shrink-0 relative">
    <?php // Swiper upgrades these to role=button + aria-label; the static label covers no-JS and the first paint. ?>
    <div class="swiper-button-prev" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Previous slide', 'gobsquad' ); ?>"><span class="swiper-caret" aria-hidden="true"></span></div>
  </div>
  <div class="flex-1 min-w-0 flex justify-center items-center [&_.swiper-pagination]:relative [&_.swiper-pagination]:text-center [&_.swiper-pagination_span]:inline-block [&_.swiper-pagination_span]:mx-[3.75px]">
    <div class="swiper-pagination"></div>
  </div>
  <div class="shrink-0">
    <div class="swiper-button-next" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Next slide', 'gobsquad' ); ?>"><span class="swiper-caret" aria-hidden="true"></span></div>
  </div>
</div>
