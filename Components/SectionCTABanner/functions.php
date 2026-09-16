<?php

namespace Flynt\Components\SectionCTABanner;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=SectionCTABanner', function ($data) {
    if (empty($data['headings'])) {
        $data['headings'] = [
            [
                'tag'   => 'h2',
                'style' => 'display-2',
                'text'  => 'Commercial & Professional',
            ],
        ];
    }

    if (empty($data['sectionHtml_1'])) {
        $data['sectionHtml_1'] = "<p>For commercial supplies, construction needs and more, see our full list of Coburn's branch locations and find a counter near you.</p>";
    }

    if (empty($data['buttons'])) {
        $data['buttons'] = [
            [
                'text'  => "See All Coburn's Locations",
                'link'  => [
                    'url'    => home_url('/locations/'),
                    'target' => '',
                    'title'  => "See All Coburn's Locations",
                ],
                'color' => 'primary',
                'style' => '',
            ],
        ];
    }

    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Section: CTA Banner',
        'name' => 'SectionCTABanner',
        'sub_fields' => [
            FieldVariables\getTab('Content'),
            FieldVariables\getHeadingLoop(
                $instructions = '<strong>Defaults</strong><br/>tag: h2, style: display-2'
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getButtonLoop($limit = 2, $required = false, $accent_line = false),
        ],
    ];
}
