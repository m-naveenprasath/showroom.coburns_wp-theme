<?php

namespace Flynt\Components\SectionImages;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;


add_filter('Flynt/addComponentData?name=SectionImages', function ($data) {

    return $data;
});


function getACFLayout() {
    return [
        'label' => 'Section: Image Gallery',
        'name' => 'SectionImages',
        'sub_fields' => [
          FieldVariables\getTab("Content"),
          FieldVariables\getHeadingLoop($instructions = '<strong>Defaults</strong><br/>tag: h2, size: auto, style: subhead'),
          FieldVariables\getSectionContent_1(),
          FieldVariables\getTab("Images"),
          FieldVariables\getImageLinksLoop(),
          FieldVariables\getTab("Options"),
          FieldVariables\getSectionBackgroundSelect(),
           
        ]
    ];
}
