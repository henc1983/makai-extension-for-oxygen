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
    $email = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
    $return_scope = isset( $_POST['return_scope'] ) ? sanitize_text_field( $_POST['return_scope'] ) : '';
    $products = isset( $_POST['products'] ) ? sanitize_text_field( $_POST['products'] ) : '';
    
    wp_send_json_success([ 'response' => 'ok', 'email_sent' => true ]);
    exit();
}