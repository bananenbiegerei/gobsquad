<div x-data="{ navOpen: false }"
     @keydown.escape.window="if (navOpen) { navOpen = false; $refs.menuButton.focus() }"
     x-effect="document.body.classList.toggle('nav-open', navOpen)">
<header class="site-header mobile-header md:hidden">
  <div class="flex items-center gap-x-gutter px-gutter-half h-(--mobile-header-height)">
    <div class="flex-1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: site name */ __( '%s – home', 'gobsquad' ), get_bloginfo( 'name' ) ) ); ?>">
        <img class="logo mobile" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/gob-squad-logo.png" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
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
      <button type="button" class="button clear menu-button" x-ref="menuButton"
              @click="navOpen = true; $nextTick(() => $refs.closeButton.focus())"
              :aria-expanded="navOpen.toString()" aria-controls="mobile-navigation"
              aria-label="<?php esc_attr_e( 'Open menu', 'gobsquad' ); ?>">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>

<div class="offcanvas-backdrop" x-show="navOpen" x-transition.opacity @click="navOpen = false; $refs.menuButton.focus()" x-cloak></div>

<nav id="mobile-navigation" class="off-canvas" :class="navOpen ? 'translate-x-0' : '-translate-x-full'"
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
  <button class="close-button" x-ref="closeButton" aria-label="<?php esc_attr_e( 'Close menu', 'gobsquad' ); ?>" type="button"
          @click="navOpen = false; $refs.menuButton.focus()">
    <span aria-hidden="true">&times;</span>
  </button>
</nav>
</div>
