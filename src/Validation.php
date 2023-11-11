<?php
/**
 * The Validation class provides utility methods for validating and ensuring the integrity of input parameters
 * related to S3 operations.
 *
 * This class offers methods to:
 *
 * - Validate S3 object keys to ensure they adhere to safe and permissible characters.
 * - Validate S3 bucket names to ensure they follow S3's naming conventions.
 * - Validate S3 region strings to ensure they meet the required format.
 * - Check the validity of S3 endpoint URLs without a protocol.
 * - Validate period values to ensure they are positive integers.
 * - Check if query strings contain only valid characters.
 *
 * By offering dedicated validation methods, this class ensures that S3-related data is consistently
 * and securely processed, reducing the risk of errors and vulnerabilities.
 *
 * @package     ArrayPress/Utils/S3/Sanitization
 * @copyright   Copyright (c) 2023, ArrayPress Limited
 * @license     GPL2+
 * @since       1.0.0
 * @author      David Sherlock
 * @description Provides utility methods for validating S3-related parameters.
 */

namespace ArrayPress\Utils\S3;

/**
 * Check if the class `Validation` is defined, and if not, define it.
 */
if ( ! class_exists( __NAMESPACE__ . '\\Validation' ) ) :

	/**
	 * Validation
	 *
	 * Offers utility methods for validating and ensuring the integrity of input parameters associated with S3 operations.
	 */
	class Validation {

		/**
		 * Validate the S3 object key to ensure it contains safe and permissible characters.
		 *
		 * Example:
		 * Input: "my_folder/my_file.txt*"
		 * Output: false
		 *
		 * @param string $key The S3 object key to validate.
		 *
		 * @return bool True if valid, false otherwise.
		 */
		public static function object_key( string $key ): bool {
			return preg_match( '/^[a-zA-Z0-9\-_\.\/]*$/', $key ) === 1;
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
		public static function bucket( string $bucket ): bool {
			return preg_match( '/^[a-z0-9\-\.]{3,63}$/', $bucket ) === 1;
		}

		/**
		 * Validate if the provided S3 region string is a valid region.
		 *
		 * Example:
		 * Input: "us-west-1"
		 * Output: true
		 *
		 * @param string $region The S3 region string to validate.
		 *
		 * @return bool True if the region is valid, false otherwise.
		 */
		public static function region( string $region ): bool {
			return preg_match( '/^[a-z0-9\-]+$/', $region ) === 1;
		}

		/**
		 * Check if the endpoint is a valid domain name without a protocol.
		 *
		 * Example:
		 * Input: "https://my.endpoint.com/"
		 * Output: true (valid)
		 *
		 * @param string $endpoint The endpoint to check.
		 *
		 * @return bool True if the endpoint is valid, false otherwise.
		 */
		public static function endpoint( string $endpoint ): bool {
			// Remove any protocol prefixes
			$sanitized = preg_replace( '#^https?://#', '', rtrim( $endpoint, '/' ) );

			// Validate URL format
			if ( filter_var( 'https://' . $sanitized, FILTER_VALIDATE_URL ) === false ) {
				return false; // Endpoint is not valid
			}

			// Ensure that the endpoint has a valid TLD
			if ( ! preg_match( '/\.[a-z]{2,}(?:\.[a-z]{2,})?$/', $sanitized ) ) {
				return false; // Endpoint is not valid
			}

			// Finally, strip any invalid characters
			$sanitized = preg_replace( '/[^a-zA-Z0-9\-\.]/', '', $sanitized );

			// Check if the sanitized endpoint is empty
			return ! empty( $sanitized );
		}

		/**
		 * Check if a period value is valid (positive integer).
		 *
		 * @param mixed $period The period value to check.
		 *
		 * @return bool True if the period is valid, false otherwise.
		 */
		public static function period( $period ): bool {
			return is_int( $period ) && $period > 0;
		}

		/**
		 * Check if the query string contains only valid characters.
		 *
		 * @param string $query_string The query string to check.
		 *
		 * @return bool True if the query string is valid, false otherwise.
		 */
		public static function extra_query_string( string $query_string ): bool {
			return preg_match( '/^[a-zA-Z0-9\-_=&]*$/', $query_string ) === 1;
		}

	}

endif;