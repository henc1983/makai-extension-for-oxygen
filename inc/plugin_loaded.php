<?php


namespace MakaiExtensions\PluginLoaded;



add_action( 'plugins_loaded' , '\MakaiExtensions\PluginLoaded\plugin_loaded' , 20 );





function plugin_loaded() {
    $GLOBALS['mex_screen_size'] = $_SESSION['mex_screen_size'] ?? 'desktop';
    
    $GLOBALS['mex_products_per_page'] = $_SESSION['mex_products_per_page'] ?? 12;
    $GLOBALS['mex_onsale'] = $_SESSION['mex_onsale'] ?? false;
    $GLOBALS['mex_layout'] = $_SESSION['mex_layout'] ?? 'grid';
    $GLOBALS['mex_orderby'] = $_SESSION['mex_orderby'] ?? 'menu_order';
    $GLOBALS['mex_price_filter'] = $_SESSION['mex_price_filter'] ?? false;
    $GLOBALS['mex_minprice'] = $_SESSION['mex_minprice'] ?? 0;
    $GLOBALS['mex_maxprice'] = $_SESSION['mex_maxprice'] ?? 0;
    $GLOBALS['mex_categories'] = $_SESSION['mex_categories'] ?? [];
}