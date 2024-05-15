# S3 Utilities Library

The S3 Utilities Library is a comprehensive toolkit designed for developers working with Amazon S3 and S3-compatible
storage solutions. This library encompasses a wide range of functionalities including sanitization, validation, and
serialization of S3 parameters, ensuring adherence to AWS standards and enhancing the safety and efficiency of cloud
storage operations.

**Key Features:**

- **Comprehensive Sanitization:** Ensures that bucket names, object keys, endpoints, and other parameters conform to S3
  standards by removing or replacing invalid characters.
- **Robust Validation:** Validates inputs to ensure they meet specific criteria for AWS access keys, bucket names,
  object keys, and more, preventing common errors.
- **Advanced Serialization:** Facilitates the correct encoding and decoding of object keys, crucial for handling special
  characters in S3 object paths.
- **Wide Compatibility:** Designed to work seamlessly with AWS S3 and various S3-compatible services like Linode,
  DigitalOcean Spaces, and BackBlaze.
- **Utility Functions:** Provides helper functions for validation and sanitization, simplifying common tasks and
  streamlining development.

Ensure your cloud storage interactions are optimized, secure, and compliant by leveraging the S3 Utilities Library.

## Minimum Requirements

- **PHP:** 7.4 or later

## Installation

To integrate the S3 Utilities Library into your project, use Composer:

```bash
composer require arraypress/s3-utilities
```

### Including the Vendor Library

Include the Composer autoloader in your project to access the library:

```php
require_once __DIR__ . '/vendor/autoload.php';
```

## Sanitize Class Examples

The `Sanitize` class provides comprehensive methods for sanitizing various parameters for Amazon S3 operations, ensuring
compliance with AWS S3 standards and enhancing data safety.

### accessKey (Sanitizing AWS Access Key ID)

```php
use ArrayPress\S3\Sanitize;

$accessKey = "AKIA1234EXAMPLE!@#$%";
$sanitizedAccessKey = Sanitize::accessKey($accessKey);
echo $sanitizedAccessKey; // Outputs: "AKIA1234EXAMPLE"
```

### secretKey (Sanitizing AWS Secret Access Key)

```php
$secretKey = "wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY%^&*";
$sanitizedSecretKey = Sanitize::secretKey($secretKey);
echo $sanitizedSecretKey; // Outputs: "wJalrXUtnFEMIK7MDENGbPxRfiCYEXAMPLEKEY"
```

### objectKey (Sanitizing S3 Object Keys)

```php
$objectKey = "my_folder/my_file.txt*";
$sanitizedObjectKey = Sanitize::objectKey($objectKey);
echo $sanitizedObjectKey; // Outputs: "my_folder/my_file.txt"
```

### bucket (Sanitizing Bucket Names)

```php
$bucketName = "My_Bucket-Name.123!";
$sanitizedBucketName = Sanitize::bucket($bucketName);
echo $sanitizedBucketName; // Outputs: "my-bucket-name.123"
```

### region (Sanitizing S3 Region Strings)

```php
$region = "us-west-1_extra";
$sanitizedRegion = Sanitize::region($region);
echo $sanitizedRegion; // Outputs: "us-west-1"
```

### endpoint (Sanitizing Endpoints)

```php
$endpoint = "https://my.endpoint.com/";
$sanitizedEndpoint = Sanitize::endpoint($endpoint);
echo $sanitizedEndpoint; // Outputs: "my.endpoint.com"
```

### duration (Sanitizing Duration Values)

```php
$duration = -60;
$sanitizedDuration = Sanitize::duration($duration);
echo $sanitizedDuration; // Outputs: 60
```

### extra_query_string (Sanitizing Extra Query Strings)

```php
$extraQueryString = "param1=value1&param2=value2!";
$sanitizedQueryString = Sanitize::extra_query_string($extraQueryString);
echo $sanitizedQueryString; // Outputs: "param1=value1&param2=value2"
```

### key (Sanitizing Generic Keys)

```php
$key = "my_key-123!";
$sanitizedKey = Sanitize::key($key);
echo $sanitizedKey; // Outputs: "my_key-123"
```

### bool (Sanitizing Boolean Values)

```php
$boolValue = "true";
$sanitizedBool = Sanitize::bool($boolValue);
echo $sanitizedBool ? 'true' : 'false'; // Outputs: true
```

### html (Sanitizing HTML Strings)

```php
$htmlString = "<div>Some content</div>";
$sanitizedHtml = Sanitize::html($htmlString);
echo $sanitizedHtml; // Outputs: "&lt;div&gt;Some content&lt;/div&gt;"
```

### url (Sanitizing URLs)

```php
$url = "http://example.com/page?query=<unsafe string>";
$sanitizedUrl = Sanitize::url($url);
echo $sanitizedUrl; // Outputs: "http://example.com/page?query=%3Cunsafe%20string%3E"
```

## Validate Class Examples

The `Validate` class offers a range of methods to ensure that your Amazon S3 operations use correctly formatted and
compliant parameters.

### accessKey (Validating AWS Access Key ID)

```php
use ArrayPress\S3\Validate;

try {
    Validate::accessKey("AKIA1234EXAMPLE");
    echo "Access key is valid.";
} catch (InvalidArgumentException $e) {
    echo "Access key validation error: " . $e->getMessage();
}
```

### secretKey (Validating AWS Secret Access Key)

```php
try {
    Validate::secretKey("wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY");
    echo "Secret key is valid.";
} catch (InvalidArgumentException $e) {
    echo "Secret key validation error: " . $e->getMessage();
}
```

### objectKey (Validating S3 Object Keys)

```php
try {
    Validate::objectKey("my_folder/my_file.txt");
    echo "Object key is valid.";
} catch (InvalidArgumentException $e) {
    echo "Object key validation error: " . $e->getMessage();
}
```

### bucket (Validating Bucket Names)

```php
try {
    Validate::bucket("my-bucket-name.123");
    echo "Bucket name is valid.";
} catch (InvalidArgumentException $e) {
    echo "Bucket name validation error: " . $e->getMessage();
}
```

### region (Validating S3 Region Strings)

```php
try {
    Validate::region( "us-west-1" );
    echo "Region is valid.";
} catch (InvalidArgumentException $e) {
    echo "Region validation error: " . $e->getMessage();
}
```

### endpoint (Validating Endpoints)

```php
try {
    Validate::endpoint( "my.endpoint.com" );
    echo "Endpoint is valid.";
} catch (InvalidArgumentException $e) {
    echo "Endpoint validation error: " . $e->getMessage();
}
```

### duration (Validating Duration Values)

```php
try {
    Validate::duration( 60 );
    echo "Duration is valid.";
} catch (InvalidArgumentException $e) {
    echo "Duration validation error: " . $e->getMessage();
}
```

### extraQueryString (Validating Extra Query Strings)

```php
try {
    Validate::extraQueryString( "param1=value1&param2=value2" );
    echo "Extra query string is valid.";
} catch (InvalidArgumentException $e) {
    echo "Extra query string validation error: " . $e->getMessage();
}
```

## Serialization Class Examples

The `Serialization` class facilitates the encoding and decoding of S3 object keys to ensure safe and compliant storage
paths.

### encodeObjectName (Encoding S3 Object Names)

Encoding S3 object names into URL-safe representations is crucial for handling special characters correctly, especially
when dealing with file paths that include spaces or reserved characters.

```php
use ArrayPress\S3\Serialization;

$objectName = "my folder/my file.txt";
$encodedObjectName = Serialization::encodeObjectName( $objectName );
echo $encodedObjectName; // Outputs: "my%20folder/my%20file.txt"
```

This method ensures that spaces are encoded as `%20` and slashes (`/`) are preserved, making the string safe for use in
URLs while retaining its significance as a path delimiter.

### decodeObjectName (Decoding URL-encoded S3 Object Keys)

Decoding is as important as encoding, especially when you need to retrieve and accurately identify resources based on
URL-encoded paths.

```php
$encodedKey = "my%20folder/my%20file.txt";
$decodedKey = Serialization::decodeObjectName( $encodedKey );
echo $decodedKey; // Outputs: "my folder/my file.txt"
```

This method converts URL-encoded representations back to their original form, allowing for the correct identification
and handling of object names within your application.

By utilizing these serialization methods, you can ensure that object names are consistently and securely processed
across your S3 operations, minimizing the risk of errors and enhancing data management practices.

## Helper Functions for S3 Operations

The helper functions `validate` and `sanitize` offer simplified interfaces for validating and sanitizing data respectively, by leveraging the `Validate` and `Sanitize` classes from the `ArrayPress\S3` namespace.

### Validate Helper Function

The `validate` function checks if a given value meets specific criteria defined in the `Validate` class methods. It returns `true` for successful validation or `false` otherwise.

```php
$isValid = validate( 'bucket', 'my-valid-bucket-name' );
if ( $isValid ) {
    echo "Bucket name is valid.";
} else {
    echo "Bucket name is invalid or method doesn't exist.";
}
```

This function abstracts the complexity of direct validation calls and exception handling, making it easier to integrate into validation flows.

### Sanitize Helper Function

The `sanitize` function cleans a given value according to the rules specified in the `Sanitize` class methods. It directly returns the sanitized value.

```php
// Should output the sanitized version of the object key, e.g., "my folder/my file.txt"
$sanitizedValue = sanitize( 'objectKey', 'my folder/my file.txt*' );
echo $sanitizedValue;
```

In case the specified method does not exist within the `Sanitize` class, an `InvalidArgumentException` is thrown, indicating an implementation error.

Note: Direct use of `sanitize` without checking for method existence might lead to exceptions if the method name is incorrect or not supported.

Utilizing these utility functions streamlines the process of ensuring that data interacting with Amazon S3 is properly formatted and validated, enhancing the security and reliability of your S3 operations.

## Contributions

Contributions to this library are highly appreciated. Raise issues on GitHub or submit pull requests for bug
fixes or new features. Share feedback and suggestions for improvements.

## License: GPLv2 or later

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public
License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.