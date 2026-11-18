<div x-data="{ navOpen: false }"
     @keydown.escape.window="if (navOpen) { navOpen = false; $refs.menuButton.focus() }"
     x-effect="document.body.classList.toggle('nav-open', navOpen)">
<header class="absolute top-0 left-0 w-full z-[9] transition-all duration-800 ease-[ease] bg-transparent md:hidden">
  <div class="flex items-center gap-x-gutter px-gutter-half h-(--mobile-header-height)">
    <div class="flex-1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: site name */ __( '%s – home', 'gobsquad' ), get_bloginfo( 'name' ) ) ); ?>">
        <img class="logo mobile ml-small h-[calc(var(--mobile-header-height)_-_2rem)]" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/gob-squad-logo.png" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
      </a>
    </div>
    <div class="shrink-0">
      <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $count = WC()->cart->cart_contents_count;
        if ( $count > 0 ) {
        ?>
        <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: number of items */ _n( 'Shopping cart, %d item', 'Shopping cart, %d items', $count, 'gobsquad' ), $count ) ); ?>">
          <span class="cart-contents-count"><i class="fas fa-shopping-cart" aria-hidden="true"></i> <?php echo esc_html( $count ); ?></span>
        </a>
        <?php
        }
      } ?>
    </div>
    <div class="shrink-0">
      <button type="button" class="<?php echo esc_attr( gob_button_clear_class( 'menu-button text-primary bg-white hover:bg-white [&_i]:text-lg' ) ); ?>" x-ref="menuButton"
              @click="navOpen = true; $nextTick(() => $refs.closeButton.focus())"
              :aria-expanded="navOpen.toString()" aria-controls="mobile-navigation"
              aria-label="<?php esc_attr_e( 'Open menu', 'gobsquad' ); ?>">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>

<div class="fixed inset-0 z-[998] bg-black/50" x-show="navOpen" x-transition.opacity @click="navOpen = false; $refs.menuButton.focus()" x-cloak></div>

<nav id="mobile-navigation" class="fixed top-0 left-0 bottom-0 z-[999] w-64 max-w-[85vw] overflow-y-auto bg-white bg-no-repeat bg-bottom-right bg-auto transition-transform duration-300 ease-[ease] bg-[url('/wp-content/themes/gobsquad/dist/assets/img/lady.png')] aria-hidden:invisible" :class="navOpen ? 'translate-x-0' : '-translate-x-full'"
     :aria-hidden="(!navOpen).toString()" :inert="!navOpen" aria-label="<?php esc_attr_e( 'Mobile', 'gobsquad' ); ?>" x-cloak>
  <?php
  wp_nav_menu(array(
    'container' => false,
    'menu' => __( 'Mobile Top', 'textdomain' ),
    'menu_class' => 'drilldown-root mt-8',
    'theme_location' => 'mobile-top',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    //Recommend setting this to false, but if you need a fallback...
    'fallback_cb' => 'f6_drill_menu_fallback',
    'walker' => new F6_DRILL_MENU_WALKER(),
));
  ?>
  <button class="absolute z-10 right-4 top-2 text-[3em] leading-none text-black bg-transparent border-none cursor-pointer hover:text-black focus:text-black" x-ref="closeButton" aria-label="<?php esc_attr_e( 'Close menu', 'gobsquad' ); ?>" type="button"
          @click="navOpen = false; $refs.menuButton.focus()">
    <span aria-hidden="true">&times;</span>
  </button>
</nav>
</div>
