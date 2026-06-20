<?php

namespace Flynt\Components\SectionLogos;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=SectionLogos', function ($data) {
    if ($brands = get_field('brands')) {
        $data['brands'] = $brands;

        $logos = [];
        foreach ($data['brands'] as $brand) {
            if ($logo = get_field('logo', $brand)) {
                $logos[] = $logo;
            }
        }
        $data['brand_logos'] = $logos;
    } else {
        // If at some point it needs to show all brands:
        // $brands = Timber::get_posts([
        //     'post_status' => 'publish',
        //     'post_type' => 'brands',
        //     'posts_per_page' => -1
        // ]);
        // $data['brands'] = $brands;
    }

    if ($labels = Options::getTranslatable('StyleLabels')) {
        $data = array_merge($data, $labels);
    }

    return $data;
});

function getACFLayout() {
    return [
        'label' => 'Style: Logos',
        'name' => 'sectionLogos',
        'sub_fields' => [
            FieldVariables\getTab("Content"),
            FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, size: auto, style: subhead'),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getButtonLoop($limit = 2),
            FieldVariables\getTab("Media"),
            FieldVariables\getMessage("If no images are supplied here, brand logos are automatically pulled in based on the current style."),
            FieldVariables\getCarousel(),
            FieldVariables\getCarouselToggle(),
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect(),
        ]
    ];
}


// Options::addGlobal('StyleFinderLogoCarousel', [
//     // FieldVariables\getTab("Content"),
//     // FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, style: minimal 1<br/>tag: div, style: display 1'),
//     // FieldVariables\getSectionContent_1(),
//     // FieldVariables\getButtonLoop($limit = 1),
//     // FieldVariables\getTab("Media"),
//     // FieldVariables\getImage(),
//     FieldVariables\getTab("Options"),
//     FieldVariables\getSectionBackgroundSelect(),
// ], 'Sections');


// Options::addTranslatable('StyleFinderLogoCarousel', [
//     FieldVariables\getTab("Content"),
//     FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, style: minimal 1<br/>tag: div, style: display 1'),
//     FieldVariables\getSectionContent_1(),
//     FieldVariables\getButtonLoop($limit = 1),
//     FieldVariables\getTab("Media"),
//     FieldVariables\getImage(),
// ], 'Sections');
