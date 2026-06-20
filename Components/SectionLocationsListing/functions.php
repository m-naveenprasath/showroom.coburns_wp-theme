<?php

namespace Flynt\Components\SectionLocationsListing;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

const POST_TYPE = "locations";

add_filter("Flynt/addComponentData?name=SectionLocationsListing", function ($data) {
    $postType = POST_TYPE;

    $locations = [];
    $location_posts = Timber::get_posts([
        "orderby" => "post_name",
        "order" => "ASC",
        "post_status" => "publish",
        "post_type" => $postType,
        "posts_per_page" => -1,
    ]);

    $flamedrop_data = flamedrop_fetch_api_data();
    foreach ($location_posts as $location) {
        if (isset($location->{'flamedrop_branch_id'})) {
            $id = $location->flamedrop_branch_id;
            foreach ($flamedrop_data[$id] as $key => $value) {
                if (!empty($value)) {
                    $location->import([$key => $value], true); // 'true' overwrites WP data with Flamedrop data
                }
            }
        }
        $locations[] = $location;
    }

    $data["locations"] = $locations;

    if ($labels = Options::getTranslatable("LocationLabels")) {
        $data = array_merge($data, $labels);
    }

    if ($labels = Options::getTranslatable("LocationsListingLabels")) {
        $data = array_merge($data, $labels);
    }

    wp_enqueue_script("google-map");

    wp_enqueue_script("location-sort");

    return $data;
});

function getACFLayout()
{
    return [
        "label" => "Locations: Map / Listing",
        "name" => "SectionLocationsListing",
        "sub_fields" => [
            FieldVariables\getTab("Content"),
            FieldVariables\getHeadingLoop(
                $instructions = "<strong>Defaults</strong><br/>tag: h1, style: minimal-1<br/>tag: div, style: display 1"
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
Options::addTranslatable(
    "LocationsListingLabels",
    [
        FieldVariables\getTab("Map"),
        [
            "label" => "Location Search Field Placeholder Text",
            "name" => "location_search_field_placeholder_label",
            "type" => "text",
            "default_value" => "Enter City, State or Zip Code",
        ],
        [
            "label" => '"Use My Location" Button Text',
            "name" => "location_search_button_label",
            "type" => "text",
            "default_value" => "Find Locations Near Me",
        ],
        [
            "label" => '"No Locations Found" Headline',
            "name" => "no_locations_found_headline",
            "type" => "text",
            "default_value" => "No Locations Found",
        ],
        [
            "label" => '"No Locations Found" Content',
            "name" => "no_locations_found_content",
            "type" => "textarea",
            "default_value" =>
                "There are no Coburn’s Supply or Coburn’s Kitchen & Bath Showrooms within 100 miles of this location.",
        ],
        [
            "label" => '"No Locations Found" Reset Button Text',
            "name" => "location_reset_button_label",
            "type" => "text",
            "default_value" => "Show All Locations",
        ],
        FieldVariables\getTab("Table"),
        [
            "label" => '"View Location Information" Button Text',
            "name" => "location_view_info_button_label",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [
                [
                    "label" => "Before",
                    "name" => "before",
                    "type" => "text",
                    "default_value" => "View",
                ],
                [
                    "label" => "",
                    "name" => "message",
                    "type" => "message",
                    "message" => "<location name>",
                ],
                [
                    "label" => "After",
                    "name" => "after",
                    "type" => "text",
                    "default_value" => "Location Information",
                ],
            ],
        ],
        [
            "label" => '"Get Directions" Button Text',
            "name" => "location_directions_button_label",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [
                [
                    "label" => "Before",
                    "name" => "before",
                    "type" => "text",
                    "default_value" => "Get Directions to",
                ],
                [
                    "label" => "",
                    "name" => "message",
                    "type" => "message",
                    "message" => "<location name>",
                ],
                [
                    "label" => "After",
                    "name" => "after",
                    "type" => "text",
                    "default_value" => "Showroom",
                ],
            ],
        ],
        [
            "label" => '"Schedule Appointment" Button Text',
            "name" => "location_appointment_button_label",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [
                [
                    "label" => "Before",
                    "name" => "before",
                    "type" => "text",
                    "default_value" => "Schedule Appointment at",
                ],
                [
                    "label" => "",
                    "name" => "message",
                    "type" => "message",
                    "message" => "<location name>",
                ],
                [
                    "label" => "After",
                    "name" => "after",
                    "type" => "text",
                    "default_value" => "Showroom",
                ],
            ],
        ],
    ],
    "Locations"
);
