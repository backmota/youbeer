<?php

/* ----------------------------------------------------------------------------------- */
/* 	Add Heading and Tagline Custom Fields
  /*----------------------------------------------------------------------------------- */

/* ----------------------------------------------------------------------------------- */
/* 	Create a set of arrays for each option
  /*----------------------------------------------------------------------------------- */
$tf_new_meta_boxes =
        array(
            "heading" => array(
                "name" => "website",
                "type" => "input",
                "std" => "",
                "title" => "Website"),
            "clientef" => array(
                "name" => "clientreference",
                "type" => "input",
                "std" => "",
                "title" => "Testimonial"),
            "clientname" => array(
                "name" => "clientname",
                "type" => "input",
                "std" => "",
                "title" => "Testimonial Source")
);


/* ----------------------------------------------------------------------------------- */
/* 	Create a new meta box function. This creates each different type of box, input, select etc...
  /*----------------------------------------------------------------------------------- */

function tf_new_meta_boxes() {
    global $post, $tf_new_meta_boxes;

    foreach ($tf_new_meta_boxes as $meta_box) {

        echo'<input type="hidden" name="' . $meta_box['name'] . '_noncename" id="' . $meta_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';

        echo'<h4>' . $meta_box['title'] . '</h4>';

        if ($meta_box['type'] == "input") {

            $meta_box_value = get_post_meta($post->ID, $meta_box['name'] . '_value', true);

            if ($meta_box_value == "")
                $meta_box_value = $meta_box['std'];

            echo'<input type="text" name="' . $meta_box['name'] . '_value" value="' . esc_attr($meta_box_value) . '" style="width:90%"/><br />';
        } elseif ($meta_box['type'] == "select") {

            echo'<select name="' . $meta_box['name'] . '_value">';

            foreach ($meta_box['options'] as $option) {

                echo'<option';
                if (get_post_meta($post->ID, $meta_box['name'] . '_value', true) == $option) {
                    echo ' selected="selected"';
                } elseif ($option == $meta_box['std']) {
                    echo ' selected="selected"';
                }
                echo'>' . $option . '</option>';
            }

            echo'</select>';
        } elseif ($meta_box['type'] == "upload") {

            echo 'upload box';
        }

        echo'<p><label for="' . $meta_box['name'] . '_value">' . $meta_box['description'] . '</label></p>';
    }
}

/* ----------------------------------------------------------------------------------- */
/* 	Enable the boxes on page, posts and portfolios
  /*----------------------------------------------------------------------------------- */

function tf_create_meta_box() {
    global $theme_name, $tf_new_meta_boxes;
    if (function_exists('add_meta_box')) {
        add_meta_box('new-meta-boxes', __('Showcase Details', 'tfbasedetails'), 'tf_new_meta_boxes', 'tf_showcase', 'normal', 'high');
    }
}

/* ----------------------------------------------------------------------------------- */
/* 	Save the newly added custom fields
  /*----------------------------------------------------------------------------------- */

function tf_save_postdata($post_id) {
    global $post, $tf_new_meta_boxes;
    foreach ($tf_new_meta_boxes as $meta_box) {


        // Verify  
        if (!wp_verify_nonce($_POST[$meta_box['name'] . '_noncename'], plugin_basename(__FILE__))) {
            return $post_id;
        }

        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {
            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        $data = $_POST[$meta_box['name'] . '_value'];

        if (get_post_meta($post_id, $meta_box['name'] . '_value') == "")
            add_post_meta($post_id, $meta_box['name'] . '_value', esc_attr($data), true);
        elseif ($data != get_post_meta($post_id, $meta_box['name'] . '_value', true))
            update_post_meta($post_id, $meta_box['name'] . '_value', esc_attr($data));
        elseif ($data == "")
            delete_post_meta($post_id, $meta_box['name'] . '_value', get_post_meta($post_id, $meta_box['name'] . '_value', true));
    }
}

add_action('admin_menu', 'tf_create_meta_box');
add_action('save_post', 'tf_save_postdata');
?>