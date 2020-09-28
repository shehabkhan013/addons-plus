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
     * @access public
     */
    public function __construct() {

        // Register widget Scripts
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
        // Register widget Styles
        add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] );

        // Register Categories
        add_action( 'elementor/elements/categories_registered', [ $this, 'widgets_categories' ] );
        // Register Widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'widgets_init' ] );

        add_action('wp_ajax_nopriv_adp_contact',[$this,'process_contact_form']);
        add_action('wp_ajax_adp_contact',[$this,'process_contact_form']);
    }

    private function formSanitizer($data){

        $prefix = 'adp_';
        $formId = '_'.$data[$prefix.'formid'];

        $form_data = array();

        foreach ($data as $key => $item){
            $form_data[ltrim($prefix,rtrim($formId,$key))] = $item;
        }

        foreach (['nonce','_wp_http_referer','action','formid'] as $item) {

            if (isset($form_data[$item])){
                unset($form_data[$item]);
            };

        }

        return $form_data;

    }
    public function process_contact_form() {
        $prefix = 'adp_';

        if(strtoupper($_SERVER["REQUEST_METHOD"]) != "POST") return;
        $formId = '_'.$_POST[$prefix.'formid'];


        if ( wp_verify_nonce( $_POST[ 'adp_nonce' . $formId ], 'adp_contact' ) ) {
            $email = get_option( 'admin_email' );
            $data = '';
            $form_data = !empty($_POST) ? $this->formSanitizer($_POST) : [];



            foreach ( $form_data as $key => $val ) {
                $data .= sprintf( "%s = %s<br>", $key, sanitize_text_field( $val ) );
            }
            wp_mail( $email, __( 'Contact Form Submission', 'addons-plus' ), $data );

            wp_send_json([
                'success'   => 'OK',
                'message'   => __('Thank you for your message. It has been sent.', 'addons-plus')
            ]);

        }else{

            wp_send_json([
                'success'   => 'FAIL',
                'message'   => __( 'There was an error trying to send your message. Please try again later.', 'addons-plus')
            ]);

        }

        die();
    }
    public function get_widgets_styles() {
        return [
            'addons-plus-form-style' => [
                'src' => ADDONS_PLUS_URL .'assets/widgets/css/contact-form.css',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/widgets/css/contact-form.css' ),
            ],
            'addons-plus-cf7-style' => [
                'src' => ADDONS_PLUS_URL .'assets/widgets/css/cf7.css',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/widgets/css/cf7.css' ),
            ]
        ];
    }
    public function get_widgets_scripts() {
        return [
            'addons-plus-form-script' =>[
                'src' => ADDONS_PLUS_URL .'assets/widgets/js/contact-form.js',
                'version' => filemtime( ADDONS_PLUS_PATH . 'assets/widgets/js/contact-form.js' ),
                'deps' => [ 'jquery' ]
            ]
        ];
    }

    /**
     * widget_scripts
     *
     * Load required plugin core files.
     *
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

        $ajax_url = admin_url( 'admin-ajax.php' );
        wp_localize_script( 'addons-plus-form-script', 'adp_contact', [ 'ajax_url' => $ajax_url ] );


    }

    /**
     * Register Categories
     *
     * Register new Elementor Categories.
     *
     * @access public
     */

    public function widgets_categories( $manager ) {
        $manager->add_category( 'addons-plus', [
            'title'=>__( 'Addons Plus', 'addons-plus' ),
            'icon' => 'dashicons-plugins-checked'
        ]);
    }


    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @access public
     */
    public function widgets_init() {

        $folder_names = [
            'contact-form',
            'cf7',
        ];


        foreach ( $folder_names as $folder_name) {
            require_once ( ADDONS_PLUS_PATH. "includes/widgets/{$folder_name}/widget.php" );

            $class_name = str_replace(' ','_',  ucwords( str_replace('-',' ',$folder_name)));

            \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );

        }

    }
}