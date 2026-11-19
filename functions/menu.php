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

/*
 * Mobile drilldown — same disclosure pattern as desktop: parent link, then a
 * focusable caret button, then the submenu (closed until the caret opens it).
 * Tab order: item link → caret → (opened) children → … → close button.
 */
class F6_DRILL_MENU_WALKER extends Walker_Nav_Menu
{
    /**
     * Submenu element ids keyed by depth, set in start_el for start_lvl.
     *
     * @var array<int, string>
     */
    private $submenu_ids = array();

    function start_lvl( &$output, $depth = 0, $args = array() ) {
        $id      = isset( $this->submenu_ids[ $depth ] ) ? $this->submenu_ids[ $depth ] : '';
        $id_attr = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= "\n<ul{$id_attr} class=\"drilldown-submenu\">\n";
    }

    function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "</ul>\n";
    }

    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $classes      = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[]    = 'drilldown-item';
        $has_children = in_array( 'menu-item-has-children', $classes, true );
        $title        = apply_filters( 'the_title', $item->title, $item->ID );
        $href         = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
        $class_attr   = esc_attr( implode( ' ', array_unique( array_filter( $classes ) ) ) );

        if ( $has_children ) {
            $submenu_id                  = 'drilldown-submenu-' . (int) $item->ID;
            $this->submenu_ids[ $depth ] = $submenu_id;
            $plain_title                 = wp_strip_all_tags( $title );
            $output                     .= '<li class="' . $class_attr . '">';
            $output                     .= '<span class="drilldown-control">';
            $output                     .= '<a href="' . $href . '" class="drilldown-link">' . $title . '</a>';
            $output                     .= sprintf(
                '<button type="button" class="submenu-toggle" aria-expanded="false" aria-controls="%1$s" aria-label="%2$s"><span class="submenu-caret drilldown-caret" aria-hidden="true"></span></button>',
                esc_attr( $submenu_id ),
                /* translators: %s: menu item title */
                esc_attr( sprintf( __( '%s submenu', 'gobsquad' ), $plain_title ) )
            );
            $output .= '</span>';
        } else {
            $output .= '<li class="' . $class_attr . '"><a href="' . $href . '" class="drilldown-link drilldown-link--leaf">' . $title . '</a>';
        }
    }

    function end_el( &$output, $item, $depth = 0, $args = array() ) {
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

/**
 * Highlight Projects nav parents on project singles / the projects archive.
 * The listing page in the menu is "Current Projects" (slug current-projects);
 * CPT URLs are /projects/… so WordPress does not mark that page current on its own.
 *
 * @param string[] $classes Menu item classes.
 * @param WP_Post  $item    Menu item.
 * @return string[]
 */
function gob_nav_menu_projects_current_classes( $classes, $item ) {
	if ( ! is_singular( 'projects' ) && ! is_post_type_archive( 'projects' ) ) {
		return $classes;
	}

	$is_projects_nav = false;

	if ( 'page' === $item->object && ! empty( $item->object_id ) ) {
		$page = get_post( (int) $item->object_id );
		if ( $page instanceof WP_Post ) {
			$template = get_page_template_slug( (int) $item->object_id );
			$is_projects_nav = in_array(
				$page->post_name,
				array( 'current-projects', 'projects-archive' ),
				true
			) || 'page-current-projects.php' === $template;
		}
	} elseif ( 'post_type_archive' === $item->type && 'projects' === $item->object ) {
		$is_projects_nav = true;
	}

	if ( ! $is_projects_nav && ! empty( $item->url ) ) {
		$item_path = untrailingslashit( (string) wp_parse_url( $item->url, PHP_URL_PATH ) );
		$archive   = untrailingslashit( (string) wp_parse_url( (string) get_post_type_archive_link( 'projects' ), PHP_URL_PATH ) );
		$is_projects_nav = in_array( $item_path, array( '/current-projects', '/projects-archive', $archive ), true );
	}

	if ( ! $is_projects_nav ) {
		return $classes;
	}

	$classes[] = 'current-menu-item';
	if ( in_array( 'menu-item-has-children', $classes, true ) ) {
		$classes[] = 'current-menu-ancestor';
		$classes[] = 'current-menu-parent';
	}

	return array_unique( $classes );
}
add_filter( 'nav_menu_css_class', 'gob_nav_menu_projects_current_classes', 10, 2 );
