<?php



namespace MakaiExtensions\PreGetPosts;



function custom_woocommerce_products_per_page( $query ) {

    // Csak a weboldal elején (nem az adminban), és csak a fő WooCommerce terméklistán fusson le

    if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
        $query->set( 'posts_per_page', 12 );
    }


}
add_action( 'pre_get_posts', '\MakaiExtensions\PreGetPosts\custom_woocommerce_products_per_page' );