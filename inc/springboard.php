<?php

namespace Flynt\Springboard;

use Flynt\ComponentManager;

class AddComponentData
{
    public static function registerHooks()
    {
        add_filter('Flynt/addComponentData', function ($data, $componentName) {
            $data['component_name'] = $componentName;

            return apply_filters(
                "Flynt/addComponentData?name={$componentName}",
                $data,
                $componentName
            );
        }, 10, 2);
    }
}
