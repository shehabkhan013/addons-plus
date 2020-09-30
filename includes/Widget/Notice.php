<?php


namespace Addons_Plus\Widget;


use Addons_Plus\Widget;

class Notice {

	public function __construct() {
		$this->dependency_notice();
	}

	public function dependency_notice() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'missing_main_plugin' ] );

			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, \Addons_Plus::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'elementor_version' ] );

			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, \Addons_Plus::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'php_version' ] );

			return;
		}

		new \Addons_Plus\Widget\Dependency();

	}


	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '%1$s requires %2$s to be installed and activated to function properly. %3$s', 'addons-plus' ),
			'<strong>' . esc_html__( 'Addons Plus', 'addons-plus' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'addons-plus' ) . '</strong>',
			'<a href="' . esc_url( admin_url( 'plugin-install.php?s=Elementor&tab=search&type=term' ) ) . '">' . esc_html__( 'Please click on this link and install Elementor', 'addons-plus' ) . '</a>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '%1$s requires %2$s version %3$s or greater.', 'addons-plus' ),
			'<strong>' . esc_html__( 'Addons Plus', 'addons-plus' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'addons-plus' ) . '</strong>',
			\Addons_Plus::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '%1$s requires %2$s version %3$s or greater.', 'addons-plus' ),
			'<strong>' . esc_html__( 'Addons Plus', 'addons-plus' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'addons-plus' ) . '</strong>',
			\Addons_Plus::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}