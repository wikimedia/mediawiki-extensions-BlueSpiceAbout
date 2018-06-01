<?php

namespace BlueSpice\About;

use BlueSpice\IAdminTool;

class AdminTool implements IAdminTool {

	public function getURL() {
		$tool = \SpecialPage::getTitleFor( 'BlueSpiceAbout' );
		return $tool->getLocalURL();
	}

	public function getDescription() {
		return wfMessage( 'bs-bluespiceabout-desc' );
	}

	public function getName() {
		return wfMessage( 'bs-bluespiceabout-about-bluespice' );
	}

	public function getClasses() {
		return [ 'icon-admin-bluespiceabout' ];
	}

	public function getDataAttributes() {
		return [];
	}

	public function getPermissions() {
		$permissions = array(
			'bluespiceabout-viewspecialpage'
		);
		return $permissions;
	}

}