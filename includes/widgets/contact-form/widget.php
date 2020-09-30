<?php


use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * Elementor Hello World
 *
 * Elementor widget for hello world.
 *
 * @since 1.0.0
 */
class Contact_Form extends Widget_Base {
	private static $formCounter = 0;

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
		return 'contact-form';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Contact Form', 'addons-plus' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_keywords() {
		return [ 'form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja' ];
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
	public function get_script_depends() {
		return [ 'addons-plus-form-script' ];
	}

	public function get_style_depends() {
		return [ 'addons-plus-form-style' ];
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
			'section_content',
			[
				'label' => __( 'Content', 'addons-plus' ),
			]
		);

		$this->add_control(
			'contact_title',
			[
				'label'   => __( 'Form Title', 'addons-plus' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Contact Form', 'addons-plus' ),
			]
		);
		$this->add_control(
			'info',
			[
				'label'       => __( 'Form Subtitle', 'addons-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Contact with Us', 'addons-plus' ),
				'label_block' => true,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'field_id', [
				'label'       => __( 'Field Id', 'addons-plus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'field_placeholder', [
				'label'       => __( 'Placeholder Text', 'addons-plus' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'field_type',
			[
				'label'   => __( 'Field Type', 'addons-plus' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'text',
				'options' => [
					'text'     => __( 'Text', 'addons-plus' ),
					'textarea' => __( 'Textarea', 'addons-plus' ),
				],
			]
		);
		$this->add_control(
			'fields',
			[
				'label'       => __( 'Fields', 'addons-plus' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ field_id }}}',
			]
		);
		$this->add_control(
			'button_text',
			array(
				'label'       => __( 'Button Text', 'addons-plus' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'SUBMIT', 'addons-plus' ),
				'label_block' => false
			)
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Form', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'form_bg',
			[
				'label'     => __( 'Form Background Color', 'addons-plus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .adp-cform-wrapper' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [ '0', '0', '0', '0' ],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .adp-cform-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->add_control(
			'form_padding',
			[
				'label'      => __( 'Form Padding', 'addons-plus' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => [ '30', '15', '30', '15' ],
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .adp-cform-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Form Info', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'ingo_alignment',
			[
				'label'   => __( 'Info Alignment', 'addons-plus' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
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
				'default' => 'left',
				'toggle'  => true,
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
					'{{WRAPPER}} .adp-cform-header h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => __( 'Heading Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .adp-cform-header h5',
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
					'{{WRAPPER}} .adp-cform-header p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'subheading_typography',
				'label'    => __( 'Sub Heading Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .adp-cform-header p',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'fields_style',
			[
				'label' => __( 'Fields', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'fields_height',
			[
				'label'      => __( 'Fields Height', 'addons-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors'  => [
					'{{WRAPPER}} .field input.ui-control' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'fields_textarea_height',
			[
				'label'      => __( 'Textarea Height', 'addons-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 120,
				],
				'selectors'  => [
					'{{WRAPPER}} .field textarea.ui-control' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'fields_margin',
			[
				'label'              => __( 'Fields Margin', 'addons-plus' ),
				'type'               => Controls_Manager::DIMENSIONS,
				'size_units'         => [ 'px' ],
				'allowed_dimensions' => [ 'bottom' ],
				'default'            => [ '0', '0', '16', '0' ],
				'selectors'          => [
					'{{WRAPPER}} .field input.ui-control' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				]
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'fields_typography',
				'label'    => __( 'Fields Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .ui-control',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'field_background',
				'label'    => __( 'Background', 'addons-plus' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .ui-control, .adp-cform-wrapper.ui.form .field.field input:-webkit-autofill:focus',
			]
		);
		$this->add_control(
			'field_color',
			[
				'label'     => __( 'Fields Color', 'addons-plus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_3,
				],
				'selectors' => [
					'{{WRAPPER}} .adp-cform-wrapper.ui.form .ui-control' => 'color: {{VALUE}}',
				],
			]
		);
		$this->start_controls_tabs( '_tabs_fields' );

		$this->start_controls_tab(
			'_tab_fields_normal',
			[
				'label' => __( 'Normal', 'addons-plus' ),
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'border',
				'label'    => __( 'Border', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .ui-control',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_fields_focus',
			[
				'label' => __( 'Focus', 'addons-plus' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'focus_border',
				'label'    => __( 'Border', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .ui-control:focus, .adp-cform-wrapper.ui.form .field.field input:-webkit-autofill:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
			'button_style',
			[
				'label' => __( 'Button', 'addons-plus' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'button_alignment',
			[
				'label'   => __( 'Button Alignment', 'addons-plus' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
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
				'default' => 'left',
				'toggle'  => true,
			]
		);
		$this->add_control(
			'button_width',
			[
				'label'      => __( 'Button Width', 'addons-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					]
				],
				'default'    => [
					'unit' => '%'
				],
				'selectors'  => [
					'{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'button_height',
			[
				'label'      => __( 'Button Height', 'addons-plus' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 1000,
						'step' => 5,
					]
				],
				'default'    => [
					'unit' => 'px',
					'size' => 40,
				],
				'selectors'  => [
					'{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( '_tabs_button_normal' );

		$this->start_controls_tab(
			'_tab_button_normal',
			[
				'label' => __( 'Normal', 'addons-plus' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'label'    => __( 'Background', 'addons-plus' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button',
			]
		);
		$this->add_control(
			'button_color',
			[
				'label'     => __( 'Color', 'addons-plus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'label'    => __( 'Border', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => __( 'Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_button_hover',
			[
				'label' => __( 'Hover', 'addons-plus' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'background_hover',
				'label'    => __( 'Background', 'addons-plus' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:hover',
			]
		);
		$this->add_control(
			'hover_button_color',
			[
				'label'     => __( 'Color', 'addons-plus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'hover_border',
				'label'    => __( 'Border', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:hover',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'hover_button_typography',
				'label'    => __( 'Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:hover',
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'_tab_button_focus',
			[
				'label' => __( 'Focus', 'addons-plus' ),
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'     => 'background_focus',
				'label'    => __( 'Background', 'addons-plus' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:focus',
			]
		);
		$this->add_control(
			'focus_button_color',
			[
				'label'     => __( 'Color', 'addons-plus' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'scheme'    => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_1,
				],
				'default'   => '#000',
				'selectors' => [
					'{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:focus' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'burron_focus_border',
				'label'    => __( 'Border', 'addons-plus' ),
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:focus',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'button_focus_typography',
				'label'    => __( 'Typography', 'addons-plus' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .adp-cform-wrapper.ui.form .contact_button.ui.button:focus',
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
		++ self::$formCounter;
		$settings = $this->get_settings_for_display();
		?>
        <div class="adp-cform-wrapper ui form">
            <form class="adp-cform" method="post">
				<?php
				wp_nonce_field( 'adp_contact', 'adp_nonce_' . self::$formCounter );
				?>
                <input type="hidden" name="action" value="adp_contact">
                <input type="hidden" name="adp_formid" value="<?php echo self::$formCounter ?>">
                <div class="adp-cform-header"
                     style="text-align: <?php echo esc_attr( $settings['ingo_alignment'] ); ?>">
                    <h5 class="ui header"><?php echo esc_html( $settings['contact_title'] ); ?></h5>
                    <p class="ui text"><?php echo esc_html( $settings['info'] ); ?></p>
                </div>
				<?php

				foreach ( $settings['fields'] as $field ) {
					$fieldId = 'adp_' . str_replace( ' ', '_', strtolower( $field['field_id'] ) ) . '_' . self::$formCounter;
					if ( 'text' == $field['field_type'] ) {
						printf( '<div class="field">
                            <input id="%s" name="%s" type="text" class="ui-control" placeholder="%s">
                        </div>', esc_attr( $fieldId ), esc_attr( $fieldId ), esc_attr( $field['field_placeholder'] ) );
					} else {
						printf( '<div class="field">
                            <textarea id="%s" name="%s" class="ui-control" rows="4" placeholder="%s"></textarea>
                        </div>', esc_attr( $fieldId ), esc_attr( $fieldId ), esc_attr( $field['field_placeholder'] ) );
					}
				}
				?>
                <div class="adp-cfrom-btn-wrap"
                     style="text-align: <?php echo esc_attr( $settings['button_alignment'] ); ?>">
                    <button type="submit"
                            class="contact_button ui button"><?php echo esc_html( $settings['button_text'] ); ?></button>
                </div>
                <p class="adp_message" style="display:none"></p>
            </form>
        </div>
		<?php

	}


}
