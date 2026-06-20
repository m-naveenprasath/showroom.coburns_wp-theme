<?php

namespace Flynt\Components\SectionExternalFeaturedProducts;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_action("wp_enqueue_scripts", function () {
    $componentNamespace = explode("\\", __NAMESPACE__);
    $componentName = array_pop($componentNamespace);

    $js_path = "/Components/" . $componentName . "/script.js";

    
    wp_register_script(
        $componentName,
        get_stylesheet_directory_uri() . $js_path,
        ['jquery'],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );

});

add_filter(
    "Flynt/renderComponent",
    function ($output, $componentName) {
        if ($componentName == "SectionExternalFeaturedProducts") {
            wp_enqueue_script($componentName);
        }

        return $output;
    },
    10,
    3
);

	


add_filter("Flynt/addComponentData?name=SectionExternalFeaturedProducts", function ($data) {
    if ($labels = Options::getTranslatable("StyleLabels")) {
        $data = array_merge($data, $labels);
    }
    return $data;
});

function getACFLayout()
{
    return [
        "name" => "SectionExternalFeaturedProducts",
        "label" => "Section: External Featured Products",
        "sub_fields" => [
            FieldVariables\getTab("Products"),
            [
                "label" => "Source",
                "name" => "source",
                "type" => "select",
                "default_value" => "cartSync",
                "choices" => [
                    //"americommerce" => "Americommerce",
                    "cartSync" => "CartSync",
                ],
            ],
            [
                "label" => "Filter Name",
                "name" => "filter_name",
                "type" => "text",
                "instructions" => "Add filter Name ex: mid-century , contemporary",
                "conditional_logic" => [
                    [
                        [
                            "fieldPath" => "source",
                            "operator" => "==",
                            "value" => "cartSync",
                        ],
                    ],
                ],
            ],
            [
                "label" => "Filter Type",
                "name" => "filter_type",
                "type" => "text",
                "instructions" => "Add filter Type ex: Style , Brand , Room Space",
                "conditional_logic" => [
                    [
                        [
                            "fieldPath" => "source",
                            "operator" => "==",
                            "value" => "cartSync",
                        ],
                    ],
                ],
                
            ],
            // [
            //     "label" => "AC - Filtered Products",
            //     "name" => "filterProducts",
            //     "type" => "text",
            //     "placeholder" => "",
            //     "instructions" => "Pulls products in from Americommerce based on a... tag? category? something else?",
            //     "conditional_logic" => [
            //         [
            //             [
            //                 "fieldPath" => "source",
            //                 "operator" => "==",
            //                 "value" => "americommerce",
            //             ],
            //         ],
            //     ],
            // ],
            // [
            //     "label" => "Product Card Size",
            //     "name" => "card",
            //     "type" => "select",
            //     "choices" => [
            //         "carousel" => "Carousel",
            //         "small" => "Small Cards",
            //     ],
            //     "conditional_logic" => [
            //         [
            //             [
            //                 "fieldPath" => "source",
            //                 "operator" => "==",
            //                 "value" => "americommerce",
            //             ],
            //         ],
            //     ],
            // ],
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect(),
        ],
    ];
}

Options::addGlobal("SectionExternalFeaturedProducts", [FieldVariables\getSectionBackgroundSelect()], "Sections");
