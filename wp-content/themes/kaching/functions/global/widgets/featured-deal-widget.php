<?php
/**
 * Credits to Genesis Framework by StudioPress for original Featured Page Widget
 *
 *
 */
add_action('widgets_init', create_function('', 'return register_widget("TF_Featured_Deal_Content");'));

class TF_Featured_Deal_Content extends WP_Widget {

    function TF_Featured_Deal_Content() {
        $widget_ops = array('classname' => 'featureddealcontent', 'description' => __('Displays featured deal content with thumbnails', 'tfbasedetails'));
        $control_ops = array('width' => 200, 'height' => 250, 'id_base' => 'featured-deal-content');
        $this->WP_Widget('featured-deal-content', __('TF - Featured Deal', 'tfbasedetails'), $widget_ops, $control_ops);
    }

    function widget($args, $instance) {
        extract($args);

        $instance = wp_parse_args((array) $instance, array(
            'p' => '',
            'image_alignment' => '',
            'image_size' => '',
            'show_title' => 0,
            'show_byline' => 0,
            'show_content' => 0,
            'content_limit' => '',
            'more_text' => ''
                ));

        echo $before_widget;
        echo '<li class="dealitem clearfix">';
        global $wp_query, $post, $paged, $post_count;
        $featured_deal_content = new WP_Query(array('p' => $instance['p'], 'post_type' => 'tf_hpdeal'));
        if ($featured_deal_content->have_posts()) : while ($featured_deal_content->have_posts()) : $featured_deal_content->the_post();
                $url = get_post_meta($post->ID, 'hpdeal_url', true);
                echo '<div ';
                post_class('featprodmidwrap');
                echo '>';
                ?>
                <a href="<?php echo $url; ?>" title="<?php echo the_title(); ?>" class="dthumbnail">
                        <?php get_the_image(array('size' => 'showcase-hpwidget', 'echo' => true, 'link_to_post' => false, 'width' => 630, 'height' => 210)); ?>
                        <div class="sideslidetitle">
                            <div class="topthespiel">
                                <h4><?php echo the_title(); ?></h4>
                                <?php echo the_content(); ?>
                            </div>
                        </div>
                </a>
                </div>
                <?php
            endwhile;
        endif;
        echo '</li>';
        wp_reset_query();
        ?>
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['p'] = $new_instance['p'];
        return $instance;
    }

    function form($instance) {

        $instance = wp_parse_args((array) $instance, array(
            'p' => '',
            'image_alignment' => '',
            'image_size' => '',
            'show_title' => 0,
            'show_content' => 0,
            'content_limit' => '',
            'more_text' => __('[Read More...]', 'tfbasedetails')
                ));
        ?>

        <p><label for="<?php echo $this->get_field_id('p'); ?>"><?php _e('Deal - to link to', 'tfbasedetails'); ?>
                :</label>

            <select name="<?php echo $this->get_field_name('p'); ?>" id="<?php echo $this->get_field_name('p'); ?>">
                <?php
                global $post;
                $sc_loop = new WP_Query(array('post_type' => 'tf_hpdeal'));
                while ($sc_loop->have_posts()) : $sc_loop->the_post();
                    $title = get_the_title();
                    $post_id = $post->ID;
                    ?>
                    <option value="<?php echo $post_id ?>" <?php selected($instance['p'], $post_id); ?>><?php echo $title ?></option>
                    <?php
                endwhile;
                ?>      
            </select>   
            <?php
            wp_reset_postdata();
            ?> 
        </p>
        <?php
    }

}