<?php



namespace MakaiExtensions\Ajax;




$my_ajax_requests = [ 'ajax_searchbar', 'withrawal' ];





foreach ( $my_ajax_requests as $ajax ) {
    add_action( "wp_ajax_{$ajax}", "\MakaiExtensions\Ajax\\$ajax" );
    add_action( "wp_ajax_nopriv_{$ajax}", "\MakaiExtensions\Ajax\\$ajax" );
}




function ajax_searchbar() {

    $search_term = isset( $_POST['s'] ) ? sanitize_text_field( $_POST['s'] ) : '';

    if ( empty( $search_term ) ) {
        wp_send_json_success( ['response' => []] );
    }

    $args = [
        'status'     => 'publish',
        'limit'      => -1,
        's'          => $search_term,
    ];

    $products = wc_get_products( $args );

    $results = [];

    foreach ( $products as $product ) {
        $results[] = array(
            'id'    => $product->get_id(),
            'title' => $product->get_title(),
            'url'   => $product->get_permalink(),
            'price' => $product->get_price_html(),
            'qty'   => $product->get_stock_quantity(),
            'image' => wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' ),
        );
    }

    wp_send_json_success([ 'response' => $results ]);
    exit();
}





function withrawal() {

    $last_name = isset( $_POST['last_name'] ) ? sanitize_text_field( $_POST['last_name'] ) : '';
    $first_name = isset( $_POST['first_name'] ) ? sanitize_text_field( $_POST['first_name'] ) : '';
    $order_number = isset( $_POST['order_number'] ) ? sanitize_text_field( $_POST['order_number'] ) : '';
    $return_scope = isset( $_POST['return_scope'] ) ? sanitize_text_field( $_POST['return_scope'] ) : '';
    $products = isset( $_POST['products'] ) ? sanitize_text_field( $_POST['products'] ) : '';
    

    $admin_email = get_option('admin_email');
    $subject     = sprintf( __( 'Oops!, %s - order cancelled by customer!' , 'makai' ) , $order_number );
    $message     = '';
    $headers     = array( 'Content-Type: text/html; charset=UTF-8' );

    $response_message_title = __( "We're sorry it turned out this way!" , 'makai' );
    $response_message_message = ( $return_scope === 'partial' ) ? sprintf( __( 'We will be removing some products from your order %s.' , 'makai' ) , $order_number ) : sprintf( __( 'Your order %s will be cancelled soon.' , 'makai' ) , $order_number );

    
    
    
    $email_sent = wp_mail($admin_email, $subject, $message, $headers);
    
    wp_send_json_success([ 'response' => 'ok', 'email_sent' => $email_sent, 'message' => [ 'title' => $response_message_title , 'message' => $response_message_message ] ] );
    
    exit();
}