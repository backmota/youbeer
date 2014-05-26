<?php

/* ----------------------------------------------------- */
/* Shortcodes */
/* ----------------------------------------------------- */

/* Dropcap */

function tf_dropcap($atts, $content = null) {
    extract(shortcode_atts(array(), $atts));
    $out = "<span class='dropcap' >" . $content . "</span>";
    return $out;
}

add_shortcode('dropcap', 'tf_dropcap');


/* Accordion Shortcode */

function tf_accordion($atts, $content, $code) {
    extract(shortcode_atts(array(
                'style' => false
                    ), $atts));
    if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
        return do_shortcode($content);
    } else {
        $output = '';
        for ($i = 0; $i < count($matches[0]); $i++) {
            $matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
            if ($i == 0) {
                $first = 'class="firsttitle"';
            } else {
                $first = '';
            }
            $output .= '<div class="title"><a href="#acc-' . $i . '" ' . $first . '>' . $matches[3][$i]['title'] . '</a></div><div class="inner" id="acc-' . $i . '">' . do_shortcode(trim($matches[5][$i])) . '</div>';
        }
        return '<div class="accordion">' . $output . '</div>';
    }
}

add_shortcode('accordion', 'tf_accordion');

/* ----------------------------------------------------- */
/* Alter Block */

function tf_alert($atts, $content = null) {

    extract(shortcode_atts(array(
                'type' => 'warning'
                    ), $atts));
    //return '<a href="' . $link . '" class="button ' . $color . ' ' . $align . '">' . $content . '</a>';
    return '<div class="alert-message ' . $type . '"><p>' . tf_remove_autop($content) . '</p></div>';
}

add_shortcode('alert', 'tf_alert');

/* ----------------------------------------------------- */
/* Responsive */

function tf_responsive($atts, $content = null) {

    extract(shortcode_atts(array(
                'show' => 'desktop'
                    ), $atts));
    //return '<a href="' . $link . '" class="button ' . $color . ' ' . $align . '">' . $content . '</a>';
    return '<div class="show-' . $show . '">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('responsive', 'tf_responsive');

/* ----------------------------------------------------- */
/* List Shortcodes */

function tf_list($atts, $content = null) {
    extract(shortcode_atts(array(
                'type' => 'check'
                    ), $atts));
    $out = '<ul class="list">' . tf_remove_autop($content) . '</ul>';
    return $out;
}

add_shortcode('list', 'tf_list');

function tf_item($atts, $content = null) {
    extract(shortcode_atts(array(
                'icon' => 'ok'
                    ), $atts));
    $out = '<li class="icon-' . $icon . '">' . tf_remove_autop($content) . '</li>';
    return $out;
}

add_shortcode('item', 'tf_item');

function tf_icon($atts, $content = null) {
    extract(shortcode_atts(array(
                'icon' => 'ok',
                'size' => 'default',
                'color' => '',
                'circle' => false,
                'type' => 'h1'
                    ), $atts));

    if ($size == 'large') {
        $return = " large";
    } else {
        $return = " default";
    }

    if ($circle == true) {
        $return2 = " circle";
    } else {
        $return2 = "";
    }

    if ($circle == true && $color != '') {
        $return4 = ' style="background-color:' . $color . ' !important; color: #ffffff !important;"';
    }
    if ($circle == false && $color != '') {
        $return4 = ' style="color: ' . $color . ' !important;"';
    }
    if ($circle != true && $color != '') {
        $return4 = ' style="color: ' . $color . ' !important;"';
    }



    if ($type == 'h1') {
        $return3 = "h1";
    } elseif ($type == 'h2') {
        $return3 = "h2";
    } elseif ($type == 'h3') {
        $return3 = "h3";
    } elseif ($type == 'h4') {
        $return3 = "h4";
    } elseif ($type == 'h5') {
        $return3 = "h5";
    } elseif ($type == 'h6') {
        $return3 = "h6";
    } else {
        $return3 = "h1";
    }


    $out = '<' . $return3 . ' class="tficon' . $return . '' . $return2 . '"><span class="icon-' . $icon . '"' . $return4 . '></span>' . tf_remove_autop($content) . '</' . $return3 . '>';
    return $out;
}

add_shortcode('icon', 'tf_icon');

/* ----------------------------------------------------- */
/* Video Shortcodes */

function tf_video($atts, $content=null) {
    extract(shortcode_atts(array(
                'type' => '',
                'id' => '',
                'width' => false,
                'height' => false,
                'autoplay' => ''
                    ), $atts));

    if ($height && !$width)
        $width = intval($height * 16 / 9);
    if (!$height && $width)
        $height = intval($width * 9 / 16) + 25;
    if (!$height && !$width) {
        $height = 320;
        $width = 480;
    }

    //$link = $link?' href="'.$link.'"':'';

    $autoplay = ($autoplay == 'yes' ? '1' : false);

    if ($type == "vimeo")
        $return = "<div class='video-embed'><iframe src='http://player.vimeo.com/video/$id?autoplay=$autoplay&amp;title=0&amp;byline=0&amp;portrait=0' width='$width' height='$height' class='iframe'></iframe></div>";
    else if ($type == "youtube")
        $return = "<div class='video-embed'><iframe src='http://www.youtube.com/embed/$id?HD=1;rel=0;showinfo=0' width='$width' height='$height' class='iframe'></iframe></div>";
    if (!empty($id)) {
        return $return;
    }
}

add_shortcode('video', 'tf_video');

/* ----------------------------------------------------- */
/* HR */

function tf_hr() {
    return '<div class="hr"></div>';
}

add_shortcode('hr', 'tf_hr');

function tf_hr2() {
    return '<div class="hr2"></div>';
}

add_shortcode('hr2', 'tf_hr2');

function tf_hr3() {
    return '<div class="hr3"></div>';
}

add_shortcode('hr3', 'tf_hr3');

function tf_clear() {
    return '<div class="clear"></div>';
}

add_shortcode('clear', 'tf_clear');

function tf_hr4() {
    return '<div class="hr4"><span class="seperator"></span><span class="lightborder"></span></div>';
}

add_shortcode('hr4', 'tf_hr4');

function tf_spacer() {
    return '<div class="spacer"></div>';
}

add_shortcode('spacer', 'tf_spacer');

/* ----------------------------------------------------- */
/* Buttons */

function tf_buttons($atts, $content = null) {
    extract(shortcode_atts(array(
                'link' => '#',
                'target' => '_self',
                'size' => 'normal',
                'style' => 'default', //light, dark, normal
                //'class' => 'generic',
                'align' => '',
                'icon' => ''
                    ), $atts));

    if ($icon != '') {
        $return = "icon-" . $icon;
    } else {
        $return = "";
    }

    $out = "<a href=\"" . $link . "\" target=\"" . $target . "\" class=\"generic button " . $style . " " . $size . " " . $align . " " . $return . "\">" . do_shortcode($content) . "</a>";
    return $out;
}

add_shortcode('button', 'tf_buttons');

/* ----------------------------------------------------- */
/* Responsive Images */

function tf_image($atts, $content = null) {
    extract(shortcode_atts(array(
                'src' => '#',
                'responsive' => true,
                'lightbox' => false
                    ), $atts));

    if ($responsive == true) {
        $return = "responsive";
    } else {
        $return = "";
    }

    if ($lightbox == true) {
        $return2 = '<a href="' . $src . '">';
        $return3 = '</a>';
    }

    $out = $return2 . '<img src="' . $src . '" class="' . $return . '">' . $return3;
    return $out;
}

add_shortcode('image', 'tf_image');

/* ----------------------------------------------------- */
/* Toggle Shortcode */

function tf_toggle($atts, $content = null) {
    extract(shortcode_atts(array(
                'title' => '',
                    ), $atts));
    return '<div class="toggle"><div class="title">' . $title . '<span></span></div><div class="inner"><div>' . tf_remove_autop($content) . '</div></div></div>';
}

add_shortcode('toggle', 'tf_toggle');


/* ----------------------------------------------------- */
/* Tabs Shortcode */

function tf_tabs($atts, $content = null, $code) {
    extract(shortcode_atts(array(
                    ), $atts));
    if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
        return do_shortcode($content);
    } else {
        for ($i = 0; $i < count($matches[0]); $i++) {
            $matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
        }
        $output = '<ul class="tabNavigation clearfix">';

        for ($i = 0; $i < count($matches[0]); $i++) {
            $output .= '<li><a title="' . $matches[3][$i]['title'] . '" href="#tab-' . $i . '">' . $matches[3][$i]['title'] . '</a></li>';
        }
        $output .= '</ul><div class="clearnav"></div>';
        for ($i = 0; $i < count($matches[0]); $i++) {
            $output .= '<div id="tab-' . $i . '">' . do_shortcode(trim($matches[5][$i])) . '</div>';
        }

        return '<div class="tabs">' . $output . '</div>';
    }
}

add_shortcode('tabs', 'tf_tabs');


/* ----------------------------------------------------- */
/* Pricing Table */

function tf_plan($atts, $content = null) {
    extract(shortcode_atts(array(
                'name' => 'Premium',
                'link' => 'http://www.google.de',
                'linkname' => 'Sign Up',
                'price' => '39.00$',
                'per' => false,
                'color' => false, // grey, green, red, blue
                'featured' => false
                    ), $atts));

    if ($featured == true) {
        $return = " featured";
        $return2 = "";
    } else {
        $return = "";
        $return2 = "light";
    }
    if ($per != false) {
        $return3 = "" . $per . "";
    } else {
        $return3 = "";
    }
    $return5 = "";
    if ($color != false) {
        if ($featured == true) {
            $return5 = "style='color:" . $color . ";' ";
        }
        $return4 = "style='color:" . $color . ";' ";
    } else {
        $return4 = "";
    }

    $out = "
        <div class='plan" . $return . "' " . $return5 . ">
            <div class='plan-head'><h3 " . $return4 . ">" . $name . "</h3>
            <div class='price' " . $return4 . ">" . $price . " <span>" . $return3 . "</span></div></div>
            <ul>" . do_shortcode($content) . "</ul><div class='signup'><a class='button " . $return2 . "' href='" . $link . "'>" . $linkname . "<span></span></a></div>
        </div>";
    return $out;
}

add_shortcode('plan', 'tf_plan');

/* ----------------------------------------------------- */
/* Pricing Table */

function tf_pricing($atts, $content = null) {
    extract(shortcode_atts(array(
                'col' => '3'
                    ), $atts));

    $out = "<div class='pricing-table col-" . $col . "'>" . do_shortcode($content) . "</div><div class='clear'></div>";
    return $out;
}

add_shortcode('pricing-table', 'tf_pricing');

/* ----------------------------------------------------- */
/* Columns */

function tf_one_third($atts, $content = null) {
    return '<div class="one_third">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_third', 'tf_one_third');

function tf_one_third_first($atts, $content = null) {
    return '<div class="one_third first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_third_first', 'tf_one_third_first');

function tf_one_third_last($atts, $content = null) {
    return '<div class="one_third last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_third_last', 'tf_one_third_last');

function tf_two_third($atts, $content = null) {
    return '<div class="two_third">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('two_third', 'tf_two_third');

function tf_two_third_first($atts, $content = null) {
    return '<div class="two_third first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('two_third_first', 'tf_two_third_first');

function tf_two_third_last($atts, $content = null) {
    return '<div class="two_third last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('two_third_last', 'tf_two_third_last');

function tf_one_half($atts, $content = null) {
    return '<div class="one_half">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_half', 'tf_one_half');

function tf_one_half_first($atts, $content = null) {
    return '<div class="one_half first">' . wpautop(tf_remove_autop($content)) . '</div>';
}

add_shortcode('one_half_first', 'tf_one_half_first');

function tf_one_half_last($atts, $content = null) {
    return '<div class="one_half last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_half_last', 'tf_one_half_last');

function tf_one_fourth($atts, $content = null) {
    return '<div class="one_fourth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_fourth', 'tf_one_fourth');

function tf_one_fourth_first($atts, $content = null) {
    return '<div class="one_fourth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_fourth_first', 'tf_one_fourth_first');

function tf_one_fourth_last($atts, $content = null) {
    return '<div class="one_fourth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_fourth_last', 'tf_one_fourth_last');

function tf_three_fourth($atts, $content = null) {
    return '<div class="three_fourth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('three_fourth', 'tf_three_fourth');

function tf_three_fourth_first($atts, $content = null) {
    return '<div class="three_fourth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('three_fourth_first', 'tf_three_fourth_first');

function tf_three_fourth_last($atts, $content = null) {
    return '<div class="three_fourth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('three_fourth_last', 'tf_three_fourth_last');

function tf_one_fifth($atts, $content = null) {
    return '<div class="one_fifth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_fifth', 'tf_one_fifth');

function tf_one_fifth_first($atts, $content = null) {
    return '<div class="one_fifth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_fifth_first', 'tf_one_fifth_first');

function tf_one_fifth_last($atts, $content = null) {
    return '<div class="one_fifth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_fifth_last', 'tf_one_fifth_last');

function tf_two_fifth($atts, $content = null) {
    return '<div class="two_fifth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('two_fifth', 'tf_two_fifth');

function tf_two_fifth_first($atts, $content = null) {
    return '<div class="two_fifth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('two_fifth_first', 'tf_two_fifth_first');

function tf_two_fifth_last($atts, $content = null) {
    return '<div class="two_fifth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('two_fifth_last', 'tf_two_fifth_last');

function tf_three_fifth($atts, $content = null) {
    return '<div class="three_fifth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('three_fifth', 'tf_three_fifth');

function tf_three_fifth_first($atts, $content = null) {
    return '<div class="three_fifth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('three_fifth_first', 'tf_three_fifth_first');

function tf_three_fifth_last($atts, $content = null) {
    return '<div class="three_fifth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('three_fifth_last', 'tf_three_fifth_last');

function tf_four_fifth($atts, $content = null) {
    return '<div class="four_fifth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('four_fifth', 'tf_four_fifth');

function tf_four_fifth_first($atts, $content = null) {
    return '<div class="four_fifth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('four_fifth_first', 'tf_four_fifth_first');

function tf_four_fifth_last($atts, $content = null) {
    return '<div class="four_fifth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('four_fifth_last', 'tf_four_fifth_last');

function tf_one_sixth($atts, $content = null) {
    return '<div class="one_sixth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_sixth', 'tf_one_sixth');

function tf_one_sixth_first($atts, $content = null) {
    return '<div class="one_sixth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('one_sixth_first', 'tf_one_sixth_first');

function tf_one_sixth_last($atts, $content = null) {
    return '<div class="one_sixth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('one_sixth_last', 'tf_one_sixth_last');

function tf_five_sixth($atts, $content = null) {
    return '<div class="five_sixth">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('five_sixth', 'tf_five_sixth');

function tf_five_sixth_first($atts, $content = null) {
    return '<div class="five_sixth first">' . tf_remove_autop($content) . '</div>';
}

add_shortcode('five_sixth_first', 'tf_five_sixth_first');

function tf_five_sixth_last($atts, $content = null) {
    return '<div class="five_sixth last">' . tf_remove_autop($content) . '</div><div class="clear"></div>';
}

add_shortcode('five_sixth_last', 'tf_five_sixth_last');



/**
 * Removes wordpress autop and invalid nesting of p tags, as well as br tags
 *
 * @param string $content html content by the wordpress editor
 * @return string $content
 */
if (!function_exists("tf_remove_autop")) {

    function tf_remove_autop($content) {

        $content = do_shortcode(shortcode_unautop($content));
        $content = preg_replace('#^<\/p>|^<br\s?\/?>|<p>$|<p>\s*(&nbsp;)?\s*<\/p>#', '', $content);
        return $content;
    }

}

function tf_parse_shortcode_content($content) {

    /* Parse nested shortcodes and add formatting. */
    $content = trim(do_shortcode(shortcode_unautop($content)));

    /* Remove '' from the start of the string. */
    if (substr($content, 0, 4) == '')
        $content = substr($content, 4);

    /* Remove '' from the end of the string. */
    if (substr($content, -3, 3) == '')
        $content = substr($content, 0, -3);

    /* Remove any instances of ''. */
    $content = str_replace(array('<p></p>'), '', $content);
    $content = str_replace(array('<p>  </p>'), '', $content);

    return $content;
}

// add_filter('tf_shortcode_out_filter', 'tf_clear_autop');
// function tf_clear_autop($content)
// {
//     $content = str_ireplace('<p>', '', $content);
//     $content = str_ireplace('</p>', '', $content);
//     $content = str_ireplace('<br />', '', $content);
//     return $content;
// }
?>