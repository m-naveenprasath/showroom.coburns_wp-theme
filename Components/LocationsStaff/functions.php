<?php

namespace Flynt\Components\LocationsStaff;

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
        ["jquery", "bootstrap"],
        filemtime(get_stylesheet_directory() . $js_path),
        true
    );
});

add_filter(
    "Flynt/renderComponent",
    function ($output, $componentName) {
        if ($componentName == "LocationsStaff") {
            wp_enqueue_script($componentName);
        }

        return $output;
    },
    10,
    3
);

add_filter("Flynt/addComponentData?name=LocationsStaff", function ($data) {
    if ($fields = get_fields()) {
        unset($fields["pageComponents"]);
        $data = array_merge($data, $fields);
    }

    if ($options = Options::getTranslatable("LocationLabels")) {
        $data = array_merge($data, $options);
    }
    if ($options = Options::getTranslatable("LocationDefaults")) {
        $data = array_merge($data, $options);
    }

    return $data;
});
