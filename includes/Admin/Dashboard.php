<?php


namespace Addons_Plus\Admin;

/**
 * Class Dashboard
 * @package Addons_plus\Admin
 */
class Dashboard {

	public function plugin_dashboard_page() {


		$template = __DIR__ . '/views/dashboard.php';


		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}