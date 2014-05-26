<?php
global $woo_options;

// Remove WC sidebar
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action('tfwoocommerce_sidebar', 'woocommerce_get_sidebar', 10);
add_action('woocommerce_before_shop_loop', 'tf_beforeshoploop', 10);
add_action('woocommerce_after_shop_loop', 'tf_aftershoploop', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 10);
remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
add_action('woocommerce_product_thumbnails', 'tf_woocommerce_show_product_thumbnails', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'tf_woocommerce_template_single_meta' );
add_action( 'woocommerce_before_single_product_summary', 'tf_woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'tf_woocommerce_template_sku_meta', 40 );

function tf_woocommerce_template_single_price() {
    global $post, $product;
?>

<div class="tf-price-wrap clearfix">
    <div class="tf-product-title two_third first">
        <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>        
    </div>
<div class="tf-product-price one_third" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
    <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>
</div>

<?php
}

function tf_woocommerce_template_single_meta() {
    global $post, $product;
?>
<div class="product_meta">

    <?php echo $product->get_categories( ', ', ' <span class="posted_in">'.__('Category:', 'tfbasedetails').' ', '.</span>'); ?>

    <?php echo $product->get_tags( ', ', ' <span class="tagged_as">'.__('Tags:', 'tfbasedetails').' ', '.</span>'); ?>

</div>

<?php 
}

function tf_woocommerce_template_sku_meta() {
    global $post, $product;
         if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option('woocommerce_enable_sku') == 'yes' && $product->get_sku() ) : ?>
       <i class="icon-map-marker"></i><span itemprop="productID" class="sku"><?php _e('SKU:', 'tfbasedetails'); ?> <?php echo $product->get_sku(); ?>.</span>
    <?php endif; ?>

<?php 

}

function tf_woocommerce_show_product_thumbnails() {

    global $post, $product, $woocommerce;

    $attachment_ids = $product->get_gallery_attachment_ids();

    if ( $attachment_ids ) {
    ?>    
    <div class="jcarousel-container clearfix">
    <div class="thumbnails">
        <ul class="prodthumbs-carousel">
        <?php

        $loop = 0;
        $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );

        foreach ( $attachment_ids as $attachment_id ) {

            $classes = array( 'zoom' );

            if ( $loop == 0 || $loop % $columns == 0 )
                $classes[] = 'first';

            if ( ( $loop + 1 ) % $columns == 0 )
                $classes[] = 'last';

            $image_link = wp_get_attachment_url( $attachment_id );

            if ( ! $image_link )
                continue;

            $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
            $image_class = esc_attr( implode( ' ', $classes ) );
            $image_title = esc_attr( get_the_title( $attachment_id ) );

            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li class="jcarousel-item"><a href="%s" class="%s" title="%s"  rel="prettyPhoto[product-gallery]">%s</a></li>', $image_link, $image_class, $image_title, $image ), $attachment_id, $post->ID, $image_class );
            $loop++;
        }
        ?>
        </ul>
        <?php
            if ( $counta > 3)  {
            ?>
            <div class="jcarousel-prev"></div>
            <div class="jcarousel-next"></div>
        <?php
        }
    ?></div>
</div>
<?php 
    }
}

function tf_close_before_title() {
    ?>
    </div>
    </div>
    <div>
        <div>
            <?php
        }

        function tf_beforeshoploop() {
            $tf_woocommerce_columns = 0;
            if (!get_option('tf_shopcolumns')) {
                $tf_woocommerce_columns = 4;
            } else {
                $tf_woocommerce_columns = get_option('tf_shopcolumns');
            }
            ?>
            <div class="clearfix tfshop-<?php echo $tf_woocommerce_columns; ?>">
            <?php
        }

        function tf_aftershoploop() {
            ?>
            </div>
                <?php
            }

            function tf_beforeshoploopitem() {
                ?>
            <div class="tf_prodthumb">
                <div class="tf_prodthumb_inner">
            <?php
        }

        function tf_aftershoploopitem() {
            ?>
                </div>
            </div>
                    <?php
                }

                function tf_woocommerce_cat_before_content() {
                    ?>
            <div id="wrap_all">
                <section id="contents" role="main">
                    <div class="container">
                        <div class="content nine alpha units">
                            <div id="content">
    <?php
}

function tf_woocommerce_cat_after_content() {
    ?>

                                <section id="tbc">
                                <?php ?>
                                </section>


                            </div>
                        </div>
                    </div>

                    <div class="clearboth"></div>
                </section>
            </div><!-- #main -->
    <?php
}

// Change columns in Otros Productos output to 3
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 10);
add_action('woocommerce_after_single_product', 'woocommerce_upsell_display', 20);

function woocommerce_output_related_products() {
    woocommerce_related_products(3, 3); // 4 products, 4 columns
}

// Change columns in product loop to 3
function loop_columns() {

    if (!get_option('tf_shopcolumns')) {
        return 4;
    } else {
        return get_option('tf_shopcolumns');
    }
}

add_filter('loop_shop_columns', 'loop_columns');

$tfnoofproducts = get_theme_mod('tf_woonoprods', "12"); 

if ( strlen ( trim ($tfnoofproducts) ) > 0 ) { 
 $tfnoofproducts = $tfnoofproducts; 
} else {
 $tfnoofproducts = "12";
}

$cols = $tfnoofproducts;

// How many products per page?
$prodfunction = create_function('', 'global $cols; return $cols;');
//add_filter('loop_shop_per_page', create_function('$cols', 'return 12;'));
add_filter('loop_shop_per_page', $prodfunction);

// Adjust the star rating in the sidebar
add_filter('woocommerce_star_rating_size_sidebar', 'woostore_star_sidebar');

function woostore_star_sidebar() {
    return 12;
}

// Adjust the star rating in the recent reviews
add_filter('woocommerce_star_rating_size_recent_reviews', 'woostore_star_reviews');

function woostore_star_reviews() {
    return 12;
}

// Handle cart in header fragment for ajax add to cart
add_filter('add_to_cart_fragments', 'tf_header_add_to_cart_fragment');

if (!function_exists('tf_header_add_to_cart_fragment')) {

    function tf_header_add_to_cart_fragment($fragments) {
        global $woocommerce;

        ob_start();
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
                            echo '<li class="cart-title"><h3>' . __('Your Cart Contents', 'tfbasedetails') . '</h3></li>';
                            if (sizeof($woocommerce->cart->cart_contents) > 0) : foreach ($woocommerce->cart->cart_contents as $cart_item_key => $cart_item) :
                                    $_product = $cart_item['data'];
                                    if ($_product->exists() && $cart_item['quantity'] > 0) :
                                        echo '<li class="cart_list_product"><a href="' . get_permalink($cart_item['product_id']) . '">';

                                        echo $_product->get_image();

                                        echo apply_filters('woocommerce_cart_widget_product_title', $_product->get_title(), $_product) . '</a>';

                                        if ($_product instanceof woocommerce_product_variation && is_array($cart_item['variation'])) :
                                            echo woocommerce_get_formatted_variation($cart_item['variation']);
                                        endif;

                                        echo '<span class="quantities">' . $cart_item['quantity'] . ' &times; ' . woocommerce_price($_product->get_price()) . '</span></li>';
                                    endif;
                                endforeach;

                            else: echo '<li class="empty">' . __('No products in the cart.', 'tfbasedetails') . '</li>';
                            endif;
                            if (sizeof($woocommerce->cart->cart_contents) > 0) :
                                echo '<li class="total"><strong>';

                                if (get_option('js_prices_include_tax') == 'yes') :
                                    _e('Total', 'tfbasedetails');
                                else :
                                    _e('Subtotal', 'tfbasedetails');
                                endif;



                                echo ':</strong>' . $woocommerce->cart->get_cart_total();
                                '</li>';

                                echo '<li class="buttons"><a href="' . $woocommerce->cart->get_cart_url() . '" class="button">' . __('View Cart &rarr;', 'tfbasedetails') . '</a> <a href="' . $woocommerce->cart->get_checkout_url() . '" class="button checkout">' . __('Checkout &rarr;', 'tfbasedetails') . '</a></li>';
                            endif;

                            echo '</ul>';
                            ?>
                    </li>
                </ul>
                        <?php
                        $fragments['ul.mini-cart'] = ob_get_clean();

                        return $fragments;
                    }

                }
                ?>