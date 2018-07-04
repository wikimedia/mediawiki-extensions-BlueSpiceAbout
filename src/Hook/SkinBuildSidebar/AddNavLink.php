<?php

namespace BlueSpice\About\Hook\SkinBuildSidebar;

use BlueSpice\Hook\SkinBuildSidebar;

class AddNavLink extends SkinBuildSidebar {

	protected function skipProcessing() {
		return !$this->getConfig()->get( 'BlueSpiceAboutShowMenuLinks' );
	}

	protected function doProcess() {

		$specialPage = \SpecialPage::getTitleFor( 'BlueSpiceAbout' );

		$this->bar["navigation"][] = array (
			'id' => 'n-bluespiceabout',
			'href' => $specialPage->getLocalURL(),
			'text' => wfMessage( 'bs-bluespiceabout-about-bluespice' )->plain(),
			'classes' => ' icon-admin-bluespiceabout '
		);

		return true;
	}

}
