<?php

#
# creates the post image for each post
#
function tf_woocommerce_thumbnail($asdf)
{
	//circumvent the missing post and product parameter in the loop_shop template
	global $post;

	// wc2.0upgrade

	if ( function_exists( 'get_product' ) )
		$product = get_product( $post->ID );
	else

	$product = new WC_Product( $post->ID );
	ob_start();
	if($product->product_type != 'external')
	{
		woocommerce_template_loop_add_to_cart($post, $product);
	}
	$link = ob_get_clean();
	$extraClass  = empty($link) ? "single_button" :  "" ;
	
	echo "<div class='thumbnail_container'>";
	echo "<div class='thumbnail_container_inner'>";
		echo get_the_post_thumbnail( get_the_ID(), 'shop_catalog' );
		echo $link;
		echo "<a class='button show_details_button $extraClass' href='".get_permalink($post->ID)."'>".__('Show Details','tfbasedetails')."</a>";
		if(!empty($rating)) echo "<span class='rating_container'>".$rating."</span>";
		
		echo "</div>";
	echo "</div>";
}

function tf_woocommerce_cart_dropdown() {

	global $woo_options;
 	global $woocommerce;

	?>
		<ul class="mini-cart">
		    <li>
		    	<a class="cart_dropdown_link cart-parent" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'tfbasedetails'); ?>">
		    		<i class='icon-shopping-cart'></i>
		    		<span class='cart_subtotal'><?php 
		    		echo $woocommerce->cart->get_cart_total(); 
		    		?></span>
		    		<?php
		    		echo sprintf(_n('<span class="cart_itemstotal">%d item</span>', '<span class="cart_itemstotal">%d items</span>', $woocommerce->cart->cart_contents_count, 'tfbasedetails'), $woocommerce->cart->cart_contents_count);		    		
		    		?>
		    	</a>
		    	<?php
 		    		
		            echo '<ul class="cart_list">';
		            echo '<li class="cart-title"><h3>'.__('Your Cart Contents', 'tfbasedetails').'</h3></li>';
		               if (sizeof($woocommerce->cart->cart_contents)>0) : foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
		    	           $_product = $cart_item['data'];
		    	           if ($_product->exists() && $cart_item['quantity']>0) :
		    	               echo '<li class="cart_list_product"><a href="'.get_permalink($cart_item['product_id']).'">';
		    	               
		    	               echo $_product->get_image();
		    	               
		    	               echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product).'</a>';
		    	               
		    	               if($_product instanceof woocommerce_product_variation && is_array($cart_item['variation'])) :
		    	                   echo woocommerce_get_formatted_variation( $cart_item['variation'] );
		    	                 endif;
		    	               
		    	               echo '<span class="quantities">' .$cart_item['quantity'].' &times; '.woocommerce_price($_product->get_price()).'</span></li>';
		    	           endif;
		    	       endforeach;
       
		            	else: echo '<li class="empty">'.__('No products in the cart.','tfbasedetails').'</li>'; endif;
		            	if (sizeof($woocommerce->cart->cart_contents)>0) :
		                echo '<li class="total"><strong>';
		
		                if (get_option('js_prices_include_tax')=='yes') :
		                    _e('Total', 'tfbasedetails');
		                else :
		                    _e('Subtotal', 'tfbasedetails');
		                endif;
		    				    				
		                echo ': </strong>' .$woocommerce->cart->get_cart_total();'</li>';
		
		                echo '<li class="buttons"><a href="'.$woocommerce->cart->get_cart_url().'" class="button">'.__('View Cart &rarr;','tfbasedetails').'</a> <a href="'.$woocommerce->cart->get_checkout_url().'" class="button checkout">'.__('Checkout &rarr;','tfbasedetails').'</a></li>';
		            endif;
		            
		            echo '</ul>';
		
		        ?>
		    </li>
	  	</ul>
<?php }

#
# helper function that collects all the necessary urls for the shop navigation
#

function tf_collect_shop_urls()
{
	global $woocommerce;
	
	$url['cart']				= $woocommerce->cart->get_cart_url();
	$url['checkout']			= $woocommerce->cart->get_checkout_url();
	$url['account_overview'] 	= get_permalink(get_option( 'woocommerce_myaccount_page_id' ));
	$url['edit_address']		= home_url('/my-account/edit-address');
	$url['edit_account'] 		= home_url('/my-account/edit-account');
	$url['logout'] 				= wp_logout_url(home_url('/'));
	$url['register'] 			= site_url('wp-login.php?action=register', 'login');

	return $url;
}

function tf_shop_nav()
{
	$output = "";
	$args = "";
	$url = tf_collect_shop_urls();
	
	$output .= "<ul>";
	
	if( is_user_logged_in() )
	{
		$output .= "<li class='account_overview_link'><a href='".$url['account_overview']."'>".__('Mi Cuenta', 'tfbasedetails')."</a>";
			$output .= "<ul>";
			$output .= "<li class='account_logout_link'><a href='".$url['logout']."'>".__('Salir', 'tfbasedetails')."</a></li>";
			$output .= "</ul>";
		$output .= "</li>";
	}
	else
	{
		if(get_option('users_can_register')) 
		{
			$output .= "<li class='register_link'><a href='".$url['register']."'>".__('Registrar', 'tfbasedetails')."</a></li>";
		}
		
		$output .= "<li class='login_link'><a href='".$url['account_overview']."'>".__('Log In', 'tfbasedetails')."</a></li>";
	}
	
	$output .= "<li class='shopping_cart_link'><a href='".$url['cart']."'>".__('Carrito', 'tfbasedetails')."</a></li>";
	$output .= "<li class='checkout_link'><a href='".$url['checkout']."'>".__('Checkout', 'tfbasedetails')."</a></li>";
	$output .= "</ul>";
	
	return $output;
}

function tf_add_summary_div()
{
	echo "<div class='one_half'>";
}

function tf_close_summary_div()
{
	echo "</div>";
}

function tf_woocommerce_product_taxonomy_content() {

	global $wp_query;

	$term = get_term_by( 'slug', get_query_var( $wp_query->query_vars['taxonomy'] ) , $wp_query->query_vars['taxonomy'] ); ?>

	<div class="wooside three units first">
		<?php do_action('tfwoocommerce_sidebar'); ?>
	</div>
	<div class="nine units">
		<?php 

		$image		 	= "";
		$titleClass		= "";
		$attachment_id 	= get_woocommerce_term_meta($term->term_id, 'thumbnail_id');

		if(!empty($attachment_id)) {
				$titleClass .= "title_container_image ";
				$image		= wp_get_attachment_image( $attachment_id, 'woocat_thumb', false, array('class'=>'woocat_thumb'));
		}
		?>
		<div class="shop-descwrap">
			<div class="shop-cat-thumb">
				<?php echo $image; ?>
			</div>
			
			<div class="shop-cat-desc">
				<h1 class="page-title"><?php echo wptexturize( $term->name ); ?></h1>
				<?php if ( $term->description ) : ?>
				<?php echo wpautop( wptexturize( $term->description ) ); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="shop-cat-orderby clearfix">
			<?php woocommerce_get_template_part( 'loop', 'shop'  ); ?>
		</div>
	</div>

	<?php

}

function tf_woocommerce_archive_product_content() {
	?>

	<div class="wooside three units first">
		<?php do_action('tfwoocommerce_sidebar'); ?>
	</div>


	<?php

	if ( ! is_search() ) {
		$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
		$shop_page_title = apply_filters( 'the_title', ( get_option( 'woocommerce_shop_page_title' ) ) ? get_option( 'woocommerce_shop_page_title' ) : $shop_page->post_title );
		if ( is_object( $shop_page  ) )
			$shop_page_content = $shop_page->post_content;
	} else {
		$shop_page_title = __( 'Search Results:', 'tfbasedetails' ) . ' &ldquo;' . get_search_query() . '&rdquo;';
		if ( get_query_var( 'paged' ) ) $shop_page_title .= ' &mdash; ' . __( 'Page', 'tfbasedetails' ) . ' ' . get_query_var( 'paged' );
		$shop_page_content = '';
	}

	?>
	<div class="nine units">
		<div class="shop-descwrap">
			<div class="shop-cat-desc">
				<h1 class="page-title"><?php echo $shop_page_title ?></h1>
			</div>
		</div>
		<div class="shop-cat-orderby clearfix">
			<?php if ( ! empty( $shop_page_content  ) ) echo apply_filters( 'the_content', $shop_page_content ); ?>
			<?php woocommerce_get_template_part( 'loop', 'shop'  ); ?>
		</div>	
	</div>
<?php
} 

function tf_woocommerce_single_product_content() {
	?>

	<div class="wooside three units first">
		<?php do_action('tfwoocommerce_sidebar'); ?>
	</div>


	<?php

	if ( ! is_search() ) {
		$shop_page = get_post( woocommerce_get_page_id( 'shop' ) );
		$shop_page_title = apply_filters( 'the_title', ( get_option( 'woocommerce_shop_page_title' ) ) ? get_option( 'woocommerce_shop_page_title' ) : $shop_page->post_title );
		if ( is_object( $shop_page  ) )
			$shop_page_content = $shop_page->post_content;
	} else {
		$shop_page_title = __( 'Search Results:', 'tfbasedetails' ) . ' &ldquo;' . get_search_query() . '&rdquo;';
		if ( get_query_var( 'paged' ) ) $shop_page_title .= ' &mdash; ' . __( 'Page', 'tfbasedetails' ) . ' ' . get_query_var( 'paged' );
		$shop_page_content = '';
	}

	?>
	<div class="nine units">
		<div class="shop-descwrap">
			<div class="shop-cat-desc">
				<h1 class="page-title"><?php echo $shop_page_title ?></h1>
			</div>
		</div>
		<div class="shop-cat-orderby clearfix">
			<?php woocommerce_catalog_ordering(); ?>
			<?php if ( ! empty( $shop_page_content  ) ) echo apply_filters( 'the_content', $shop_page_content ); ?>
			<?php woocommerce_get_template_part( 'loop', 'shop'  ); ?>
			<?php do_action( 'woocommerce_pagination' ); ?>
		</div>	
	</div>
<?php
} 

function tf_woocommerce_advanced_title()
{
	global $wp_query;

	$titleClass 	= "";
	$image		 	= "";

	if(isset($wp_query->query_vars['taxonomy']))
	{
		$term 			= get_term_by( 'slug', get_query_var($wp_query->query_vars['taxonomy']), $wp_query->query_vars['taxonomy']);
		$attachment_id 	= get_woocommerce_term_meta($term->term_id, 'thumbnail_id');
		if(!empty($term->description)) $titleClass .= "title_container_description ";
	}
	
	if(!empty($attachment_id))
	{
		$titleClass .= "title_container_image ";
		$image		= wp_get_attachment_image( $attachment_id, 'thumbnail', false, array('class'=>'category_thumb'));
	}

	echo "<div class='extralight-border title_container shop_title_container $titleClass'>";
	woocommerce_catalog_ordering();
	echo $image;
}