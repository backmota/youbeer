<?php
/**
 * Loop-shop (deprecated)
 *
 * Outputs a product loop
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 * @deprecated 	1.6
 */

_deprecated_file( basename(__FILE__), '1.6' );
?>

<?php if ( have_posts() ) : ?>

	<?php do_action('woocommerce_before_shop_loop'); ?>
	<?php
            $tf_woocommerce_columns = 0;
            if (!get_option('tf_shopcolumns')) {
                $tf_woocommerce_columns = 4;
            } else {
                $tf_woocommerce_columns = get_option('tf_shopcolumns');
            }
     ?>
	<ul class="products">

		<?php woocommerce_product_subcategories(); ?>

		<?php do_action('woocommerce_before_shop_loop_products'); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php woocommerce_get_template_part( 'content', 'product' ); ?>

		<?php endwhile; // end of the loop. ?>

	</ul>

	<?php do_action('woocommerce_after_shop_loop'); ?>

<?php else : ?>

	<?php if ( ! woocommerce_product_subcategories( array( 'before' => '<ul class="products">', 'after' => '</ul>' ) ) ) : ?>

		<p><?php _e( 'No products found which match your selection.', 'tfbasedetails' ); ?></p>

	<?php endif; ?>

<?php endif; ?>

<div class="clear"></div>