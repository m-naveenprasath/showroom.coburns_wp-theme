<?php

namespace Flynt\Components\SectionGeneric;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=SectionGeneric', function ($data) {
    //If map is selected for media
    if ($data['media']['type'] == 'map') {
        $data['locations'] = Timber::get_posts([
            'orderby' => 'post_name',
            'order' => 'ASC',
            'post_status' => 'publish',
            'post_type' => 'locations',
            'posts_per_page' => -1,
        ]);

        wp_enqueue_script( 'google-map' );
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: Image/Text',
        'name' => 'SectionGeneric',
        'sub_fields' => [
			FieldVariables\getTab("Content"),
			FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, size: auto, style: minimal 1<br/>tag: p, size: auto, style: display 1'),
            FieldVariables\getSectionContent_1(),
			FieldVariables\getButtonLoop($limit = 2),
            FieldVariables\getSectionContent_2(),
            [
                'label' => 'Shortcode',
                'name' => 'shortcode',
                'type' => 'text',
            ],
			FieldVariables\getTab("Media"),
			FieldVariables\getMediaSwitcher(),
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionIDField(),
            FieldVariables\getSectionBackgroundSelect(),
            FieldVariables\getSectionTextAlignSelect(),
            [
                'label' => 'Style Finder Stamp',
                'name' => 'styleFinderStamp_show',
                'type' => 'true_false',
                'default_value' => false,
                'ui' => 1,
                'ui_on_text' => 'Show',
                'ui_off_text' => 'Hide',
            ],
            [
                'label' => 'Style Finder Accent',
                'name' => 'styleFinderAccent_show',
                'type' => 'true_false',
                'default_value' => false,
                'ui' => 1,
                'ui_on_text' => 'Show',
                'ui_off_text' => 'Hide',
            ],
        ]
    ];
}
