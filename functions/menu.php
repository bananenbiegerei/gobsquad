<?php
// Register Navigation Menus
function custom_navigation_menus() {

    $locations = array(
        'top' => __( 'Top', 'text_domain' ),
        'mobile-top' => __( 'Mobile Top', 'text_domain' ),
        'footer' => __( 'Footer', 'text_domain' ),
    );
    register_nav_menus( $locations );

}
add_action( 'init', 'custom_navigation_menus' );

// %%%%%%%%%% Desktop dropdown menu %%%%%%%%%%
/*
 * Markup follows the WAI-ARIA "disclosure navigation menu" pattern rather
 * than role=menubar/menuitem (which axe flagged as aria-required-children /
 * aria-required-parent and which is meant for application menus, not site
 * navigation): a plain <ul>, each parent item is a normal link plus a
 * <button aria-expanded aria-controls> that toggles the submenu.
 *
 * Tab order (Figma): 1) parent link  2) caret toggle (submenu still closed)
 * 3) submenu links only after the toggle opens it. Link + toggle sit in
 * `.menu-item-control` so link focus can ring the whole trigger. Hover
 * reveal is CSS (layout.css); toggle / Escape / arrows are in app.js.
 */
class insertcart_walker extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"dropdown-submenu\">\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes      = empty( $item->classes ) ? array() : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes, true );

        parent::start_el( $output, $item, $depth, $args, $id );

        if ( ! $has_children ) {
            return;
        }

        $submenu_id = 'submenu-' . (int) $item->ID;
        $title      = wp_strip_all_tags( apply_filters( 'the_title', $item->title, $item->ID ) );
        $button     = sprintf(
            '<button type="button" class="submenu-toggle" aria-expanded="false" aria-controls="%1$s" aria-label="%2$s"><span class="submenu-caret" aria-hidden="true"></span></button>',
            esc_attr( $submenu_id ),
            /* translators: %s: menu item title */
            esc_attr( sprintf( __( '%s submenu', 'gobsquad' ), $title ) )
        );

        // Wrap link + caret so "focus tap 1" can ring both as one unit.
        $li_pos = strrpos( $output, '<li' );
        if ( false !== $li_pos ) {
            $gt = strpos( $output, '>', $li_pos );
            if ( false !== $gt ) {
                $output = substr_replace( $output, '><span class="menu-item-control">', $gt, 1 );
            }
        }

        $pos = strrpos( $output, '</a>' );
        if ( false !== $pos ) {
            $output = substr_replace( $output, '</a>' . $button . '</span>', $pos, 4 );
        }
        // Give the following <ul> the id the button points to.
        $output .= '<!--submenu:' . esc_attr( $submenu_id ) . '-->';
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $output .= "</li>\n";
    }
}
// Move the submenu id marker onto the actual <ul>.
add_filter( 'wp_nav_menu_items', function ( $items ) {
    return preg_replace( '/<!--submenu:([^>]+)-->\s*(<ul class="dropdown-submenu")/', '$2 id="$1"', $items );
}, 5 );
//Optional fallback
function f6_topbar_menu_fallback($args)
{
    $walker_page = new Walker_Page();
    $fallback = $walker_page->walk(get_pages(), 0);
    $fallback = str_replace("<ul class='children'>", '<ul class="dropdown-submenu">', $fallback);

    echo '<ul class="menu-horizontal">'.$fallback.'</ul>';
}

// %%%%%%%%%% Mobile drilldown menu (native <details>/<summary> disclosure, no custom JS state) %%%%%%%%%%
class F6_DRILL_MENU_WALKER extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "\n<ul class=\"drilldown-submenu\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "</ul>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes      = empty( $item->classes ) ? array() : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes, true );
        $title        = apply_filters( 'the_title', $item->title, $item->ID );
        $href         = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
        $item_classes = 'drilldown-item' . ( $has_children ? ' menu-item-has-children' : '' );

        if ( $has_children ) {
            $output .= '<li class="' . esc_attr( $item_classes ) . '"><details class="drilldown-details"><summary class="drilldown-summary"><a href="' . $href . '" class="drilldown-link">' . $title . '</a><span class="drilldown-caret" aria-hidden="true"></span></summary>';
        } else {
            $output .= '<li class="' . esc_attr( $item_classes ) . '"><a href="' . $href . '" class="drilldown-link drilldown-link--leaf">' . $title . '</a>';
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        if ( in_array( 'menu-item-has-children', $classes, true ) ) {
            $output .= '</details>';
        }
        $output .= "</li>\n";
    }
}

function f6_drill_menu_fallback($args)
{
    $walker_page = new Walker_Page();
    $fallback = $walker_page->walk(get_pages(), 0);
    $fallback = str_replace('children', 'children drilldown-submenu', $fallback);
    echo '<ul class="drilldown-root">'.$fallback.'</ul>';
}

// %%%%%%%%%% Add menu Slug as Class %%%%%%%%
function add_slug_class_to_menu_item($output){
 $ps = get_option('permalink_structure');
 if(!empty($ps)){
     $idstr = preg_match_all('/<li id="menu-item-(\d+)/', $output, $matches);
     foreach($matches[1] as $mid){
         $id = get_post_meta($mid, '_menu_item_object_id', true);
         $slug = basename(get_permalink($id));
         $output = preg_replace('/menu-item-'.$mid.'">/', 'menu-item-'.$mid.' menu-item-'.$slug.'">', $output, 1);
     }
 }
 return $output;
}
add_filter('wp_nav_menu', 'add_slug_class_to_menu_item');
