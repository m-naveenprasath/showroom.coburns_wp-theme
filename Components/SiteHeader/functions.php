<?php

namespace Flynt\Components\SiteHeader;

use Timber;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_action('init', function () {
    register_nav_menus([
        'nav_header_primary' => __('Header Menu: Primary', 'flynt'),
        'nav_header_utility' => __('Header Menu: Utility', 'flynt'),
        'nav_header_mega' => __('Header Menu: Mega', 'flynt'),
        'nav_header_ecommerce' => __('Header Menu: Ecommerce', 'flynt'),
        'nav_header_mobile' => __('Header Menu: Mobile', 'flynt'),
    ]);
});

add_action('wp_enqueue_scripts', function () {
    $options = Options::getGlobal('SiteHeader');
    if ($options['EcommerceNav_show'] == false) {
        return false;
    }

    $componentNamespace = explode('\\', __NAMESPACE__);
    $componentName = array_pop($componentNamespace);

    $js_path = 'https://minicart.coburns.com/dist/wp/AcCart.umd.min.js';
    wp_register_script('minicart', $js_path, ['vue'], [], true);

    $js_path = '/Components/' . $componentName . '/script.js';
    wp_register_script(
        $componentName,
        get_stylesheet_directory_uri() . $js_path,
        ['minicart'],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

add_filter(
    'Flynt/renderComponent',
    function ($output, $componentName) {
        wp_enqueue_script($componentName);

        return $output;
    },
    10,
    3
);

Options::addGlobal('SiteHeader', [
    [
        'label' => 'Ecommerce Utility Nav',
        'name' => 'EcommerceNav_show',
        'type' => 'true_false',
        'default_value' => true,
        'ui' => 1,
        'ui_on_text' => 'Show',
        'ui_off_text' => 'Hide',
    ],
    [
        'label' => 'Ecommerce Login Link',
        'name' => 'ecommerce_login_link',
        'type' => 'url',
    ],
    [
        'label' => 'Search Field',
        'name' => 'HeaderSearch_show',
        'type' => 'true_false',
        'default_value' => true,
        'ui' => 1,
        'ui_on_text' => 'Show',
        'ui_off_text' => 'Hide',
    ],
]);

add_filter('Flynt/addComponentData?name=SiteHeader', function ($data) {
    if (has_nav_menu('nav_header_primary')) {
        $data['nav_primary'] = new Timber\Menu('nav_header_primary');
    }
    if (has_nav_menu('nav_header_utility')) {
        $data['nav_utility'] = new Timber\Menu('nav_header_utility');
    }
    if (has_nav_menu('nav_header_mega')) {
        $data['nav_mega'] = new Timber\Menu('nav_header_mega');
    }
    if (has_nav_menu('nav_header_ecommerce')) {
        $data['nav_ecommerce'] = new Timber\Menu('nav_header_ecommerce');
    }
    if (has_nav_menu('nav_header_mobile')) {
        $data['nav_mobile'] = new Timber\Menu('nav_header_mobile');
    }

    //
    if ($options = Options::getGlobal('SiteHeader')) {
        $data = array_merge($data, $options);
    }
    if ($labels = Options::getTranslatable('SiteHeader')) {
        $data = array_merge($data, $labels);
    }
    if ($labels = Options::getTranslatable('SiteSearchField')) {
        $data = array_merge($data, $labels);
    }
    if ($labels = Options::getTranslatable('MobileNav')) {
        $data = array_merge($data, $labels);
    }

    return $data;
});
