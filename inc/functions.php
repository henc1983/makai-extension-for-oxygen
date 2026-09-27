<?php


namespace MakaiExtensions\Functions;




defined('ABSPATH') or die('No script kiddies please!');




// Check Oxygen Builder Plugin is installed
function is_oxygen_active() {
    return defined('__BREAKDANCE_PLUGIN_FILE__') && defined('BREAKDANCE_MODE') && BREAKDANCE_MODE === 'oxygen'; 
}



// This instantly can reload the page
function reload_page() {
    print('<script type="text/javascript">window.top.location="'.$_SERVER['REQUEST_URI'].'";</script>');
    exit;
}



// Drop all trash from html code - good compress for inline js or css codes
function compress_html( $code ) {
    $search = [

    // Remove whitespaces after tags
    '/\>[^\S ]+/s',
    
    // Remove whitespaces before tags
    '/[^\S ]+\</s',
    
    // Remove multiple whitespace sequences
    '/(\s)+/s',
    
    // Removes comments
    '/<!--(.|\s)*?-->/'

    ];
    $replace = array('>', '<', '\\1');
    $code = preg_replace( $search, $replace, $code );
    return $code;
}





function get_min_price() {
    global $wpdb;

    $min_price = $wpdb->get_var( "
        SELECT MIN( CAST( meta_value AS DECIMAL(10,2) ) ) 
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE pm.meta_key = '_price' 
        AND p.post_status = 'publish' 
        AND p.post_type IN ('product', 'product_variation')
        AND pm.meta_value > 0
    " );

    return $min_price;
}





function get_max_price() {
    global $wpdb;

    $max_price = $wpdb->get_var( "
        SELECT MAX( CAST( meta_value AS DECIMAL(10,2) ) ) 
        FROM {$wpdb->postmeta} pm
        INNER JOIN {$wpdb->posts} p ON pm.post_id = p.ID
        WHERE pm.meta_key = '_price' 
        AND p.post_status = 'publish' 
        AND p.post_type IN ('product', 'product_variation')
    " );

    return $max_price;
}





function get_euro_price() {
    // 1. Megnézzük, hogy el van-e mentve az árfolyam a WordPress-ben (Transients)
    $eur_rate = get_transient( 'current_eur_to_huf' );

    // Ha nincs elmentve (vagy lejárt a 12 óra), lekérjük az API-tól
    if ( false === $eur_rate ) {
        
        // Egy teljesen ingyenes, regisztrációt és API kulcsot NEM igénylő európai API (Frankfurter.dev)
        $api_url = 'https://api.frankfurter.dev/v2/rate/eur/huf';
        
        // WordPress beépített HTTP lekérdező funkciója
        $response = wp_remote_get( $api_url );

        if ( is_wp_error( $response ) ) {
            return 'Hiba az árfolyam lekérésekor.';
        }

        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        // Ha sikeres a válasz és megvannak az adatok
        if ( isset( $data['rate'] ) ) {
            $eur_rate = $data['rate'];

            // Eltároljuk az adatbázisban 12 órára (43200 másodperc), hogy ne terheljük az oldalt
            set_transient( 'current_eur_to_huf', $eur_rate, 12 * HOUR_IN_SECONDS );
        } 
    }

    return $eur_rate;
}