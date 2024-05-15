<?php
/**
 * The `Validate` class in the ArrayPress\S3 namespace is a comprehensive validation utility specifically
 * tailored for Amazon S3 operations. This class is part of the arraypress/s3-utilities package and provides a robust
 * set of methods to ensure the integrity and correctness of various input parameters related to AWS S3 services.
 *
 * Capabilities of the `Validate` class include:
 * - Ensuring AWS access key IDs and secret access keys are properly formatted with alphanumeric characters.
 * - Verifying the format of S3 object keys, allowing only a defined set of safe characters.
 * - Confirming that S3 bucket names adhere to Amazon S3's strict naming conventions.
 * - Checking S3 region strings for compliance with expected format requirements.
 * - Validating S3 endpoint URLs to be well-formed and free of protocol specifications.
 * - Confirming the positivity and integer nature of duration values.
 * - Ensuring that query strings are composed of only permitted characters.
 *
 * Through its focused validation methods, the `Validate` class enhances security and reliability in handling
 * S3-related data, effectively minimizing potential errors and vulnerabilities in S3 operations.
 *
 * @package       arraypress/s3-utilities
 * @author        David Sherlock
 * @license       GPL2+
 * @version       0.1.0
 * @description   Utility methods for validating Amazon S3-related parameters, ensuring data integrity and compliance
 *                with AWS standards.
 */

declare( strict_types=1 );

namespace ArrayPress\S3;

use InvalidArgumentException;

use function preg_match;
use function strlen;
use function preg_replace;
use function filter_var;

/**
 * Check if the class `Validate` is defined, and if not, define it.
 */
if ( ! class_exists( __NAMESPACE__ . '\\Validate' ) ) :

	/**
	 * Validation
	 *
	 * Offers utility methods for validating and ensuring the integrity of input parameters associated with S3 operations.
	 */
	class Validate {

		/**
		 * Regular expression for validating alphanumeric strings.
		 * This regex matches strings that consist only of letters (both upper and lower case) and numbers.
		 *
		 * @var string
		 */
		const ALPHANUMERIC_REGEX = '/^[A-Za-z0-9]+$/';

		/**
		 * Regular expression for validating S3 object keys.
		 * This regex allows alphanumeric characters, hyphens, underscores, dots, and slashes.
		 *
		 * @var string
		 */
		const OBJECT_KEY_REGEX = '/^[a-zA-Z0-9\-_\.\/]*$/';

		/**
		 * Regular expression for validating S3 bucket names.
		 * This regex permits lowercase letters, numbers, hyphens, and dots in the bucket names.
		 *
		 * @var string
		 */
		const BUCKET_NAME_REGEX = '/^[a-z0-9\-\.]+$/';

		/**
		 * Regular expression for validating S3 region strings.
		 * This regex matches strings containing lowercase letters, numbers, and hyphens.
		 *
		 * @var string
		 */
		const REGION_REGEX = '/^[a-z0-9\-]+$/';

		/**
		 * Regular expression for validating domain names in S3 endpoints.
		 * This regex ensures that the domain has a valid top-level domain (TLD) structure.
		 *
		 * @var string
		 */
		const DOMAIN_TLD_REGEX = '/\.[a-z]{2,}(?:\.[a-z]{2,})?$/';

		/**
		 * Regular expression for sanitizing strings to contain only alphanumeric characters, hyphens, and dots.
		 * This regex is used to remove any characters not matching the specified set.
		 *
		 * @var string
		 */
		const ALNUM_HYPHEN_DOT_REGEX = '/[^a-zA-Z0-9\-\.]/';

		/**
		 * Regular expression for validating query strings.
		 * This regex allows alphanumeric characters, hyphens, underscores, equals signs, and ampersands.
		 *
		 * @var string
		 */
		const QUERY_STRING_REGEX = '/^[a-zA-Z0-9\-_=&]*$/';

		/**
		 * Validate AWS access key ID.
		 *
		 * @param string $accessKey The AWS access key ID to validate.
		 *
		 * @return bool True if valid.
		 * @throws InvalidArgumentException If the access key ID is invalid.
		 */
		public static function accessKey( string $accessKey ): bool {
			if ( empty( $accessKey ) ) {
				throw new InvalidArgumentException( "Access key ID cannot be empty." );
			}
			if ( ! preg_match( self::ALPHANUMERIC_REGEX, $accessKey ) ) {
				throw new InvalidArgumentException( "Invalid AWS access key ID characters. It should be alphanumeric." );
			}

			return true;
		}

		/**
		 * Validate AWS secret access key.
		 *
		 * @param string $secretKey The AWS secret access key to validate.
		 *
		 * @return bool True if valid.
		 * @throws InvalidArgumentException If the secret access key is invalid.
		 */
		public static function secretKey( string $secretKey ): bool {
			if ( empty( $secretKey ) ) {
				throw new InvalidArgumentException( "Secret key cannot be empty." );
			}
			if ( ! preg_match( self::ALPHANUMERIC_REGEX, $secretKey ) ) {
				throw new InvalidArgumentException( "Invalid AWS secret access key characters. It should be alphanumeric." );
			}

			return true;
		}

		/**
		 * Validate the S3 object key to ensure it contains safe and permissible characters.
		 *
		 * Example:
		 * Input: "my_folder/my_file.txt*"
		 * Output: false
		 *
		 * @param string $objectKey The S3 object key to validate.
		 *
		 * @throws InvalidArgumentException If the key is invalid.
		 */
		public static function objectKey( string $objectKey ): bool {
			if ( empty( $objectKey ) ) {
				throw new InvalidArgumentException( "Object key cannot be empty." );
			}
			if ( ! preg_match( self::OBJECT_KEY_REGEX, $objectKey ) ) {
				throw new InvalidArgumentException( "Invalid S3 object key. Only alphanumeric characters, hyphens, underscores, dots, and slashes are allowed." );
			}

			return true;
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
		 * @return bool True if the bucket name is valid.
		 * @throws InvalidArgumentException If the bucket name is invalid.
		 */
		public static function bucket( string $bucket ): bool {
			if ( empty( $bucket ) ) {
				throw new InvalidArgumentException( "Bucket name cannot be empty." );
			}

			// Check length
			$length = strlen( $bucket );
			if ( $length < 3 || $length > 63 ) {
				throw new InvalidArgumentException( "Invalid bucket name length. It should be between 3 and 63 characters." );
			}

			// Check characters
			if ( ! preg_match( self::BUCKET_NAME_REGEX, $bucket ) ) {
				throw new InvalidArgumentException( "Invalid bucket name characters. Only lowercase letters, numbers, hyphens, and dots are allowed." );
			}

			return true;
		}

		/**
		 * Check if a string represents a valid Amazon S3 region.
		 *
		 * Example:
		 * Input: "us-west-1"
		 * Output: true
		 *
		 * @param string $region The S3 region string to check.
		 *
		 * @return bool True if the region is valid.
		 * @throws InvalidArgumentException If the region is invalid.
		 */
		public static function region( string $region ): bool {
			if ( empty( $region ) ) {
				throw new InvalidArgumentException( "Region cannot be empty." );
			}
			if ( ! preg_match( self::REGION_REGEX, $region ) ) {
				throw new InvalidArgumentException( "Invalid S3 region. It should contain only lowercase letters, numbers, and hyphens." );
			}

			return true;
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
		 * @return bool True if the endpoint is valid.
		 * @throws InvalidArgumentException If the endpoint is invalid.
		 */
		public static function endpoint( string $endpoint ): bool {
			if ( empty( $endpoint ) ) {
				throw new InvalidArgumentException( "Endpoint cannot be empty." );
			}

			// Remove any protocol prefixes
			$sanitized = preg_replace( '#^https?://#', '', rtrim( $endpoint, '/' ) );

			// Validate URL format
			if ( filter_var( 'https://' . $sanitized, FILTER_VALIDATE_URL ) === false ) {
				throw new InvalidArgumentException( "Invalid endpoint format. It should be a valid URL." );
			}

			// Ensure that the endpoint has a valid TLD
			if ( ! preg_match( self::DOMAIN_TLD_REGEX, $sanitized ) ) {
				throw new InvalidArgumentException( "Invalid top-level domain in the endpoint." );
			}

			// Finally, strip any invalid characters
			$sanitized = preg_replace( self::ALNUM_HYPHEN_DOT_REGEX, '', $sanitized );

			// Check if the sanitized endpoint is empty
			if ( empty( $sanitized ) ) {
				throw new InvalidArgumentException( "Invalid endpoint. It should not be empty." );
			}

			return true;
		}

		/**
		 * Validate if a value is a valid duration (positive integer representing a duration).
		 *
		 * @param int $duration The value to check.
		 *
		 * @return bool True if the duration is valid.
		 * @throws InvalidArgumentException If the duration is invalid.
		 */
		public static function duration( int $duration ): bool {
			if ( empty( $duration ) ) {
				throw new InvalidArgumentException( "Duration cannot be empty." );
			}
			if ( $duration <= 0 ) {
				throw new InvalidArgumentException( "Duration must be a positive integer." );
			}

			return true;
		}

		/**
		 * Check if the query string contains only valid characters.
		 *
		 * @param string $queryString The query string to check.
		 *
		 * @return bool True if the query string is valid.
		 * @throws InvalidArgumentException If the query string is invalid.
		 */
		public static function extraQueryString( string $queryString ): bool {
			if ( ! empty( $queryString ) ) {
				if ( ! preg_match( self::QUERY_STRING_REGEX, $queryString ) ) {
					throw new InvalidArgumentException( "Invalid query string characters." );
				}
			}

			return true;
		}

	}

endif;