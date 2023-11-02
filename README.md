# S3 Sanitization Library

The `Sanitization` class has been meticulously crafted to ensure the correctness and compliance of S3 bucket names, endpoints, regions, and object keys. Its objective is to sanitize and validate names and strings according to the S3 naming conventions, ensuring seamless integration with S3-compatible storage systems and safeguarding against potential naming conflicts or violations.

**Key Features:**

* **Bucket Name Sanitization:** Transform any input into a valid S3 bucket name. For instance, turning "My_Bucket-Name.123" into "my-bucket-name.123".
* **Endpoint & Region Cleaning:** Sanitize and strip endpoints and regions, ensuring they adhere to valid formats. Transforming something like "https://my.endpoint.com/" into "my.endpoint.com" or "us-west-1_extra" into "us-west-1".
* **Object Key Cleanup:** Object keys can contain a mix of characters, but the library ensures that they are compliant with S3 standards.
* **URL Encoding & Decoding:** The library offers functionality to encode and decode object keys, essential when dealing with spaces or special characters.
* **Validation:** Besides sanitization, the library also validates bucket names to make sure they conform to S3's stringent naming conventions.
* **Broad S3 Compatibility:** While the class aids in sanitization, its design ensures compatibility with numerous S3-Compatible storage solutions, including Linode, DigitalOcean Spaces, Cloudflare R2, BackBlaze, and more.

Ensure your S3 operations are error-free and compliant by integrating the `Sanitization` class into your application. Whether you're building a new application, migrating data, or just managing your S3 storage, proper naming and validation are crucial for smooth operations.

## Installation and set up

The extension in question needs to have a `composer.json` file, specifically with the following:

```json 
{
  "require": {
    "arraypress/s3-sanitization": "*"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/arraypress/s3-sanitization"
    }
  ]
}
```

Once set up, run `composer install --no-dev`. This should create a new `vendors/` folder
with `arraypress/s3-sanitization/` inside.

### Including the Vendor Library

Before using the `Sanitization` class, you need to include the Composer-generated autoload file. This file ensures that the required dependencies and classes are loaded into your PHP script. You can include it using the following code:

```php 
// Include the Composer-generated autoload file.
require_once dirname(__FILE__) . '/vendor/autoload.php';
```

**Usage Examples for the `Sanitization` Class**

**1. Sanitizing Bucket Names:**
```php
$input = "My_Bucket-Name.123";
$sanitized = ArrayPress\Utils\S3\Sanitization::bucket( $input );
echo $sanitized;  // Outputs: "my-bucket-name.123"
```

**2. Sanitizing S3 Region Strings:**
```php
$input = "us-west-1_extra";
$sanitized = ArrayPress\Utils\S3\Sanitization::region( $input );
echo $sanitized;  // Outputs: "us-west-1"
```

**3. Sanitizing Endpoints:**
```php
$input = "https://my.endpoint.com/";
$sanitized = ArrayPress\Utils\S3\Sanitization::endpoint( $input );
echo $sanitized;  // Outputs: "my.endpoint.com"
```

**4. Sanitizing Object Keys:**
```php
$input = "my_folder/my_file.txt*";
$sanitized = ArrayPress\Utils\S3\Sanitization::object_key( $input );
echo $sanitized;  // Outputs: "my_folder/my_file.txt"
```

**5. Encoding Object Names:**
```php
$input = "my folder/my file.txt";
$encoded = ArrayPress\Utils\S3\Sanitization::encode_object_name( $input );
echo $encoded;  // Outputs: "my%20folder/my%20file.txt"
```

**6. Decoding Object Names:**
```php
$input = "my%20folder/my%20file.txt";
$decoded = ArrayPress\Utils\S3\Sanitization::decode_object_name( $input );
echo $decoded;  // Outputs: "my folder/my file.txt"
```

**7. Validating Bucket Names:**
```php
$input = "my.bucket-123";
$isValid = ArrayPress\Utils\S3\Sanitization::is_valid_bucket( $input );
echo $isValid ? 'Valid' : 'Invalid';  // Outputs: "Valid"
```

## Contributions

Contributions to this library are highly appreciated. Raise issues on GitHub or submit pull requests for bug
fixes or new features. Share feedback and suggestions for improvements.

## License

This library is licensed under
the [GNU General Public License v2.0](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html).