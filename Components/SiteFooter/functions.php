<?php

namespace Flynt\Components\SiteFooter;

use Timber;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

// Display order. "Find a Location" is rendered just before FOOTER_LOCATIONS_BEFORE, so Resources comes last.
const FOOTER_LOCATIONS_BEFORE = 'nav_footer_2';
const FOOTER_COLUMNS = [
    'nav_footer_1' => 'Menu',
    'nav_footer_3' => 'Get Inspired',
    'nav_footer_2' => 'Resources',
];

const FOOTER_LOCATIONS_LIMIT = 5;

add_action('init', function () {
    register_nav_menus([
        'nav_footer_1' => __('Footer Menu: Column 1', 'flynt'),
        'nav_footer_2' => __('Footer Menu: Column 2', 'flynt'),
        'nav_footer_3' => __('Footer Menu: Column 3', 'flynt'),
        'nav_footer_locations' => __('Footer Menu: Find a Location', 'flynt'),
    ]);
});

/**
 * Title for a footer column: the menu's "Menu Title" field, falling back to the design default.
 */
function getMenuTitle($menu, $fallback)
{
    $title = $menu ? get_field('nav_title', 'menu_' . $menu->id) : '';
    return $title ?: $fallback;
}

add_filter('Flynt/addComponentData?name=SiteFooter', function ($data) {
    $data['footer_columns'] = [];
    foreach (FOOTER_COLUMNS as $location => $fallbackTitle) {
        if (!has_nav_menu($location)) {
            continue;
        }
        $menu = new Timber\Menu($location);
        $data['footer_columns'][] = [
            'title' => getMenuTitle($menu, $fallbackTitle),
            'menu' => $menu,
            'locations_before' => $location === FOOTER_LOCATIONS_BEFORE,
        ];
    }

    // Find a Location: curated menu if assigned, otherwise the first few Location posts.
    $locations = Options::getGlobal('FooterLocations') ?: [];
    $data['footer_locations'] = [
        'title' => 'Find a Location',
        'items' => [],
        'view_all' => $locations['view_all_link'] ?? null,
    ];
    if (has_nav_menu('nav_footer_locations')) {
        $menu = new Timber\Menu('nav_footer_locations');
        $data['footer_locations']['title'] = getMenuTitle($menu, 'Find a Location');
        foreach ($menu->items as $item) {
            $data['footer_locations']['items'][] = [
                'title' => $item->title,
                'link' => $item->link,
            ];
        }
    } else {
        $posts = Timber::get_posts([
            'post_type' => 'locations',
            'posts_per_page' => FOOTER_LOCATIONS_LIMIT,
            'orderby' => ['menu_order' => 'ASC', 'title' => 'ASC'],
        ]);
        foreach ($posts as $post) {
            // "Beaumont, Texas" -> "Beaumont"
            $data['footer_locations']['items'][] = [
                'title' => trim(explode(',', $post->title)[0]),
                'link' => $post->link,
            ];
        }
    }
    if (empty($data['footer_locations']['view_all']['url']) && ($page = get_page_by_path('locations'))) {
        $data['footer_locations']['view_all'] = [
            'url' => get_permalink($page),
            'title' => '',
            'target' => '',
        ];
    }

    $data['corporate'] = [];
    if ($contactInfo = Options::getGlobal('CorporateAddress')) {
        $data['corporate'] = array_merge($data['corporate'], $contactInfo);
    }

    $appointmentPage = get_page_by_path('schedule-an-appointment');
    $data['appointment'] = [
        'title' => 'Schedule An Appointment',
        'url' => $appointmentPage ? get_permalink($appointmentPage) : home_url('/schedule-an-appointment/'),
    ];

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

Options::addGlobal('FooterLocations', [
    [
        'name' => 'view_all_link',
        'label' => 'Footer "View all locations" Link',
        'type' => 'link',
        'return_format' => 'array',
        'instructions' => 'Defaults to the Locations page. The list of locations comes from the "Footer Menu: Find a Location" menu (or the first ' . FOOTER_LOCATIONS_LIMIT . ' locations if no menu is assigned).',
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
