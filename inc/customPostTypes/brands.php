<?php

namespace Flynt\CustomPostTypes;

use ACFComposer\ACFComposer;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_action("init", '\\Flynt\\CustomPostTypes\\registerBrandsPostType');

function registerBrandsPostType()
{
    $slug = "brands";
    $post_type = $slug;

    $name_singular = "Brand";
    $name_plural = $name_singular . "s";
    $description = "";

    $icon = "dashicons-images-alt";
    $menu_position = 2;

    $labels = [
        "add_new_item" => __("Add New " . $name_singular, "sb"),
        "add_new" => __("Add New", "sb"),
        "all_items" => __("All " . $name_plural, "sb"),
        "archives" => __($name_singular . " archives", "sb"),
        "attributes" => __($name_plural . " attributes", "sb"),
        "edit_item" => __("Edit " . $name_singular, "sb"),
        "featured_image" => __("Featured image for this " . $name_singular, "sb"),
        "filter_items_list" => __("Filter " . $name_plural . " list", "sb"),
        "insert_into_item" => __("Insert into " . $name_singular, "sb"),
        "item_published_privately" => __($name_singular . " published privately.", "sb"),
        "item_published" => __($name_singular . " published", "sb"),
        "item_reverted_to_draft" => __($name_singular . " reverted to draft.", "sb"),
        "item_scheduled" => __($name_singular . " scheduled", "sb"),
        "item_updated" => __($name_singular . " updated.", "sb"),
        "items_list_navigation" => __($name_plural . " list navigation", "sb"),
        "items_list" => __($name_plural . " list", "sb"),
        "menu_name" => __($name_plural, "sb"),
        "name" => __($name_plural, "sb"),
        "name_admin_bar" => __($name_singular, "sb"),
        "new_item" => __("New " . $name_singular, "sb"),
        "not_found_in_trash" => __("No " . $name_plural . " found in Trash.", "sb"),
        "not_found" => __("No " . $name_plural . " found.", "sb"),
        "parent_item_colon" => __("Parent " . $name_singular . ":", "sb"),
        "remove_featured_image" => __("Remove featured image for this " . $name_singular, "sb"),
        "search_items" => __("Search " . $name_plural, "sb"),
        "set_featured_image" => __("Set featured image for this " . $name_singular, "sb"),
        "singular_name" => __($name_singular, "sb"),
        "uploaded_to_this_item" => __("Upload to this " . $name_singular, "sb"),
        "use_featured_image" => __("Use as featured image for this " . $name_singular, "sb"),
        "view_item" => __("View " . $name_singular, "sb"),
        "view_items" => __("View " . $name_plural, "sb"),
    ];

    $args = [
        "label" => __($name_plural, "sb"),
        "labels" => $labels,
        "description" => __($description, "sb"),
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "delete_with_user" => false,
        "show_in_rest" => true,
        "rest_base" => $post_type,
        "has_archive" => false,
        "rewrite" => ["slug" => $slug, "with_front" => false],
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "exclude_from_search" => true,
        "capability_type" => "page",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "query_var" => true,
        "menu_icon" => $icon,
        "menu_position" => 21,
        "supports" => ["title", "thumbnail", "revisions", "custom-fields", "page-attributes"],
        "taxonomies" => ["product_lines", "category"],
    ];

    register_post_type($post_type, $args);
}

add_action("acf/init", '\\Flynt\\CustomPostTypes\\registerBrandsCustomFields');

function registerBrandsCustomFields()
{
    $slug = "brands";
    $post_type = $slug;

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_brand_group",
        "title" => "Brand Content",
        "fields" => [
            fieldVariables\getTab("Content"),
            FieldVariables\getSectionContent_1(),
            fieldVariables\getTab("Images"),
            [
                "label" => "",
                "name" => "message",
                "type" => "message",
                "message" => "These images are used on the Brand Filter component. Images 2 and 3 are also used in the Brand Hero component.",
            ],
            [
                "label" => "Logo",
                "name" => "logo",
                "type" => "image",
                "return_format" => "id",
            ],
            [
                "label" => "Image 1",
                "name" => "image1",
                "type" => "image",
                "return_format" => "id",
            ],
            [
                "label" => "Image 2",
                "name" => "image2",
                "type" => "image",
                "return_format" => "id",
            ],
            [
                "label" => "Image 3",
                "name" => "image3",
                "type" => "image",
                "return_format" => "id",
            ],
            fieldVariables\getTab("Links"),
            [
                "label" => "Shop",
                "name" => "shop",
                "type" => "url",
            ],
            [
                "label" => "Website",
                "name" => "website",
                "type" => "url",
            ],
        ],
        "location" => [
            [
                [
                    "param" => "post_type",
                    "operator" => "==",
                    "value" => $post_type,
                ],
            ],
        ],
    ]);


    Options::addGlobal(
        "BrandsOptions",
        [
            [
                "name" => "brands_page_for_posts",
                "label" => "Archive Page",
                "type" => "page_link",
                "default_value" => "",
                "instructions" => "Used in the breadcrumb trail."
            ],
        ],
    );

    Options::addTranslatable(
        "BrandDefaults",
        [
            FieldVariables\getTab("Hero"),
            [
                "name" => "brand_hero_default",
                "label" => "",
                "type" => "group",
                "sub_fields" => [
                    [
                        "name" => "eyebrow",
                        "label" => "Eyebrow",
                        "type" => "text",
                        "default_value" => "Brand Overview",
                        "instructions" => "Used on featured Brands pages."
                    ],
                    [
                        "name" => "product_lines_title",
                        "label" => "Product Lines Title",
                        "type" => "text",
                        "default_value" => "Product Lines",
                    ],
                    [
                        "name" => "shop_link_label",
                        "label" => "Shop Link",
                        "type" => "text",
                        "default_value" => "Shop This Brand",
                    ],
                    [
                        "name" => "website_link_label",
                        "label" => "Website Link",
                        "type" => "text",
                        "default_value" => "Visit Official Site",
                    ],
                ],
            ],
        ],
        "Brands"
    );
}
