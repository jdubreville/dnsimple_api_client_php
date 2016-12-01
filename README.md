DNSimple API Client PHP
=======================

A PHP Client for the DNSimple API. For information on parameters please review the 
[DNSimple API Reference](https://developer.dnsimple.com/v1/).

Please note this is still in development on pieces of the code as not all functions have been tested.

## Installation

The API Client can be installed using [Composer](https://packagist.org/packages/zendesk/zendesk_api_client_php).

### Composer

```json
{
  "require": {
    "jdubreville/dnsipmle_api_client_php": "dev-master"
  }
}
```

## Configuration

Configuring the client is done through an instance of the jduebrville\dnsimple\Client class.

```php
use jdubreville\dnsimple\Client as DNSimpleAPI;

$email = "email@example.com"; // replace with your account email address
$token = "ajfdaojfoawjf98uwejfaw"; // replace with your account token (found in account settings)

$client = new DNSimpleAPI($email, $token);
```

## Usage

### Basic Operations

```php
// Get all domains
$domains = $client->domains()->getAll();
print_r($domains);

// Search for a given record.
$domains = $client->domains()->getAll(array('name' => 'some_host_name'));
print_r($domains);

// Create a new domain
$newDomain = $client->domains()->create(array(
  'name' => 'example.com',
  )
));
print_r($newDomain);

// Get a domain
$domain = $client->domains('example.com')->get();
print_r($domain);

// Add a Domain Record
$client->domains('example.com')->records()->create(array(
  'name' => '',
  'record_type' => 'A',
  'content' => '1.2.3.4'
));

// Delete a Domain
$client->domains('example.com')->delete();
```

## Note on Patches/Pull Requests
1. Fork the project.
2. Make changes.
3. Add tests for it. This way future releases can be verified.
4. Commit your changes.
5. Send a pull request.

## License

Licensed under the MIT License

Please refer to the LICENSE file for more information.
