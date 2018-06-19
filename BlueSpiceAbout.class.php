<?php
/**
 * BlueSpice MediaWiki
 * Extension: BlueSpiceAbout
 * Description: Show user additional options of the pro version.
 * Authors: Markus Glaser
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * For further information visit http://www.bluespice.com
 *
 * @author     Markus Glaser <glaser@hallowelt.com>
 * @author     Leonid Verhovskij <verhovskij@hallowelt.com>
 * @package    BlueSpiceAbout
 * @copyright  Copyright (C) 2016 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License v3
 * @filesource
 */

class BlueSpiceAbout extends BsExtensionMW {

	protected function initExt() {
		// Hooks
		$this->setHook( 'BeforePageDisplay' );
		$this->setHook( 'SkinBuildSidebar' );
	}

	/**
	 *
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return boolean
	 */
	public function onBeforePageDisplay( &$out, &$skin ) {
		$config = \BlueSpice\Services::getInstance()->getConfigFactory()
			->makeConfig( 'bsg' );

		if ( $config->get( 'BlueSpiceAboutShowMenuLinks' ) ) {
			$out->addModuleStyles( 'ext.bluespice.bluespiceabout' );
		}
		return true;
	}

	/**
	 * Adds entry to main navigation
	 * @param object $oSkinTemplate - not used
	 * @param array $aLinks - unrendered list of links
	 * @return boolean - always true
	 */
	public function onSkinBuildSidebar( $oSkinTemplate, &$aLinks ) {
		$config = \BlueSpice\Services::getInstance()->getConfigFactory()
			->makeConfig( 'bsg' );
		if ( !$config->get( 'BlueSpiceAboutShowMenuLinks' ) ) {
			return true;
		}
		$oSpecialPage = SpecialPage::getTitleFor( 'BlueSpiceAbout' );

		$aLinks[ "navigation" ][] = array(
			'id' => 'n-bluespiceabout',
			'href' => $oSpecialPage->getLocalURL(),
			'text' => wfMessage( 'bs-bluespiceabout-about-bluespice' )->plain()
		);

		return true;
	}
}