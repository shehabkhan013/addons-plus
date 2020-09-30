<?php

namespace Addons_Plus\Admin;

/**
 * Class Menu
 * @package Addons_plus\Admin
 */
class Menu {

	function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}


	public function admin_menu() {

		$parent_slug         = 'addons-plus';
		$parent_title        = __( 'AdonsPlus', 'addons-plus' );
		$sub_title_dashboard = __( 'Dashboard', 'addons-plus' );
		$sub_title_settings  = __( 'Settings', 'addons-plus' );
		$capability          = 'manage_options';
		add_menu_page( $parent_title, $parent_title, $capability, $parent_slug, [
			$this,
			'dashboard_page'
		], 'dashicons-plugins-checked', '59' );
		add_submenu_page( $parent_slug, $sub_title_dashboard, $sub_title_dashboard, $capability, $parent_slug, [
			$this,
			'dashboard_page'
		] );
		add_submenu_page( $parent_slug, $sub_title_settings, $sub_title_settings, $capability, 'settings', [
			$this,
			'settings_page'
		] );

	}

	/**
	 * Dashboard Page
	 *
	 * @package AddonsPlus
	 */
	public function dashboard_page() {

		$dashboard = new Dashboard();
		$dashboard->plugin_dashboard_page();

	}

	/**
	 * Settings Page
	 *
	 * @package AddonsPlus
	 */
	public function settings_page() {
		$settings = new Settings();
		$settings->plugin_settings_page();
	}


}