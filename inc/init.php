<?php


namespace MakaiExtensions\Init;




add_action( 'init' , '\MakaiExtensions\Init\init' );




function init() {

    // Start session if not exists
    if ( session_status() === PHP_SESSION_NONE ) {
        session_start();
    }



    // Set MediaQuery Helper session to default is not exists
    if ( !isset( $_SESSION['mex_screen_size'] ) ) { 
        $_SESSION['mex_screen_size'] = 'desktop';
    }

}