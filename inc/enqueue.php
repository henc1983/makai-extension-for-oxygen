<?php


namespace MakaiExtensions\Enqueue;



add_action( 'wp_enqueue_scripts' , '\MakaiExtensions\Enqueue\wp_enqueue_scripts' );
add_action( 'wp_enqueue_scripts' , '\MakaiExtensions\Enqueue\wp_enqueue_styles' );



function wp_enqueue_scripts() {

    $script_dir = '/assets/scripts';
    
    foreach ( glob( MEX_PLUGIN_DIR . "$script_dir/*.js") as $file ) {
        
        $key = basename( $file, '.js' );
        $script = basename( $file );


        wp_register_script( "mex-{$key}-script" , MEX_PLUGIN_URI . "$script_dir/$script" , ['jquery'] , WP_DEBUG ? filemtime( MEX_PLUGIN_DIR . "$script_dir/$script" ) : MEX_FOR_OXYGEN_VERSION, true );
        
    }

    wp_enqueue_script( 'mex-main-script' );

}



function wp_enqueue_styles() {

    $style_dir = '/assets/styles';
    
    foreach ( glob( MEX_PLUGIN_DIR . "$style_dir/*.css") as $file ) {
        
        $key = basename( $file, '.css' );
        $style = basename( $file );


        wp_register_style( "mex-{$key}-style" , MEX_PLUGIN_URI . "$style_dir/$style" , [] , WP_DEBUG ? filemtime( MEX_PLUGIN_DIR . "$style_dir/$style" ) : MEX_FOR_OXYGEN_VERSION );
        
    }

    wp_enqueue_style( 'mex-main-style' );
    wp_enqueue_style( 'mex-font-awesome-style' );
}