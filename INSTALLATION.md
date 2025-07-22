# Installation Guide

This guide covers different ways to install and set up the Ongoing Warehouse API PHP Client.

## Prerequisites

- PHP 7.4 or higher
- Composer (recommended) or manual installation
- Valid Ongoing WMS API credentials

## Method 1: Composer Installation (Recommended)

### Step 1: Install via Composer

```bash
composer require thoaud/ongoing-warehouse-php
```

### Step 2: Include the autoloader

```php
<?php
require_once 'vendor/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;
```

### Step 3: Configure the client

```php
$config = new Configuration();
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
$config->setUsername('your-username');
$config->setPassword('your-password');
```

## Method 2: Manual Installation

### Step 1: Download the library

Download the latest release from GitHub or clone the repository:

```bash
git clone https://github.com/thoaud/ongoing-warehouse-php.git
cd ongoing-warehouse-php
```

### Step 2: Install dependencies

```bash
composer install
```

### Step 3: Include the autoloader

```php
<?php
require_once 'path/to/ongoing-api-php/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;
```

## Method 3: Direct Download

### Step 1: Download the ZIP file

Download the latest release ZIP file from GitHub.

### Step 2: Extract and include

```php
<?php
require_once 'path/to/extracted/ongoing-api-php/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;
```

## Configuration

### Basic Configuration

```php
<?php

use OngoingAPI\Configuration;

$config = new Configuration();

// Required settings
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
$config->setUsername('your-username');
$config->setPassword('your-password');

// Optional settings
$config->setDebug(true); // Enable debug mode
$config->setDebugFile('/tmp/ongoing-api.log'); // Debug log file
$config->setUserAgent('MyApp/1.0'); // Custom user agent
```

### Environment-based Configuration

```php
<?php

use OngoingAPI\Configuration;

$config = new Configuration();

// Load from environment variables
$config->setHost($_ENV['ONGOING_API_HOST']);
$config->setUsername($_ENV['ONGOING_API_USERNAME']);
$config->setPassword($_ENV['ONGOING_API_PASSWORD']);

// Optional: Load from .env file
if (file_exists('.env')) {
    $env = parse_ini_file('.env');
    $config->setHost($env['ONGOING_API_HOST']);
    $config->setUsername($env['ONGOING_API_USERNAME']);
    $config->setPassword($env['ONGOING_API_PASSWORD']);
}
```

### Configuration File

Create a configuration file `config.php`:

```php
<?php
// config.php
return [
    'host' => 'https://api.ongoingsystems.se/your-warehouse',
    'username' => 'your-username',
    'password' => 'your-password',
    'debug' => false,
    'debug_file' => '/tmp/ongoing-api.log',
];
```

Load the configuration:

```php
<?php

use OngoingAPI\Configuration;

$configArray = require 'config.php';
$config = new Configuration();

$config->setHost($configArray['host']);
$config->setUsername($configArray['username']);
$config->setPassword($configArray['password']);
$config->setDebug($configArray['debug']);
$config->setDebugFile($configArray['debug_file']);
```

## Verification

### Test Installation

Create a test file `test_installation.php`:

```php
<?php
require_once 'vendor/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;

try {
    // Test configuration
    $config = new Configuration();
    $config->setHost('https://api.ongoingsystems.se/your-warehouse');
    $config->setUsername('your-username');
    $config->setPassword('your-password');
    
    // Test API connection
    $articlesApi = new ArticlesApi(null, $config);
    $articles = $articlesApi->articlesGetAll(123, null, null, 1);
    
    echo "Installation successful! Found " . count($articles) . " articles.\n";
    
} catch (Exception $e) {
    echo "Installation test failed: " . $e->getMessage() . "\n";
}
```

Run the test:

```bash
php test_installation.php
```

## Troubleshooting

### Common Issues

#### 1. "Class not found" errors

**Solution**: Ensure the autoloader is included:

```php
require_once 'vendor/autoload.php'; // For Composer
// OR
require_once 'path/to/ongoing-api-php/autoload.php'; // For manual installation
```

#### 2. "Guzzle HTTP client not found" error

**Solution**: Install dependencies:

```bash
composer install
```

#### 3. Authentication errors

**Solution**: Verify your credentials and warehouse URL:

```php
$config->setHost('https://api.ongoingsystems.se/your-warehouse'); // Correct format
$config->setUsername('your-username'); // Your API username
$config->setPassword('your-password'); // Your API password
```

#### 4. SSL/TLS errors

**Solution**: Ensure you're using HTTPS and have valid SSL certificates:

```php
$config->setHost('https://api.ongoingsystems.se/your-warehouse'); // Must use HTTPS
```

#### 5. Timeout errors

**Solution**: Increase timeout settings:

```php
use GuzzleHttp\Client;

$client = new Client([
    'timeout' => 60,
    'connect_timeout' => 30,
]);

$articlesApi = new ArticlesApi($client, $config);
```

### Debug Mode

Enable debug mode to troubleshoot issues:

```php
$config->setDebug(true);
$config->setDebugFile('/tmp/ongoing-api-debug.log');
```

Check the debug log for detailed request/response information.

## Next Steps

After successful installation:

1. **Read the documentation**: See [README.md](README.md) for usage examples
2. **Check examples**: Look at the `examples/` directory for working code
3. **Run tests**: Execute `composer test` to verify everything works
4. **Start coding**: Begin integrating the API into your application

## Support

If you encounter installation issues:

- Check the [troubleshooting section](#troubleshooting)
- Review the [examples](examples/) directory
- Create an issue on [GitHub](https://github.com/thoaud/ongoing-warehouse-php/issues)
- Contact support at phpdevsec@proton.me 