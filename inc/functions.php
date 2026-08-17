<?php


namespace MakaiExtensions\Functions;



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