<?php

namespace Flynt\Components\SectionShareBadge;

use Flynt\Utils\Options;
use Flynt\FieldVariables;
use Timber\Timber;

add_filter('Flynt/addComponentData?name=SectionShareBadge', function ($data) {
    $data['socialmedia'] = Options::getTranslatable('SocialMediaSharing');

    return $data;
});

function getACFLayout()
{
    return [
        'label' => 'Style Finder: Share Badge',
        'name' => 'SectionShareBadge',
        'sub_fields' => [
		    FieldVariables\getTab("Share"),
            FieldVariables\getShareWithToggle($default_visibility = true),
            FieldVariables\getShareWithHeading($instructions = 'tag: div, size: h4, style: body'),
	        [
	            'label' => 'Shared Text',
	            'name' => 'shareText',
	            'type' => 'text',
				'required' => 1
	        ],
	        [
	            'label' => 'Shared Url',
	            'name' => 'shareUrl',
	            'type' => 'text',
				'required' => 1
	        ],
            FieldVariables\getShareWithAccounts($default_visibility = true),
            FieldVariables\getShareWithTwitter(),
		    FieldVariables\getButtonLoop($limit = 2),
            FieldVariables\getTab("Media"),
            FieldVariables\getImage(),
            FieldVariables\getTab("Options"),
			FieldVariables\getSectionBackgroundSelect(),
        ]
    ];
}
