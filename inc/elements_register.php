<?php



namespace MakaiExtensions\ElementsRegister;



defined('ABSPATH') or die('No script kiddies please!');



use function Breakdance\Util\getDirectoryPathRelativeToPluginFolder as getDirPath;
use function Breakdance\ElementStudio\registerSaveLocation;


add_action( 'breakdance_loaded', '\MakaiExtensions\ElementsRegister\elements_registering', 9 );




function elements_registering() {
    
    registerSaveLocation(
        getDirPath( MEX_PLUGIN_DIR ) . '/oxygen_builder/elements',
        'MakaiExtensions',
        'element',
        "Makai's Extensions for Oxygen 6",
        false
    );

    registerSaveLocation(
        getDirPath( MEX_PLUGIN_DIR ) . '/oxygen_builder/macros',
        'MakaiExtensions',
        'macro',
        "Makai's Extensions for Oxygen 6",
        false
    );

    registerSaveLocation(
        getDirPath( MEX_PLUGIN_DIR ) . '/oxygen_builder/presets',
        'MakaiExtensions',
        'preset',
        "Makai's Extensions for Oxygen 6",
        false
    );
}