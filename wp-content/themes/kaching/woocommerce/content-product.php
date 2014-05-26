<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibilty
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

?>

<li class="product <?php
	if ( $woocommerce_loop['loop'] % $woocommerce_loop['columns'] == 0 )
		echo 'last';
	elseif ( ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] == 0 )
		echo 'first';
	?>">

			<?php do_action('woocommerce_before_shop_loop_item'); ?>

			<div class="tf_prodthumb">
        		<div class="tf_prodthumb_inner">
			
			<a href="<?php the_permalink(); ?>">
				
				<?php do_action('woocommerce_before_shop_loop_item_title'); ?>

			</a>

				</div>
    		</div>

    		<a href="<?php the_permalink(); ?>">

				<h3><?php the_title(); ?></h3>
				
				<?php do_action('woocommerce_after_shop_loop_item_title'); ?>
			<?php do_action('woocommerce_after_shop_loop_item'); ?>
			
			</a>
		</li>