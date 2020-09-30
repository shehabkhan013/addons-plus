<?php

use Elementor\Group_Control_Text_Shadow;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Addons_Plus\Forms\Initializations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Elementor WPForms
 *
 * Elementor widget for WPForms.
 *
 * @since 1.0.0
 */
class Caldera_Form extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_name() {
		return 'caldera-forms';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Caldera Forms', 'addons-plus' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_keywords() {
		return [ 'wpf', 'wpform', 'form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja' ];
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array Widget categories.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_categories() {
		return [ 'addons-plus', 'general' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @return array Widget scripts dependencies.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_style_depends() {
		return [ 'addons-plus-caldera-forms-style' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'_section_calderaforms',
			[
				'label' => Initializations::is_calderaforms_activated() ? __( 'Caldera Forms', 'addons-plus' ) : __( 'Missing Notice',
					'addons-plus' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		if ( ! Initializations::is_calderaforms_activated() ) {
			$this->add_control(
				'_calderaforms_missing_notice',
				[
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf(
						__( 'Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'addons-plus' ),
						'<a href="' . esc_url( admin_url( 'plugin-install.php?s=Caldera+Forms&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">' . __( "Caldera Form", 'addons-plus' ) . '</a>',
						Initializations::get_current_user_display_name()
					),
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
				]
			);

			$this->add_control(
				'_calderaforms_install',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw'  => '<a href="' . esc_url( admin_url( 'plugin-install.php?s=Caldera+Forms&tab=search&type=term' ) ) . '" target="_blank" rel="noopener">' . __( "Click to install or activate Caldera Form", "addons-plus" ) . '</a>',
				]
			);
			$this->end_controls_section();

			return;
		}

		$this->add_control(
			'form_id',
			[
				'label'       => __( 'Select Your Form', 'addons-plus' ),
				'type'        => Controls_Manager::SELECT,
				'label_block' => true,
				'options'     => [ '' => __( 'Select a Caldera Form ', 'addons-plus' ) ] + Initializations::get_caldera_form(),
			]
		);
		$this->add_control(
			'html_class',
			[
				'label'       => __( 'HTML Class', 'addons-plus' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'description' => __( 'Add CSS custom class to the form.', 'addons-plus' ),
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'_section_from_style',
			[
				'label' => __( 'Form', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'label'    => __( 'Background', 'addons-plus' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .adp-caldera-form-wrap',
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .adp-caldera-form-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'padding',
			[
				'label'      => __( 'Padding', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .adp-caldera-form-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'_section_info_style',
			[
				'label' => __( 'Form Info', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'ingo_alignment',
			[
				'label'        => __( 'Info Alignment', 'addons-plus' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => [
					'left'   => [
						'title' => __( 'Left', 'addons-plus' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'addons-plus' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'addons-plus' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'      => 'left',
				'toggle'       => true,
				'prefix_class' => 'adp-form-sub-label--%s',
				'selectors'    => [
					'{{WRAPPER}} .first_row' => 'text-align: {{Value}};',
				],
			]
		);
		$this->add_control(
			'heading_margin',
			[
				'label'              => __( 'Heading Margin', 'addons-plus' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'allowed_dimensions' => [ 'top', 'bottom' ],
				'size_units'         => [ 'px' ],
				'selectors'          => [
					'{{WRAPPER}} .first_row h2' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => __( 'Heading Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .first_row h2',
			]
		);
		$this->add_control(
			'subheading_margin',
			[
				'label'              => __( 'Sub Heading Margin', 'addons-plus' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'allowed_dimensions' => [ 'top', 'bottom' ],
				'selectors'          => [
					'{{WRAPPER}} .first_row p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'subheading_typography',
				'label'    => __( 'Sub Heading Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .first_row p',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'_section_fields_style',
			[
				'label' => __( 'Form Fields', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'field_width',
			[
				'label'      => __( 'Width', 'addons-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'unit' => '%',
					'size' => 99
				],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 800,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .form-group:not(.btn)' => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .form-group:not(.btn)' => 'width: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'field_margin',
			[
				'label'      => __( 'Field Spacing', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .form-group:not(.btn)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_padding',
			[
				'label'      => __( 'Padding', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .form-group:not(.btn) input, {{WRAPPER}} .form-group:not(.btn) textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'field_border_radius',
			[
				'label'      => __( 'Border Radius', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .form-group:not(.btn) input, {{WRAPPER}} .form-group:not(.btn) textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'field_typography',
				'label'    => __( 'Typography', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .form-group:not(.btn) input, {{WRAPPER}} .form-group:not(.btn) textarea',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3
			]
		);

		$this->add_control(
			'field_textcolor',
			[
				'label'     => __( 'Field Text Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .form-group:not(.btn) ' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'field_placeholder_color',
			[
				'label'     => __( 'Field Placeholder Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ::-webkit-input-placeholder' => 'color: {{VALUE}};',
					'{{WRAPPER}} ::-moz-placeholder'          => 'color: {{VALUE}};',
					'{{WRAPPER}} ::-ms-input-placeholder'     => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_field_state' );

		$this->start_controls_tab(
			'tab_field_normal',
			[
				'label' => __( 'Normal', 'addons-plus' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'field_border',
				'selector' => '{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_box_shadow',
				'selector' => '{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea',
			]
		);

		$this->add_control(
			'field_bg_color',
			[
				'label'     => __( 'Background Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-field input, {{WRAPPER}} .wpforms-field-textarea textarea' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_field_focus',
			[
				'label' => __( 'Focus', 'addons-plus' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'field_focus_border',
				'selector' => '{{WRAPPER}} .wpforms-field input:focus, {{WRAPPER}} .wpforms-field-textarea textarea:focus',
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'field_focus_box_shadow',
				'exclude'  => [
					'box_shadow_position',
				],
				'selector' => '{{WRAPPER}} .wpforms-field input:focus, {{WRAPPER}} .wpforms-field-textarea textarea:focus',
			]
		);

		$this->add_control(
			'field_focus_bg_color',
			[
				'label'     => __( 'Background Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-field input:focus, {{WRAPPER}} .wpforms-field-textarea textarea:focus' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'caldera-form-label',
			[
				'label' => __( 'Form Fields Label', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'label_margin',
			[
				'label'      => __( 'Margin', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpforms-field-container label.wpforms-field-label' => 'display: inline-block; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'label_padding',
			[
				'label'      => __( 'Padding', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpforms-field-container label.wpforms-field-label' => 'display: inline-block; padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'sub_label',
			[
				'label'           => __( 'Sub Label', 'addons-plus' ),
				'type'            => Controls_Manager::CHOOSE,
				'options'         => [
					'none'  => [
						'title' => __( 'Hide', 'addons-plus' ),
						'icon'  => 'eicon-minus-square',
					],
					'block' => [
						'title' => __( 'Show', 'addons-plus' ),
						'icon'  => 'eicon-plus-square',
					],

				],
				'desktop_default' => 'block',
				'toggle'          => false,
				'prefix_class'    => 'adp-form-sub-label--%s',
				'selectors'       => [
					'{{WRAPPER}} .wpforms-field-container label.wpforms-field-sublabel' => 'display: {{Value}};',
				],
			]
		);
		$this->add_control(
			'hr3',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'label_typography',
				'label'    => __( 'Label Typography', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .wpforms-field-container label.wpforms-field-label',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'sublabel_typography',
				'label'     => __( 'Sub Label Typography', 'addons-plus' ),
				'selector'  => '{{WRAPPER}} .wpforms-field-sublabel',
				'scheme'    => Scheme_Typography::TYPOGRAPHY_3,
				'condition' => [
					'sub_label' => 'block'
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'desc_typography',
				'label'    => __( 'Description Typography', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .wpforms-field-description',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3
			]
		);

		$this->add_control(
			'label_color_popover',
			[
				'label'        => __( 'Colors', 'addons-plus' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'label_off'    => __( '', 'addons-plus' ),
				'label_on'     => __( 'Custom', 'addons-plus' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_control(
			'label_color',
			[
				'label'     => __( 'Label Text Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-field-container label.wpforms-field-label' => 'color: {{VALUE}}',
				],
				'condition' => [
					'label_color_popover' => 'yes'
				],
			]
		);

		$this->add_control(
			'requered_label',
			[
				'label'     => __( 'Required Label Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-required-label' => 'color: {{VALUE}}',
				],
				'condition' => [
					'label_color_popover' => 'yes'
				],
			]
		);

		$this->add_control(
			'sublabel_color',
			[
				'label'     => __( 'Sub Label Text Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-field-sublabel' => 'color: {{VALUE}}',
				],
				'condition' => [
					'label_color_popover' => 'yes'
				],
			]
		);

		$this->add_control(
			'desc_label_color',
			[
				'label'     => __( 'Description Text Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-field-description' => 'color: {{VALUE}}',
				],
				'condition' => [
					'label_color_popover' => 'yes'
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
			'submit',
			[
				'label' => __( 'Button', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_width',
			[
				'label'      => __( 'Button Width', 'addons-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'unit' => '%',
					'size' => 100
				],
				'range'      => [
					'%'  => [
						'min' => 1,
						'max' => 100,
					],
					'px' => [
						'min' => 1,
						'max' => 800,
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .wpforms-submit' => 'display: block; width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'submit_margin',
			[
				'label'      => __( 'Margin', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpforms-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'submit_padding',
			[
				'label'      => __( 'Padding', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpforms-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'submit_typography',
				'selector' => '{{WRAPPER}} .wpforms-submit',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'submit_border',
				'selector' => '{{WRAPPER}} .wpforms-form .wpforms-submit-container button[type=submit]',
			]
		);

		$this->add_control(
			'submit_border_radius',
			[
				'label'      => __( 'Border Radius', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpforms-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'submit_box_shadow',
				'selector' => '{{WRAPPER}} .wpforms-submit',
			]
		);

		$this->add_control(
			'hr4',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => __( 'Normal', 'addons-plus' ),
			]
		);

		$this->add_control(
			'submit_color',
			[
				'label'     => __( 'Text Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wpforms-submit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_bg_color',
			[
				'label'     => __( 'Background Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-submit' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => __( 'Hover', 'addons-plus' ),
			]
		);

		$this->add_control(
			'submit_hover_color',
			[
				'label'     => __( 'Text Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-submit:hover, {{WRAPPER}} .wpforms-submit:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_hover_bg_color',
			[
				'label'     => __( 'Background Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-submit:hover, {{WRAPPER}} .wpforms-submit:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'submit_hover_border_color',
			[
				'label'     => __( 'Border Color', 'addons-plus' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .wpforms-submit:hover, {{WRAPPER}} .wpforms-submit:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		if ( ! Initializations::is_calderaforms_activated() ) {
			return;
		}

		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['form_id'] ) ) {
			?>
            <div class="adp-caldera-form-wrap">
				<?php
				$_class = 'adp-caldera-form ' . sanitize_html_class( $settings['html_class'] );
				echo do_shortcode( '[caldera_form id="' . $settings['form_id'] . '" html_class="' . $_class . '"]' );
				?>
            </div>
			<?php
		}

	}
}