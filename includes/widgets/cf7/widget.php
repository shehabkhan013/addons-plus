<?php

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Addons_Plus\Forms\Initializations;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Elementor Contact Form 7
 *
 * Elementor widget for Contact Form 7.
 *
 * @since 1.0.0
 */
class Cf7 extends Widget_Base {



    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'cf7';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Contact Form 7', 'elementor-hello-world' );
    }

    public function get_keywords() {
        return [ 'form', 'contact', 'cf7', 'contact form', 'gravity', 'ninja' ];
    }
    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-ticker';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'addons-plus', 'general' ];
    }

    public function get_style_depends() {
        return [ 'addons-plus-cf7-style'];
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
            '_section_cf7',
            [
                'label' =>  Initializations::is_cf7_activated() ? __( 'Contact Form 7', 'addons-plus' ) : __( 'Missing Notice', 'addons-plus' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        if ( ! Initializations::is_cf7_activated() ) {
            $this->add_control(
                '_cf7_missing_notice',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => sprintf(
                        __( 'Hello %2$s, looks like %1$s is missing in your site. Please click on the link below and install/activate %1$s. Make sure to refresh this page after installation or activation.', 'addons-plus' ),
                        '<a href="'.esc_url( admin_url( 'plugin-install.php?s=Contact+Form+7&tab=search&type=term' ) )
                        .'" target="_blank" rel="noopener">Contact Form 7</a>',
                        Initializations::get_current_user_display_name()
                    ),
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-danger',
                ]
            );

            $this->add_control(
                '_cf7_install',
                [
                    'type' => Controls_Manager::RAW_HTML,
                    'raw' => '<a href="'.esc_url( admin_url( 'plugin-install.php?s=Contact+Form+7&tab=search&type=term' ) ).'" target="_blank" rel="noopener">Click to install or activate Contact Form 7</a>',
                ]
            );
            $this->end_controls_section();
            return;
        }

        $this->add_control(
            'form_id',
            [
                'label' => __( 'Select Your Form', 'addons-plus' ),
                'type' => Controls_Manager::SELECT,
                'label_block' => true,
                'options' => ['' => __( '', 'addons-plus' ) ] + Initializations::get_cf7_forms(),
            ]
        );
        $this->add_control(
            'html_class',
            [
                'label' => __( 'HTML Class', 'addons-plus' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'description' => __( 'Add CSS custom class to the form.', 'addons-plus' ),
            ]
        );
        $this->add_control(
            'contact_title',
            [
                'label' => __( 'Form Title', 'addons-plus' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Contact Form', 'addons-plus' ),
            ]
        );
        $this->add_control(
            'info',
            [
                'label' => __( 'Form Subtitle', 'addons-plus' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'Contact with Us', 'addons-plus' ),
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            '_section_from_style',
            [
                'label' => __('Form', 'happy-elementor-addons'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .adp-cf7-form-wrap',
            ]
        );
        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'plugin-domain' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .adp-cf7-form-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'padding',
            [
                'label' => __( 'Padding', 'plugin-domain' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .adp-cf7-form-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            '_section_info_style',
            [
                'label' => __( 'Form Info', 'happy-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ingo_alignment',
            [
                'label' => __( 'Info Alignment', 'addons-plus' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'addons-plus' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'addons-plus' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'addons-plus' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
            ]
        );
        $this->add_control(
            'heading_margin',
            [
                'label' => __( 'Heading Margin', 'addons-plus' ),
                'type' => Controls_Manager::DIMENSIONS,
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'size_units' => [ 'px'],
                'selectors' => [
                    '{{WRAPPER}} .adp-cf7-info h5' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __( 'Heading Typography', 'addons-plus' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .adp-cf7-info h5',
            ]
        );
        $this->add_control(
            'subheading_margin',
            [
                'label' => __( 'Sub Heading Margin', 'addons-plus' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px'],
                'allowed_dimensions' => [ 'top', 'bottom' ],
                'selectors' => [
                    '{{WRAPPER}} .adp-cf7-info p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subheading_typography',
                'label' => __( 'Sub Heading Typography', 'addons-plus' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .adp-cf7-info p',
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            '_section_fields_style',
            [
                'label' => __( 'Form Fields', 'happy-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'field_width',
            [
                'label' => __( 'Width', 'happy-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .adp-cf7-form label' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'field_margin',
            [
                'label' => __( 'Fields Spacing', 'happy-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'field_padding',
            [
                'label' => __( 'Padding', 'happy-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'field_border_radius',
            [
                'label' => __( 'Border Radius', 'happy-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'hr',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'label' => __( 'Typography', 'happy-elementor-addons' ),
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3
            ]
        );
        $this->add_control(
            'field_color',
            [
                'label' => __( 'Text Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->add_control(
            'field_placeholder_color',
            [
                'label' => __( 'Placeholder Text Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ::-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->start_controls_tabs( 'tabs_field_state' );
        $this->start_controls_tab(
            'tab_field_normal',
            [
                'label' => __( 'Normal', 'happy-elementor-addons' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_border',
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_box_shadow',
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)',
            ]
        );
        $this->add_control(
            'field_bg_color',
            [
                'label' => __( 'Background Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_field_focus',
            [
                'label' => __( 'Focus', 'happy-elementor-addons' ),
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'field_focus_border',
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'field_focus_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus',
            ]
        );
        $this->add_control(
            'field_focus_bg_color',
            [
                'label' => __( 'Background Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
        $this->start_controls_section(
            'cf7-form-label',
            [
                'label' => __( 'Form Fields Label', 'happy-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'label_margin',
            [
                'label' => __( 'Spacing Bottom', 'happy-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit)' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'hr3',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => __( 'Typography', 'happy-elementor-addons' ),
                'selector' => '{{WRAPPER}} label',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3
            ]
        );
        $this->add_control(
            'label_color',
            [
                'label' => __( 'Text Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} label' => 'color: {{VALUE}}',
                ],
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'submit',
            [
                'label' => __( 'Button', 'happy-elementor-addons' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_responsive_control(
            'button_width',
            [
                'label' => __( 'Width', 'happy-elementor-addons' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px' ],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form-control.wpcf7-submit' => 'width: {{SIZE}}{{UNIT}};'
                ],
            ]
        );
        $this->add_responsive_control(
            'submit_margin',
            [
                'label' => __( 'Margin', 'happy-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'submit_padding',
            [
                'label' => __( 'Padding', 'happy-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'selector' => '{{WRAPPER}} .wpcf7-submit',
                'scheme' => Scheme_Typography::TYPOGRAPHY_4
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'submit_border',
                'selector' => '{{WRAPPER}} .wpcf7-submit',
            ]
        );
        $this->add_control(
            'submit_border_radius',
            [
                'label' => __( 'Border Radius', 'happy-elementor-addons' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submit_box_shadow',
                'selector' => '{{WRAPPER}} .wpcf7-submit',
            ]
        );
        $this->add_control(
            'hr4',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );
        $this->start_controls_tabs( 'tabs_button_style' );
        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'happy-elementor-addons' ),
            ]
        );
        $this->add_control(
            'submit_color',
            [
                'label' => __( 'Text Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submit_bg_color',
            [
                'label' => __( 'Background Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'happy-elementor-addons' ),
            ]
        );
        $this->add_control(
            'submit_hover_color',
            [
                'label' => __( 'Text Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submit_hover_bg_color',
            [
                'label' => __( 'Background Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'submit_hover_border_color',
            [
                'label' => __( 'Border Color', 'happy-elementor-addons' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-submit:hover, {{WRAPPER}} .wpcf7-submit:focus' => 'border-color: {{VALUE}};',
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
        if ( ! Initializations::is_cf7_activated() ) {
            return;
        }

        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['form_id'] ) ) {
            ?>
            <div class="adp-cf7-form-wrap">
            <div class="adp-cf7-info" style="text-align: <?php echo esc_attr( $settings[ 'ingo_alignment' ]);?>">
                <h5><?php echo esc_html__($settings[ 'contact_title' ], 'addons-plus')?></h5>
                <p><?php echo esc_html__($settings[ 'info' ], 'addons-plus')?></p>
            </div>
            <?php
            $_class = 'adp-cf7-form ' . sanitize_html_class( $settings['html_class']);
            echo do_shortcode('[contact-form-7 id="'. $settings['form_id'] .'" html_class="'. $_class .'"]');
            ?>
            </div>
        <?php
        }
    }


}
