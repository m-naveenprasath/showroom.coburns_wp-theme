<?php

namespace Flynt\Components\LocationsHero;

use Timber\Post;
use Flynt\Utils\Options;
use Flynt\FieldVariables;

add_filter('Flynt/addComponentData?name=LocationsHero', function ($data) {
    if ($location = get_fields()) {
        unset( $location['pageComponents'] );
        $data = array_merge($data, $location);
    }

    if ($options = Options::getTranslatable('LocationLabels')) {
        $data = array_merge($data, $options);
    }
    if ($options = Options::getTranslatable('LocationDefaults')) {
        $data = array_merge($data, $options);
    }

    if (isset($data['flamedrop_branch_id'])) {
        $flamedrop_data = flamedrop_fetch_api_data();
        foreach ($flamedrop_data[$data['flamedrop_branch_id']] as $key => $value) {
            if (!empty($value)) {
                $data[$key] = $value;
            }
        }
    }

    return $data;
});
