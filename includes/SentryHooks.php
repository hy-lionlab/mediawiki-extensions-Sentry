<?php

use Wikimedia\Rdbms\DBQueryError;

class SentryHooks {
	/**
	 * @param Exception|Throwable $e
	 * @param bool $suppressed True if the error is below the level set in error_reporting().
	 */
	public static function onLogException( $e, $suppressed ) {
		global $wgSentryDsn, $wgSentryLogPhpErrors, $wgVersion, $wgSentryEnvironment;

		if ( !$wgSentryLogPhpErrors || $suppressed ) {
			return;
		}

		Sentry\init(['dsn' => $wgSentryDsn, 'environment' => $wgSentryEnvironment]);

		$data = [
			'tags' => [
				'host' => wfHostname(),
				'wiki' => wfWikiID(),
				'version' => $wgVersion,
			],
		];
		/** @phan-suppress-next-line PhanUndeclaredProperty */
		if ( isset( $e->_mwLogId ) ) {
			/** @phan-suppress-next-line PhanUndeclaredProperty */
			$data['event_id'] = $e->_mwLogId;
		}
		if ( $e instanceof DBQueryError ) {
			$data['culprit'] = $e->fname;
		}

		Sentry\captureException( $e, $data );
	}
}
