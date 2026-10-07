<header class="site-header mobile-header hide-for-large">
  <div class="grid-x grid-padding-x align-middle">
    <div class="cell auto">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img class="logo mobile" src="<?php echo get_stylesheet_directory_uri() ?>//dist/assets/img/gob-squad-logo.png" alt="Logo">
      </a>
    </div>
    <div class="cell shrink">
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
    <div class="shrink cell">
      <p><button type="button" class="button float-right clear menu-button" data-toggle="offCanvas"><i class="fas fa-bars"></i></button></p>
    </div>
  </div>
</header>

<div class="off-canvas position-left" id="offCanvas" data-off-canvas>
  <?php
  wp_nav_menu(array(
    'container' => false,
    'menu' => __( 'Mobile Top', 'textdomain' ),
    'menu_class' => 'vertical menu margin-top-4',
    'theme_location' => 'mobile-top',
    'items_wrap'      => '<ul id="%1$s" class="%2$s" data-drilldown="">%3$s</ul>',
    //Recommend setting this to false, but if you need a fallback...
    'fallback_cb' => 'f6_drill_menu_fallback',
    'walker' => new F6_DRILL_MENU_WALKER(),
));
  ?>
      <button class="close-button" aria-label="Close menu" type="button" data-close>
          <span aria-hidden="true">&times;</span>
        </button>
</div>
<!-- <div class="reveal full" id="mobileReveal" data-reveal>
<div id="ddMenu">
</div>
<button class="close-button" data-close aria-label="Close modal" type="button">
<span aria-hidden="true">&times;</span>
</button>
</div>
<nav id="drilldownMenu" class="hide-for-large">
<?php wp_nav_menu( array( 'theme_location' => 'mobile-top', 'container' => false, 'depth' => 0, 'items_wrap' => '<ul class="vertical drilldown menu top-menu" id="mobile-top" data-drilldown>%3$s</ul>', 'walker' => new insertcart_walker( array( 'in_top_bar' => true, 'item_type' => 'li', 'menu_type' => 'main-menu' ) ), ) ); ?>
</nav> -->
