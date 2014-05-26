<?php
/**
 * Our main navigation functions.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */

function tf_main_nav() {
	?>

<nav id="access" class="navbg" role="navigation">
<div id="navigation" class="clearfix">
<?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?><a id="skip" href="#content" class="hidden" title="<?php esc_attr_e('Skip to content', 'tfbasedetails'); ?>"><?php _e('Skip to content', 'tfbasedetails'); ?></a> <?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?> <?php
if (function_exists('has_nav_menu') && has_nav_menu('Main Navigation')) {
wp_nav_menu(array('theme_location' => 'Main Navigation', 'container' => 'ul', 'menu_id' => 'main-nav', 'menu_class' => 'nav fl', 'walker' => new menu_walker()));
} else {
?>

<ul id="nav" class="nav fl">
<?php
if (is_page())
$highlight = "page_item"; else
$highlight = "page_item current_page_item";
?>
<li class="<?php echo $highlight; ?>"><a href="<?php echo home_url(); ?>"><?php _e('Home', 'tfbasedetails') ?></a></li><?php wp_list_pages('sort_column=menu_order&depth=6&title_li=&exclude='); ?>
</ul><!-- /#nav -->
<?php } ?>
</div>
<?php
dropdown_menu(array(
'theme_location' => 'Main Navigation',
'menu_id' => 'select-main-nav',
// You can alter the blanking text eg. "- Menu Name -" using the following
'dropdown_title' => '-- Select a page --',
// indent_string is a string that gets output before the title of a
// sub-menu item. It is repeated twice for sub-sub-menu items and so on
'indent_string' => '- ',
// indent_after is an optional string to output after the indent_string
// if the item is a sub-menu item
'indent_after' => ''
));
?>
</nav>
	<?php
}

// Custom main-nav walker. Major kudos to Kriesi.at for: http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output

class description_walker extends Walker_Nav_Menu
{
      function start_el(&$output, $item, $depth, $args)
      {
           global $wp_query;

           $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

           $class_names = $value = '';

           $classes = empty( $item->classes ) ? array() : (array) $item->classes;

           $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
           $class_names = ' class="'. esc_attr( $class_names ) . '"';

		   $output .= $indent . '<li id="item-'. $item->ID . '"' . $value . $class_names .'>';

           $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
           $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
           $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
           $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

           $prepend = '<strong>';
           $append = '</strong>';
           $description  = ! empty( $item->description ) ? '<span class="navi-description">'.esc_attr( $item->description ).'</span>' : '';

           if($depth != 0)
           {
                     $description = $append = $prepend = "";
           }


            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'><span>';
            $item_output .= $args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
            $item_output .= $description.$args->link_after;
            $item_output .= '</span></a>';
            $item_output .= $args->after;


            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
            }
}

// Custom sub-menu Walker - kudos to Karma theme for original implementation

class sub_nav_walker extends Walker_Nav_Menu {
	var $found_parents = array();

	function start_el(&$output, $item, $depth, $args) {
		global $wp_query, $item_output;

		//this only works for second level sub navigation
		$parent_item_id = 0;

		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'.esc_attr($class_names).'"';

		#current_page_item
		// Checks if the current element is in the current selection
		if (strpos($class_names, 'current-menu-item') || strpos($class_names, 'current-menu-parent') || strpos($class_names, 'current-menu-ancestor') || (is_array($this->found_parents) && in_array($item->menu_item_parent, $this->found_parents))) {
			// Keep track of all selected parents
			$this->found_parents[] = $item->ID;
			//check if the item_parent matches the current item_parent
			if ($item->menu_item_parent != $parent_item_id) {
				$output .= $indent.'<li'.$class_names.'>';



				$attributes = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
				$attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
				$attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
				$attributes .= !empty($item->url) ? ' href="'.esc_attr($item->url).'"' : '';

				$item_output = $args->before;
				$item_output .= '<a'.$attributes.'><span>';
				$item_output .= $args->link_before.apply_filters('the_title', $item->title, $item->ID).$args->link_after;
				$item_output .= '</span></a>';
				$item_output .= $args->after;
			}
			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}
	}

	function end_el(&$output, $item, $depth) {
		$parent_item_id = 0;

		$class_names = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item));
		$class_names = ' class="'.esc_attr($class_names).'"';

		if (strpos($class_names, 'current-menu-item') || strpos($class_names, 'current-menu-parent') || strpos($class_names, 'current-menu-ancestor') || (is_array($this->found_parents) && in_array($item->menu_item_parent, $this->found_parents))) {
			// Closes only the opened li
			if (is_array($this->found_parents) && in_array($item->ID, $this->found_parents) && $item->menu_item_parent != $parent_item_id) {
				$output .= "</li>\n";
			}
		}
	}

	function end_lvl(&$output, $depth) {
		$indent = str_repeat("\t", $depth);
		// If the sub-menu is empty, strip the opening tag, else closes it
		if (substr($output, -22) == "<ul class=\"sub-menu\">\n") {
			$output = substr($output, 0, strlen($output) - 23);
		} else {
			$output .= "$indent</ul>\n";
		}
	}
}
?>