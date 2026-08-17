<?php 




add_action( 'breakdance_reusable_dependencies_urls', function ($urls) {
    
    $urls['mexsearchbar'] = MEX_PLUGIN_URI . '/assets/scripts/components/searchbar.js';
    $urls['mexdropdown'] = MEX_PLUGIN_URI . '/assets/scripts/components/dropdown.js';
    $urls['mexwithrawal'] = MEX_PLUGIN_URI . '/assets/scripts/components/withrawal.js';
    
    return $urls;
});