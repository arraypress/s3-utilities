<?php
/**
 * The `Sanitize` class within the ArrayPress\S3 namespace serves as a dedicated utility for sanitizing various
 * input parameters specifically for Amazon S3 operations. Part of the arraypress/s3-utilities package, this class
 * offers a comprehensive suite of methods aimed at cleaning and standardizing data inputs to conform to AWS S3
 * standards and requirements.
 *
 * Key features of the `Sanitize` class include:
 * - Sanitization of AWS access key IDs and secret access keys by removing non-alphanumeric characters.
 * - Ensuring S3 object keys are free of unsafe characters, allowing only specific, permissible characters.
 * - Standardizing S3 bucket names to comply with Amazon S3 naming conventions by removing disallowed characters.
 * - Processing S3 region strings to remove any characters not part of the standard region format.
 * - Sanitizing S3 endpoint URLs to ensure they are valid domain names without protocol specifications.
 * - Converting any non-positive duration values into positive integers.
 * - Cleaning up query strings to include only characters that are deemed safe and valid.
 * - General sanitization functions for boolean values, URLs, and strings to ensure data cleanliness and safety.
 *
 * This class plays a crucial role in enhancing the security and stability of interactions with AWS S3 by providing
 * reliable methods to preprocess and sanitize data inputs, thus reducing the risk of errors and security
 * vulnerabilities associated with improper or malicious input.
 *
 * @package       arraypress/s3-utilities
 * @copyright     Copyright (c) 2024, ArrayPress Limited
 * @author        David Sherlock
 * @license       GPL2+
 * @version       0.1.0
 * @description   Methods for sanitizing various parameters related to Amazon S3, ensuring data safety and protocol
 *                compliance.
 */

declare( strict_types=1 );

namespace ArrayPress\S3\Utils;

use function abs;
use function filter_var;
use function htmlspecialchars;
use function preg_match;
use function preg_replace;
use function strtolower;
use function trim;

/**
 * Sanitization
 *
 * Offers utility methods for cleansing and validating input parameters associated with S3 operations.
 */
class Sanitize {

	/**
	 * Regular expression for sanitizing AWS access key ID and secret access key.
	 * This regex removes any characters that are not alphanumeric.
	 *
	 * @var string
	 */
	const AWS_KEY_SANITIZE_REGEX = '/[^A-Za-z0-9]/';

	/**
	 * Regular expression for sanitizing S3 object keys.
	 * This regex allows alphanumeric characters, hyphens, underscores, dots, and slashes.
	 *
	 * @var string
	 */
	const OBJECT_KEY_SANITIZE_REGEX = '/[^a-zA-Z0-9\-_\.\/]/';

	/**
	 * Regular expression for sanitizing S3 bucket names.
	 * This regex permits lowercase letters, numbers, hyphens, and dots in the bucket names.
	 *
	 * @var string
	 */
	const BUCKET_NAME_SANITIZE_REGEX = '/[^a-z0-9\-\.]/';

	/**
	 * Regular expression for sanitizing S3 region strings.
	 * This regex matches strings containing lowercase letters, numbers, and hyphens.
	 *
	 * @var string
	 */
	const REGION_SANITIZE_REGEX = '/[^a-z0-9\-]/';

	/**
	 * Regular expression for validating the top-level domain (TLD) of an endpoint.
	 * This regex ensures that the endpoint has a valid TLD, allowing for second-level domains.
	 * It matches a period followed by two or more lowercase letters, and optionally another period
	 * and two or more lowercase letters, appearing at the end of the string.
	 *
	 * Example:
	 * Input: "https://my.endpoint.com/"
	 * Output: true (valid)
	 *
	 * @var string
	 */
	const ENDPOINT_TLD_SANITIZE_REGEX = '/\.[a-z]{2,}(?:\.[a-z]{2,})?$/';

	/**
	 * Regular expression for sanitizing domain names in S3 endpoints.
	 * This regex ensures that only valid characters for domain names are retained.
	 *
	 * @var string
	 */
	const DOMAIN_SANITIZE_REGEX = '/[^a-zA-Z0-9\-\.]/';

	/**
	 * Regular expression for sanitizing extra query strings.
	 * This regex allows alphanumeric characters, hyphens, underscores, equals signs, and ampersands.
	 *
	 * @var string
	 */
	const QUERY_STRING_SANITIZE_REGEX = '/[^a-zA-Z0-9\-_=&]/';

	/**
	 * Regular expression for sanitizing generic keys.
	 * This regex permits only lowercase letters, numbers, underscores, or hyphens.
	 *
	 * @var string
	 */
	const KEY_SANITIZE_REGEX = '/[^a-z0-9_\-]/';

	/**
	 * Sanitize AWS access key ID.
	 *
	 * Removes any non-alphanumeric characters from the access key ID.
	 *
	 * @param string $accessKey The AWS access key ID to sanitize.
	 *
	 * @return string The sanitized access key ID.
	 */
	public static function accessKey( string $accessKey ): string {
		return preg_replace( self::AWS_KEY_SANITIZE_REGEX, '', $accessKey );
	}

	/**
	 * Sanitize AWS secret access key.
	 *
	 * Removes any non-alphanumeric characters from the secret access key.
	 *
	 * @param string $secretKey The AWS secret access key to sanitize.
	 *
	 * @return string The sanitized secret access key.
	 */
	public static function secretKey( string $secretKey ): string {
		return preg_replace( self::AWS_KEY_SANITIZE_REGEX, '', $secretKey );
	}

	/**
	 * Sanitize the S3 object key.
	 *
	 * Example:
	 * Input: "my_folder/my_file.txt*"
	 * Output: "my_folder/my_file.txt"
	 *
	 * @param string $objectKey The S3 object key to sanitize.
	 *
	 * @return string The sanitized S3 object key.
	 */
	public static function objectKey( string $objectKey ): string {
		return preg_replace( self::OBJECT_KEY_SANITIZE_REGEX, '', $objectKey );
	}

	/**
	 * Sanitize the provided bucket name based on S3's naming conventions.
	 *
	 * Example:
	 * Input: "My_Bucket-Name.123"
	 * Output: "my-bucket-name.123"
	 *
	 * @param mixed $bucket The bucket name to sanitize.
	 *
	 * @return string The sanitized bucket name.
	 */
	public static function bucket( string $bucket ): string {
		return preg_replace( self::BUCKET_NAME_SANITIZE_REGEX, '', $bucket );
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
		return preg_replace( self::REGION_SANITIZE_REGEX, '', $region );
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
		if ( ! preg_match( self::ENDPOINT_TLD_SANITIZE_REGEX, $sanitized ) ) {
			return ''; // Return empty string or handle accordingly
		}

		// Finally, strip any invalid characters
		return preg_replace( self::DOMAIN_SANITIZE_REGEX, '', $sanitized );
	}

	/**
	 * Sanitize a value as a positive integer representing a duration.
	 *
	 * @param int $duration The value to sanitize.
	 *
	 * @return int The sanitized duration as a positive integer.
	 */
	public static function duration( int $duration ): int {
		return abs( $duration );
	}

	/**
	 * Sanitize the extra query string by removing any unsafe characters.
	 *
	 * @param string $extraQueryString The extra query string to sanitize.
	 *
	 * @return string The sanitized extra query string.
	 */
	public static function extraQueryString( string $extraQueryString ): string {
		return preg_replace( self::QUERY_STRING_SANITIZE_REGEX, '', $extraQueryString );
	}

	/**
	 * Sanitizes a key string by ensuring it contains only lowercase letters, numbers, underscores, or hyphens.
	 *
	 * @param string $key The input key to be sanitized.
	 *
	 * @return string The sanitized key.
	 */
	public static function key( string $key ): string {
		$sanitized_key = trim( $key );
		$sanitized_key = strtolower( $sanitized_key );

		return preg_replace( self::KEY_SANITIZE_REGEX, '', $sanitized_key );
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
	 * @param mixed $data The input string to be sanitized.
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