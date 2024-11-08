<?php
/**
 * The Serialization class provides utility methods for encoding, decoding, and sanitizing input parameters
 * related to S3 operations.
 *
 * This class offers methods to:
 *
 * - Encode S3 object names into URL-safe representations, allowing for '/' characters.
 * - Decode URL-encoded S3 object keys back to their original form.
 *
 * By offering dedicated serialization methods, this class ensures that S3-related data is consistently
 * and securely processed, reducing the risk of errors and vulnerabilities.
 *
 * @package       arraypress/s3-utilities
 * @copyright     Copyright (c) 2024, ArrayPress Limited
 * @license       GPL2+
 * @version       0.1.0
 * @author        David Sherlock
 * @description   Provides utility methods for encoding, decoding, and sanitizing S3-related parameters.
 */

declare( strict_types=1 );

namespace ArrayPress\S3\Utils;

use function str_replace;
use function rawurlencode;
use function rawurldecode;

/**
 * Serialization
 *
 * Provides utility methods for encoding, decoding, and sanitizing input parameters associated with S3 operations.
 */
class Serialization {

	/**
	 * Raw URL encode a key and allow for '/' characters.
	 *
	 * Example:
	 * Input: "my folder/my file.txt"
	 * Output: "my%20folder/my%20file.txt"
	 *
	 * @param string $key Key to encode
	 *
	 * @return string Returns the encoded key
	 */
	public static function encodeObjectName( string $key ): string {
		$key = str_replace( '+', ' ', $key );

		return str_replace( '%2F', '/', rawurlencode( $key ) );
	}

	/**
	 * Decode a URL encoded object key.
	 *
	 * Example:
	 * Input: "my%20folder/my%20file.txt"
	 * Output: "my folder/my file.txt"
	 *
	 * @param string $key Encoded object key.
	 *
	 * @return string Returns the decoded key.
	 */
	public static function decodeObjectName( string $key ): string {
		return rawurldecode( str_replace( ' ', '+', $key ) );
	}

}