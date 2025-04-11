<?php

namespace BlueSpice\About\HookHandlers\SkinAfterContent;

use MediaWiki\Hook\SkinAfterContentHook;
use MediaWiki\Html\Html;
use MediaWiki\MediaWikiServices;
use MediaWiki\Parser\Sanitizer;
use MediaWiki\User\User;

class AddBanner implements SkinAfterContentHook {

	private const USER_PREFERENCE = 'bs-about-banner-dontshowuntil';

	private const BANNER_MESSAGES = [
		'en' => [
			'newsletter' => [
				'heading' => 'Stay up to date!',
				'message' => 'Subscribe to our newsletter and receive the latest information on updates, features, webinars and events from the world of BlueSpice.', // phpcs:ignore Generic.Files.LineLength.TooLong
				'subscriberate' => 'Subscribe now',
				'link' => 'https://bluespice.com/?mtm_campaign=Product-NewsletterSubscription#newsletter'
			],
			'rating' => [
				'heading' => 'Your opinion counts!',
				'message' => 'Take five minutes and rate BlueSpice at Capterra.',
				'subscriberate' => 'Rate now',
				'remind' => 'Remind me later',
				'link' => 'https://reviews.capterra.com/products/new/bd5d69ea-dd9f-405d-a333-a820004f3204/?mtm_campaign=Product-GartnerReview' // phpcs:ignore Generic.Files.LineLength.TooLong
			],
		],
		'de' => [
			'newsletter' => [
				'heading' => 'Bleiben Sie auf dem Laufenden!',
				'message' => 'Abonnieren Sie unseren Newsletter und erhalten Sie die neuesten Infos zu Updates, Features, Webinaren und Events aus der Welt von BlueSpice.', // phpcs:ignore Generic.Files.LineLength.TooLong
				'subscriberate' => 'Jetzt abonnieren',
				'link' => 'https://bluespice.com/de/?mtm_campaign=Produkt-NewsletterSubskription#newsletter'
			],
			'rating' => [
				'heading' => 'Ihre Meinung zählt!',
				'message' => 'Nehmen Sie sich fünf Minuten Zeit und bewerten Sie BlueSpice bei Capterra.',
				'subscriberate' => 'Jetzt bewerten',
				'remind' => 'Später erinnern',
				'link' => 'https://reviews.capterra.com/products/new/bd5d69ea-dd9f-405d-a333-a820004f3204/?lang=de&mtm_campaign=Produkt-GartnerReview' // phpcs:ignore Generic.Files.LineLength.TooLong
			],
		],
		'fr' => [
			'newsletter' => [
				'heading' => 'Restez informé !',
				'message' => 'Abonnez-vous à notre newsletter et recevez les dernières informations sur les mises à jour, les fonctionnalités, les webinaires et les événements autour de BlueSpice.', // phpcs:ignore Generic.Files.LineLength.TooLong
				'subscriberate' => 'Abonnez-vous maintenant',
				'link' => 'https://bluespice.com/?mtm_campaign=Product-NewsletterSubscription#newsletter'
			],
			'rating' => [
				'heading' => 'Votre avis compte !',
				'message' => 'Prenez cinq minutes pour évaluer BlueSpice chez Capterra.',
				'subscriberate' => 'Évaluer maintenant',
				'remind' => 'Plus tard',
				'link' => 'https://reviews.capterra.com/products/new/bd5d69ea-dd9f-405d-a333-a820004f3204/?lang=fr&mtm_campaign=Product_GartnerReview_fr' // phpcs:ignore Generic.Files.LineLength.TooLong
			],
		]
	];

	/**
	 * @inheritDoc
	 */
	public function onSkinAfterContent( &$data, $skin ) {
		if ( $this->getEdition() !== 'free' ) {
			return;
		}

		$user = $skin->getUser();
		if ( $user->isAnon() ) {
			return;
		}

		$services = MediaWikiServices::getInstance();
		$option = $services->getUserOptionsLookup()->getOption( $user, self::USER_PREFERENCE );
		if ( $option > time() ) {
			return;
		}

		$output = $skin->getOutput();
		$userLang = $this->getSupportedLanguage( $user );
		if ( in_array( 'sysop',	$services->getUserGroupManager()->getUserGroups( $user ) ) ) {
			$output->addJsConfigVars( [
				'bsAboutBannerType' => 'newsletter',
				'bsAboutBannerMessages' => self::BANNER_MESSAGES[ $userLang ][ 'newsletter' ]
			] );
		} else {
			$output->addJsConfigVars( [
				'bsAboutBannerType' => 'rating',
				'bsAboutBannerMessages' => self::BANNER_MESSAGES[ $userLang ][ 'rating' ]
			] );
		}

		$output->addModules( [ 'ext.bluespice.about.banner' ] );
		$output->addModuleStyles( [ 'ext.bluespice.about.banner.styles' ] );

		$bannerHtml = Html::rawElement( 'div', [ 'id' => 'bs-about-banner-container' ] );

		$data .= $bannerHtml;
	}

	/**
	 * @return string
	 */
	private function getEdition(): string {
		return $this->getFileContent( $GLOBALS['IP'] . '/BLUESPICE-EDITION' );
	}

	/**
	 * Reads a file, sanitises its contents, and trims whitespace.
	 *
	 * @param string $filePath
	 * @return string
	 */
	private function getFileContent( string $filePath ): string {
		$objectCache = MediaWikiServices::getInstance()->getObjectCacheFactory()->getLocalServerInstance();

		return $objectCache->getWithSetCallback(
			$objectCache->makeKey( 'bluespiceabout-getedition', $filePath ),
			$objectCache::TTL_HOUR,
			static function () use ( $filePath ) {
				$content = '';
				if ( file_exists( $filePath ) ) {
					$fileContent = file_get_contents( $filePath );
					$content = Sanitizer::stripAllTags( $fileContent );
					$content = trim( $content );
				}

				return $content;
			}
		);
	}

	/**
	 * @param User $user
	 * @return string
	 */
	private function getSupportedLanguage( User $user ): string {
		$supportedLanguages = [ 'en', 'de', 'fr' ];
		$services = MediaWikiServices::getInstance();

		$userLanguage = $services->getUserOptionsLookup()->getOption( $user, 'language' );
		if ( !in_array( $userLanguage, $supportedLanguages ) ) {
			$userLanguage = $services->getContentLanguage()->getCode();
			if ( !in_array( $userLanguage, $supportedLanguages ) ) {
				$userLanguage = 'en';
			}
		}

		return $userLanguage;
	}

}
