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

    // 1. BEÁLLÍTÁSOK (Módosítsd a saját adataidra)
    $plugin_slug     = 'makai-extensions-for-oxygen/makai-extension.php'; // Bővítmény fő fájlja
    $github_user     = UPDATE_GITHUB_USER;          // GitHub felhasználóneved
    $github_repo     = UPDATE_GITHUB_REPO;                         // GitHub repó neve
    
    // Lekérjük a jelenleg telepített verziót
    $current_version = $transient->checked[ $plugin_slug ] ?? MEX_VERSION;

    // 2. GitHub API hívás a legfrissebb Release adataiért
    $api_url = "https://api.github.com/repos/{$github_user}/{$github_repo}/releases/latest";
    
    $args = array(
        'timeout'    => 10,
        'headers'    => array(
            'Accept'     => 'application/vnd.github.v3+json',
            'User-Agent' => 'WordPress-Plugin-Update-Checker' // A GitHub API megköveteli a User-Agent fejlécet
        )
    );

    $response = wp_remote_get( $api_url, $args );

    // Ha hiba történt a lekérés során, visszatérünk az eredeti adattal
    if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
        return $transient;
    }

    $release_data = json_decode( wp_remote_retrieve_body( $response ) );

    if ( ! empty( $release_data ) ) {
        // Megtisztítjuk a verziószámot (pl. "v2.0.0" -> "2.0.0")
        $remote_version = ltrim( $release_data->tag_name, 'v' );
        $download_url   = $release_data->zipball_url; // A GitHub által generált forráskód ZIP linkje

        // 3. Verziók összehasonlítása
        if ( version_compare( $current_version, $remote_version, '<' ) ) {
            $res = new stdClass();
            $res->slug        = dirname( $plugin_slug );
            $res->plugin      = $plugin_slug;
            $res->new_version = $remote_version;
            $res->url         = $release_data->html_url; // A GitHub Release weboldala
            $res->package     = $download_url;            // A letöltési link

            // Injektáljuk a frissítést a WordPress felületére
            $transient->response[ $plugin_slug ] = $res;
        }
    }

    return $transient;
}