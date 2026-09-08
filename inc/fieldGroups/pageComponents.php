<?php

use ACFComposer\ACFComposer;
use Flynt\Components;

add_action('Flynt/afterRegisterComponents', function () {
    $page_components = [
        Components\SectionGeneric\getACFLayout(),
        Components\SectionFullWidth\getACFLayout(),
        Components\SectionButtons\getACFLayout(),
        Components\SectionFeatured\getACFLayout(),
        Components\SectionHero\getACFLayout(),
        Components\SectionImages\getACFLayout(),
        Components\SectionAbout\getACFLayout(),
        Components\SectionPinterest\getACFLayout(),
        Components\SectionProducts\getACFLayout(),
        Components\SectionExternalFeaturedProducts\getACFLayout(),
        Components\SectionAppointments\getACFLayout(),
        Components\SectionBlogList\getACFLayout(),
        Components\PageContentBrandFilter\getACFLayout(),
        Components\SectionBrandsListing\getACFLayout(),
        Components\SectionBrandsGrid\getACFLayout(),
        Components\SectionBrandsContact\getACFLayout(),
        Components\SectionLocationsListing\getACFLayout(),
        Components\LocationsOfferings\getACFLayout(),
        Components\SectionSpace\getACFLayout(),
        Components\SectionLogos\getACFLayout(),
        Components\SectionStyleList\getACFLayout(),
        Components\SectionOtherStyles\getACFLayout(),
        Components\SectionShareBadge\getACFLayout(),
        Components\SectionShareButtons\getACFLayout(),
        Components\BrandHero\getACFLayout(),
    ];

    ACFComposer::registerFieldGroup([
        'name' => 'pageComponents',
        'title' => 'Page Sections',
        'style' => 'seamless',
        'menu_order' => 50,
        'fields' => [
            [
                'name' => 'pageComponents',
                'label' => 'Page Sections',
                'type' => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts' => $page_components,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '!=',
                    'value' => 'post',
                ],
            ],
        ],
    ]);

    // How post type-specific components could work. Data would have to be moved from pageComponents sections into new ones.
    //
    // $location_components = array_merge($page_components, []);
    // ACFComposer::registerFieldGroup([
    //     'name' => 'locationPageComponents',
    //     'title' => 'Location Page Components',
    //     'style' => 'seamless',
    //     'menu_order' => 50,
    //     'fields' => [
    //         [
    //             'name' => 'pageComponents',
    //             'label' => 'Location Page Components',
    //             'type' => 'flexible_content',
    //             'button_label' => 'Add Component',
    //             'layouts' => $page_components,
    //         ]
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => 'locations'
    //             ]
    //         ]
    //     ]
    // ]);
});
