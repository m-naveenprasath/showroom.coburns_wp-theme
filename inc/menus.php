<?php

use ACFComposer\ACFComposer;
use Flynt\Utils\Options;

// Add labels for mobile nav
Options::addTranslatable('MobileNav', [
    [
        'label' => 'Menu Button',
        'name' => 'mobileNavMenuButton',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Text',
                'name' => 'label',
                'type' => 'text',
                'default_value' => 'Toggle Menu',
            ],
        ],
    ],
    [
        'label' => 'Search Button',
        'name' => 'mobileNavSearchButton',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Text',
                'name' => 'label',
                'type' => 'text',
                'default_value' => 'Search',
            ],
        ],
    ],
    [
        'label' => 'Cart Button',
        'name' => 'mobileNavCartButton',
        'type' => 'group',
        'sub_fields' => [
            [
                'label' => 'Text',
                'name' => 'label',
                'type' => 'text',
                'default_value' => 'View Cart',
            ],
        ],
    ],
]);

// Add options to nav items
ACFComposer::registerFieldGroup([
    'name' => 'nav_item_options',
    'title' => 'Display Options',
    'fields' => [
        [
            'label' => 'Style',
            'name' => 'style',
            'type' => 'select',
            'instructions' => '',
            'choices' => [
                '' => 'Default',
                'nav-header' => 'Arrow Accent (Desktop) / Dark Blue Background (Mobile)',
                'highlight' => 'Teal Background',
            ],
            'return_format' => 'value',
            'wrapper' => [
                'width' => '50%',
                'class' => '',
                'id' => '',
            ],
        ],
        [
            'label' => 'Visibility',
            'name' => 'visible',
            'type' => 'checkbox',
            'instructions' => '',
            'choices' => [
                'desktop' => 'Desktop',
                'mobile' => 'Mobile',
            ],
            'layout' => 'horizontal',
            'default_value' => [
                0 => 'desktop',
                1 => 'mobile',
            ],
            'return_format' => 'value',
            'wrapper' => [
                'width' => '50%',
                'class' => '',
                'id' => '',
            ],
        ],
        [
            'label' => 'Mega Menu',
            'name' => 'mega_menu',
            'type' => 'select',
            'instructions' => 'Desktop only (Header Menu: Primary). Tabs are built from this item\'s child links: a child linking to a "style", "brand" or "space" page becomes that tab. Auto turns it on when at least two such child links exist.',
            'choices' => [
                '' => 'Auto',
                'find_your_style' => 'Find Your Style (By Style / By Brand / By Space)',
                'none' => 'Off',
            ],
            'return_format' => 'value',
        ],
    ],
    'location' => [
        [
            [
                'param' => 'nav_menu_item',
                'operator' => '==',
                'value' => 'all',
            ],
        ],
    ],
    'instruction_placement' => 'field',
]);

// Add title to menu
ACFComposer::registerFieldGroup([
    'name' => 'nav_title',
    'title' => 'Menu Title',
    'fields' => [
        [
            'label' => '',
            'name' => 'nav_title',
            'type' => 'text',
            'instructions' => '',
        ],
    ],
    'location' => array_map(function ($location) {
        return [
            [
                'param' => 'nav_menu',
                'operator' => '==',
                'value' => 'location/' . $location,
            ],
        ];
    }, ['nav_footer_1', 'nav_footer_2', 'nav_footer_3', 'nav_footer_locations']),
    'instruction_placement' => 'label',
]);
