<?php
function site_scripts() {
    //JS
    wp_enqueue_script( 'site-js', get_template_directory_uri() . '/dist/assets/js/main.js', array( 'jquery' ), '', true );

    // CSS
    wp_enqueue_style( 'site-css', get_template_directory_uri() . '/dist/assets/scss/site.css', array(), '', 'all' );
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);
