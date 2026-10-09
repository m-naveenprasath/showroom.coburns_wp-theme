<?php

namespace Flynt\Components\SectionProducts;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;


	
add_filter("Flynt/addComponentData?name=SectionProducts", function ($data) {
    if ($labels = Options::getTranslatable("StyleLabels")) {
        $data = array_merge($data, $labels);
    }
    return $data;
});

function getACFLayout()
{
    return [
        "name" => "SectionProducts",
        "label" => "Section: Featured Products",
        "sub_fields" => [
            FieldVariables\getTab("Content"),
            [
                "label" => "Heading Text",
                "name" => "featured_products_heading",
                "type" => "text",
                "default_value" => "",
                "placeholder" => "Featured Products",
                "instructions" => "Overrides the heading set in Translatable Options > Sections > Products.",
            ],
            [
                "label" => "Intro Text",
                "name" => "featured_products_intro",
                "type" => "textarea",
                "rows" => 3,
                "new_lines" => "",
                "instructions" => "Optional short paragraph shown centered under the heading.",
            ],
            FieldVariables\getTab("Products"),

            [
                "label" => "Products",
                "name" => "products",
                "type" => "repeater",
                "layout" => "block",
                "button_label" => "Add Product",
                "sub_fields" => [
                    FieldVariables\getHeadingLoop(
                        $instructions =
                            "The first heading is the card title (tag: h3). Any further headings are shown as the card description. Style and size are set by the card design."
                    ),
                    FieldVariables\getImage(),
                    FieldVariables\getButton($instructions = "", $required = false),
                ],
            ],
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect(),
        ],
    ];
}

Options::addTranslatable(
    "SectionProducts",
    [
        [
            "label" => "Featured Products Heading Text",
            "name" => "featured_products_heading_default",
            "type" => "text",
            "default_value" => "Featured Products",
        ],
    ],
    "Sections"
);

Options::addGlobal("SectionProducts", [FieldVariables\getSectionBackgroundSelect()], "Sections");
