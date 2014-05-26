<?php

/**
 * Custom Post Types - proceed with caution!
 * Hat tip to Noel Tock for his wonderful Custom Post Types tuts - http://www.noeltock.com/web-design/wordpress/custom-post-types-events-pt1/
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
/* ----------------------------------------------------------------------------------- */
/*  Create a new post type called showcase(s)
  /*----------------------------------------------------------------------------------- */

function tf_create_post_type_showcase_init() {
    $labels = array(
        'name' => __('Showcases', 'tfbasedetails'),
        'singular_name' => __('Showcase', 'tfbasedetails'),
        'rewrite' => array('slug' => __('showcase', 'tfbasedetails')),
        'add_new' => _x('Add New', 'showcase', 'tfbasedetails'),
        'add_new_item' => __('Add New Showcase', 'tfbasedetails'),
        'edit_item' => __('Edit Showcase', 'tfbasedetails'),
        'new_item' => __('New Showcase', 'tfbasedetails'),
        'view_item' => __('View Showcase', 'tfbasedetails'),
        'search_items' => __('Search Showcases', 'tfbasedetails'),
        'not_found' => __('No showcases found', 'tfbasedetails'),
        'not_found_in_trash' => __('No showcases found in Trash', 'tfbasedetails'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'showcase'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'excerpt', 'editor', 'thumbnail')
    );

    register_post_type('tf_showcase', $args);
}

function create_tfshowcasecategory_taxonomy() {

    $labels = array(
        'name' => _x('Showcase Categories', 'taxonomy general name', 'tfbasedetails'),
        'singular_name' => _x('Showcase Category', 'taxonomy singular name', 'tfbasedetails'),
        'search_items' => __('Search Showcase Categories', 'tfbasedetails'),
        'popular_items' => __('Popular Showcase Categories', 'tfbasedetails'),
        'all_items' => __('All Showcase Categories', 'tfbasedetails'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Showcase Category', 'tfbasedetails'),
        'update_item' => __('Update Showcase Category', 'tfbasedetails'),
        'add_new_item' => __('Add New Showcase Category', 'tfbasedetails'),
        'new_item_name' => __('New Showcase Category Name', 'tfbasedetails'),
        'separate_items_with_commas' => __('Separate showcase categories with commas', 'tfbasedetails'),
        'add_or_remove_items' => __('Add or remove showcase categories', 'tfbasedetails'),
        'choose_from_most_used' => __('Choose from the most used showcase categories', 'tfbasedetails'),
    );

    register_taxonomy('tf_showcasecategory', 'tf_showcase', array(
        'label' => __('Showcase Category', 'tfbasedetails'),
        'labels' => $labels,
        'hierarchical' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'showcase-category'),
    ));
}

/* ----------------------------------------------------------------------------------- */
/*  Updated messages for the Showcase post type
  /*----------------------------------------------------------------------------------- */

function tf_showcase_updated_messages($messages) {

    $post_ID = '';
    $post = '';

    $messages[__('tf_showcase')] =
            array(
                0 => '', // Unused. Messages start at index 1.
                1 => sprintf(__('Showcase updated. <a href="%s">View Showcase</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                2 => __('Custom field updated.', 'tfbasedetails'),
                3 => __('Custom field deleted.', 'tfbasedetails'),
                4 => __('Showcase updated.', 'tfbasedetails'),
                /* translators: %s: date and time of the revision */
                5 => isset($_GET['revision']) ? sprintf(__('Showcase restored to revision from %s', 'tfbasedetails'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
                6 => sprintf(__('Showcase published. <a href="%s">View Showcase</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                7 => __('Showcase saved.', 'tfbasedetails'),
                8 => sprintf(__('Showcase submitted. <a target="_blank" href="%s">Preview Showcase</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
                9 => sprintf(__('Showcase scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Showcase</a>', 'tfbasedetails'),
                        // translators: Publish box date format, see http://php.net/date
                        date_i18n(__('M j, Y @ G:i', 'tfbasedetails'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                10 => sprintf(__('Showcase draft updated. <a target="_blank" href="%s">Preview Showcase</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );

    return $messages;
}

// Custom Meta Boxes

function tf_showcasemeta() {
    add_meta_box("prodInfo-meta", "Product Optionss", "tf_meta_options", "tf_showcase", "side", "default");
}

function tf_meta_options() {
    global $post;
    $custom = get_post_custom($post->ID);
    $website = $custom["website"][0];
    $promodetails = $custom["promodetails"][0];
    ?>
    <label>Website:</label><input name="website" value="<?php echo $website; ?>" /> <br />
    <label>Promo Details:</label><input name="promodetails" value="<?php echo $promodetails; ?>" />
    <?php
}

function tf_save_meta() {
    global $post;

    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    update_post_meta($post->ID, "website", $_POST["website"]);
    update_post_meta($post->ID, "promodetails", $_POST["promodetails"]);
}

// End Custom Meta Boxes



/* ----------------------------------------------------------------------------------- */
/*  Modify the showcase posts page to display custom columns 
  /*----------------------------------------------------------------------------------- */

function tf_showcase_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Showcase Title",
        "description" => "Showcase Description",
        "website_value" => "Website",
        "clientreference_value" => "Testimonial",
        "tf_showcasecategory" => "Showcase Categories"
    );
    return $columns;
}

function tf_showcase_custom_columns($column) {
    global $post;
    switch ($column) {
        case "description":
            the_excerpt();
            break;
        case "website_value":
            $custom = get_post_custom();
            echo $custom["website_value"][0];
            break;
        case "clientreference_value":
            $custom = get_post_custom();
            echo $custom["clientreference_value"][0];
            break;
        case "tf_showcasecategory":
            echo get_the_term_list($post->ID, 'tf_showcasecategory', '', ', ', '');
            break;
    }
}

/* ----------------------------------------------------------------------------------- */
/*  Create a new post type called hpslides
  /*----------------------------------------------------------------------------------- */

function tf_create_post_type_hpslide_init() {
    $labels = array(
        'name' => __('Slides', 'tfbasedetails'),
        'singular_name' => __('Slide', 'tfbasedetails'),
        'rewrite' => array('slug' => __('slide', 'tfbasedetails')),
        'add_new' => _x('Add New', 'slide', 'tfbasedetails'),
        'add_new_item' => __('Add New Slide', 'tfbasedetails'),
        'edit_item' => __('Edit Slide', 'tfbasedetails'),
        'new_item' => __('New Slide', 'tfbasedetails'),
        'view_item' => __('View Slide', 'tfbasedetails'),
        'search_items' => __('Search Slides', 'tfbasedetails'),
        'not_found' => __('No slides found', 'tfbasedetails'),
        'not_found_in_trash' => __('No slides found in Trash', 'tfbasedetails'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail')
    );

    register_post_type('tf_hpslide', $args);
}

/* ----------------------------------------------------------------------------------- */
/*  Updated messages for the HP Slide post type
  /*----------------------------------------------------------------------------------- */

function tf_hpslide_updated_messages($messages) {

    $post_ID = '';
    $post = '';

    $messages[__('tf_hpslide')] =
            array(
                0 => '', // Unused. Messages start at index 1.
                1 => sprintf(__('Slide updated. <a href="%s">View Slide</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                2 => __('Custom field updated.', 'tfbasedetails'),
                3 => __('Custom field deleted.', 'tfbasedetails'),
                4 => __('Slide updated.', 'tfbasedetails'),
                /* translators: %s: date and time of the revision */
                5 => isset($_GET['revision']) ? sprintf(__('Slide restored to revision from %s', 'tfbasedetails'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
                6 => sprintf(__('Slide published. <a href="%s">View Slide</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                7 => __('Slide saved.', 'tfbasedetails'),
                8 => sprintf(__('Slide submitted. <a target="_blank" href="%s">Preview Slide</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
                9 => sprintf(__('Slide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Slide</a>', 'tfbasedetails'),
                        // translators: Publish box date format, see http://php.net/date
                        date_i18n(__('M j, Y @ G:i', 'tfbasedetails'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                10 => sprintf(__('Slide draft updated. <a target="_blank" href="%s">Preview Slide</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );

    return $messages;
}

/* ----------------------------------------------------------------------------------- */
/*  Modify the slide posts page to display custom columns 
  /*----------------------------------------------------------------------------------- */

function tf_hpslide_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Slide Title",
        "hpslide_description" => "Slide Description",
        "hpslide_price" => "Price",
        "hpslide_pricemsg" => "Price Description",
        "hpslide_url" => "Slide URL",
    );
    return $columns;
}

function tf_hpslide_custom_columns($column) {
    global $post;
    switch ($column) {
        case "hpslide_description":
            the_excerpt();
            break;   
        case "hpslide_url":
            $custom = get_post_custom();
            echo $custom["hpslide_url"][0];
            break;
        case "hpslide_price":
            $custom = get_post_custom();
            echo $custom["hpslide_price"][0];
            break;
        case "hpslide_pricemsg":
            $custom = get_post_custom();
            echo $custom["hpslide_pricemsg"][0];
            break;
    }
}

// Slide Custom Meta Boxes

function tf_hpslidemeta() {
    add_meta_box("tf_hpslide_meta", "Slide Options", "tf_hpslide_meta_options", "tf_hpslide", "normal", "high");
}

function tf_hpslide_meta_options() {
    global $post;
    $custom = get_post_custom($post->ID);
    $hpslide_url = $custom["hpslide_url"][0];
    $hpslide_price = $custom["hpslide_price"][0];
    $hpslide_pricemsg = $custom["hpslide_pricemsg"][0];
    ?>
    <div style="padding-top:10px;">
        <label style="display:block;padding:2px;">Price:</label>
        <input style="width:220px;" name="hpslide_price" value="<?php echo $hpslide_price; ?>" />
    </div>
    <div style="padding-top:10px;">
        <label style="display:block;padding:2px;">Price Description:</label>
        <input name="hpslide_pricemsg" value="<?php echo $hpslide_pricemsg; ?>" />
    </div>
    <div style="padding-top:10px;">
        <label style="display:block;padding:2px;">Link:</label>
        <input style="width:220px;" name="hpslide_url" value="<?php echo $hpslide_url; ?>" />
    </div>
    <?php
}

function tf_hpslide_save_meta() {
    global $post;

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    update_post_meta($post->ID, "hpslide_price", $_POST["hpslide_price"]);
    update_post_meta($post->ID, "hpslide_pricemsg", $_POST["hpslide_pricemsg"]);
    update_post_meta($post->ID, "hpslide_url", $_POST["hpslide_url"]);
}

// Slide End Custom Meta Boxes

/* ----------------------------------------------------------------------------------- */
/*  Create a new post type called hpdeals
  /*----------------------------------------------------------------------------------- */

function tf_create_post_type_hpdeal_init() {
    $labels = array(
        'name' => __('Deals', 'tfbasedetails'),
        'singular_name' => __('Deal', 'tfbasedetails'),
        'rewrite' => array('slug' => __('deal', 'tfbasedetails')),
        'add_new' => _x('Add New', 'deal', 'tfbasedetails'),
        'add_new_item' => __('Add New Deal', 'tfbasedetails'),
        'edit_item' => __('Edit Deal', 'tfbasedetails'),
        'new_item' => __('New Deal', 'tfbasedetails'),
        'view_item' => __('View Deal', 'tfbasedetails'),
        'search_items' => __('Search Deals', 'tfbasedetails'),
        'not_found' => __('No deals found', 'tfbasedetails'),
        'not_found_in_trash' => __('No deals found in Trash', 'tfbasedetails'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );
    register_post_type('tf_hpdeal', $args);
}

/* ----------------------------------------------------------------------------------- */
/*  Updated messages for the HP Deal post type
  /*----------------------------------------------------------------------------------- */

function tf_hpdeal_updated_messages($messages) {

    $post_ID = '';
    $post = '';
    
    $messages[__('tf_hpdeal')] =
            array(
                0 => '', // Unused. Messages start at index 1.
                1 => sprintf(__('Deal updated. <a href="%s">View Deal</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                2 => __('Custom field updated.', 'tfbasedetails'),
                3 => __('Custom field deleted.', 'tfbasedetails'),
                4 => __('Deal updated.', 'tfbasedetails'),
                /* translators: %s: date and time of the revision */
                5 => isset($_GET['revision']) ? sprintf(__('Deal restored to revision from %s', 'tfbasedetails'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
                6 => sprintf(__('Deal published. <a href="%s">View Deal</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                7 => __('Deal saved.', 'tfbasedetails'),
                8 => sprintf(__('Deal submitted. <a target="_blank" href="%s">Preview Slide</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
                9 => sprintf(__('Deal scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Deal</a>', 'tfbasedetails'),
                        // translators: Publish box date format, see http://php.net/date
                        date_i18n(__('M j, Y @ G:i', 'tfbasedetails'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                10 => sprintf(__('Deal draft updated. <a target="_blank" href="%s">Preview Deal</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );

    return $messages;
}

/* ----------------------------------------------------------------------------------- */
/*  Modify the deal posts page to display custom columns 
  /*----------------------------------------------------------------------------------- */

function tf_hpdeal_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Deal Title",
        "hpdeal_description" => "Deal Description",
        "hpdeal_url" => "Deal URL",
        "hpdeal_link_title" => "Deal Link Title"
    );
    return $columns;
}

function tf_hpdeal_custom_columns($column) {
    global $post;
    switch ($column) {
        case "hpdeal_description":
            the_excerpt();
            break;        
        case "hpdeal_url":
            $custom = get_post_custom();
            echo $custom["hpdeal_url"][0];
            break;
        case "hpdeal_link_title":
            $custom = get_post_custom();
            echo $custom["hpdeal_link_title"][0];
            break;
    }
}

// Deal Custom Meta Boxes

function tf_hpdealmeta() {
    add_meta_box("tf_hpdeal_meta", "Deal Options", "tf_hpdeal_meta_options", "tf_hpdeal", "normal", "high");
}

function tf_hpdeal_meta_options() {
    global $post;
    $custom = get_post_custom($post->ID);
    $hpdeal_url = $custom["hpdeal_url"][0];
    $hpdeal_link_title = $custom["hpdeal_link_title"][0];

    if ($hpdeal_link_title == null) {
        $hpdeal_link_title = 'More';
    }
    ?>
    <div style="padding-top:10px;">
        <label style="display:block;padding:2px;">Link:</label>
        <input style="width:220px;" name="hpdeal_url" value="<?php echo $hpdeal_url; ?>" />
    </div>
    <div style="padding-top:10px;">
        <label style="display:block;padding:2px;">Link Title:</label>
        <input name="hpdeal_link_title" value="<?php echo $hpdeal_link_title; ?>" />
    </div>
    <?php
}

function tf_hpdeal_save_meta() {
    global $post;

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    update_post_meta($post->ID, "hpdeal_url", $_POST["hpdeal_url"]);
    update_post_meta($post->ID, "hpdeal_link_title", $_POST["hpdeal_link_title"]);
}

// Deals End Custom Meta Boxes

/* ----------------------------------------------------------------------------------- */
/*  Create a new post type called hptestimonials
  /*----------------------------------------------------------------------------------- */

function tf_create_post_type_hptestimonial_init() {
    $labels = array(
        'name' => __('Testimonials', 'tfbasedetails'),
        'singular_name' => __('Testimonial', 'tfbasedetails'),
        'rewrite' => array('slug' => __('testimonial', 'tfbasedetails')),
        'add_new' => _x('Add New', 'testimonial', 'tfbasedetails'),
        'add_new_item' => __('Add New Testimonial', 'tfbasedetails'),
        'edit_item' => __('Edit Testimonial', 'tfbasedetails'),
        'new_item' => __('New Testimonial', 'tfbasedetails'),
        'view_item' => __('View Testimonial', 'tfbasedetails'),
        'search_items' => __('Search Testimonials', 'tfbasedetails'),
        'not_found' => __('No testimonials found', 'tfbasedetails'),
        'not_found_in_trash' => __('No testimonials found in Trash', 'tfbasedetails'),
        'parent_item_colon' => ''
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );
    register_post_type('tf_hptestimonial', $args);
}

/* ----------------------------------------------------------------------------------- */
/*  Updated messages for the HP Testimonial post type
  /*----------------------------------------------------------------------------------- */

function tf_hptestimonial_updated_messages($messages) {

    $post_ID = '';
    $post = '';
    
    $messages[__('tf_hptestimonial')] =
            array(
                0 => '', // Unused. Messages start at index 1.
                1 => sprintf(__('Testimonial updated. <a href="%s">View Testimonial</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                2 => __('Custom field updated.', 'tfbasedetails'),
                3 => __('Custom field deleted.', 'tfbasedetails'),
                4 => __('Testimonial updated.', 'tfbasedetails'),
                /* translators: %s: date and time of the revision */
                5 => isset($_GET['revision']) ? sprintf(__('Testimonial restored to revision from %s', 'tfbasedetails'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
                6 => sprintf(__('Testimonial published. <a href="%s">View Testimonial</a>', 'tfbasedetails'), esc_url(get_permalink($post_ID))),
                7 => __('Testimonial saved.', 'tfbasedetails'),
                8 => sprintf(__('Testimonial submitted. <a target="_blank" href="%s">Preview Slide</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
                9 => sprintf(__('Testimonial scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Testimonial</a>', 'tfbasedetails'),
                        // translators: Publish box date format, see http://php.net/date
                        date_i18n(__('M j, Y @ G:i', 'tfbasedetails'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
                10 => sprintf(__('Testimonial draft updated. <a target="_blank" href="%s">Preview Testimonial</a>', 'tfbasedetails'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
    );

    return $messages;
}

/* ----------------------------------------------------------------------------------- */
/*  Modify the testimonial posts page to display custom columns 
  /*----------------------------------------------------------------------------------- */

function tf_hptestimonial_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Testimonial Title",
        "hptestimonial_description" => "Testimonial Description",
        "hptestimonial_name" => "Testimonial Name",
        "hptestimonial_occupation" => "Testimonial Occupation"
    );
    return $columns;
}

function tf_hptestimonial_custom_columns($column) {
    global $post;
    switch ($column) {
        case "hptestimonial_description":
            the_excerpt();
            break;        
        case "hptestimonial_name":
            $custom = get_post_custom();
            echo $custom["hptestimonial_name"][0];
            break;
        case "hptestimonial_occupation":
            $custom = get_post_custom();
            echo $custom["hptestimonial_occupation"][0];
            break;
    }
}

// Deal Custom Meta Boxes

function tf_hptestimonialmeta() {
    add_meta_box("tf_hptestimonial_meta", "Testimonial Options", "tf_hptestimonial_meta_options", "tf_hptestimonial", "normal", "high");
}

function tf_hptestimonial_meta_options() {
    global $post;
    $custom = get_post_custom($post->ID);
    $hptestimonial_name = $custom["hptestimonial_name"][0];
    $hptestimonial_occupation = $custom["hptestimonial_occupation"][0];

    if ($hptestimonial_occupation == null) {
        $hptestimonial_occupation = 'Citizen';
    }
    ?>
    <div style="padding-top:10px;">
        <label style="display:block;padding:2px;">Name:</label>
        <input style="width:220px;" name="hptestimonial_name" value="<?php echo $hptestimonial_name; ?>" />
    </div>
    <div style="padding-top:10px;">
        <label style="display:block;padding:2px;">Occupation:</label>
        <input name="hptestimonial_occupation" value="<?php echo $hptestimonial_occupation; ?>" />
    </div>
    <?php
}

function tf_hptestimonial_save_meta() {
    global $post;

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    update_post_meta($post->ID, "hptestimonial_name", $_POST["hptestimonial_name"]);
    update_post_meta($post->ID, "hptestimonial_occupation", $_POST["hptestimonial_occupation"]);
}

// Deals End Custom Meta Boxes



add_action('init', 'tf_create_post_type_showcase_init');
add_action('init', 'create_tfshowcasecategory_taxonomy', 0);
add_filter('post_updated_messages', 'tf_showcase_updated_messages');

add_action('init', 'tf_create_post_type_hpslide_init');
add_filter("manage_edit-tf_hpslide_columns", "tf_hpslide_edit_columns");
add_filter('post_updated_messages', 'tf_hpslide_updated_messages');

add_action('init', 'tf_create_post_type_hpdeal_init');
add_filter("manage_edit-tf_hpdeal_columns", "tf_hpdeal_edit_columns");
add_filter('post_updated_messages', 'tf_hpdeal_updated_messages');

add_action('init', 'tf_create_post_type_hptestimonial_init');
add_filter("manage_edit-tf_hptestimonial_columns", "tf_hptestimonial_edit_columns");
add_filter('post_updated_messages', 'tf_hptestimonial_updated_messages');

add_action('admin_menu', 'tf_hpslidemeta');
add_action('save_post', 'tf_hpslide_save_meta');

add_action('admin_menu', 'tf_hpdealmeta');
add_action('save_post', 'tf_hpdeal_save_meta');

add_action('admin_menu', 'tf_hptestimonialmeta');
add_action('save_post', 'tf_hptestimonial_save_meta');

add_action("manage_posts_custom_column", "tf_hpslide_custom_columns");
add_action("manage_posts_custom_column", "tf_hpdeal_custom_columns");
add_action("manage_posts_custom_column", "tf_hptestimonial_custom_columns");