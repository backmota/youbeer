<?php
/**
 * The Template for displaying products in a product tag. Simply includes the archive template.
 *
 * Override this template by copying it to yourtheme/woocommerce/taxonomy-product_tag.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>

<?php get_header( 'shop' ); ?>

<?php do_action( 'woocommerce_before_main_content' ); ?>

<?php tf_woocommerce_product_taxonomy_content(); ?>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php do_action( 'woocommerce_sidebar' ); ?>

<?php get_footer( 'shop' ); ?>
