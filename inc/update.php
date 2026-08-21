<?php




namespace MakaiExtensions\Update;



defined('ABSPATH') or die('No script kiddies please!');



define( 'UPDATE_GITHUB_USER' , 'henc1983' );
define( 'UPDATE_GITHUB_REPO' , 'makai-extension-for-oxygen' );
define( 'UPDATE_GITHUB_TOKEN' , '' );



add_filter( 'pre_set_site_transient_update_plugins', '\MakaiExtensions\Update\update');




function update( $transient ) {
    if ( empty( $transient->checked ) ) {
        return $transient;
    }

    
    $plugin_slug     = UPDATE_GITHUB_REPO . '/makai-extension.php';
    $github_user     = UPDATE_GITHUB_USER;
    $github_repo     = UPDATE_GITHUB_REPO;
    

    
    $api_url = "https://api.github.com/repos/{$github_user}/{$github_repo}/releases/latest";
    
    $args = array(
        'timeout'    => 10,
        'headers'    => array(
            'Accept'     => 'application/vnd.github.v3+json',
            'User-Agent' => 'WordPress-Plugin-Update-Checker'
        )
    );

    $response = wp_remote_get( $api_url, $args );

    
    if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
        return $transient;
    }

    $release_data = json_decode( wp_remote_retrieve_body( $response ) );

    if ( ! empty( $release_data ) ) {
        
        $remote_version = ltrim( $release_data->tag_name, 'v' );
        $download_url   = $release_data->zipball_url; // A GitHub által generált forráskód ZIP linkje

        
        if ( version_compare( MEX_VERSION, $remote_version, '<' ) ) {
            $res = (object) [];
            $res->slug        = dirname( $plugin_slug );
            $res->plugin      = $plugin_slug;
            $res->new_version = $remote_version;
            $res->url         = $release_data->html_url;
            $res->package     = $download_url;

            
            $transient->response[ $plugin_slug ] = $res;
        }
    }

    return $transient;
}



add_filter( 'upgrader_source_selection', '\MakaiExtensions\Update\github_plugin_fix_folder_name', 10, 4 );

function github_plugin_fix_folder_name( $source, $remote_source, $upgrader, $hook_extra ) {
    
    if ( ! isset( $hook_extra['plugin'] ) ) {
        return $source;
    }

    
    $correct_folder_name = UPDATE_GITHUB_REPO; 

    
    if ( dirname( $hook_extra['plugin'] ) === $correct_folder_name ) {
        $source_path = trailingslashit( $source );
        $new_source_path = trailingslashit( $remote_source ) . $correct_folder_name;

        
        if ( basename( $source ) !== $correct_folder_name ) {
            if ( rename( $source, $new_source_path ) ) {
                return trailingslashit( $new_source_path );
            }
        }
    }

    return $source;
}
