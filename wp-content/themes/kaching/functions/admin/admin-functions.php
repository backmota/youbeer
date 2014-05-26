<?php
/* ----------------------------------------------------------------------------------- */
/* Head Hook
  /*----------------------------------------------------------------------------------- */

function tf_head() {
    do_action('tf_head');
}

/* ----------------------------------------------------------------------------------- */
/* Get the style path currently selected */
/* ----------------------------------------------------------------------------------- */

function tf_style_path() {
    $style = $_REQUEST['style'];
    if ($style != '') {
        $style_path = $style;
    } else {
        $stylesheet = get_option('tf_optstylesheet');
        $style_path = str_replace(".css", "", $stylesheet);
    }
    if ($style_path == "default")
        echo 'images';
    else
        echo 'styles/' . $style_path;
}

/* ----------------------------------------------------------------------------------- */
/* Add default options after activation */
/* ----------------------------------------------------------------------------------- */
if (is_admin() && isset($_GET['activated']) && $pagenow == "themes.php?page=adminoptions") {
    //Call action that sets
    add_action('admin_head', 'tf_option_setup');
}

function tf_option_setup() {

    //Update EMPTY options
    $tf_array = array();
    add_option('tf_options', $tf_array);

    $template = get_option('tf_template');
    $saved_options = get_option('tf_options');

    foreach ($template as $option) {
        if ($option['type'] != 'heading') {
            $id = $option['id'];
            $std = $option['std'];
            $db_option = get_option($id);
            if (empty($db_option)) {
                if (is_array($option['type'])) {
                    foreach ($option['type'] as $child) {
                        $c_id = $child['id'];
                        $c_std = $child['std'];
                        update_option($c_id, $c_std);
                        $tf_array[$c_id] = $c_std;
                    }
                } else {
                    update_option($id, $std);
                    $tf_array[$id] = $std;
                }
            } else { //So just store the old values over again.
                $tf_array[$id] = $db_option;
            }
        }
    }
    update_option('tf_options', $tf_array);
}

/* ----------------------------------------------------------------------------------- */
/* Admin Backend */
/* ----------------------------------------------------------------------------------- */

function adminoptions_admin_head() {
//Tweaked the message on theme activate
    ?>

    <script type="text/javascript">
        jQuery(function(){
            var message = '<p><strong>This theme has been activated.</strong> The custom options panel is located under <a href="<?php echo admin_url('admin.php?page=adminoptions'); ?>">Appearance > Theme Admin Options</a>.</p>';
            jQuery('.themes-php #message2').html(message);

        });
    </script>


<?php
}

add_action('admin_head', 'adminoptions_admin_head');
?>