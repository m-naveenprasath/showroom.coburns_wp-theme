<?php

namespace Flynt\Components\SiteFooter;

use Timber;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_action('init', function () {
    register_nav_menus([
        'nav_footer_1' => __('Footer Menu: Column 1', 'flynt'),
        'nav_footer_2' => __('Footer Menu: Column 2', 'flynt'),
        'nav_footer_3' => __('Footer Menu: Column 3', 'flynt'),
        'nav_footer_3_bottom' => __('Footer Menu: Column 3 Bottom', 'flynt'),
        'nav_family_sites' => __('Footer Menu: Family Sites', 'flynt'),
    ]);
});

add_filter('Flynt/addComponentData?name=SiteFooter', function ($data) {
    if (has_nav_menu('nav_footer_1')) {
        $data['nav_footer_1'] = new Timber\Menu('nav_footer_1');
    }
    if (has_nav_menu('nav_footer_2')) {
        $data['nav_footer_2'] = new Timber\Menu('nav_footer_2');
    }
    if (has_nav_menu('nav_footer_3')) {
        $data['nav_footer_3'] = new Timber\Menu('nav_footer_3');
    }
    if (has_nav_menu('nav_footer_3_bottom')) {
        $data['nav_footer_3_bottom'] = new Timber\Menu('nav_footer_3_bottom');

        if ($nav_footer_3_bottom_title = get_field('nav_title', 'menu_' . $data['nav_footer_3_bottom']->id)) {
            $data['nav_footer_3_bottom_title'] = $nav_footer_3_bottom_title;
        } else {
            $data['nav_footer_3_bottom_title'] = 'Resources';
            //Remove this fallback once the nav_title custom field is filled in on prod
        }
    }
    if (has_nav_menu('nav_family_sites')) {
        $data['nav_family_sites'] = new Timber\Menu('nav_family_sites');
    }

    $data['corporate'] = [];
    if ($contactInfo = Options::getGlobal('CorporateAddress')) {
        $data['corporate'] = array_merge($data['corporate'], $contactInfo);
    }

    if ($socialAccounts = Options::getGlobal('CorporateSocialMediaAccounts')) {
        $data = array_merge($data, $socialAccounts);
    }

    if ($copyright = Options::getTranslatable('CopyrightText')) {
        $data = array_merge($data, $copyright);
    }
    return $data;
});

Options::addGlobal('CorporateAddress', [
    [
        'name' => 'name',
        'label' => 'Name',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => 'Uses Wordpress site name if left blank.',
    ],
    [
        'name' => 'link',
        'label' => 'Site Link',
        'type' => 'group',
        'collapsed' => 'text',
        'layout' => 'table',
        'sub_fields' => [FieldVariables\getButtonParts()],
    ],
    [
        'name' => 'address',
        'label' => 'Address',
        'type' => 'google_map',
    ],
    [
        'name' => 'address_suite',
        'label' => 'Address Suite #',
        'type' => 'text',
        'default_value' => 'Suite 850',
    ],
]);

Options::addGlobal('CorporateSocialMediaAccounts', [
    [
        'label' => '',
        'name' => 'socialCorporate',
        'type' => 'repeater',
        'layout' => 'table',
        'sub_fields' => fieldVariables\getSocialMediaAccounts(),
        'button_label' => 'Add Account',
    ],
]);

Options::addTranslatable('CopyrightText', [
    [
        'label' => 'Copyright',
        'name' => 'copyright',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Label',
                'name' => 'label',
                'type' => 'text',
                'placeholder' => '&copy;',
                'default_value' => '&copy;',
            ],
            [
                'label' => 'Company',
                'name' => 'company_name',
                'type' => 'text',
                'placeholder' => 'Uses Wordpress site name if left blank.',
            ],
            [
                'label' => 'Text',
                'name' => 'text',
                'type' => 'text',
                'default_value' => 'All Rights Reserved.',
            ],
        ],
    ],
]);
