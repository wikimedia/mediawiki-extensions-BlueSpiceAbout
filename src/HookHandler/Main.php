<?php

namespace BlueSpice\About\HookHandler;

use BlueSpice\About\GlobalActionsTool;
use MWStake\MediaWiki\Component\CommonUserInterface\Hook\MWStakeCommonUIRegisterSkinSlotComponents;

class Main implements MWStakeCommonUIRegisterSkinSlotComponents {

	/**
	 * @inheritDoc
	 */
	public function onMWStakeCommonUIRegisterSkinSlotComponents( $registry ): void {
		$registry->register(
			'GlobalActionsTools',
			[
				'special-bluespice-about' => [
					'factory' => function () {
						return new GlobalActionsTool();
					}
				]
			]
		);
	}
}
