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
 * @package     ArrayPress/Utils/S3/Sanitization
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
if ( ! class_exists( __NAMESPACE__ . '\\Sanitize' ) ) :

	/**
	 * Sanitization
	 *
	 * Offers utility methods for cleansing and validating input parameters associated with S3 operations.
	 */
	class Sanitize {

		/**
		 * Sanitize AWS access key ID.
		 *
		 * Removes any non-alphanumeric characters from the access key ID.
		 *
		 * @param string $key The AWS access key ID to sanitize.
		 *
		 * @return string The sanitized access key ID.
		 */
		public static function access_key( string $key ): string {
			return preg_replace( '/[^A-Za-z0-9]/', '', $key );
		}

		/**
		 * Sanitize AWS secret access key.
		 *
		 * Removes any non-alphanumeric characters from the secret access key.
		 *
		 * @param string $key The AWS secret access key to sanitize.
		 *
		 * @return string The sanitized secret access key.
		 */
		public static function secret_key( string $key ): string {
			return preg_replace( '/[^A-Za-z0-9]/', '', $key );
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
			// Remove any protocol prefixes
			$sanitized = preg_replace( '#^https?://#', '', rtrim( $endpoint, '/' ) );

			// Validate URL format
			if ( filter_var( 'https://' . $sanitized, FILTER_VALIDATE_URL ) === false ) {
				return ''; // Return empty string or handle accordingly
			}

			// Ensure that the endpoint has a valid TLD
			if ( ! preg_match( '/\.[a-z]{2,}(?:\.[a-z]{2,})?$/', $sanitized ) ) {
				return ''; // Return empty string or handle accordingly
			}

			// Finally, strip any invalid characters
			return preg_replace( '/[^a-zA-Z0-9\-\.]/', '', $sanitized );
		}

		/**
		 * Sanitize a value as a positive integer representing a duration.
		 *
		 * @param mixed $duration The value to sanitize.
		 *
		 * @return int The sanitized duration as a positive integer.
		 */
		public static function duration( $duration ): int {
			return abs( (int) $duration );
		}

		/**
		 * Sanitize the extra query string by removing any unsafe characters.
		 *
		 * @param string $extra_query_string The extra query string to sanitize.
		 *
		 * @return string The sanitized extra query string.
		 */
		public static function extra_query_string( string $extra_query_string ): string {
			return preg_replace( '/[^a-zA-Z0-9\-_=&]/', '', $extra_query_string );
		}

		/**
		 * Sanitizes a key string by ensuring it contains only lowercase letters, numbers, underscores, or hyphens.
		 *
		 * @param mixed $key The input key to be sanitized.
		 *
		 * @return string The sanitized key.
		 */
		public static function key( $key ): string {
			$sanitized_key = '';

			if ( is_scalar( $key ) ) {
				$sanitized_key = trim( $key );
				$sanitized_key = strtolower( $sanitized_key );
				$sanitized_key = preg_replace( '/[^a-z0-9_\-]/', '', $sanitized_key );
			}

			return $sanitized_key;
		}

		/**
		 * Validates and sanitizes a boolean value.
		 *
		 * @param mixed $data The input data to be validated and sanitized.
		 *
		 * @return bool The sanitized boolean value.
		 */
		public static function bool( $data ): bool {
			return filter_var( $data, FILTER_VALIDATE_BOOLEAN );
		}

		/**
		 * Sanitizes a string by converting special characters to their respective HTML entities.
		 *
		 * @param string $data The input string to be sanitized.
		 *
		 * @return string The sanitized string with special characters converted to HTML entities.
		 */
		public static function html( string $data ): string {
			return htmlspecialchars( $data, ENT_QUOTES, 'UTF-8' );
		}

		/**
		 * Sanitize a given URL.
		 *
		 * @param string $url The raw URL to sanitize.
		 *
		 * @return string The sanitized URL or an empty string if invalid.
		 */
		public static function url( string $url ): string {
			$clean_url = filter_var( $url, FILTER_SANITIZE_URL );
			if ( filter_var( $clean_url, FILTER_VALIDATE_URL ) ) {
				return $clean_url;
			}

			return ''; // Return an empty string if the URL is not valid.
		}

	}

endif;