<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Core\Responsive\Responsive;
use Elementor\Repeater;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Parallax {
    public function __construct() {
        // Fix Parallax granular-controls-for-elementor
        if (function_exists('granular_get_options')) {
            $parallax_on = granular_get_options('granular_editor_parallax_on', 'granular_editor_settings', 'no');
            if ('yes' === $parallax_on) {
                add_action('elementor/frontend/section/after_render', [$this, 'granular_editor_after_render'], 10, 1);
            }
        }

        add_action('elementor/element/section/section_layout/after_section_end', [$this, 'register_controls'], 10, 2);
        add_action('elementor/frontend/section/after_render', [$this, 'osf_paralax_render'], 10, 1);
    }

    public function granular_editor_after_render($element) {
        $settings = $element->get_settings();
        if ($element->get_settings('section_parallax_on') == 'yes') {
            $type        = $settings['parallax_type'];
            $and_support = $settings['android_support'];
            $ios_support = $settings['ios_support'];
            $speed       = $settings['parallax_speed'];
            ?>

            <script type="text/javascript">
                (function ($) {
                    "use strict";
                    var granularParallaxElementorFront = {
                        init: function () {
                            elementorFrontend.hooks.addAction('frontend/element_ready/global', granularParallaxElementorFront.initWidget);
                        },
                        initWidget: function ($scope) {
                            $('.elementor-element-<?php echo $element->get_id(); ?>').jarallax({
                                type: '<?php echo $type; ?>',
                                speed: <?php echo $speed; ?>,
                                keepImg: true,
                                // imgSize: 'cover',
                                imgSize: $background_size,
                                imgPosition: '50% 0%',
                                noAndroid: <?php echo $and_support; ?>,
                                noIos: <?php echo $ios_support; ?>
                            });
                        }
                    };
                    $(window).on('elementor/frontend/init', granularParallaxElementorFront.init);
                }(jQuery));
            </script>

        <?php }
    }

    public function osf_paralax_render($element) {
        $svgfile = $this->render_svg();

        wp_enqueue_script('parallaxmouse');
        $settings      = $element->get_settings();
        $repeater_list = (isset($settings['osf_section_parallax_layer']) && $settings['osf_section_parallax_layer']) ? $settings['osf_section_parallax_layer'] : array();
        if ($settings['osf_section_parallax_switcher'] === 'yes') {
            foreach ($repeater_list as $layer):

                $html = '';
                if ($layer['osf_section_parallax_item_style'] == 'image') {
                    $image_url = $layer['osf_section_parallax_image']['url'];
                    if (!empty($image_url)) {
                        $path_parts = pathinfo($image_url);
                        if ($path_parts['extension'] === 'svg') {
                            $image = $layer['osf_section_parallax_image'];
                            if ($image['id']) {
                                $pathSvg = get_attached_file($image['id']);
                                $html    = osf_get_icon_svg($pathSvg);
                            }

                        } else {
                            $html = '<img src="' . $layer['osf_section_parallax_image']['url'] . '" title="" alt="">';
                        }
                    }

                } else {
                    $html = $svgfile[$layer['osf_section_parallax_item_svg_style']];
                }
                $parallax_mouse = $layer['osf_section_parallax_mouse'] == 'yes' ? 'true' : 'false';
                echo '<div class="parallax-layer elementor-repeater-item-' . $layer['_id'] . ' parallax-layer-' . $layer['_id'] . $element->get_id() . ' f-' . $layer['osf_section_parallax_item_svg_color_type'] . '" data-parallax="' . $parallax_mouse . '" data-rate="' . $layer['osf_section_parallax_rate'] . '">' . $html . '</div>';
            endforeach;
            ?>
            <script type="text/javascript">
                (function ($) {
                    "use strict";

                    <?php foreach( $repeater_list as $layer ): ?>

                    $(' .parallax-layer-<?php echo $layer['_id'] . $element->get_id();?>').prependTo($('.elementor-element-<?php echo $element->get_id(); ?>')).css({
                        'z-index': <?php echo !empty($layer['osf_section_parallax_z_index']) ? $layer['osf_section_parallax_z_index'] : 0; ?>,
                        'left': <?php echo !empty($layer['osf_section_parallax_position_h']['size']) ? $layer['osf_section_parallax_position_h']['size'] : 50; ?> +'<?php echo !empty($layer['osf_section_parallax_position_h']['unit']) ? $layer['osf_section_parallax_position_h']['unit'] : '%'; ?>',
                        'top': <?php echo !empty($layer['osf_section_parallax_position_v']['size']) ? $layer['osf_section_parallax_position_v']['size'] : 50; ?> +'<?php echo !empty($layer['osf_section_parallax_position_v']['unit']) ? $layer['osf_section_parallax_position_v']['unit'] : '%'; ?>'
                    });

                    <?php endforeach; ?>
                    if ($(window).outerWidth() > <?php echo esc_js(Responsive::get_breakpoints()['md']); ?> ) {
                        $('.elementor-element-<?php echo $element->get_id(); ?>').mousemove(function (e) {
                            $(this).find('.parallax-layer[data-parallax="true"]').each(function (index, element) {
                                $(this).jsparallax($(this).data('rate'), e);
                            });
                        });
                    }
                }(jQuery));
            </script>
            <?php
        }

    }

    public function register_controls($element, $args) {

        $element->start_controls_section(
            'osf_section_parallax',
            [
                'label' => __('Multi Parallax ', 'medilazar-core'),
                'tab'   => Controls_Manager::TAB_LAYOUT,
            ]
        );
        $element->add_control('osf_section_parallax_switcher',
            [
                'label' => __('Enable Parallax', 'medilazar-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'osf_section_parallax_item_style',
            [
                'label'   => __('Parallax Type', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'image' => __('Image', 'medilazar-core'),
                    'svg'   => __('Svg', 'medilazar-core'),
                    'svg'   => __('Opal Style', 'medilazar-core'),
                ],
                'default' => 'image',
            ]
        );

        $repeater->add_control(
            'osf_section_parallax_item_svg_style',
            [
                'label'     => __('Opal Style', 'medilazar-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    '0' => __('Style 1', 'medilazar-core'),
                    '1' => __('Style 2', 'medilazar-core'),
                    '2' => __('Style 3', 'medilazar-core'),
                    '3' => __('Style 4', 'medilazar-core'),
                ],
                'default'   => '1',
                'condition' => [
                    'osf_section_parallax_item_style' => 'svg'
                ]
            ]
        );

        $repeater->add_control(
            'osf_section_parallax_image',
            [
                'label'     => __('Choose Image', 'medilazar-core'),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'osf_section_parallax_item_style' => 'image'
                ]
            ]
        );

        $repeater->add_control(
            'osf_section_parallax_item_svg_color_type',
            [
                'label'   => __('Opal Style Color', 'medilazar-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'primary'   => __('Primary', 'medilazar-core'),
                    'secondary' => __('Secondary', 'medilazar-core'),
                    'custom'    => __('Custom', 'medilazar-core'),
                ],
                'default' => 'custom',
            ]
        );

        $repeater->add_control(
            'osf_section_parallax_item_svg_color',
            [
                'label'     => __('Custom Color', 'medilazar-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'osf_section_parallax_item_svg_color_type' => 'custom',
                ],
            ]
        );

        $repeater->add_control(
            'osf_section_parallax_item_svg_width',

            [
                'name'       => 'osf_section_parallax_item_svg_width',
                'label'      => __('Width', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'range'      => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 2000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 150,
                    ]
                ],
                'size_units' => ['%', 'px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer svg, {{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer img'                                                  => 'object-fit: fill;'
                ],
                //						'condition'  => [
                //							'osf_section_parallax_item_style' => 'svg'
                //						]
            ]
        );
        $repeater->add_control(
            'osf_section_parallax_item_svg_height',
            [
                'label'      => __('Height', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'size' => 100,
                    'unit' => '%',
                ],
                'range'      => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 2000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 150,
                    ]
                ],
                'size_units' => ['%', 'px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer svg, {{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer img' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer'                                                      => 'min-height: 100px;',
                ],
                //						'condition'  => [
                //							'osf_section_parallax_item_style' => 'svg'
                //						]
            ]
        );
        $repeater->add_control(
            'osf_section_parallax_item_svg_rotate',
            [
                'label'     => __('Rotate', 'medilazar-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 0,
                    'unit' => 'deg'
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.parallax-layer svg' => 'rotate({{SIZE}}{{UNIT}})'
                ],
                'condition' => [
                    'osf_section_parallax_item_style' => 'svg'
                ]
            ]
        );
        $repeater->add_control(
            'osf_section_parallax_position_h',
            [
                'label'      => __('Position h', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'size_units' => ['%', 'px', 'em'],
            ]
        );
        $repeater->add_control(
            'osf_section_parallax_position_v',
            [
                'label'      => __('Position v', 'medilazar-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    '%'  => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 150,
                    ],
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'size_units' => ['%', 'px', 'em'],
            ]
        );
        $repeater->add_control(
            'osf_section_parallax_z_index',
            [
                'label'       => __('Z-Index', 'medilazar-core'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 1,
                'description' => __('Choose z-index for the parallax layer, default: 3', 'medilazar-core'),
            ]
        );
        $repeater->add_control(
            'osf_section_parallax_mouse',
            [
                'label'       => __('Mousemove Parallax', 'medilazar-core'),
                'type'        => Controls_Manager::SWITCHER,
                'description' => __('Enable or disable mousemove interaction', 'medilazar-core'),
            ]
        );
        $repeater->add_control(
            'osf_section_parallax_rate',
            [
                'label'   => __('Rate', 'medilazar-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => -10,
                'min'     => -20,
                'max'     => 20,
                'step'    => 1,
            ]
        );
        $element->add_control(
            'osf_section_parallax_layer',
            [
                'label'     => __('Parallax Items', 'medilazar-core'),
                'type'      => Controls_Manager::REPEATER,
                'condition' => [
                    'osf_section_parallax_switcher' => 'yes',
                ],
                'fields'    => $repeater->get_controls(),
            ]
        );

        $element->end_controls_section();

    }

    public function render_svg() {
        return [
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 180 180">
<path d="M 6.5 39.4 C 7.17777 60.4204 5.32592 79.1167 3.8 94.8 c -2.87222 28.2426 -2.5185 36.4167 2.80742 43.2963 c 10.3352 12.9463 35.9426 13.0352 53.5926 2.9037 c 17.7482 -7.97406 16.839 -13.8926 27.2834 -23.3444 c 12.0667 -10.8704 20.4148 -5.08522 33.4925 -19.9315 c 7.69999 -8.51482 10.763 -16.787 11.7 -21.9 c 2.74074 -17.2926 -9.69815 -31.863 -16.7 -40.1 C 92.2556 7.78519 56.8796 0.105572 35.9315 2.60742 C 27.7445 3.36297 20.3982 5.02594 14.9148 10.4908 C 4.45186 20.0833 6.24074 36.2426 6.5 39.4 Z">
<animate repeatCount="indefinite" attributeName="d" dur="10s" values="M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-2.9,17.7-7.2,30.9,0.4,41.9c5.9,8.5,15.7,11,17.6,11.5
c17.9,4.5,26.2-9.4,64-27c25.6-11.9,39.7-13.9,45.3-28c3.1-7.9,1.9-15.3,1.5-17.3c-2.7-12.7-14.2-21.9-28.5-30.4
c-20-12-39.7-48.3-72-45.2C29.1,0.5,21.6,1.3,15.3,7C3.2,17.7,6,36.7,6.5,39.4z;
M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-4.1,24.8-5.6,33.6,0.4,41.9c10.6,14.8,41.6,17.2,56,4.3
c11.2-9.9,4.2-21.5,15.8-31c13.8-11.4,29.9,0.5,45-12.3c9-7.6,11.1-18.4,11.7-21.9c2.5-17.1-9-30.9-16.7-40.1
C92.4,7.4,57-3,32.2,0.2C25,1.1,19.7,3.1,15.3,7C3.2,17.7,6,36.7,6.5,39.4z;
M6.5,39.4C4.9,52.6,3.2,71.6,3.8,94.8c1,39.1,7.2,45.3,10.4,47.7c9.5,7.1,18.1-0.1,46-1.5
c38.4-1.9,56.7,10.1,63.5,0.8c6.6-9.2-9.5-22.7-2.8-44c3.6-11.4,9.7-11.7,11.7-21.9c3.5-17.9-11.9-34.9-16.7-40.1
C91.8,9,56.5,9.9,47.7,10.2c-11.3,0.3-25.1,0.9-34,11.3C8.4,27.6,7,34.8,6.5,39.4z;
M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-2.9,17.7-7.2,30.9,0.4,41.9c5.9,8.5,15.7,11,17.6,11.5
c17.9,4.5,26.2-9.4,64-27c25.6-11.9,39.7-13.9,45.3-28c3.1-7.9,1.9-15.3,1.5-17.3c-2.7-12.7-14.2-21.9-28.5-30.4
c-20-12-39.7-48.3-72-45.2C29.1,0.5,21.6,1.3,15.3,7C3.2,17.7,6,36.7,6.5,39.4z"></animate>
</path>
</svg>',
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 180 180">
<path d="M 6.5 39.4 C 6.49327 58.0702 4.68705 76.8578 3.8 94.8 c -1.07125 27.7347 -0.447688 37.6523 5.08911 44.6197 c 7.58808 7.84352 16.8254 5.79509 30.9171 5.40416 c 27.5127 1.49897 40.5018 -0.256243 63.7655 -13.9643 c 16.6907 -10.6339 16.6296 -18.0264 22.7454 -35.5026 c 3.33446 -9.54119 5.5575 -13.6119 6.28289 -19.457 c 0.207246 -15.1383 -13.1215 -27.9958 -22.9669 -34.9484 c -21.9225 -18.9399 -48.9375 -37.7964 -70.2181 -36.0094 C 32.523 5.18911 22.0689 5.89532 14.5497 13.7992 C 5.63833 22.3422 6.46891 35.8091 6.5 39.4 Z">
<animate repeatCount="indefinite" attributeName="d" dur="10s" values="
M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-2.9,17.7-7.2,30.9,0.4,41.9c5.9,8.5,15.7,11,17.6,11.5
c17.9,4.5,26.2-9.4,64-27c25.6-11.9,39.7-13.9,45.3-28c3.1-7.9,1.9-15.3,1.5-17.3c-2.7-12.7-14.2-21.9-28.5-30.4
c-20-12-39.7-48.3-72-45.2C29.1,0.5,21.6,1.3,15.3,7C3.2,17.7,6,36.7,6.5,39.4z;
M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-4.1,24.8-5.6,33.6,0.4,41.9c10.6,14.8,41.6,17.2,56,4.3
c11.2-9.9,4.2-21.5,15.8-31c13.8-11.4,29.9,0.5,45-12.3c9-7.6,11.1-18.4,11.7-21.9c2.5-17.1-9-30.9-16.7-40.1
C92.4,7.4,57-3,32.2,0.2C25,1.1,19.7,3.1,15.3,7C3.2,17.7,6,36.7,6.5,39.4z;
M6.5,39.4C4.9,52.6,3.2,71.6,3.8,94.8c1,39.1,7.2,45.3,10.4,47.7c9.5,7.1,18.1-0.1,46-1.5
c38.4-1.9,56.7,10.1,63.5,0.8c6.6-9.2-9.5-22.7-2.8-44c3.6-11.4,9.7-11.7,11.7-21.9c3.5-17.9-11.9-34.9-16.7-40.1
C91.8,9,56.5,9.9,47.7,10.2c-11.3,0.3-25.1,0.9-34,11.3C8.4,27.6,7,34.8,6.5,39.4z;
M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-2.9,17.7-7.2,30.9,0.4,41.9c5.9,8.5,15.7,11,17.6,11.5
c17.9,4.5,26.2-9.4,64-27c25.6-11.9,39.7-13.9,45.3-28c3.1-7.9,1.9-15.3,1.5-17.3c-2.7-12.7-14.2-21.9-28.5-30.4
c-20-12-39.7-48.3-72-45.2C29.1,0.5,21.6,1.3,15.3,7C3.2,17.7,6,36.7,6.5,39.4z  "></animate>
</path>
</svg>',
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" viewBox="0 0 180 180">
<path d="M 6.5 39.4 C 7.38819 61.1428 5.52231 79.811 3.8 94.8 c -2.23465 21.3509 -4.74332 33.3567 2.10602 42.8895 c 6.51417 8.26116 16.1094 9.10631 22.4451 9.28217 c 21.3974 3.40814 31.4034 -6.07325 63.9147 -22.2573 c 22.3586 -11.4394 31.3064 -15.4013 37.094 -30.7296 c 3.1853 -8.49711 3.2307 -14.6858 3.24014 -18.0848 c -1.64226 -13.5871 -13.8076 -24.1178 -26.4869 -32.0548 c -20.6995 -14.5249 -43.0609 -44.4785 -71.3517 -41.8562 C 30.3454 2.20602 21.7706 2.9719 15.027 9.47374 C 4.08713 19.389 6.1706 36.3759 6.5 39.4 Z">
<animate repeatCount="indefinite" attributeName="d" dur="10s" values="M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-2.9,17.7-7.2,30.9,0.4,41.9c5.9,8.5,15.7,11,17.6,11.5
c17.9,4.5,26.2-9.4,64-27c25.6-11.9,39.7-13.9,45.3-28c3.1-7.9,1.9-15.3,1.5-17.3c-2.7-12.7-14.2-21.9-28.5-30.4
c-20-12-39.7-48.3-72-45.2C29.1,0.5,21.6,1.3,15.3,7C3.2,17.7,6,36.7,6.5,39.4z;
M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-4.1,24.8-5.6,33.6,0.4,41.9c10.6,14.8,41.6,17.2,56,4.3
c11.2-9.9,4.2-21.5,15.8-31c13.8-11.4,29.9,0.5,45-12.3c9-7.6,11.1-18.4,11.7-21.9c2.5-17.1-9-30.9-16.7-40.1
C92.4,7.4,57-3,32.2,0.2C25,1.1,19.7,3.1,15.3,7C3.2,17.7,6,36.7,6.5,39.4z;
M6.5,39.4C4.9,52.6,3.2,71.6,3.8,94.8c1,39.1,7.2,45.3,10.4,47.7c9.5,7.1,18.1-0.1,46-1.5
c38.4-1.9,56.7,10.1,63.5,0.8c6.6-9.2-9.5-22.7-2.8-44c3.6-11.4,9.7-11.7,11.7-21.9c3.5-17.9-11.9-34.9-16.7-40.1
C91.8,9,56.5,9.9,47.7,10.2c-11.3,0.3-25.1,0.9-34,11.3C8.4,27.6,7,34.8,6.5,39.4z;
M6.5,39.4C7.9,62.9,6,81.5,3.8,94.8c-2.9,17.7-7.2,30.9,0.4,41.9c5.9,8.5,15.7,11,17.6,11.5
c17.9,4.5,26.2-9.4,64-27c25.6-11.9,39.7-13.9,45.3-28c3.1-7.9,1.9-15.3,1.5-17.3c-2.7-12.7-14.2-21.9-28.5-30.4
c-20-12-39.7-48.3-72-45.2C29.1,0.5,21.6,1.3,15.3,7C3.2,17.7,6,36.7,6.5,39.4z"></animate>
</path>
</svg>',
            '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 180 180">
<path d="M 78.8 23.2 c -3.5 3 -8.7 7.6 -14.9 13.3 c -8.9 8.3 -13.5 12.4 -17.5 16.6 c -8.40903 8.80373 -12.7727 13.3674 -15.9 19 c -6.8886 12.5976 -6.78646 25.2756 -6.64029 32.6106 c 0.20982 7.53183 0.471896 18.8273 7.75068 30.8857 C 39.321 148.318 50.3332 154.108 54.7082 156.34 c 6.84029 3.4167 23.7016 11.8809 35.7159 5.20451 c 9.46682 -5.01964 6.73149 -13.2135 15.5042 -19.5438 c 13.169 -9.3886 26.4931 3.52314 41.3717 -5.38961 c 9.65147 -5.86896 16.6947 -18.5045 15.4 -29 c -0.489391 -3.47878 -1.38939 -3.5167 -2 -7.3 c -1.90609 -11.8719 6.18149 -16.9499 7.76163 -27.6711 c 2.42099 -15.9833 -10.1284 -35.6462 -24.3669 -42.0289 c -4.87799 -2.24932 -6.23792 -1.30395 -12.5992 -4.12968 c -13.2931 -5.84774 -13.9236 -12.287 -22.2008 -14.3703 C 98.2302 9.55384 86.2992 16.7849 78.8 23.2 Z">
<animate repeatCount="indefinite" attributeName="d" dur="10s" values="
M78.8,23.2c-3.5,3-8.7,7.6-14.9,13.3c-8.9,8.3-13.5,12.4-17.5,16.6c-5,5.3-10.5,11-15.9,19c-4.9,7.2-11.9,17.7-14.5,32.8
c-1.4,8.1-3.6,21.1,3.3,34.2c7.9,14.9,22.7,20.5,30.2,23.3c14.7,5.5,27.3,4.4,36,3.5c17.8-1.8,30.5-8.1,37-11.4
c14.4-7.4,22.8-15.7,24.8-17.7c7-7.1,16.6-16.8,15.4-29c-0.3-3.1-1.2-5.6-2-7.3c-3.8-7.8-12-10.7-19.7-21.8c-9.7-13.9,9-32.9,3-47.9
c-2.7-6.7-8.7-10.3-10.8-11.8c-9.6-6.7-19.7-6.7-24-6.7C95.2,12.3,84.5,18.3,78.8,23.2z;
M78.8,23.2c-3.5,3-8.7,7.6-14.9,13.3c-8.9,8.3-13.5,12.4-17.5,16.6c-8.6,9-12.9,13.5-15.9,19c-7,12.9-6.5,25.7-6.2,32.6
c0.3,7.5,0.7,18.7,8,30.7C40,148,50.8,153.8,55,156c6.4,3.3,23.5,12.3,35.7,5.3c9-5.2,5.4-13.5,14.3-20c13.1-9.5,26.7,4.6,42.3-4.7
c9.8-5.8,16.7-18.6,15.4-29c-0.5-3.5-1.4-3.4-2-7.3c-1.8-12.1,7.2-17.3,9.3-28c3.1-16.1-11.2-35.8-25.9-41.7c-5-2-6.1-0.8-12.7-3.7
c-13.5-5.8-13.6-12.6-22.1-14.8C98.4,9.4,86.4,16.7,78.8,23.2z;
M82,8.3c-4.8,3-9.3,11.4-18.1,28.2c-5.2,9.9-5.8,12-10.2,19.5C47.4,66.7,44.3,72,40,76C27.5,87.6,16.6,81.5,8.7,89.7
c-10.8,11.1-6.6,38.7,7,55c20,23.9,57.6,20,64,18.7c0.8-0.2,5.1-1.1,11-2c6.6-1,11.4-1.2,12.7-1.3c13.9-1.1,31.1-16,40.7-27.3
c3.5-4.2,10.2-12.3,14.3-24.3c1.3-3.8,1-4.2,2.4-8c5.1-14.4,11.6-16.6,14-24c4.9-15.3-12.2-40-30.6-45.7c-5.1-1.5-7.5-0.8-12.7-3.7
c-10.8-5.9-10-14.3-18.3-19.7C104.1,1.6,90.5,3,82,8.3z;
M78.8,23.2c-3.5,3-8.7,7.6-14.9,13.3c-8.9,8.3-13.5,12.4-17.5,16.6c-5,5.3-10.5,11-15.9,19c-4.9,7.2-11.9,17.7-14.5,32.8
c-1.4,8.1-3.6,21.1,3.3,34.2c7.9,14.9,22.7,20.5,30.2,23.3c14.7,5.5,27.3,4.4,36,3.5c17.8-1.8,30.5-8.1,37-11.4
c14.4-7.4,22.8-15.7,24.8-17.7c7-7.1,16.6-16.8,15.4-29c-0.3-3.1-1.2-5.6-2-7.3c-3.8-7.8-12-10.7-19.7-21.8c-9.7-13.9,9-32.9,3-47.9
c-2.7-6.7-8.7-10.3-10.8-11.8c-9.6-6.7-19.7-6.7-24-6.7C95.2,12.3,84.5,18.3,78.8,23.2z"></animate>
</path>
</svg>'
        ];
    }
}

new OSF_Elementor_Parallax();