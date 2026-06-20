<?php

namespace Flynt\Components\BlogSingle;

use Flynt\FieldVariables;
use Flynt\Utils\Options;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=BlogSingle', function ($data) {
    if ($options = Options::getGlobal('BlogSingle')) {
        $data = array_merge($data, $options);
    }
    if ($labels = Options::getTranslatable('BlogSingle')) {
        $data = array_merge($data, $labels);
    }

    return $data;
});

Options::addTranslatable('BlogSingle', [
    [
        'label' => '',
        'name' => 'postNavLabels',
        'type' => 'group',
        'sub_fields' => [
		    [
		        'label' => '"Next" Label',
		        'name' => 'next',
		        'type' => 'text',
		        'default_value' => 'Next Post',
		        'required' => 1,
		    ],
		    [
		        'label' => '"Previous" Label',
		        'name' => 'prev',
		        'type' => 'text',
		        'default_value' => 'Previous Post',
		        'required' => 1,
		    ],
		],
	]
], 'Blog');

