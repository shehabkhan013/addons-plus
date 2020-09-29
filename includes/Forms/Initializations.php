<?php


namespace Addons_Plus\Forms;


class Initializations
{


    /**
     * Check if contact form 7 is activated
     *
     * @return bool
     */
    public static function is_cf7_activated() {
        return class_exists( '\WPCF7' );
    }
    /**
     * Check if We Form is activated
     *
     * @return bool
     */
    public static function is_weforms_activated() {
        return class_exists( '\WeForms' );
    }

    /**
     * Get a list of all CF7 forms
     *
     * @return array
     */
    public static function get_cf7_forms() {
        $forms = [];

        if ( self::is_cf7_activated() ) {
            $_forms = get_posts( [
                'post_type'      => 'wpcf7_contact_form',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ] );

            if ( ! empty( $_forms ) ) {
                $forms = wp_list_pluck( $_forms, 'post_title', 'ID' );
            }
        }

        return $forms;
    }



    /**
     * Get a list of all WeForm
     *
     * @return array
     */
    public static function get_we_forms() {
        $forms = [];

        if ( self::is_weforms_activated() ) {
            $_forms = get_posts( [
                'post_type' => 'wpuf_contact_form',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            ] );

            if ( ! empty( $_forms ) ) {
                $forms = wp_list_pluck( $_forms, 'post_title', 'ID' );
            }
        }

        return $forms;
    }
    public static function get_current_user_display_name() {
        $user = wp_get_current_user();
        $name = 'user';
        if ( $user->exists() && $user->display_name ) {
            $name = $user->display_name;
        }
        return $name;
    }

}