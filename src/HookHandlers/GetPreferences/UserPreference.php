<?php

namespace BlueSpice\About\HookHandlers\GetPreferences;

use MediaWiki\Preferences\Hook\GetPreferencesHook;

class UserPreference implements GetPreferencesHook {

	/**
	 * @inheritDoc
	 */
	public function onGetPreferences( $user, &$defaultPreferences ) {
		$defaultPreferences['bs-about-banner-dontshowuntil'] = [
			'type' => 'api',
			'default' => '0',
		];
	}
}
