<?php


namespace Addons_Plus;

/**
 * Assets Handler Class
 * @package Addons_Plus
 */
class Assets
{
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_assets' ] );
    }

    public function get_styles() {
        return [
            'semantic-min' => [
                'src' => ADDONS_PLUS_URL .'assets/css/semantic.min.css',
                'version' => '2.4.0',
            ],
            'addons-plus-style' => [
                'src' => ADDONS_PLUS_URL .'assets/css/frontend.css',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/css/frontend.css' ),
            ],
            'addons-plus-admin-style' => [
                'src' => ADDONS_PLUS_URL .'assets/css/admin.css',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/css/admin.css' ),
            ]

        ];
    }
    public function get_scripts() {
        return [
            'semantic-min' =>[
                'src' => ADDONS_PLUS_URL .'assets/js/semantic.min.js',
                'version' => '2.4.0',
                'deps' => [ 'jquery' ]
            ],
            'addons-plus-script' =>[
                'src' => ADDONS_PLUS_URL .'assets/js/frontend.js',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/js/frontend.js' ),
                'deps' => [ 'jquery' ]
            ]
        ];
    }



    public function enqueue_assets () {
        $styles = $this->get_styles();
        $scripts = $this->get_scripts();

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style[ 'deps' ] ) ? $style[ 'deps' ] : [];
            wp_register_style( $handle , $style[ 'src' ] , $deps , $style[ 'version' ] );
        }

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script[ 'deps' ] ) ? $script[ 'deps' ] : [];
            wp_register_script( $handle , $script[ 'src' ] , $deps , $script[ 'version' ], true );
        }

        $valid_url = [ 'addons-plus', 'settings' ];
        $current_page = isset( $_REQUEST[ 'page' ] ) ? $_REQUEST[ 'page' ] : '';
        if ( in_array( $current_page, $valid_url )){
            wp_enqueue_style( 'addons-plus-admin-style');
        }

        wp_enqueue_style( 'semantic-min' );
        wp_enqueue_style( 'addons-plus-style' );
        wp_enqueue_script( 'semantic-min' );
        wp_enqueue_script( 'addons-plus-script' );
    }
}