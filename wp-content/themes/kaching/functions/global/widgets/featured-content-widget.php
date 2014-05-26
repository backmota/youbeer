<?php
/**
 * Credits to Genesis Framework by StudioPress for original Featured Page Widget
 *
 *
 */
add_action('widgets_init', create_function('', 'return register_widget("TF_Featured_Content");'));

class TF_Featured_Content extends WP_Widget {

    function TF_Featured_Content() {
        $widget_ops = array('classname' => 'featuredcontent', 'description' => __('Displays featured content with thumbnails', 'tfbasedetails'));
        $control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'featured-content');
        $this->WP_Widget('featured-content', __('TF - Featured Content', 'tfbasedetails'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);

        $instance = wp_parse_args((array) $instance, array(
            'title' => '',
            'desc' => '',
            'page_id' => '',
            'show_image' => 0,
            'image_alignment' => '',
            'image_size' => '',
            'show_title' => 0,
            'show_byline' => 0,
            'show_content' => 0,
            'content_limit' => '',
            'more_text' => ''
                ));

        //echo $before_widget;
        echo '<li class="clearfix">';

        $featured_content = new WP_Query(array('page_id' => $instance['page_id']));
        if ($featured_content->have_posts()) : while ($featured_content->have_posts()) : $featured_content->the_post();

                echo '<div ';
                post_class('featprodmidwrap');
                echo '>';

                if (!empty($instance['show_image'])) :
                    ?>
                    <div class="featprodmidimg"><a href="<?php echo get_permalink(); ?>" title="<?php echo $instance['title']; ?>">
                            <?php get_the_image(array('size' => 'hp-prod-thumbnail', 'echo' => true, 'link_to_post' => false, 'width' => 400, 'height' => 200)); ?>
                        </a></div>

                    <?php
                endif;


                // Set up the author bio
                if (!empty($instance['title']))
                    
                    ?>

                <div class="featprodmidesc"><h2 class="centertoptitle"><a href="<?php echo get_permalink(); ?>"
                                                                          title="<?php echo $instance['title']; ?>"><?php echo $instance['title']; ?></a></h2>
                        <?php
                        if (!empty($instance['desc'])) ?>
                        <p class="centertopdesc"><a href="<?php echo get_permalink(); ?>" title="<?php echo $instance['title'];?>">
                        <?php
                        echo $instance['desc'];
                        echo '</a></p>';

                        echo '</div></div><!--end post_class()-->' . "\n\n";

                    endwhile;
                endif;

                echo '</li>';
                //echo $after_widget;

                wp_reset_query();
            }

            function update($new_instance, $old_instance) {
                return $new_instance;
            }

            function form($instance) {

                $instance = wp_parse_args((array) $instance, array(
                    'title' => '',
                    'desc' => '',
                    'page_id' => '',
                    'show_image' => 0,
                    'image_alignment' => '',
                    'image_size' => '',
                    'show_title' => 0,
                    'show_content' => 0,
                    'content_limit' => '',
                    'more_text' => __('[Read More...]', 'tfbasedetails')
                        ));
                ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'tfbasedetails'); ?>:</label>
                <input type="text" id="<?php echo $this->get_field_id('title'); ?>"
                       name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>"
                       style="width:95%;"/></p>

            <p><label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Tagline - keep it short!', 'tfbasedetails'); ?>
                    :</label>
                <input type="text" id="<?php echo $this->get_field_id('desc'); ?>"
                       name="<?php echo $this->get_field_name('desc'); ?>" value="<?php echo esc_attr($instance['desc']); ?>"
                       style="width:95%;"/></p>

            <p><label for="<?php echo $this->get_field_id('page_id'); ?>"><?php _e('Page - to link to', 'tfbasedetails'); ?>
                    :</label>
                <?php wp_dropdown_pages(array('name' => $this->get_field_name('page_id'), 'selected' => $instance['page_id'])); ?>
            </p>

            <hr class="div"/>

            <p><input id="<?php echo $this->get_field_id('show_image'); ?>" type="checkbox"
                      name="<?php echo $this->get_field_name('show_image'); ?>"
                      value="1" <?php checked(1, $instance['show_image']); ?>/> <label
                      for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Show Featured Image', 'tfbasedetails'); ?></label>
            </p>

            <?php
        }

    }