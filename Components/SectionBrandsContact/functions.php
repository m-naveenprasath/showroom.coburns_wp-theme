<?php

namespace Flynt\Components\SectionBrandsContact;

use Flynt\FieldVariables;

// Self-contained assets: this component enqueues its own CSS so it never
// has to touch the theme's shared Sass manifest (css/src/_sections.scss).
// Safe to enable/disable independently. Matches the SectionBrandsGrid
// component's approach.
add_action("wp_enqueue_scripts", function () {
    $css_path = "/Components/SectionBrandsContact/css/brands-contact.css";
    wp_enqueue_style(
        "section-brands-contact",
        get_stylesheet_directory_uri() . $css_path,
        [],
        filemtime(get_stylesheet_directory() . $css_path),
        "screen"
    );
});

function getACFLayout()
{
    return [
        "label" => "Section: Brands Contact CTA",
        "name" => "SectionBrandsContact",
        "sub_fields" => [
            FieldVariables\getHeadingLoop(
                $instructions =
                    "<strong>Defaults</strong><br/>tag: h2, size: auto, style: display 2"
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getButtonLoop($limit = 2, $required = false, $accent_line = false,
                $instructions = "Up to 2 buttons (e.g. Email, Find Your Nearest Location)."
            ),
            [
                "label" => "Image",
                "name" => "image",
                "type" => "image",
                "return_format" => "id",
            ],
        ],
    ];
}
