<?php 


add_action( 'breakdance_reusable_dependencies_urls', function ($urls) {
    
    $urls['mexsearchbar'] = MEX_PLUGIN_URI . '/assets/scripts/components/searchbar.js';
    $urls['mexdropdown'] = MEX_PLUGIN_URI . '/assets/scripts/components/dropdown.js';
    $urls['mexwithrawal'] = MEX_PLUGIN_URI . '/assets/scripts/components/withrawal.js';
    $urls['mexsubscription'] = MEX_PLUGIN_URI . '/assets/scripts/components/subscribe.js';
    $urls['mexordering'] = MEX_PLUGIN_URI . '/assets/scripts/components/ordering.js';
    
    $urls['mexfontawesomecss'] = MEX_PLUGIN_URI . '/assets/styles/font-awesome.css';
    $urls['mexformscss'] = MEX_PLUGIN_URI . '/assets/styles/components/forms.css';
    
    return $urls;
});