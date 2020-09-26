<?php


namespace Addons_Plus\Widget;

/**
 * Class Dependency
 * @package Addons_Plus\Widget
 */
class Dependency
{

    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct() {

        // Register widget scripts
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] );


        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_init' ] );
    }


    public function get_widgets_styles() {
        return [
            'addons-plus-hello-style' => [
                'src' => ADDONS_PLUS_URL .'assets/widgets/css/hello.css',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/widgets/css/hello.css' ),
            ]
        ];
    }
    public function get_widgets_scripts() {
        return [
            'addons-plus-hello-script' =>[
                'src' => ADDONS_PLUS_URL .'assets/widgets/js/hello.js',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/widgets/js/hello.js' ),
                'deps' => [ 'jquery' ]
            ]
        ];
    }

    /**
     * widget_scripts
     *
     * Load required plugin core files.
     *
     * @since 1.2.0
     * @access public
     */
    public function widget_styles() {
        $widgets_styles = $this->get_widgets_styles();

        foreach ( $widgets_styles as $handle => $style ) {
            $deps = isset( $style[ 'deps' ] ) ? $style[ 'deps' ] : [];
            wp_register_style( $handle , $style[ 'src' ] , $deps , $style[ 'version' ] );
        }


    }
    public function widget_scripts() {
        $widgets_scripts = $this->get_widgets_scripts();

        foreach ( $widgets_scripts as $handle => $script ) {
            $deps = isset( $script[ 'deps' ] ) ? $script[ 'deps' ] : [];
            wp_register_script( $handle , $script[ 'src' ] , $deps , $script[ 'version' ], true );
        }

    }

    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function widgets_init() {

        $class_names = [
            'hello-world',
            'inline-editing'
        ];

        foreach ( $class_names as $class_name) {
            require_once ( ADDONS_PLUS_PATH. "includes/widgets/{$class_name}.php" );

            $class_name = str_replace(' ','_',  ucwords( str_replace('-',' ',$class_name)));

            $class_name = "{$class_name}";
            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );

        }

    }
}