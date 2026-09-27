<?php


namespace MakaiExtensions\Init;

use function MakaiExtensions\Functions\get_min_price as get_minprice;
use function MakaiExtensions\Functions\get_max_price as get_maxprice;



add_action( 'init' , '\MakaiExtensions\Init\init', 1 );
add_action( 'init' , '\MakaiExtensions\Init\init_shop', 2 );




function init() {

    // Start session if not exists
    if ( session_status() === PHP_SESSION_NONE ) {
        session_start();
    }

    if ( !isset( $_SESSION['mex_screen_size'] ) ) { 
        $_SESSION['mex_screen_size'] = 'desktop';
    }
}




function init_shop() {


    if ( session_status() === PHP_SESSION_NONE ) {
        session_start();
    }

    if ( !isset( $_SESSION['mex_products_per_page'] ) ) { 
        $_SESSION['mex_products_per_page'] = 12;
    }
    
    if ( !isset( $_SESSION['mex_orderby'] ) ) { 
        $_SESSION['mex_orderby'] = 'menu_order';
    }
    
    if ( !isset( $_SESSION['mex_ordering'] ) ) { 
        $_SESSION['mex_ordering'] = 'DESC';
    }
    
    if ( !isset( $_SESSION['mex_categories'] ) ) { 
        $_SESSION['mex_categories'] = [];
    }
    
    if ( !isset( $_SESSION['mex_on_sale'] ) ) { 
        $_SESSION['mex_on_sale'] = false;
    }
    
    if ( !isset( $_SESSION['mex_price_filter'] ) ) { 
        $_SESSION['mex_price_filter'] = true;
    }
    
    if ( !isset( $_SESSION['mex_minprice'] ) ) { 
        $_SESSION['mex_minprice'] = 0;
    }
    
    if ( !isset( $_SESSION['mex_maxprice'] ) ) { 
        $_SESSION['mex_maxprice'] = 0;
    }
}