<header id="site-header" class="site-header hidden md:block" role="banner">
  <div class="mx-auto max-w-360 px-gutter-half">
    <div class="flex items-center gap-x-gutter" id="main-menu">
      <div class="flex-1">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img class="logo desktop" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/gob-squad-logo.png" alt="Logo">
        </a>
      </div>
      <?php if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
        $count = WC()->cart->cart_contents_count;
        if ($count > 0) {
          ?>
          <div class="shrink-0">
            <ul class="menu">
              <li>
                <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart'); ?>">
                  <span class="cart-contents-count"><i class="fas fa-shopping-cart"></i> <?php echo esc_html($count); ?></span>
                </a>
              </li>
            </ul>
          </div>
          <?php
        }
      } ?>
      <div class="shrink-0">
        <?php wp_nav_menu(array('theme_location' => 'top', 'container' => false, 'depth' => 0, 'items_wrap' => '<ul class="menu top-menu">%3$s</ul>', 'walker' => new insertcart_walker(array('in_top_bar' => true, 'item_type' => 'li', 'menu_type' => 'main-menu')),)); ?>
      </div>
    </div>
  </div>
</header>
