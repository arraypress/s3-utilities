<?php
/**
 * The Sanitization class offers utility methods to cleanse and validate input parameters
 * related to Amazon's Simple Storage Service (S3) operations.
 *
 * This class contains methods to:
 *
 * - Sanitize bucket names to ensure conformity with S3's naming conventions.
 * - Sanitize S3 region strings by removing any disallowed characters.
 * - Sanitize S3 endpoints by removing protocols and invalid domain characters.
 * - Sanitize S3 object keys by permitting only valid characters.
 * - Encode and decode S3 object names to ensure valid URL representation.
 * - Validate the provided bucket name to ensure it adheres to S3's naming guidelines.
 *
 * By providing a dedicated sanitization process for S3 operations, this class ensures
 * that the data exchanged with S3 is consistent and secure, thus minimizing potential
 * errors and vulnerabilities.
 *
 * @package     arraypress/s3-sanitization
 * @copyright   Copyright (c) 2023, ArrayPress Limited
 * @license     GPL2+
 * @since       1.0.0
 * @author      David Sherlock
 * @description Provides utility methods for sanitizing and validating S3-related parameters.
 */

namespace ArrayPress\Utils\S3;

/**
 * Check if the class `Sanitization` is defined, and if not, define it.
 */
if ( ! class_exists( __NAMESPACE__ . '\\Sanitization' ) ) :

	/**
	 * Sanitization
	 *
	 * Offers utility methods for cleansing and validating input parameters associated with S3 operations.
	 */
	class Sanitization {

		/**
		 * Sanitize the provided bucket name based on S3's naming conventions.
		 *
		 * Example:
		 * Input: "My_Bucket-Name.123"
		 * Output: "my-bucket-name.123"
		 *
		 * @param string $bucket The bucket name to sanitize.
		 *
		 * @return string The sanitized bucket name.
		 */
		public static function bucket( string $bucket ): string {
			return preg_replace( '/[^a-z0-9\-\.]/', '', $bucket );
		}

		/**
		 * Sanitize the provided S3 region string.
		 *
		 * Example:
		 * Input: "us-west-1_extra"
		 * Output: "us-west-1"
		 *
		 * @param string $region The S3 region string to sanitize.
		 *
		 * @return string The sanitized S3 region string.
		 */
		public static function region( string $region ): string {
			return preg_replace( '/[^a-z0-9\-]/', '', $region );
		}

		/**
		 * Sanitize the endpoint to ensure only valid domain names without any protocol.
		 *
		 * Example:
		 * Input: "https://my.endpoint.com/"
		 * Output: "my.endpoint.com"
		 *
		 * @param string $endpoint The endpoint to sanitize.
		 *
		 * @return string The sanitized endpoint.
		 */
		public static function endpoint( string $endpoint ): string {
			$sanitized = preg_replace( '#^https?://#', '', $endpoint );

			return preg_replace( '/[^a-zA-Z0-9\-\.]/', '', $sanitized );
		}

		/**
		 * Sanitize the S3 object key.
		 *
		 * Example:
		 * Input: "my_folder/my_file.txt*"
		 * Output: "my_folder/my_file.txt"
		 *
		 * @param string $key The S3 object key to sanitize.
		 *
		 * @return string The sanitized S3 object key.
		 */
		public static function object_key( string $key ): string {
			return preg_replace( '/[^a-zA-Z0-9\-_\.\/]/', '', $key );
		}

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
		private function encode_object_name( string $key ): string {
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
		public static function decode_object_name( string $key ): string {
			return rawurldecode( str_replace( ' ', '+', $key ) );
		}

		/**
		 * Validate if the provided bucket name conforms to S3's naming conventions.
		 *
		 * Example:
		 * Input: "my.bucket-123"
		 * Output: true
		 *
		 * @param string $bucket The bucket name to validate.
		 *
		 * @return bool True if valid, false otherwise.
		 */
		public static function is_valid_bucket( string $bucket ): bool {
			return preg_match( '/^[a-z0-9\-\.]{3,63}$/', $bucket ) === 1;
		}
	}

endif;