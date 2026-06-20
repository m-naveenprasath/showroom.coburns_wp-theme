<?php

namespace Flynt\Components\SectionAbout;

use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=SectionAbout', function ($data) {
    return $data;
});

function getACFLayout() {
    return [
        'label' => 'Section: About Coburns',
        'name' => 'SectionAbout',
        'sub_fields' => [
            FieldVariables\getTab("Content"),
            FieldVariables\getHeadingLoop(),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getTab("Media"),
            FieldVariables\getMediaSwitcher(),
            FieldVariables\getCarousel(),
            FieldVariables\getTab("Buttons"),
            FieldVariables\getSectionContent_2(),
            FieldVariables\getButtonHeading(),
            FieldVariables\getButtonLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, size: h1, style: minimal 1'),
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect(),
            FieldVariables\getSectionTextAlignSelect(),
        ]
    ];
}
