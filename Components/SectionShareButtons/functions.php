<?php

namespace Flynt\Components\SectionShareButtons;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=SectionShareButtons', function ($data) {
    $data['socialmedia'] = Options::getTranslatable('SocialMediaSharing');

    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Style Finder: Share Buttons',
        'name' => 'SectionShareButtons',
        'sub_fields' => [
		    FieldVariables\getTab("Share"),
            FieldVariables\getShareWithToggle($default_visibility = true),
	        [
	            'label' => 'Icon Position',
	            'name' => 'iconPosition',
	            'type' => 'select',
	            'choices' => [
	                'left' => 'Left',
	                'right' => 'Right',
	            ],
	            'default_value' => 'left',
	        ],
            FieldVariables\getShareWithHeading(),
            FieldVariables\getShareWithAccounts($default_visibility = true),
            FieldVariables\getShareWithTwitter(),
            FieldVariables\getTab("Options"),
            FieldVariables\getSectionBackgroundSelect(),
        ]
    ];
}
