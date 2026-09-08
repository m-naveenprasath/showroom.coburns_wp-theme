<?php

namespace Flynt\Components\SectionBrandsGrid;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

const POST_TYPE = "brands";

add_filter("Flynt/addComponentData?name=SectionBrandsGrid", function ($data) {
    $postType = POST_TYPE;

    $data["brands"] = Timber::get_posts([
        "orderby" => "post_name",
        "order" => "ASC",
        "post_status" => "publish",
        "post_type" => $postType,
        "posts_per_page" => -1,
    ]);
    $data["categories"] = Timber::get_terms("product_line", [
        "hide_empty" => 1,
    ]);

    if ($options = Options::getGlobal("SectionBrandsGrid")) {
        $data = array_merge($data, $options);
    }
    if ($options = Options::getTranslatable("SectionBrandsGrid")) {
        $data = array_merge($data, $options);
    }

    return $data;
});

// Self-contained assets: this component enqueues its own CSS/JS so it
// never has to touch the theme's shared Sass manifest (css/src/_sections.scss)
// or the shared js/src/scripts.js bundle. Safe to enable/disable independently.
add_action("wp_enqueue_scripts", function () {
    $css_path = "/Components/SectionBrandsGrid/css/brands-grid.css";
    wp_enqueue_style(
        "section-brands-grid",
        get_stylesheet_directory_uri() . $css_path,
        [],
        filemtime(get_stylesheet_directory() . $css_path),
        "screen"
    );

    $js_path = "/Components/SectionBrandsGrid/js/brands-grid.js";
    wp_enqueue_script(
        "section-brands-grid",
        get_stylesheet_directory_uri() . $js_path,
        [],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

Options::addGlobal(
    "SectionBrandsGrid",
    [
        [
            "label" => "Show Brand Ecommerce Link",
            "name" => "BrandEcommerceLink_show",
            "type" => "true_false",
            "default_value" => true,
            "ui" => 1,
            "ui_on_text" => "Show",
            "ui_off_text" => "Hide",
        ],
    ],
    "Sections"
);

Options::addTranslatable(
    "SectionBrandsGrid",
    [
        [
            "label" => "Category Dropdown",
            "name" => "GridCategoryDropdown",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [
                [
                    "label" => "Filter Label",
                    "name" => "label",
                    "type" => "text",
                    "default_value" => "Filter:",
                    "required" => 1,
                ],
                [
                    "label" => "Placeholder",
                    "name" => "placeholder",
                    "type" => "text",
                    "default_value" => "Brand Category",
                    "required" => 1,
                ],
            ],
        ],
        [
            "label" => "Card Content",
            "name" => "GridCardContent",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [
                [
                    "label" => "Shop Link Text",
                    "name" => "BrandShopLinkText",
                    "type" => "text",
                    "default_value" => "Shop This Brand",
                    "required" => 1,
                ],
                [
                    "label" => "Know More Link Text",
                    "name" => "KnowMoreText",
                    "type" => "text",
                    "default_value" => "Know More",
                    "required" => 1,
                ],
                [
                    "label" => "Brands Count Label",
                    "name" => "BrandsCountLabel",
                    "type" => "text",
                    "default_value" => "Brands",
                    "required" => 1,
                ],
                [
                    "label" => "Load More Text",
                    "name" => "LoadMoreText",
                    "type" => "text",
                    "default_value" => "Load More",
                    "required" => 1,
                ],
                [
                    "label" => "Brands Per Page",
                    "name" => "BrandsPerPage",
                    "type" => "number",
                    "default_value" => 12,
                    "min" => 1,
                    "required" => 1,
                ],
            ],
        ],
    ],
    "Sections"
);

function getACFLayout()
{
    return [
        "label" => "Section: Brands Grid",
        "name" => "SectionBrandsGrid",
        "sub_fields" => [
            FieldVariables\getTab("Hero"),
            FieldVariables\getHeadingLoop(
                $instructions =
                    "<strong>Defaults</strong><br/>tag: div, size: h1, style: minimal 1  <br/>tag: h1, size: auto, style: display 1"
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getButtonLoop($limit = 3, $required = true, $accent_line = false,
                $instructions = "Up to 3 buttons shown under the hero heading (e.g. Shop Brands Products, Find a Showroom, Schedule Appointment)."
            ),
            FieldVariables\getTab("Options"),
            FieldVariables\getFeaturedImageToggle(),
        ],
    ];
}
