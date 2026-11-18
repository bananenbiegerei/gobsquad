<header id="site-header" class="absolute top-0 left-0 w-full z-[999] transition-all duration-800 ease-[ease] hidden md:block [&_#main-menu]:h-(--header-height)" role="banner">
  <div class="mx-auto max-w-320 px-3 sm:px-4">
    <div class="flex items-center gap-x-6 sm:gap-x-8" id="main-menu">
      <div class="flex-1">
        <a href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: site name */ __( '%s – home', 'gobsquad' ), get_bloginfo( 'name' ) ) ); ?>">
          <img class="logo desktop" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/gob-squad-logo.png" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
        </a>
      </div>
      <?php if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        $count = WC()->cart->cart_contents_count;
        if ($count > 0) {
          ?>
          <div class="shrink-0">
            <ul class="menu">
              <li>
                <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: number of items */ _n( 'Shopping cart, %d item', 'Shopping cart, %d items', $count, 'gobsquad' ), $count ) ); ?>">
                  <span class="cart-contents-count"><i class="fas fa-shopping-cart" aria-hidden="true"></i> <?php echo esc_html($count); ?></span>
                </a>
              </li>
            </ul>
          </div>
          <?php
        }
      } ?>
      <nav class="shrink-0 main-navigation" aria-label="<?php esc_attr_e( 'Main', 'gobsquad' ); ?>">
        <?php wp_nav_menu(array('theme_location' => 'top', 'container' => false, 'depth' => 0, 'items_wrap' => '<ul class="menu top-menu">%3$s</ul>', 'walker' => new insertcart_walker(array('in_top_bar' => true, 'item_type' => 'li', 'menu_type' => 'main-menu')),)); ?>
      </nav>
    </div>
  </div>
</header>
