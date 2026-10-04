<?php



namespace MakaiExtensions\Requests;

defined('ABSPATH') or die('No script kiddies please!');




// Listing function names in array
$my_requests = [ 'media_query' , 'layout' ];




// Creating foreach loop to call and handle functions by action hook
foreach ( $my_requests as $request ) {
    add_action( 'init' , "\MakaiExtensions\Requests\\$request" );
}




function media_query() {
    
    // return if not exists in POST method key 
    if ( ! isset( $_POST[ 'mex-screen-size' ] ) ) {
        return;
    }

    // store value in a session
    $_SESSION['mex_screen_size'] = $_POST[ 'mex-screen-size' ];
    $GLOBALS['mex_screen_size'] = $_POST['mex-screen-size'];
    
    // remove POST method key
    unset( $_POST[ 'mex-screen-size' ] );
}




function layout() {
    if ( ! isset( $_POST[ 'mex-layout' ] ) ) {
        return;
    }
    
    $_SESSION['mex_layout'] = $_POST[ 'mex-layout' ];
    $GLOBALS['mex_layout'] = $_POST['mex-layout'];
    unset( $_POST[ 'mex-layout' ] );

    // \MakaiExtensions\Functions\reload_page();
    // if ( is_admin() || ( !is_shop() && !is_product_category() && !is_product_tag() ) ) {
    //     return;
    // }

    // if ( isset( $_POST[ 'mex-products-per-page' ] ) ) {
    //     $_SESSION['mex_products_per_page'] = $_POST[ 'mex-products-per-page' ];
    //     $GLOBALS['mex_products_per_page'] = $_POST['mex-products-per-page'];
    //     unset( $_POST[ 'mex-products-per-page' ] );
    // }

    // if ( isset( $_POST[ 'mex-onsale' ] ) ) {
    //     $_SESSION['mex_onsale'] = $_POST[ 'mex-onsale' ];
    //     $GLOBALS['mex_onsale'] = $_POST['mex-onsale'];
    //     unset( $_POST[ 'mex-onsale' ] );
    // }

    // if ( isset( $_POST[ 'mex-orderby' ] ) ) {
    //     $_SESSION['mex_orderby'] = $_POST[ 'mex-orderby' ];
    //     $GLOBALS['mex_orderby'] = $_POST['mex-orderby'];
    //     unset( $_POST[ 'mex-orderby' ] );
    // }
    
    // if ( isset( $_POST[ 'mex-price-filter' ] ) ) {
    //     $_SESSION['mex_price_filter'] = $_POST[ 'mex-price-filter' ];
    //     $GLOBALS['mex_price_filter'] = $_POST['mex-price-filter'];
    //     unset( $_POST[ 'mex-price-filter' ] );
    // }
    
    // if ( isset( $_POST[ 'mex-minprice' ] ) ) {
    //     $_SESSION['mex_minprice'] = $_POST[ 'mex-minprice' ];
    //     $GLOBALS['mex_minprice'] = $_POST['mex-minprice'];
    //     unset( $_POST[ 'mex-minprice' ] );
    // }
    
    // if ( isset( $_POST[ 'mex-maxprice' ] ) ) {
    //     $_SESSION['mex_maxprice'] = $_POST[ 'mex-maxprice' ];
    //     $GLOBALS['mex_maxprice'] = $_POST['mex-maxprice'];
    //     unset( $_POST[ 'mex-maxprice' ] );
    // }
    
    // if ( isset( $_POST[ 'mex-categories' ] ) ) {
    //     $_SESSION['mex_categories'] = $_POST[ 'mex-categories' ];
    //     $GLOBALS['mex_categories'] = $_POST['mex-categories'];
    //     unset( $_POST[ 'mex-categories' ] );
    // }

}