<?php

namespace Flynt\Components\BrandHero;

use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=BrandHero', function ($data) {
    if ($options = Options::getTranslatable("BrandDefaults")) {
        $data = array_merge($data, $options);
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Brands: Hero',
        'name' => 'BrandHero',
        'sub_fields' => [
            FieldVariables\getTab('Content'),
            FieldVariables\getMessage('<strong>Note:</strong> Content added in this tab will any override equivalent-ish content set in the "Brand Content" box. Additional functionality toggles are available in the Options tab.'),
            FieldVariables\getHeadingLoop(
                $instructions =
                    '<strong>Defaults</strong><br/>tag: h1, style: minimal-1<br/>tag: p/div, style: display 1'
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getButtonLoop($limit = 2),
            FieldVariables\getTab('Carousel'),
            FieldVariables\getCarouselToggle($default = false),
            [
                'label' => 'Carousel Heading',
                'name' => 'carouselHeading',
                'type' => 'group',
                'layout' => 'table',
                'instructions' => '<strong>Defaults</strong>: tag: h2',
                'sub_fields' => [FieldVariables\getHeadingParts($required = false, $included_fields = ['tag', 'text'])],
            ],
            FieldVariables\getCarousel($default_visibility = false),
            FieldVariables\getTab('Options'),
            [
                "label" => "Product Lines",
                "name" => "brandProductLines_show",
                "type" => "true_false",
                "default_value" => true,
                "ui" => 1,
                "ui_on_text" => "Show",
                "ui_off_text" => "Hide",
            ],
            [
                "label" => "Shop / Website Links",
                "name" => "brandHeroButtons_show",
                "type" => "true_false",
                "default_value" => true,
                "ui" => 1,
                "ui_on_text" => "Show",
                "ui_off_text" => "Hide",
            ],
            FieldVariables\getFeaturedImageToggle(),
            FieldVariables\getAdditionalImagesToggle($default = false),
        ],
    ];
}
