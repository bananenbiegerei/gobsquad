<?php
/**
 * Vite asset loading: dev-server HMR when `npm run dev` is running
 * (signalled by dist/hot, written by vite.config.js), manifest-based
 * hashed output from `npm run build` otherwise.
 */

define( 'GOBSQUAD_VITE_ENTRY', 'src/assets/js/app.js' );

function gobsquad_vite_dev_server_url() {
    $hot_file = get_template_directory() . '/dist/hot';
    if ( ! file_exists( $hot_file ) ) {
        return false;
    }
    return trim( file_get_contents( $hot_file ) );
}

function gobsquad_vite_manifest() {
    $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
    if ( ! file_exists( $manifest_path ) ) {
        return false;
    }
    $manifest = json_decode( file_get_contents( $manifest_path ), true );
    return is_array( $manifest ) ? $manifest : false;
}

function gobsquad_vite_script_tag( $tag, $handle ) {
    if ( in_array( $handle, array( 'gobsquad-vite-client', 'gobsquad-vite-app' ), true ) ) {
        $tag = str_replace( ' src=', ' type="module" src=', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'gobsquad_vite_script_tag', 10, 2 );

function gobsquad_enqueue_vite_assets() {
    $dev_server = gobsquad_vite_dev_server_url();

    if ( $dev_server ) {
        wp_enqueue_script( 'gobsquad-vite-client', $dev_server . '/@vite/client', array(), null, true );
        wp_enqueue_script( 'gobsquad-vite-app', $dev_server . '/' . GOBSQUAD_VITE_ENTRY, array(), null, true );
        return;
    }

    $manifest = gobsquad_vite_manifest();
    $entry    = $manifest ? ( $manifest[ GOBSQUAD_VITE_ENTRY ] ?? null ) : null;

    if ( ! $entry ) {
        if ( current_user_can( 'manage_options' ) ) {
            add_action( 'wp_footer', function () {
                echo '<div style="position:fixed;bottom:0;left:0;right:0;background:#b00;color:#fff;padding:1em;z-index:99999;font-family:monospace;">'
                    . 'Vite assets missing: run <code>npm run dev</code> or <code>npm run build</code> in the theme directory.'
                    . '</div>';
            } );
        }
        return;
    }

    $base_url = get_template_directory_uri() . '/dist/';

    wp_enqueue_script( 'gobsquad-vite-app', $base_url . $entry['file'], array(), null, true );

    if ( ! empty( $entry['css'] ) ) {
        foreach ( $entry['css'] as $i => $css_file ) {
            wp_enqueue_style( 'gobsquad-vite-app-' . $i, $base_url . $css_file, array(), null );
        }
    }

    if ( ! empty( $entry['imports'] ) ) {
        add_action( 'wp_head', function () use ( $entry, $manifest, $base_url ) {
            foreach ( $entry['imports'] as $import_key ) {
                if ( ! empty( $manifest[ $import_key ]['file'] ) ) {
                    printf(
                        '<link rel="modulepreload" href="%s">' . "\n",
                        esc_url( $base_url . $manifest[ $import_key ]['file'] )
                    );
                }
            }
        } );
    }
}
add_action( 'wp_enqueue_scripts', 'gobsquad_enqueue_vite_assets', 999 );
