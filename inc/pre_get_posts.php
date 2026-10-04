<?php



namespace MakaiExtensions\PreGetPosts;



function custom_woocommerce_products_per_page( $query ) {

    if ( is_admin() || !($query->is_main_query()) || ( !is_shop() && !is_product_category() && !is_product_tag() ) ) {
        return;
    }


    $product_per_page = $GLOBALS['mex_products_per_page'];
    
    $layout = $GLOBALS['mex_layout'];
    $orderby = $GLOBALS['mex_orderby'];
    $ordering = $GLOBALS['mex_ordering'];
    
    $onsale = true;// $GLOBALS['mex_onsale'];

    $price_filter = $GLOBALS['mex_price_filter'];
    $min_price = $GLOBALS['mex_minprice'];
    $max_price = $GLOBALS['mex_maxprice'];

    if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
    }
    
    $meta_query = $query->get('meta_query');

    if ( ! is_array( $meta_query ) ) {
        $meta_query = [];
    }
        
    if ( $onsale ) {    
        $meta_query[] = [
            'relation' => 'OR',
            [
                'key'           => '_sale_price',
                'value'         => 0,
                'compare'       => '>',
                'type'          => 'numeric'
            ],
            [
                'key'           => '_min_variation_sale_price',
                'value'         => 0,
                'compare'       => '>',
                'type'          => 'numeric'
            ]
        ];
    }

    if ( $price_filter && !( $min_price == 0 ) && !( $min_price == 0 ) ) {
    
        if ( !( $min_price == 0 ) ) {
            
            $meta_query[] = array(
                'key'     => '_price',
                'value'   => $min_price,
                'compare' => '>=',
                'type'    => 'NUMERIC',
            );

        }
        
        if ( !( $max_price == 0 ) ) {
            
            $meta_query[] = array(
                'key'     => '_price',
                'value'   => $max_price,
                'compare' => '<=',
                'type'    => 'NUMERIC',
            );

        }


    }

    if ( $orderby == 'price' ) {
        $query->set( 'meta_key', '_price' );
        $orderby = 'meta_value_num';
    }

    if ( !($orderby == 'menu_order') ) {
        $query->set( 'order', $ordering );
    }

    $query->set( 'orderby', $orderby );

    $query->set( 'layout', $layout );
    $query->set( 'posts_per_page', $product_per_page );
    $query->set( 'meta_query', $meta_query );

}
add_action( 'pre_get_posts', '\MakaiExtensions\PreGetPosts\custom_woocommerce_products_per_page' , 999 );