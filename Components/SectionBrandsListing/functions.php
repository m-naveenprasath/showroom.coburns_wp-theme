<?php

namespace Flynt\Components\SectionBrandsListing;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

const POST_TYPE = "brands";

add_filter("Flynt/addComponentData?name=SectionBrandsListing", function ($data) {
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

    if ($options = Options::getGlobal("SectionBrandsListing")) {
        $data = array_merge($data, $options);
    }
    if ($options = Options::getTranslatable("SectionBrandsListing")) {
        $data = array_merge($data, $options);
    }

    return $data;
});

Options::addGlobal(
    "SectionBrandsListing",
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
    "SectionBrandsListing",
    [
        [
            "label" => "Category Dropdown",
            "name" => "CategoryDropdown",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [
                [
                    "label" => "Label",
                    "name" => "label",
                    "type" => "text",
                    "default_value" => "Category",
                    "required" => 1,
                ],
                [
                    "label" => "Placeholder",
                    "name" => "placeholder",
                    "type" => "text",
                    "default_value" => "Choose a Category...",
                    "required" => 1,
                ],
            ],
        ],
        [
            "label" => "Table Headers",
            "name" => "TableHeaders",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [
                [
                    "label" => "Name",
                    "name" => "name",
                    "type" => "text",
                    "default_value" => "Brand",
                    "required" => 1,
                ],
                [
                    "label" => "Categories",
                    "name" => "categories",
                    "type" => "text",
                    "default_value" => "Product Lines",
                    "required" => 1,
                ],
                [
                    "label" => "Links",
                    "name" => "links",
                    "type" => "text",
                    "default_value" => "Actions",
                    "required" => 1,
                ],
            ],
        ],
        [
            "label" => "Table Content",
            "name" => "TableContent",
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
            ],
        ],
    ],
    "Sections"
);

function getACFLayout()
{
    return [
        "label" => "Section: Brands Listing",
        "name" => "SectionBrandsListing",
        "sub_fields" => [
            FieldVariables\getTab("Hero"),
            FieldVariables\getHeadingLoop(
                $instructions =
                    "<strong>Defaults</strong><br/>tag: div, size: h1, style: minimal 1  <br/>tag: h1, size: auto, style: display 1"
            ),
            FieldVariables\getSectionContent_1(),
            FieldVariables\getTab("Links"),
            FieldVariables\getButtonHeadingLoop(
                $instructions = "<strong>Defaults</strong><br/>tag: h2 or h3, size: h4, style: body"
            ),
            FieldVariables\getSectionContent_2(),
            FieldVariables\getButtonLoop($limit = 2),
            FieldVariables\getTab("Options"),
            FieldVariables\getFeaturedImageToggle(),
        ],
    ];
}
