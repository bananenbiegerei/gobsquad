<div x-data="{ navOpen: false }"
     @keydown.escape.window="if (navOpen) { navOpen = false; $refs.menuButton.focus() }"
     x-effect="
       document.body.classList.toggle('nav-open', navOpen);
       if (!navOpen && $refs.mobileNav) {
         $refs.mobileNav.querySelectorAll('.drilldown-item.is-open').forEach((el) => {
           el.classList.remove('is-open');
           el.querySelector(':scope > .drilldown-control .submenu-toggle')?.setAttribute('aria-expanded', 'false');
         });
       }
     ">
<header class="absolute top-0 left-0 w-full z-[9] transition-all duration-800 ease-[ease] bg-transparent md:hidden">
  <div class="flex items-center gap-x-6 sm:gap-x-8 px-3 sm:px-4 h-(--mobile-header-height)">
    <div class="flex-1">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %s: site name */ __( '%s – home', 'gobsquad' ), get_bloginfo( 'name' ) ) ); ?>">
        <img class="logo mobile ml-4 h-[calc(var(--mobile-header-height)_-_2rem)]" src="<?php echo get_stylesheet_directory_uri() ?>/dist/assets/img/gob-squad-logo.png" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
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
      <button type="button" class="button clear menu-button text-primary bg-white hover:bg-white [&_i]:text-lg" x-ref="menuButton"
              @click="navOpen = true; $nextTick(() => $refs.mobileNav.querySelector('.drilldown-link')?.focus())"
              :aria-expanded="navOpen.toString()" aria-controls="mobile-navigation"
              aria-label="<?php esc_attr_e( 'Open menu', 'gobsquad' ); ?>">
        <i class="fas fa-bars" aria-hidden="true"></i>
      </button>
    </div>
  </div>
</header>

<div class="fixed inset-0 z-[998] bg-black/50" x-show="navOpen" x-transition.opacity @click="navOpen = false; $refs.menuButton.focus()" x-cloak></div>

<nav id="mobile-navigation" x-ref="mobileNav" class="fixed inset-0 z-[999] w-full overflow-y-auto bg-white transition-transform duration-300 ease-[ease] aria-hidden:invisible" :class="navOpen ? 'translate-x-0' : '-translate-x-full'"
     :aria-hidden="(!navOpen).toString()" :inert="!navOpen" aria-label="<?php esc_attr_e( 'Mobile', 'gobsquad' ); ?>" x-cloak
     @keydown.tab="
       const items = Array.from($refs.mobileNav.querySelectorAll('a[href], button:not([disabled])')).filter((el) => el.getClientRects().length > 0);
       if (!items.length) return;
       const first = items[0];
       const last = items[items.length - 1];
       if ($event.shiftKey && document.activeElement === first) { $event.preventDefault(); last.focus(); }
       else if (!$event.shiftKey && document.activeElement === last) { $event.preventDefault(); first.focus(); }
     ">
  <?php
  wp_nav_menu(array(
    'container' => false,
    'menu' => __( 'Mobile Top', 'textdomain' ),
    'menu_class' => 'drilldown-root',
    'theme_location' => 'mobile-top',
    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
    //Recommend setting this to false, but if you need a fallback...
    'fallback_cb' => 'f6_drill_menu_fallback',
    'walker' => new F6_DRILL_MENU_WALKER(),
));
  ?>
  <?php // Last in tab order (after all menu links/carets); visually pinned top-right. ?>
  <button class="absolute z-10 right-4 top-2 text-[3em] leading-none text-black bg-transparent border-none cursor-pointer hover:text-black focus:text-black" x-ref="closeButton" aria-label="<?php esc_attr_e( 'Close menu', 'gobsquad' ); ?>" type="button"
          @click="navOpen = false; $refs.menuButton.focus()">
    <span aria-hidden="true">&times;</span>
  </button>
</nav>
</div>
