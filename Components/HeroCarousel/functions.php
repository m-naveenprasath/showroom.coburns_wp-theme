<?php

namespace Flynt\Components\HeroCarousel;

use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter("Flynt/addComponentData?name=HeroCarousel", function ($data) {
    if ($labels = Options::getTranslatable("StyleLabels")) {
        $data = array_merge($data, $labels);
    }

    return $data;
});

add_filter(
    "Flynt/renderComponent",
    function ($output, $componentName) {
        if ($componentName == "HeroCarousel") {
            wp_enqueue_script("carousel");
        }

        return $output;
    },
    10,
    3
);
