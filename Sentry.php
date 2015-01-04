<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Sentry',
	'author' => 'Gergő Tisza',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Sentry',
	'descriptionmsg' => 'sentry-desc',
	'version'  => 0.1,
	'license-name' => "MIT",
);

$wgMessagesDirs['Sentry'] = __DIR__ . '/i18n';

$wgAutoloadClasses['SentryHooks'] = __DIR__ . '/SentryHooks.php';

$wgResourceModules += array(
	'sentry' => array(
		'scripts' => array(
			'raven/raven.js',
			'init.js',
		),
		'position' => 'top',
		'localBasePath' => __DIR__ . '/resources',
		'remoteExtPath' => 'Sentry/resources',
	),
);

$wgHooks['ResourceLoaderGetConfigVars'][] = 'SentryHooks::onResourceLoaderGetConfigVars';
$wgHooks['BeforePageDisplay'][] = 'SentryHooks::onBeforePageDisplay';

/**
 * Sentry endpoint / API key
 * @var string
 */
$wgSentryEndpoint = null;

/**
 * List of domains to log error from.
 * '*' can be used as a wildcard; the wiki's own domain will be added automatically.
 * Set to false to enable any domain.
 * @var array|bool
 */
$wgSentryWhitelist = false;

/**
 * Log uncaught Javascript errors automatically.
 * @var bool
 */
$wgSentryLogOnError = true;
