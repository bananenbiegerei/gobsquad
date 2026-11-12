<div x-data="{ navOpen: false }" @keydown.escape.window="navOpen = false">
<header class="site-header mobile-header md:hidden">
  <div class="flex flex-wrap items-center gap-4 px-4">
    <div class="flex-1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img class="logo mobile" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/gob-squad-logo.png" alt="Logo">
      </a>
    </div>
    <div class="shrink-0">
      <?php if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
        $count = WC()->cart->cart_contents_count;
        ?>
        <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
        if ( $count > 0 ) {
          ?>
          <span class="cart-contents-count"><i class="fas fa-shopping-cart"></i> <?php echo esc_html( $count ); ?></span>
          <?php
        }
        ?></a>
      <?php } ?>
    </div>
    <div class="shrink-0">
      <button type="button" class="button clear menu-button" @click="navOpen = true" aria-label="Open menu">
        <i class="fas fa-bars"></i>
      </button>
    </div>
  </div>
</header>

<div class="offcanvas-backdrop" x-show="navOpen" x-transition.opacity @click="navOpen = false" x-cloak></div>

<div class="off-canvas" :class="navOpen ? 'translate-x-0' : '-translate-x-full'" x-cloak>
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
      <button class="close-button" aria-label="Close menu" type="button" @click="navOpen = false">
          <span aria-hidden="true">&times;</span>
        </button>
</div>
</div>
