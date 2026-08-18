<?php

namespace MakaiExtensions;

use function Breakdance\Elements\c;
use function Breakdance\Elements\PresetSections\getPresetSection;


\Breakdance\ElementStudio\registerElementForEditing(
    "MakaiExtensions\\Withrawalform",
    \Breakdance\Util\getdirectoryPathRelativeToPluginFolder(__DIR__)
);

class Withrawalform extends \Breakdance\Elements\Element
{
    static function uiIcon()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="24px" fill="currentColor"><path d="M480-40q-112 0-206-51T120-227v107H40v-240h240v80h-99q48 72 126.5 116T480-120q75 0 140.5-28.5t114-77q48.5-48.5 77-114T840-480h80q0 91-34.5 171T791-169q-60 60-140 94.5T480-40Zm-36-160v-52q-47-11-76.5-40.5T324-370l66-26q12 41 37.5 61.5T486-314q33 0 56.5-15.5T566-378q0-29-24.5-47T454-466q-59-21-86.5-50T340-592q0-41 28.5-74.5T446-710v-50h70v50q36 3 65.5 29t40.5 61l-64 26q-8-23-26-38.5T482-648q-35 0-53.5 15T410-592q0 26 23 41t83 35q72 26 96 61t24 77q0 29-10 51t-26.5 37.5Q583-274 561-264.5T514-250v50h-70ZM40-480q0-91 34.5-171T169-791q60-60 140-94.5T480-920q112 0 206 51t154 136v-107h80v240H680v-80h99q-48-72-126.5-116T480-840q-75 0-140.5 28.5t-114 77q-48.5 48.5-77 114T120-480H40Z"/></svg>';
    }

    static function tag()
    {
        return 'section';
    }

    static function tagOptions()
    {
        return [];
    }

    static function tagControlPath()
    {
        return false;
    }

    static function name()
    {
        return 'WithrawalForm';
    }

    static function className()
    {
        return 'mex-withrawal';
    }

    static function category()
    {
        return 'other';
    }

    static function badge()
    {
        return false;
    }

    static function slug()
    {
        return __CLASS__;
    }

    static function template()
    {
        return file_get_contents(__DIR__ . '/html.twig');
    }

    static function defaultCss()
    {
        return file_get_contents(__DIR__ . '/default.css');
    }

    static function defaultProperties()
    {
        return false;
    }

    static function defaultChildren()
    {
        return false;
    }

    static function cssTemplate()
    {
        $template = file_get_contents(__DIR__ . '/css.twig');
        return $template;
    }

    static function designControls()
    {
        return [];
    }

    static function contentControls()
    {
        return [];
    }

    static function settingsControls()
    {
        return [];
    }

    static function dependencies()
    {
        return ['0' =>  ['scripts' => ['%%BREAKDANCE_REUSABLE_MEXWITHRAWAL%%'],'inlineScripts' => ['document.querySelectorAll(\'input[name="return-scope"]\').forEach((radio) => {
  radio.addEventListener(\'change\', (e) => {
    const productsWrapper = document.getElementById(\'products-wrapper\');
    const productsInput = document.getElementById(\'products\');
    
    // Háttérszín osztályok frissítése a gombokon
    document.querySelectorAll(\'.radio-btn\').forEach(btn => {
      btn.classList.remove(\'checked\');
      btn.querySelector(\'.far\').classList.remove(\'fa-circle-check\');
      btn.querySelector(\'.far\').classList.add(\'fa-circle-xmark\');
    });
    const newBtn = e.target.closest(\'.radio-btn\')
    newBtn.classList.add(\'checked\');
    newBtn.querySelector(\'.far\').classList.remove(\'fa-circle-xmark\');
    newBtn.querySelector(\'.far\').classList.add(\'fa-circle-check\');

    // Termék mező mutatása/rejtése
    if (e.target.id === \'trigger-products\') {
      productsWrapper.classList.remove(\'hidden\');
      productsInput.setAttribute(\'required\', \'required\');
    } else {
      productsWrapper.classList.add(\'hidden\');
      productsInput.removeAttribute(\'required\');
      productsInput.value = \'\';
    }
  });
});

// Alapértelmezett állapot beállítása betöltéskor
document.addEventListener("DOMContentLoaded", () => {
  const triggerProducts = document.getElementById(\'trigger-products\');
  if(!triggerProducts.checked) {
    document.getElementById(\'products-wrapper\').classList.add(\'hidden\');
  }
});
'],'styles' => ['%%BREAKDANCE_REUSABLE_MEXFORMSCSS%%'],],];
    }

    static function settings()
    {
        return false;
    }

    static function addPanelRules()
    {
        return false;
    }

    static public function actions()
    {
        return false;
    }

    static function nestingRule()
    {
        return ['type' => 'final'];
    }

    static function spacingBars()
    {
        return false;
    }

    static function attributes()
    {
        return false;
    }

    static function experimental()
    {
        return false;
    }

    static function availableIn()
    {
        return ['oxygen'];
    }


    static function order()
    {
        return 0;
    }

    static function dynamicPropertyPaths()
    {
        return false;
    }

    static function additionalClasses()
    {
        return false;
    }

    static function projectManagement()
    {
        return false;
    }

    static function propertyPathsToWhitelistInFlatProps()
    {
        return false;
    }

    static function propertyPathsToSsrElementWhenValueChanges()
    {
        return false;
    }
}
