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
                            "<strong>Defaults</strong><br/>tag: h2 or h3, style: minimal 1<br/>tag: p, style: minimal body"
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
