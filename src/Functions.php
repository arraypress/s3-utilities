<?php
/**
 * These helper functions provide utilities for working with S3 Signer class.
 *
 * @since       1.0.0
 * @copyright   Copyright (c) 2023, ArrayPress Limited
 * @license     GPL2+
 * @package     ArrayPress/s3-signer
 * @author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\S3;

use InvalidArgumentException;
use function method_exists;

if ( ! function_exists( 'validate' ) ) {
	/**
	 * Attempts to validate a value using a specified method from the Validate class.
	 * Returns true if the validation succeeds, or false if it fails or if an exception occurs.
	 *
	 * This function internally catches InvalidArgumentExceptions thrown by the Validate class methods.
	 * It is designed to provide a boolean outcome for validation attempts, simplifying error handling for callers.
	 *
	 * Note: While this function currently does not throw exceptions to its callers, it internally handles
	 * InvalidArgumentExceptions thrown by validation methods. Future modifications could change this behavior.
	 *
	 * @param string $methodName The name of the validation method to call (e.g., 'bucket', 'objectKey').
	 * @param mixed  $value      The value to be validated.
	 *
	 * @return bool True if validation succeeds, false otherwise.
	 */
	function validate( string $methodName, $value ): bool {
		try {
			// Ensure the method exists in the Validate class before attempting to call it
			if ( method_exists( Validate::class, $methodName ) ) {
				// Call the method dynamically with $value as its argument
				Validate::{$methodName}( $value );

				return true; // Validation succeeded
			} else {
				throw new InvalidArgumentException( "Validation method '{$methodName}' does not exist." );
			}
		} catch ( InvalidArgumentException $e ) {
			// Validation failed or method does not exist
			return false;
		}
	}
}

if ( ! function_exists( 'sanitize' ) ) {
	/**
	 * Sanitizes a value using a specified method from the Sanitize class.
	 * Returns the sanitized value.
	 *
	 * This function provides a unified interface to the various sanitization methods available
	 * in the Sanitize class, simplifying the process of sanitizing data inputs for S3 operations.
	 *
	 * @param string $methodName The name of the sanitization method to call (e.g., 'accessKey', 'bucket').
	 * @param mixed  $value      The value to be sanitized.
	 *
	 * @return mixed The sanitized value.
	 */
	function sanitize( string $methodName, $value ) {
		// Ensure the method exists in the Sanitize class before attempting to call it
		if ( method_exists( Sanitize::class, $methodName ) ) {
			// Call the method dynamically with $value as its argument
			return Sanitize::{$methodName}( $value );
		} else {
			throw new InvalidArgumentException( "Santization method '{$methodName}' does not exist." );
		}
	}
}