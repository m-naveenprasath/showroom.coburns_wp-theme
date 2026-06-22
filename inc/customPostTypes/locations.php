<?php

namespace Flynt\CustomPostTypes;

use ACFComposer\ACFComposer;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_action("init", '\\Flynt\\CustomPostTypes\\registerLocationsPostType');

function registerLocationsPostType()
{
    $slug = "locations";
    $post_type = $slug;

    $name_singular = "Location";
    $name_plural = $name_singular . "s";
    $description = "";

    $icon = "dashicons-location";
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
        "exclude_from_search" => false,
        "capability_type" => "page",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "query_var" => true,
        "menu_icon" => $icon,
        "menu_position" => 21,
        "supports" => ["title", "thumbnail", "revisions", "custom-fields"],
    ];
    register_post_type($post_type, $args);
}

add_action("acf/init", '\\Flynt\\CustomPostTypes\\registerLocationsCustomFields');

function registerLocationsCustomFields()
{
    $slug = "locations";
    $post_type = $slug;

    //And now add custom fields

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_hero_group",
        "title" => "Location Hero",
        "fields" => [
            fieldVariables\getTab("Content"),
            [
                "label" => "Hero Intro",
                "name" => "location_hero_intro",
                "type" => "wysiwyg",
                "toolbar" => "full",
                "media_upload" => false,
                "delay" => 1,
                "instructions" =>
                    "Insert {location_name} where you want the location's name to appear.<br/> Leave empty to use the default content.",
            ],
            fieldVariables\getButtonLoop(),
            fieldVariables\getTab("Images"),
            [
                "label" => "Image 1",
                "name" => "image_1",
                "type" => "message",
                "message" => "<em>Image 1 is the Featured Image.</em> 👉",
            ],
            [
                "label" => "Image 2",
                "name" => "image_2",
                "type" => "image",
            ],
            [
                "label" => "Image 3",
                "name" => "image_3",
                "type" => "image",
            ],
            fieldVariables\getTab("Options"),
            FieldVariables\getFeaturedImageToggle(),
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

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_flamedrop_group",
        "title" => "Flamedrop",
        "fields" => [
            fieldVariables\getTab("Branch ID"),
            [
                "label" => "Branch ID",
                "name" => "flamedrop_branch_id",
                "type" => "text",
                "instructions" =>
                    "The branch ID of the location in Flamedrop. Overrides some data entered in Wordpress.",
            ],
            fieldVariables\getTab("ID"),
            [
                "label" => "ID",
                "name" => "flamedrop_id",
                "type" => "text",
                "instructions" => 'I\'m not sure if this actually matters.',
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

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_tour_group",
        "title" => "Virtual Tour",
        "fields" => [
            [
                "label" => "Link",
                "name" => "virtual_tour_link",
                "type" => "link",
            ],
        ],
        "position" => "side",
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

    // ACFComposer::registerFieldGroup([
    //     'name' => $post_type . '_location_group',
    //     'title' => 'Location Map',
    //     'fields' => [
    //         [
    //             'label' => 'Address',
    //             'name' => 'address',
    //             'type' => 'google_map',
    //         ],
    //         [
    //             'label' => 'Hours',
    //             'name' => 'hours_human',
    //             'type' => 'textarea',
    //         ],
    //         [
    //             'label' => 'Year Opened',
    //             'name' => 'year_opened',
    //             'type' => 'text',
    //         ],
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => $post_type,
    //             ],
    //         ],
    //     ],
    // ]);

    // ACFComposer::registerFieldGroup([
    //     'name' => $post_type . '_social_group',
    //     'title' => 'Location Social Media',
    //     'fields' => [
    //         [
    //             'label' => 'Accounts',
    //             'name' => 'social',
    //             'type' => 'group',
    //             'layout' => 'row',
    //             'sub_fields' => FieldVariables\getSocialMedia(),
    //         ]
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => $post_type,
    //             ],
    //         ],
    //     ],
    // ]);

    // ACFComposer::registerFieldGroup([
    //     'name' => $post_type . '_contact_group',
    //     'title' => 'Location Contact',
    //     'position' => 'side',
    //     'fields' => [
    //         [
    //             'label' => 'Phone',
    //             'name' => 'phone',
    //             'type' => 'text'
    //         ],
    //         [
    //             'label' => 'Fax',
    //             'name' => 'fax',
    //             'type' => 'text'
    //         ]
    //     ],
    //     'location' => [
    //         [
    //             [
    //                 'param' => 'post_type',
    //                 'operator' => '==',
    //                 'value' => $post_type,
    //             ],
    //         ],
    //     ],
    // ]);

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_cta_group",
        "title" => "CTA Section",
        "fields" => [
            [
                "label" => "Background Image",
                "name" => "cta_image",
                "type" => "image",
                "return_format" => "array",
                "instructions" => "Full-width background image for the CTA banner section.",
            ],
            [
                "label" => "Heading",
                "name" => "cta_heading",
                "type" => "text",
                "instructions" => "Use {location_name} to insert the location name automatically.",
            ],
            [
                "label" => "Description",
                "name" => "cta_description",
                "type" => "wysiwyg",
                "toolbar" => "basic",
                "media_upload" => false,
            ],
            [
                "label" => "Directions URL",
                "name" => "cta_directions_url",
                "type" => "url",
                "instructions" => "Paste the Google Maps or Apple Maps directions link for this location.",
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

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_map_group",
        "title" => "Map & Contact",
        "fields" => [
            [
                "label" => "Map Embed",
                "name" => "map_embed",
                "type" => "textarea",
                "instructions" => "Paste the Google Maps iframe embed code. In Google Maps: share → Embed a map → copy HTML.",
                "rows" => 4,
            ],
            [
                "label" => "Address City / Subtitle",
                "name" => "map_address_city",
                "type" => "text",
                "instructions" => "e.g. Harahan, Louisiana",
            ],
            [
                "label" => "Address",
                "name" => "map_address",
                "type" => "textarea",
                "instructions" => "Street address, one line per line",
                "rows" => 3,
            ],
            [
                "label" => "Directions URL",
                "name" => "map_directions_url",
                "type" => "url",
                "instructions" => "Google Maps or Apple Maps link for this location",
            ],
            [
                "label" => "Phone Number",
                "name" => "map_phone",
                "type" => "text",
            ],
            [
                "label" => "Hours",
                "name" => "map_hours",
                "type" => "repeater",
                "layout" => "table",
                "button_label" => "Add Row",
                "sub_fields" => [
                    [
                        "label" => "Days",
                        "name" => "days",
                        "type" => "text",
                    ],
                    [
                        "label" => "Time",
                        "name" => "time",
                        "type" => "text",
                    ],
                ],
            ],
            [
                "label" => "Hours Note",
                "name" => "map_hours_note",
                "type" => "textarea",
                "rows" => 2,
                "instructions" => "Optional note below hours",
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

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_departments_group",
        "title" => "Departments",
        "fields" => [
            [
                "label" => "Departments",
                "name" => "departments",
                "type" => "repeater",
                "layout" => "block",
                "button_label" => "Add Department",
                "sub_fields" => [
                    [
                        "label" => "Image",
                        "name" => "image",
                        "type" => "image",
                        "return_format" => "array",
                    ],
                    [
                        "label" => "Title",
                        "name" => "title",
                        "type" => "text",
                    ],
                    [
                        "label" => "Description",
                        "name" => "description",
                        "type" => "textarea",
                    ],
                    [
                        "label" => "Background Color",
                        "name" => "background_color",
                        "type" => "color_picker",
                    ],
                    [
                        "label" => "Link",
                        "name" => "link",
                        "type" => "link",
                    ],
                ],
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

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_products_group",
        "title" => "Popular Products",
        "fields" => [
            [
                "label"        => "Products",
                "name"         => "products",
                "type"         => "repeater",
                "layout"       => "block",
                "button_label" => "Add Product",
                "sub_fields"   => [
                    [
                        "label"         => "Image",
                        "name"          => "image",
                        "type"          => "image",
                        "return_format" => "array",
                    ],
                    [
                        "label" => "Title",
                        "name"  => "title",
                        "type"  => "text",
                    ],
                    [
                        "label" => "Description",
                        "name"  => "description",
                        "type"  => "textarea",
                        "rows"  => 3,
                    ],
                    [
                        "label" => "Link",
                        "name"  => "link",
                        "type"  => "link",
                    ],
                ],
            ],
        ],
        "location" => [
            [
                [
                    "param"    => "post_type",
                    "operator" => "==",
                    "value"    => $post_type,
                ],
            ],
        ],
    ]);

    ACFComposer::registerFieldGroup([
        "name"  => $post_type . "_testimonials_group",
        "title" => "Customer Testimonials",
        "fields" => [
            [
                "label" => "View All Link",
                "name"  => "view_all_link",
                "type"  => "link",
            ],
            [
                "label"        => "Testimonials",
                "name"         => "testimonials",
                "type"         => "repeater",
                "layout"       => "block",
                "button_label" => "Add Testimonial",
                "sub_fields"   => [
                    [
                        "label"         => "Photo",
                        "name"          => "photo",
                        "type"          => "image",
                        "return_format" => "array",
                    ],
                    [
                        "label" => "Name",
                        "name"  => "name",
                        "type"  => "text",
                    ],
                    [
                        "label" => "Role / Title",
                        "name"  => "role",
                        "type"  => "text",
                    ],
                    [
                        "label"         => "Rating (1-5)",
                        "name"          => "rating",
                        "type"          => "number",
                        "min"           => 1,
                        "max"           => 5,
                        "default_value" => 5,
                    ],
                    [
                        "label" => "Review",
                        "name"  => "review",
                        "type"  => "textarea",
                        "rows"  => 3,
                    ],
                ],
            ],
        ],
        "location" => [
            [
                [
                    "param"    => "post_type",
                    "operator" => "==",
                    "value"    => $post_type,
                ],
            ],
        ],
    ]);

    ACFComposer::registerFieldGroup([
        "name"  => $post_type . "_faq_group",
        "title" => "FAQ Section",
        "fields" => [
            [
                "label" => "Eyebrow Text",
                "name"  => "eyebrow",
                "type"  => "text",
            ],
            [
                "label"        => "FAQ Items",
                "name"         => "faqs",
                "type"         => "repeater",
                "layout"       => "block",
                "button_label" => "Add FAQ Item",
                "sub_fields"   => [
                    [
                        "label" => "Question",
                        "name"  => "question",
                        "type"  => "text",
                    ],
                    [
                        "label" => "Answer",
                        "name"  => "answer",
                        "type"  => "textarea",
                        "rows"  => 4,
                    ],
                ],
            ],
        ],
        "location" => [
            [
                [
                    "param"    => "post_type",
                    "operator" => "==",
                    "value"    => $post_type,
                ],
            ],
        ],
    ]);

    ACFComposer::registerFieldGroup([
        "name"  => $post_type . "_consultation_group",
        "title" => "Consultation CTA",
        "fields" => [
            [
                "label" => "Heading",
                "name"  => "heading",
                "type"  => "text",
            ],
            [
                "label" => "Description (first paragraph)",
                "name"  => "description_1",
                "type"  => "textarea",
                "rows"  => 3,
            ],
            [
                "label" => "Description (second paragraph)",
                "name"  => "description_2",
                "type"  => "textarea",
                "rows"  => 3,
            ],
            [
                "label" => "Primary Button",
                "name"  => "primary_button",
                "type"  => "link",
            ],
            [
                "label" => "Secondary Button",
                "name"  => "secondary_button",
                "type"  => "link",
            ],
            [
                "label"         => "Image",
                "name"          => "consultation_image",
                "type"          => "image",
                "return_format" => "array",
            ],
        ],
        "location" => [
            [
                [
                    "param"    => "post_type",
                    "operator" => "==",
                    "value"    => $post_type,
                ],
            ],
        ],
    ]);

    ACFComposer::registerFieldGroup([
        "name" => $post_type . "_staff_group",
        "title" => "Location Staff",
        "fields" => [
            // [
            //     'label' => 'Managers',
            //     'name' => 'managers',
            //     'type' => 'repeater',
            //     'layout' => 'block',
            //     'button_label' => 'Add Manager',
            //     'sub_fields' => FieldVariables\getManagerParts()
            // ],
            [
                "label" => "Staff Members",
                "name" => "staff",
                "type" => "repeater",
                "layout" => "block",
                "button_label" => "Add Staff Member",
                "sub_fields" => FieldVariables\getStaffParts(),
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

    Options::addTranslatable(
        "LocationLabels",
        [
            FieldVariables\getTab("Hero"),
            [
                "label" => "Eyebrow",
                "name" => "eyebrow_label",
                "type" => "text",
                "default_value" => 'Coburn\'s Kitchen & Bath Showroom',
            ],
            [
                "label" => "Address",
                "name" => "address_label",
                "type" => "text",
                "default_value" => "Address",
            ],
            [
                "label" => "Phone",
                "name" => "phone_label",
                "type" => "text",
                "default_value" => "Phone",
            ],
            [
                "label" => "Fax",
                "name" => "fax_label",
                "type" => "text",
                "default_value" => "Fax",
            ],
            [
                "label" => "Manager",
                "name" => "manager_label_singular",
                "type" => "text",
                "default_value" => "Showroom Manager",
            ],
            [
                "label" => "Managers",
                "name" => "manager_label_plural",
                "type" => "text",
                "default_value" => "Showroom Managers",
            ],
            [
                "label" => "Social",
                "name" => "social_label",
                "type" => "text",
                "default_value" => "Find Us On Social",
            ],
            [
                "label" => "Hours",
                "name" => "hours_label",
                "type" => "text",
                "default_value" => "Showroom Hours",
            ],
            [
                "name" => "year_opened_label",
                "label" => "Year Opened Label",
                "type" => "text",
                "default_value" => "Open Since",
            ],
            FieldVariables\getTab("Staff"),
            [
                "name" => "staff_bio_collapse_label",
                "label" => "Staff Member Bio Collapse Label",
                "type" => "text",
                "default_value" => "Bio",
            ],
            [
                "name" => "staff_bio_collapse_open_label",
                "label" => "Staff Member Bio Collapse Open Prefix",
                "type" => "text",
                "default_value" => "Read",
                "append" => "Bio",
            ],
            [
                "name" => "staff_bio_collapse_close_label",
                "label" => "Staff Member Bio Collapse Close Prefix",
                "type" => "text",
                "default_value" => "Close",
                "append" => "Bio",
            ],
        ],
        "Locations"
    );

    Options::addTranslatable(
        "LocationDefaults",
        [
            FieldVariables\getTab("Hero"),
            [
                "name" => "location_hero_default",
                "label" => "",
                "type" => "group",
                "sub_fields" => [
                    [
                        "label" => "Hero Intro",
                        "name" => "intro",
                        "type" => "wysiwyg",
                        "toolbar" => "full",
                        "media_upload" => false,
                        "delay" => 1,
                        "default_value" => "",
                        "instructions" => "Insert {location_name} where you want the location's name to appear.",
                    ],
                    [
                        "name" => "virtual_tour_link_text",
                        "label" => "Virtual Tour Link Text",
                        "type" => "text",
                        "default_value" => "Take the Tour",
                    ],
                ],
            ],
            FieldVariables\getTab("Staff"),
            [
                "name" => "staff_section_headings_default",
                "label" => "Section Headings",
                "type" => "group",
                "sub_fields" => [
                    FieldVariables\getHeadingLoop(
                        $instructions =
                            "<strong>Defaults</strong><br/>tag: h2, style: minimal-1 <br/>tag: div, style: display-1"
                    ),
                    [
                        "label" => "Intro Content",
                        "name" => "intro",
                        "type" => "wysiwyg",
                        "toolbar" => "full",
                        "media_upload" => false,
                        "delay" => 1,
                        "default_value" => "",
                        "instructions" => "",
                    ],
                ],
            ],
            FieldVariables\getTab("Offerings"),
            [
                "name" => "location_offerings_default",
                "label" => "",
                "type" => "group",
                "sub_fields" => [
                    FieldVariables\getHeadingLoop(
                        $instructions =
                            "<strong>Defaults</strong><br/>tag: h1, style: minimal 1<br/>tag: div, style: display 1"
                    ),
                    FieldVariables\getSectionContent_1(),
                    array_merge(FieldVariables\getSectionContent_2(), [
                        "label" => "Listing",
                        "instructions" => "Enter only lists.",
                    ]),
                ],
            ],
            FieldVariables\getTab("Features"),
            [
                "name" => "location_features_default",
                "label" => "Features Section Defaults",
                "type" => "group",
                "sub_fields" => [
                    FieldVariables\getHeadingLoop(
                        $instructions =
                            "<strong>Defaults</strong><br/>tag: h2, style: minimal-1<br/>tag: div, style: display-1"
                    ),
                ],
            ],
            FieldVariables\getTab("Departments"),
            [
                "name" => "location_departments_default",
                "label" => "Departments Section Defaults",
                "type" => "group",
                "sub_fields" => [
                    FieldVariables\getHeadingLoop(
                        $instructions =
                            "<strong>Defaults</strong><br/>tag: h2, style: minimal-1<br/>tag: div, style: display-1"
                    ),
                ],
            ],
            FieldVariables\getTab("Map"),
            [
                "name" => "location_map_default",
                "label" => "Map Section Defaults",
                "type" => "group",
                "sub_fields" => [
                    FieldVariables\getHeadingLoop(
                        $instructions =
                            "<strong>Defaults</strong><br/>tag: h2, style: minimal-1<br/>tag: div, style: display-1"
                    ),
                ],
            ],
            FieldVariables\getTab("CTA"),
            [
                "name" => "location_cta_default",
                "label" => "CTA Section Defaults",
                "type" => "group",
                "sub_fields" => [
                    [
                        "label" => "Heading",
                        "name" => "heading",
                        "type" => "text",
                        "default_value" => "Find luxury kitchen and bath fixtures near {location_name}.",
                    ],
                ],
            ],
        ],
        "Locations"
    );
}
