# S3 Utilities Library

The utilities library has been meticulously crafted to ensure the correctness and compliance of S3 bucket names,
endpoints, regions, and object keys. Its objective is to sanitize and validate names and strings according to the S3
naming conventions, ensuring seamless integration with S3-compatible storage systems and safeguarding against potential
naming conflicts or violations.

**Key Features:**

* **Bucket Name Sanitization:** Transform any input into a valid S3 bucket name. For instance, turning "
  My_Bucket-Name.123" into "my-bucket-name.123".
* **Endpoint & Region Cleaning:** Sanitize and strip endpoints and regions, ensuring they adhere to valid formats.
  Transforming something like "https://my.endpoint.com/" into "my.endpoint.com" or "us-west-1_extra" into "us-west-1".
* **Object Key Cleanup:** Object keys can contain a mix of characters, but the library ensures that they are compliant
  with S3 standards.
* **URL Encoding & Decoding:** The library offers functionality to encode and decode object keys, essential when dealing
  with spaces or special characters.
* **Validation:** Besides sanitization, the library also validates bucket names to make sure they conform to S3's
  stringent naming conventions.
* **Broad S3 Compatibility:** While the class aids in sanitization, its design ensures compatibility with numerous
  S3-Compatible storage solutions, including Linode, DigitalOcean Spaces, Cloudflare R2, BackBlaze, and more.

Ensure your S3 operations are error-free and compliant by integrating the `Sanitize` class into your application.
Whether you're building a new application, migrating data, or just managing your S3 storage, proper naming and
validation are crucial for smooth operations.

## Minimum Requirements ##

* **PHP:** 7.4

## Installation ##

S3 Utilities is a developer library, not a plugin, which means you need to include it somewhere in your own
project.

You can use Composer:

```bash
composer require arraypress/slurp
```

### Including the Vendor Library

```php 
// Require the Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';
```

**Usage Examples for the `Sanitize` Class**

**1. Sanitizing Bucket Names:**

```php
$input = "My_Bucket-Name.123";
$sanitized = ArrayPress\S3\Sanitize::bucket( $input );
echo $sanitized;  // Outputs: "my-bucket-name.123"
```

**2. Sanitizing S3 Region Strings:**

```php
$input = "us-west-1_extra";
$sanitized = ArrayPress\S3\Sanitize::region( $input );
echo $sanitized;  // Outputs: "us-west-1"
```

**3. Sanitizing Endpoints:**

```php
$input = "https://my.endpoint.com/";
$sanitized = ArrayPress\S3\Sanitize::endpoint( $input );
echo $sanitized;  // Outputs: "my.endpoint.com"
```

**4. Sanitizing Object Keys:**

```php
$input = "my_folder/my_file.txt*";
$sanitized = ArrayPress\S3\Sanitize::objectKey( $input );
echo $sanitized;  // Outputs: "my_folder/my_file.txt"
```

**5. Encoding Object Names:**

```php
$input = "my folder/my file.txt";
$encoded = ArrayPress\S3\Serialization::encodeObjectName( $input );
echo $encoded;  // Outputs: "my%20folder/my%20file.txt"
```

**6. Decoding Object Names:**

```php
$input = "my%20folder/my%20file.txt";
$decoded = ArrayPress\S3\Serialization::decodeObjectName( $input );
echo $decoded;  // Outputs: "my folder/my file.txt"
```

**7. Validating Bucket Names:**

```php
$input = "my.bucket-123";
$is_valid = ArrayPress\S3\Validate::is_valid( $input, 'bucket' );
echo $is_valid ? 'Valid' : 'Invalid';  // Outputs: "Valid"
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