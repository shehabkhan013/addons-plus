<?php


namespace Addons_Plus\Admin;

/**
 * Class Settings
 * @package Addons_plus\Admin
 */
class Settings {
	public function plugin_settings_page() {
		$template = __DIR__ . '/views/settings.php';

		if ( file_exists( $template ) ) {
			include $template;
		}
	}
}