<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;

/**
 * Class OSF_Elementor_Blog
 */
class OSF_Elementor_Post_Category extends Elementor\Widget_Base
{

    public function get_name()
    {
        return 'opal-post-category';
    }

    public function get_title()
    {
        return __('Opal Posts Category', 'medilazar-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return array('opal-addons');
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'medilazar-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'categories',
            [
                'label' => __('Categories', 'medilazar-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->get_post_categories(),
                'multiple' => true,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'medilazar-core'),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'thumbnail',
                'separato-r' => 'none',
            ]
        );

        $this->add_responsive_control(
            '_align',
            [
                'label' => __('Alignment', 'medilazar-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => __('Left', 'medilazar-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'medilazar-core'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => __('Right', 'medilazar-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .category-name' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'vertical_position',
            [
                'label' => __('Vertical Position', 'medilazar-core'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'flex-start' => [
                        'title' => __('Top', 'medilazar-core'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => __('Middle', 'medilazar-core'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => __('Bottom', 'medilazar-core'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'middle',
                'selectors' => [
                    '{{WRAPPER}} .category-name' => 'align-items: {{VALUE}}',
                ],
                'separator' => 'after',
            ]
        );
        $this->end_controls_section();


        $this->start_controls_section(
            'section_content_style',
            [
                'label' => __('Content', 'medilazar-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .category-name',
                'label' => __('Title Typo', 'medilazar-core'),
            ]
        );

        $this->start_controls_tabs('title_colors');

        $this->start_controls_tab(
            'title_color_normal',
            [
                'label' => __('Normal', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'medilazar-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .category-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_color_hover',
            [
                'label' => __('Hover', 'medilazar-core'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label' => __('Color', 'medilazar-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function get_post_categories()
    {
        $categories = get_terms(array(
                'taxonomy' => 'category',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->term_id] = $category->name;
            }
        }
        return $results;
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $category_link = #;
        $category_name = 'No Category';
        if (!empty($settings['categories'])) {
            $category_link = get_category_link($settings['categories']);
            $category_name = get_the_category_by_ID($settings['categories']);
        }
        $this->add_render_attribute('wrapper', 'class', 'elementor-category-wrapper');
        ?>

        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>

            <?php
            if (!empty($settings['image']['url'])) :
                $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
                echo $image_html;
            endif;
            ?>

            <a class="category-name" href="<?php echo esc_url($category_link); ?>"
               title="<?php echo $category_name; ?>"><?php echo $category_name; ?></a>

        </div>

        <?php
    }
}

$widgets_manager->register(new OSF_Elementor_Post_Category());