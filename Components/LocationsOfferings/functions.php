<?php

namespace Flynt\Components\LocationsOfferings;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter("Flynt/addComponentData?name=LocationsOfferings", function ($data) {
    // if ($fields = get_fields()) {
    //     unset($fields["pageComponents"]);
    //     $data = array_merge($data, $fields);
    // }

    if ($options = Options::getTranslatable("LocationDefaults")) {
        $data = array_merge($data, $options);
    }

    return $data;
});

function getACFLayout()
{
    $list_field = array_merge(FieldVariables\getSectionContent_2(), [
        "label" => "Listing",
        "instructions" => "Enter only lists.",
    ]);

    return [
        "label" => "Locations: Our Offerings",
        "name" => "LocationsOfferings",
        "sub_fields" => [
            FieldVariables\getHeadingLoop($instructions = "Defaults: h2, Display 1"),
            FieldVariables\getSectionContent_1(),
            $list_field,
        ],
    ];
}
