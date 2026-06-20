<?php

/**
 * Defines field variables to be used across multiple components.
 */

namespace Flynt\FieldVariables;

function getMessage($message = "")
{
    return [
        "label" => "",
        "name" => preg_replace("/[^a-zA-Z0-9]+/", "", $message) . "Message",
        "type" => "message",
        "message" => $message,
    ];
}

function getTab($name)
{
    return [
        "label" => $name,
        "name" => preg_replace("/[^a-zA-Z0-9]+/", "", $name) . "Tab",
        "type" => "tab",
        "placement" => "top",
        "endpoint" => 0,
    ];
}

function getHeadingParts($required = true, $included_fields = ["tag", "text", "style", "size"])
{
    $fields = [];

    if (in_array("tag", $included_fields)) {
        $fields[] = [
            "name" => "tag",
            "label" => "Tag",
            "type" => "select",
            "choices" => [
                "h1" => "h1",
                "h2" => "h2",
                "h3" => "h3",
                "h4" => "h4",
                "h5" => "h5",
                "h6" => "h6",
                "p" => "p",
                "div" => "div",
            ],
            "default_value" => "h2",
            "instructions" => "A page should only have one h1 tag.",
        ];
    }
    if (in_array("text", $included_fields)) {
        $fields[] = [
            "name" => "text",
            "label" => "Text",
            "type" => "text",
            "required" => $required,
            "wrapper" => [
                "width" => "35%",
            ],
            "instructions" => "Use normal case. Uppercase is applied automatically.",
        ];
    }
    if (in_array("style", $included_fields)) {
        $fields[] = [
            "name" => "style",
            "label" => "Style",
            "type" => "select",
            "choices" => [
                "" => "Default",
                "display-1" => "Display 1",
                "display-2" => "Display 2",
                "subhead" => "Subhead",
                "body" => "Body",
                "minimal-1" => "Minimal 1",
                "minimal-2" => "Minimal 2",
                "minimal-body" => "Minimal Body",
            ],
            "default_value" => "",
        ];
    }
    if (in_array("size", $included_fields)) {
        $fields[] = [
            "name" => "size",
            "label" => "Size",
            "type" => "select",
            "choices" => [
                "" => "Auto",
                "h1" => "h1",
                "h2" => "h2",
                "h3" => "h3",
                "h4" => "h4",
                "h5" => "h5",
                "h6" => "h6",
            ],
            "default_value" => "",
        ];
    }
    if (in_array("color", $included_fields)) {
        $fields[] = [
            "name" => "color",
            "label" => "Color",
            "type" => "select",
            "choices" => [
                "" => "Default",
                "gray" => "gray",
                "gray-light" => "gray-light",
                "blue" => "blue",
                "blue-light" => "blue-light",
                "blue-dark" => "blue-dark",
                "teal" => "teal",
                "brown-light" => "brown-light",
                "brown-dark" => "brown-dark",
            ],
            "default_value" => "",
        ];
    }

    return $fields;
}

function getHeading($instructions = "")
{
    return [
        [
            "label" => "Heading",
            "name" => "heading",
            "type" => "group",
            "layout" => "table",
            "sub_fields" => [getHeadingParts()],
            "instructions" => $instructions,
        ],
    ];
}

function getHeadingLoop($instructions = "")
{
    return [
        "label" => "Headings",
        "name" => "headings",
        "type" => "repeater",
        "collapsed" => "text",
        "layout" => "table",
        "button_label" => "Add Heading",
        "sub_fields" => [getHeadingParts()],
        "instructions" => $instructions,
    ];
}

function getSectionIDField()
{
    return [
        "label" => "Section ID Attribute",
        "name" => "component_ID",
        "type" => "text",
        "instruction" => "Use for anchor links or tracking. IDs must be unique per page.",
    ];
}

function getSectionBackgroundSelect()
{
    return [
        "label" => "Background",
        "name" => "sectionBackground",
        "type" => "select",
        "choices" => [
            "white" => "White",
            "stripes" => "Stripes",
            "texture" => "Texture",
        ],
        "default_value" => "white",
    ];
}
function getSectionTextAlignSelect($default = "")
{
    return [
        "label" => "Text Align",
        "name" => "sectionTextAlign",
        "type" => "select",
        "choices" => [
            "" => "Default",
            "left" => "Left",
            "center" => "Center",
        ],
        "default_value" => $default,
    ];
}
function getSectionPaddingSelect($default = "")
{
    return [
        "label" => "Padding",
        "name" => "sectionPadding",
        "type" => "select",
        "choices" => [
            "" => "Default",
            // '5' => '5',
            // '4' => '4',
            // '3' => '3',
            // '2' => '2',
            // '1' => '1',
            "0" => "Full Bleed",
        ],
        "default_value" => $default,
    ];
}

function getFeaturedImageToggle($default = true)
{
    return [
        "label" => "Featured / Hero Image",
        "name" => "featuredImage_show",
        "type" => "true_false",
        "default_value" => $default,
        "ui" => 1,
        "ui_on_text" => "Show",
        "ui_off_text" => "Hide",
    ];
}
function getAdditionalImagesToggle($default = true)
{
    return [
        "label" => "Additional Featured Images",
        "name" => "additionalImages_show",
        "type" => "true_false",
        "default_value" => $default,
        "ui" => 1,
        "ui_on_text" => "Show",
        "ui_off_text" => "Hide",
    ];
}
function getBreadcrumbToggle($default = true)
{
    return [
        "label" => "Breadcrumb Trail",
        "name" => "breadcrumbTrail_show",
        "type" => "true_false",
        "default_value" => $default,
        "ui" => 1,
        "ui_on_text" => "Show",
        "ui_off_text" => "Hide",
    ];
}

function getSectionContent_1()
{
    return [
        "label" => "Section Text 1",
        "name" => "sectionHtml_1",
        "type" => "wysiwyg",
        "toolbar" => "full",
        "media_upload" => false,
        "delay" => 1,
    ];
}
function getSectionContent_2()
{
    return [
        "label" => "Section Text 2",
        "name" => "sectionHtml_2",
        "type" => "wysiwyg",
        "toolbar" => "full",
        "media_upload" => false,
        "delay" => 1,
    ];
}

function getSectionContent_3()
{
    return [
        "label" => "Section Text 3",
        "name" => "sectionHtml_3",
        "type" => "wysiwyg",
        "toolbar" => "full",
        "media_upload" => false,
        "delay" => 1,
    ];
}

// Deprecated, but here for accessing/editing old data. Repeater version is located under getSocialMediaAccounts
function getSocialMedia()
{
    return [
        [
            "label" => "Facebook",
            "name" => "Facebook",
            "type" => "url",
        ],
        [
            "label" => "Google Business",
            "name" => "Google",
            "type" => "url",
        ],
        [
            "label" => "Instagram",
            "name" => "Instagram",
            "type" => "url",
        ],
        [
            "label" => "LinkedIn",
            "name" => "LinkedIn",
            "type" => "url",
        ],
        [
            "label" => "Pinterest",
            "name" => "Pinterest",
            "type" => "url",
        ],
        [
            "label" => "Twitter",
            "name" => "Twitter",
            "type" => "url",
        ],
        [
            "label" => "Youtube",
            "name" => "Youtube",
            "type" => "url",
        ],
    ];
}

// This is a fancier way to add/access new social media info. Old way is under getSocialMedia
function getSocialMediaAccounts()
{
    return [
        [
            "name" => "service",
            "label" => "Service",
            "type" => "select",
            "return_format" => "array",
            "choices" => [
                "" => "",
                "facebook" => "Facebook",
                "google-business" => "Google Business",
                "houzz" => "Houzz",
                "instagram" => "Instagram",
                "linkedin" => "LinkedIn",
                "pinterest" => "Pinterest",
                "twitter" => "Twitter",
                "youtube" => "Youtube",
            ],
            "allow_null" => 0,
            "ui" => 1,
            "placeholder" => "Select Service",
        ],
        [
            "name" => "url",
            "label" => "URL",
            "type" => "url",
            "wrapper" => [
                "width" => "50%",
            ],
        ],
        [
            "name" => "username",
            "label" => "Username",
            "type" => "text",
        ],
    ];
}

function getButtonParts(
    $required = true,
    $default_values = [],
    $included_fields = ["text", "link", "style", "color", "icon", "iconPosition"]
) {
    $defaults = ["color" => "primary", "style" => "", "icon" => "", "iconPosition" => "left"];
    if (is_array($default_values) && !empty($default_values)) {
        $defaults = array_merge($defaults, $default_values);
    }

    $fields = [];

    if (in_array("text", $included_fields)) {
        $fields[] = [
            "label" => "Text",
            "name" => "text",
            "type" => "text",
            "wrapper" => [
                "width" => "20",
            ],
            "required" => $required,
        ];
    }
    if (in_array("link", $included_fields)) {
        $fields[] = [
            "label" => "Link",
            "name" => "link",
            "type" => "link",
            "wrapper" => [
                "width" => "30",
            ],
            "required" => $required,
            "instructions" =>
                '"Link Text" is optional and used for a more detailed accessible label.<br/><br/> Example: If the visible text is a generic "Learn More", the link text should be "Learn More About This Specific Thing".',
        ];
    }
    if (in_array("color", $included_fields)) {
        $fields[] = [
            "label" => "Color",
            "name" => "color",
            "type" => "select",
            "choices" => [
                "" => "Auto",
                "primary" => "Teal (Primary)",
                "blue" => "Blue",
                "blue-light" => "Light Blue",
                "blue-dark" => "Dark Blue",
                "black" => "Black",
            ],
            "default_value" => $defaults["color"],
        ];
    }
    if (in_array("style", $included_fields)) {
        $fields[] = [
            "label" => "Style",
            "name" => "style",
            "type" => "select",
            "choices" => [
                "" => "Solid",
                "outline" => "Outline",
                "link" => "Link",
            ],
            "default_value" => $defaults["style"],
        ];
    }
    if (in_array("icon", $included_fields)) {
        $fields[] = [
            "label" => "Icon",
            "name" => "icon",
            "type" => "select",
            "choices" => getIcons(),
            "default_value" => $defaults["icon"],
        ];
    }
    if (in_array("iconPosition", $included_fields)) {
        $fields[] = [
            "label" => "Icon Position",
            "name" => "iconPosition",
            "type" => "select",
            "choices" => [
                "left" => "Left",
                "right" => "Right",
            ],
            "default_value" => $defaults["iconPosition"],
            // There's a bug that prevents this from working. Try again one day?
            // "conditional_logic" => [
            //     "fieldPath" => "icon",
            //     "operator" => "!=empty",
            // ],
        ];
    }

    return $fields;
}

function getButton($instructions = "", $required = true)
{
    return [
        "label" => "Button",
        "name" => "button",
        "type" => "group",
        "collapsed" => "text",
        "layout" => "table",
        "sub_fields" => [getButtonParts($required)],
        "instructions" => $instructions,
    ];
}

function getButtonLoop($limit = "", $required = true, $accent_line = true, $instructions = "")
{
    $array = [
        [
            "label" => "Buttons",
            "name" => "buttons",
            "type" => "repeater",
            "collapsed" => "text",
            "layout" => "table",
            "button_label" => "Add Button",
            "sub_fields" => [getButtonParts($required)],
            "max" => $limit,
            "instructions" => $instructions,
        ],
    ];

    if ($accent_line == true) {
        $array[] = [
            "label" => "Buttons - Accent Line",
            "name" => "navigational",
            "type" => "select",
            "layout" => "table",
            "choices" => [
                "" => "None",
                "previous" => "Before",
                "next" => "After",
            ],
            "default_value" => "",
        ];
    }

    return $array;
}

function getImage()
{
    return [
        "label" => "Image",
        "name" => "image",
        "type" => "image",
        "return_format" => "array",
    ];
}

function getCarousel()
{
    return [
        "label" => "Carousel",
        "name" => "carousel",
        "type" => "repeater",
        "sub_fields" => [
            [
                "label" => "",
                "name" => "image",
                "type" => "image",
                "return_format" => "array",
            ],
        ],
        "button_label" => "Add Image",
    ];
}

function getCarouselToggle($default = true)
{
    return [
        "label" => "Carousel",
        "name" => "carousel_active",
        "type" => "true_false",
        "default_value" => $default,
        "ui" => 1,
        "ui_on_text" => "Enabled",
        "ui_off_text" => "Disabled",
    ];
}

function getMediaSwitcher($choices = ["none" => "None", "image" => "Image", "map" => "Map", "video" => "Video"])
{
    return [
        "label" => "Media",
        "name" => "media",
        "type" => "group",
        "layout" => "block",
        "sub_fields" => [
            [
                "label" => "Type",
                "name" => "type",
                "type" => "select",
                "required" => 1,
                "choices" => $choices,
                "default_value" => "none",
                "wrapper" => [
                    "width" => "50%",
                ],
            ],
            [
                "label" => "Position",
                "name" => "position",
                "type" => "select",
                "choices" => [
                    "" => "Auto",
                    "left" => "Left",
                    "right" => "Right",
                ],
                "default_value" => "",
                "wrapper" => [
                    "width" => "50%",
                ],
            ],
            [
                "label" => "Image",
                "name" => "image",
                "type" => "image",
                "return_format" => "array",
                "conditional_logic" => [
                    [
                        [
                            "fieldPath" => "type",
                            "operator" => "==",
                            "value" => "image",
                        ],
                    ],
                ],
            ],
            [
                "label" => "Map URL",
                "name" => "map_url",
                "type" => "url",
                "instructions" => "An embed URL from Google Maps.",
                "conditional_logic" => [
                    [
                        [
                            "fieldPath" => "type",
                            "operator" => "==",
                            "value" => "map",
                        ],
                    ],
                ],
            ],
            [
                "label" => "Video URL",
                "name" => "video_url",
                "type" => "url",
                "instructions" =>
                    "A video URL, probably from YouTube or Vimeo. Currently only supports 16:9 aspect ratio.",
                "conditional_logic" => [
                    [
                        [
                            "fieldPath" => "type",
                            "operator" => "==",
                            "value" => "video",
                        ],
                    ],
                ],
            ],
        ],
    ];
}

function getManagerParts()
{
    return [
        [
            "label" => "Name",
            "name" => "name",
            "type" => "text",
        ],
        [
            "label" => "Title",
            "name" => "title",
            "type" => "text",
        ],
    ];
}
function getStaffParts()
{
    return [
        [
            "label" => "Name",
            "name" => "name",
            "type" => "text",
        ],
        [
            "label" => "Title",
            "name" => "title",
            "type" => "text",
        ],
        [
            "label" => "Bio",
            "name" => "bio",
            "type" => "wysiwyg",
            "toolbar" => "basic",
            "media_upload" => false,
        ],
    ];
}

function getButtonHeading($instructions = "")
{
    return [
        "label" => "Button Heading",
        "name" => "buttonHeading",
        "type" => "group",
        "layout" => "table",
        "sub_fields" => [getHeadingParts($required = false)],
        "instructions" => $instructions,
    ];
}

function getButtonHeadingLoop($instructions = "")
{
    return [
        "label" => "Button Headings",
        "name" => "buttonHeading",
        "type" => "repeater",
        "collapsed" => "text",
        "layout" => "table",
        "button_label" => "Add Heading",
        "sub_fields" => [getHeadingParts()],
        "instructions" => $instructions,
    ];
}

function getShareWithToggle($default_visibility = false)
{
    return [
        "label" => "Show Share Links",
        "name" => "shareWith_show",
        "type" => "true_false",
        "default_value" => $default_visibility,
        "ui" => 1,
        "ui_on_text" => "Show",
        "ui_off_text" => "Hide",
    ];
}

function getShareWithHeading($instructions = "")
{
    return [
        "label" => "Share Heading",
        "name" => "shareWithHeading",
        "type" => "group",
        "layout" => "table",
        "sub_fields" => [getHeadingParts($required = false)],
        "instructions" => $instructions,
    ];
}

function getShareWithAccounts($default_visibility = false)
{
    return [
        "label" => "Share Accounts",
        "name" => "shareWith",
        "type" => "group",
        "layout" => "table",
        "sub_fields" => [
            [
                "label" => "Facebook",
                "name" => "Facebook",
                "type" => "true_false",
                "default_value" => $default_visibility,
            ],
            [
                "label" => "LinkedIn",
                "name" => "LinkedIn",
                "type" => "true_false",
                "default_value" => $default_visibility,
            ],
            [
                "label" => "Twitter",
                "name" => "Twitter",
                "type" => "true_false",
                "default_value" => $default_visibility,
            ],
            [
                "label" => "Pinterest",
                "name" => "Pinterest",
                "type" => "true_false",
                "default_value" => $default_visibility,
            ],
            [
                "label" => "Email",
                "name" => "Email",
                "type" => "true_false",
                "default_value" => $default_visibility,
            ],
        ],
    ];
}

function getShareWithTwitter()
{
    return [
        "label" => "Twitter Share Options",
        "name" => "shareWithTwitter",
        "type" => "group",
        "layout" => "row",
        "sub_fields" => [
            [
                "name" => "account",
                "label" => "Twitter Account",
                "type" => "text",
                "instructions" => 'says "via @account" when user tweets.',
                "prepend" => "@",
                "default_value" => "",
            ],
            [
                "name" => "hashtags",
                "label" => "Twitter Hashtags",
                "type" => "text",
                "instructions" => "Hashtags, separated by commas. Alphanumeric characters only.",
                "default_value" => "",
            ],
        ],
    ];
}

function getIcons()
{
    return [
        "" => "None",
        "arrow" => "Arrow",
        "chat" => "Chat",
        "check" => "Check",
        "coburns" => "Coburns",
        "email" => "Email",
        "eye" => "Eye",
        "facebook" => "Facebook",
        "houzz" => "Houzz",
        "instagram" => "Instagram",
        "link" => "Link",
        "linkedin" => "LinkedIn",
        "location" => "Location",
        "person" => "Person",
        "pinterest" => "Pinterest",
        "phone" => "Phone",
        "twitter" => "Twitter",
        "youtube" => "Youtube",
    ];
}

function getImageLinksParts($required = true,$included_fields = ["image", "link"]){
    $fields = [];

    if (in_array("image", $included_fields)) {
        $fields[] = [
            "label" => "Image",
            "name" => "image",
            "type" => "image",
            "required" => $required,
        ];
    }
    if (in_array("link", $included_fields)) {
        $fields[] = [
            "label" => "Link",
            "name" => "link",
            "type" => "link",
            "wrapper" => [
                "width" => "30",
            ],
            "required" => $required,
            "instructions" =>
                '"Link Text" is optional and used for a more detailed accessible label.<br/><br/> Example: If the visible text is a generic "Learn More", the link text should be "Learn More About This Specific Thing".',
        ];
    }
    return $fields;
}

function getImageLinksLoop($limit = "",$required = true,$instructions = ""){
    $array = [
        [
            "label" => "Images",
            "name" => "imagesLinks",
            "type" => "repeater",
            "collapsed" => "text",
            "layout" => "table",
            "button_label" => "Add Image",
            "sub_fields" => [getImageLinksParts($required)],
            "max" => $limit,
            "instructions" => $instructions,
        ],
    ];
    return $array;
}

function getVideoType($choices = ["video-mp4" => "Video-MP4", "video-youtube" => "YouTube"])
{
    return [
        "label" => "Hero Video",
        "name" => "heroVideo",
        "type" => "group",
        "layout" => "block",
        "sub_fields" => [
            [
                "label" => "Show Video Section",
                "name" => "videoSection_show",
                "type" => "true_false",
                "default_value" => false,
                "ui" => 1,
                "ui_on_text" => "Show",
                "ui_off_text" => "Hide",
            ],
            [
                "label" => "Type",
                "name" => "type",
                "type" => "select",
                "required" => 1,
                "choices" => $choices,
                "default_value" => "video-youtube",
            ],

            [
                "label" => "Video URL",
                "name" => "video_url",
                "type" => "url",
                "instructions" =>
                    "Enter the URL of the video you want to display in MP4 FORMAT. . Currently only supports 16:9 aspect ratio.",
                "conditional_logic" => [
                    [
                        [
                            "fieldPath" => "type",
                            "operator" => "==",
                            "value" => "video-mp4",
                        ],
                    ],
                ],
            ],

            [
                "label" => "YouTube Video ID",
                "name" => "youTube_video_id",
                "type" => "text",
                "instructions" => "Enter the YouTube video ID. Currently only supports 16:9 aspect ratio.",
                "conditional_logic" => [
                    [
                        [
                            "fieldPath" => "type",
                            "operator" => "==",
                            "value" => "video-youtube",
                        ],
                    ],
                ],
            ],
        ],
    ];
}
