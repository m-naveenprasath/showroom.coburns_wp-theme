<?php

namespace Flynt\Components\SectionOtherStyles;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter("Flynt/addComponentData?name=SectionOtherStyles", function ($data) {
    if (array_key_exists("current_style", $data)) {
        $data["posts"] = Timber::get_posts([
            "post_type" => "style",
            "post_status" => "publish",
            "posts_per_page" => 4,
            "orderby" => "menu_order",
            "post__not_in" => [$data["current_style"]],
        ]);
    }

    return $data;
});

function getACFLayout()
{
    return [
        "name" => "SectionOtherStyles",
        "label" => "Style: Other Styles",
        "sub_fields" => [
            FieldVariables\getMessage("<strong>This section pulls in four other styles.</strong>"),
            [
                "label" => "Current Style",
                "name" => "current_style",
                "type" => "post_object",
                "required" => 1,
                "instructions" => "Select the current style so it isn't included. (This is a very hacky workaround.)",
                "post_type" => [
                    0 => "style",
                ],
                "taxonomy" => "",
                "allow_null" => 0,
                "multiple" => 0,
                "return_format" => "id",
                "ui" => 1,
                "default_value" => get_the_ID(),
            ],
        ],
    ];
}

Options::addGlobal("SectionOtherStyles", [FieldVariables\getSectionBackgroundSelect()], "Sections");
