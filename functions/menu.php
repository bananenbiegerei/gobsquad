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

// %%%%%%%%%% Desktop dropdown menu (CSS-only hover reveal, see .dropdown-submenu in layout.css) %%%%%%%%%%
class insertcart_walker extends Walker_Nav_Menu
{
    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"dropdown-submenu\">\n";
    }
}
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
