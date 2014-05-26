<?php
/**
 * Plugin Name: TF - Latest Showcase Posts
 * Description: A sidebar Widget for displaying the most recent Showcase posts - needs to incorporate WP Widget in the future!
 * Version: 1.0
 * Author: Jared Williams
 * Author URI: http://new2wp.com
 * Modified by Ed Bloom - themesforge.com
 * Tags: custom post types, sidebar widget
 */

/**
 * Create the init function
 */
function tf_latest_cpt_init() {
    if (!function_exists('wp_register_sidebar_widget'))
        return;

    /**
     * The widget output function
     */
    function tf_latest_cpt($args) {
        global $post;
        extract($args);
        // These are our own options
        $options = get_option('tf_latest_cpt');
        $title = $options['title']; // Widget title
        $phead = $options['phead']; // Heading format
        $ptype = $options['ptype']; // Post type
        $pshow = $options['pshow']; // Number of Tweets
        $pclass = 'class="widget-title"';
        $beforetitle = '<header class="featuredctrbtm2"><h3>';
        $aftertitle = '</h3></header>';
        // Output
        echo $before_widget;
        $scpagelink = get_option('tf_scpage');

        if ($title)
        //echo '<a href=' . $scpagelink . ">" . $beforetitle . $title . $aftertitle . '</a>';
            echo $beforetitle . $title . $aftertitle;
        $pq = new WP_Query(array('post_type' => $ptype, 'showposts' => $pshow));
        if ($pq->have_posts()) :
            ?>
            <?php while ($pq->have_posts()) : $pq->the_post(); ?>
                <div class="showcase-widget">
                    <section class="hp-showcase">
                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                            <?php get_the_image(array('size' => 'showcase-hp', 'echo' => true, 'link_to_post' => false)); ?>
                        </a>
                        <h4>
                            <a href="<?php the_permalink(); ?>" rel="bookmark">
                                <?php the_title(); ?>
                            </a>
                        </h4>
                        <p><a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo tf_cusexcerpt(get_the_content(), 11); ?></a></p>
                    </section>
                </div>

                <?php wp_reset_query();
            endwhile; ?>
        <?php endif; ?>
        <?php
        // echo widget closing tag
        echo $after_widget;
    }

    /**
     * Widget settings form function
     */
    function tf_latest_cpt_control() {
        // Get options
        $options = get_option('tf_latest_cpt');
        // options exist? if not set defaults
        if (!is_array($options))
            $options = array(
                'title' => 'Latest from our Showcase',
                'phead' => 'h2',
                'ptype' => 'post',
                'pshow' => '2'
            );
        // form posted?
        if ($_POST['latest-cpt-submit']) {
            $options['title'] = strip_tags($_POST['latest-cpt-title']);
            $options['phead'] = $_POST['latest-cpt-phead'];
            $options['ptype'] = $_POST['latest-cpt-ptype'];
            $options['pshow'] = strip_tags($_POST['latest-cpt-pshow']);
            update_option('tf_latest_cpt', $options);
        }
        // Get options for form fields to show
        $title = $options['title'];
        $phead = $options['phead'];
        $ptype = $options['ptype'];
        $pshow = $options['pshow'];
        // The widget form fields
        ?>
        <p>
            <label for="latest-cpt-title"><?php echo __('Widget Title', 'tfbasedetails'); ?><br/>
                <input id="latest-cpt-title" name="latest-cpt-title" type="text" value="<?php echo $title; ?>" size="30"/>
            </label>
        </p>
        <p>
            <label for="latest-cpt-phead"><?php echo __('Widget Heading Format', 'tfbasedetails'); ?><br/>
                <select name="latest-cpt-phead">
                    <option value="h2" <?php
        if ($phead == 'h2') {
            echo 'selected="selected"';
        }
        ?>>H2 - <h2></h2></option>
                    <option value="h3" <?php
                    if ($phead == 'h3') {
                        echo 'selected="selected"';
                    }
        ?>>H3 - <h3></h3></option>
                    <option value="h4" <?php
                    if ($phead == 'h4') {
                        echo 'selected="selected"';
                    }
        ?>>H4 - <h4></h4></option>
                    <option value="strong" <?php
                    if ($phead == 'strong') {
                        echo 'selected="selected"';
                    }
        ?>>Bold - <strong></strong></option>
                </select>
            </label>
        </p>
        <p>
            <label for="latest-cpt-ptype">
                <select name="latest-cpt-ptype">
                    <option value=""> - <?php echo __('Select Post Type', 'tfbasedetails'); ?> -</option>
                    <?php
                    $args = array('public' => true);
                    $post_types = get_post_types($args, 'names');
                    foreach ($post_types as $post_type) {
                        ?>
                        <option value="<?php echo $post_type; ?>" <?php
            if ($options['ptype'] == $post_type) {
                echo 'selected="selected"';
            }
                        ?>><?php echo $post_type; ?></option>
                            <?php } ?>
                </select>
            </label>
        </p>
        <p>
            <label for="latest-cpt-pshow"><?php echo __('Number of posts to show', 'tfbasedetails'); ?>
                <input id="latest-cpt-pshow" name="latest-cpt-pshow" type="text" value="<?php echo $pshow; ?>" size="2"/>
            </label>
        </p>
        <input type="hidden" id="latest-cpt-submit" name="latest-cpt-submit" value="1"/>
        <?php
    }

    wp_register_sidebar_widget('widget_latest_cpt', __('TF - Latest Showcase Posts', 'tfbasedetails'), 'tf_latest_cpt');
    wp_register_widget_control('widget_latest_cpt', __('TF - Latest Showcase Posts', 'tfbasedetails'), 'tf_latest_cpt_control', 300, 200);
}

add_action('widgets_init', 'tf_latest_cpt_init');
?>