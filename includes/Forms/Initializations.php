<?php


namespace Addons_Plus\Forms;


class Initializations {


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
	 * Check if WPForms is activated
	 *
	 * @return bool
	 */
	public static function is_wpforms_activated() {
		return class_exists( '\WPForms\WPForms' );
	}

	/**
	 * Check if Ninja Form is activated
	 *
	 * @return bool
	 */
	public static function is_ninjaforms_activated() {
		return class_exists( '\Ninja_Forms' );
	}


	/**
	 * Check if Gravity Forms is activated
	 *
	 * @return bool
	 */
	public static function is_gravityforms_activated() {
		return class_exists( '\GFForms' );
	}


	/**
	 * Check if Caldera Form is activated
	 *
	 * @return bool
	 */

	public static function is_calderaforms_activated() {
		return class_exists( '\Caldera_Forms' );
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
				'posts_per_page' => - 1,
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
	 *  Get a list of all Gravity Forms
	 * @returns array
	 */

	public static function get_gravity_form() {
		$forms = [];

		if ( self::is_gravityforms_activated() ) {
			$gravity_forms = \RGFormsModel::get_forms( null, 'title' );

			if ( ! empty( $gravity_forms ) && ! is_wp_error( $gravity_forms ) ) {
				foreach ( $gravity_forms as $gravity_form ) {
					$forms[ $gravity_form->id ] = $gravity_form->title;
				}
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
				'post_type'      => 'wpuf_contact_form',
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
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
	 * Get a list of all WPForms
	 *
	 * @return array
	 */
	public static function get_wpforms() {
		$forms = [];

		if ( self::is_wpforms_activated() ) {
			$_forms = get_posts( [
				'post_type'      => 'wpforms',
				'post_status'    => 'publish',
				'posts_per_page' => - 1,
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
	 * Get a list of all Ninja Form
	 *
	 * @return array
	 */
	public static function get_ninjaform() {
		$forms = [];

		if ( self::is_ninjaforms_activated() ) {
			$_forms = \Ninja_Forms()->form()->get_forms();

			if ( ! empty( $_forms ) && ! is_wp_error( $_forms ) ) {
				foreach ( $_forms as $form ) {
					$forms[ $form->get_id() ] = $form->get_setting( 'title' );
				}
			}
		}

		return $forms;
	}

	/**
	 * Get a list of all Caldera Form
	 *
	 * @return array
	 */
	public static function get_caldera_form() {
		$forms = [];

		if ( self::is_calderaforms_activated() ) {
			$_forms = \Caldera_Forms_Forms::get_forms( true, true );

			if ( ! empty( $_forms ) && ! is_wp_error( $_forms ) ) {
				foreach ( $_forms as $form ) {
					$forms[ $form['ID'] ] = $form['name'];
				}
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