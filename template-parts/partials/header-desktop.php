<header id="site-header" class="site-header show-for-large" role="banner" data-sticky-container>
  <div class="grid-container">
    <div class="grid-x grid-padding-x align-middle" id="main-menu">
      <div class="auto cell">
        <a href="<?php echo esc_url(home_url('/')); ?>">
          <img class="logo" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/gob-squad-logo.png" alt="Logo">
        </a>
      </div>
      <div class="cell shrink show-for-large">
        <?php if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
          $count = WC()->cart->cart_contents_count;
          ?>
          <ul class="menu horizontal">
            <li>
              <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart'); ?>"><?php
              if ($count > 0) {
                ?>
                <span class="cart-contents-count"><i class="fas fa-shopping-cart"></i> <?php echo esc_html($count); ?></span>
                <?php
              }
              ?></a>
            </li>
          </ul>
        <?php } ?>
      </div>
      <div class="shrink cell">
        <?php wp_nav_menu(array('theme_location' => 'top', 'container' => false, 'depth' => 0, 'items_wrap' => '<ul class="horizontal menu top-menu dropdown" data-dropdown-menu>%3$s</ul>', 'walker' => new insertcart_walker(array('in_top_bar' => true, 'item_type' => 'li', 'menu_type' => 'main-menu')),)); ?>
      </div>
    </div>
  </div>
</header>
