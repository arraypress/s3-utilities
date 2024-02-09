# S3 Utilities Library

The S3 Utilities Library is a comprehensive toolkit designed for developers working with Amazon S3 and S3-compatible storage solutions. This library encompasses a wide range of functionalities including sanitization, validation, and serialization of S3 parameters, ensuring adherence to AWS standards and enhancing the safety and efficiency of cloud storage operations.

**Key Features:**

- **Comprehensive Sanitization:** Ensures that bucket names, object keys, endpoints, and other parameters conform to S3 standards by removing or replacing invalid characters.
- **Robust Validation:** Validates inputs to ensure they meet specific criteria for AWS access keys, bucket names, object keys, and more, preventing common errors.
- **Advanced Serialization:** Facilitates the correct encoding and decoding of object keys, crucial for handling special characters in S3 object paths.
- **Wide Compatibility:** Designed to work seamlessly with AWS S3 and various S3-compatible services like Linode, DigitalOcean Spaces, and BackBlaze.
- **Utility Functions:** Provides helper functions for validation and sanitization, simplifying common tasks and streamlining development.

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

## Usage Examples

**Sanitize::accessKey (Sanitizing AWS Access Key ID):**

```php
use ArrayPress\S3\Sanitize;

echo Sanitize::accessKey("AKIAIOSFODNN7EXAMPLE");
// Outputs: "AKIAIOSFODNN7EXAMPLE"
```

**Sanitize::secretKey (Sanitizing AWS Secret Access Key):**

```php
echo Sanitize::secretKey("wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY");
// Outputs: "wJalrXUtnFEMIK7MDENGbPxRfiCYEXAMPLEKEY"
```

**Sanitize::bucket (Sanitizing Bucket Names):**

```php
echo Sanitize::bucket("My_Bucket-Name.123");
// Outputs: "my-bucket-name.123"
```

**Sanitize::objectKey (Sanitizing Object Keys):**

```php
echo Sanitize::objectKey("my_folder/my_file.txt*");
// Outputs: "my_folder/my_file.txt"
```

**Sanitize::region (Sanitizing S3 Region Strings):**

```php
echo Sanitize::region("us-west-1_extra");
// Outputs: "us-west-1"
```

**Sanitize::endpoint (Sanitizing Endpoints):**

```php
echo Sanitize::endpoint("https://my.endpoint.com/");
// Outputs: "my.endpoint.com"
```

**Validate::accessKey (Validating AWS Access Key ID):**

```php
use ArrayPress\S3\Validate;

if (Validate::accessKey("AKIAIOSFODNN7EXAMPLE")) {
    echo "Access key is valid.";
} else {
    echo "Access key is invalid.";
}
```

**Validate::secretKey (Validating AWS Secret Access Key):**

```php
if (Validate::secretKey("wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY")) {
    echo "Secret key is valid.";
} else {
    echo "Secret key is invalid.";
}
```

**Validate::bucket (Validating Bucket Names):**

```php
if (Validate::bucket("my-bucket-name.123")) {
    echo "Bucket name is valid.";
} else {
    echo "Bucket name is invalid.";
}
```

**Validate::objectKey (Validating Object Keys):**

```php
if (Validate::objectKey("my_folder/my_file.txt")) {
    echo "Object key is valid.";
} else {
    echo "Object key is invalid.";
}
```

**Validate::region (Validating S3 Region Strings):**

```php
if (Validate::region("us-west-1")) {
    echo "Region is valid.";
} else {
    echo "Region is invalid.";
}
```

**Serialization::encodeObjectName (Encoding Object Names):**

```php
use ArrayPress\S3\Serialization;

echo Serialization::encodeObjectName("my folder/my file.txt");
// Outputs: "my%20folder/my%20file.txt"
```

**Serialization::decodeObjectName (Decoding Object Names):**

```php
echo Serialization::decodeObjectName("my%20folder/my%20file.txt");
// Outputs: "my folder/my file.txt"
```

## Contributions

Contributions to this library are highly appreciated. Raise issues on GitHub or submit pull requests for bug
fixes or new features. Share feedback and suggestions for improvements.

## License: GPLv2 or later

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public
License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.