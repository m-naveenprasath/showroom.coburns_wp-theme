<?php

namespace Flynt\Components\StyleHero;

use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=StyleHero', function ($data) {
    if ($fields = get_field('hero')) {
        $data = array_merge($data, $fields);
    }

    if ($labels = Options::getTranslatable('StyleLabels')) {
        $data = array_merge($data, $labels);
    }

    return $data;
});
