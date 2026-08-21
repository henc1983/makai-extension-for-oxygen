<?php



namespace MakaiExtensions\Requests;




defined('ABSPATH') or die('No script kiddies please!');




// Listing function names in array
$my_requests = [ 'media_query_helper' ];




// Creating foreach loop to call and handle functions by action hook
foreach ( $my_requests as $request ) {
    add_action( 'init' , "\MakaiExtensions\Requests\\$request" );
}



// Listening media query request
function media_query_helper() {
    
    // return if not exists in POST method key 
    if ( ! isset( $_POST[ 'mex-screen-size' ] ) ) {
        return;
    }

    // store value in a session
    $_SESSION['mex_screen_size'] = $_POST[ 'mex-screen-size' ];

    // remove POST method key
    unset( $_POST[ 'mex-screen-size' ] );

    // reload the page instantly
    \MakaiExtensions\Functions\reload_page();
}