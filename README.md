# Ongoing Warehouse API PHP Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thoaud/ongoing-warehouse-php.svg)](https://packagist.org/packages/thoaud/ongoing-warehouse-php)
[![Total Downloads on Packagist](https://img.shields.io/packagist/dt/thoaud/ongoing-warehouse-php.svg)](https://packagist.org/packages/thoaud/ongoing-warehouse-php)
[![License](https://img.shields.io/packagist/l/thoaud/ongoing-warehouse-php.svg)](https://github.com/thoaud/ongoing-warehouse-php/blob/main/LICENSE)
[![PHP Version](https://img.shields.io/packagist/php-v/thoaud/ongoing-warehouse-php.svg)](https://packagist.org/packages/thoaud/ongoing-warehouse-php)

A PHP client library for the Ongoing Warehouse Management System REST API. This library provides a convenient way to interact with the Ongoing WMS API from PHP applications.

## Features

- **Complete API Coverage**: All Ongoing WMS REST API endpoints are supported
- **Type Safety**: Full PHP type hints and return type declarations
- **PSR Standards**: Compliant with PSR-7, PSR-18, and PSR-4
- **Modern PHP**: Requires PHP 7.4+ with modern features
- **Composer Ready**: Easy installation via Composer
- **Well Documented**: Comprehensive PHPDoc comments

## Installation

### Via Composer

```bash
composer require thoaud/ongoing-warehouse-php
```

### Manual Installation

1. Download the latest release
2. Extract to your project directory
3. Include the autoloader:

```php
require_once 'path/to/ongoing-api-php/autoload.php';
```

## Quick Start

### Basic Configuration

```php
<?php

require_once 'vendor/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;

// Configure the API client
$config = new Configuration();
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
$config->setUsername('your-username');
$config->setPassword('your-password');

// Create an API instance
$articlesApi = new ArticlesApi(null, $config);
```

### Example: Get All Articles

```php
<?php

use OngoingAPI\Api\ArticlesApi;
use OngoingAPI\Configuration;

// Setup configuration
$config = new Configuration();
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
$config->setUsername('your-username');
$config->setPassword('your-password');

// Create API client
$articlesApi = new ArticlesApi(null, $config);

try {
    // Get all articles for a goods owner
    $articles = $articlesApi->articlesGetAll(123); // goods_owner_id = 123
    
    foreach ($articles as $article) {
        echo "Article: " . $article->getArticleName() . "\n";
        echo "Stock: " . $article->getInventoryInfo()->getSellableNumberOfItems() . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

### Example: Create an Order

```php
<?php

use OngoingAPI\Api\OrdersApi;
use OngoingAPI\Configuration;
use OngoingAPI\Model\GetOrderModel;
use OngoingAPI\Model\GetOrderLine;

// Setup configuration
$config = new Configuration();
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
$config->setUsername('your-username');
$config->setPassword('your-password');

// Create API client
$ordersApi = new OrdersApi(null, $config);

try {
    // Create order model
    $order = new GetOrderModel();
    $order->setOrderNumber('ORD-001');
    $order->setGoodsOwnerId(123);
    
    // Add order line
    $orderLine = new GetOrderLine();
    $orderLine->setRowNumber(1);
    $orderLine->setArticleNumber('ART-001');
    $orderLine->setNumberOfItems(5);
    
    $order->setOrderLines([$orderLine]);
    
    // Create the order
    $result = $ordersApi->ordersPut($order);
    echo "Order created successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
```

## API Endpoints

This library provides access to all Ongoing WMS API endpoints:

### Articles
- `ArticlesApi` - Manage articles, inventory, and article data
- `ArticleItemsApi` - Work with individual article items

### Orders
- `OrdersApi` - Create and manage customer orders
- `ReturnOrdersApi` - Handle return orders

### Purchase Orders
- `PurchaseOrdersApi` - Manage incoming purchase orders

### Inventory
- `InventoryAdjustmentsApi` - Handle inventory adjustments

### Warehouses
- `WarehousesApi` - Warehouse information and management

### Invoices
- `InvoicesApi` - Invoice management

### Transport
- `TransporterContractsApi` - Transporter contract management
- `ParcelTypesApi` - Parcel type information

## Configuration Options

### Authentication

The API uses HTTP Basic Authentication:

```php
$config->setUsername('your-username');
$config->setPassword('your-password');
```

### Host Configuration

Set your warehouse-specific API URL:

```php
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
```

### Debug Mode

Enable debug mode for troubleshooting:

```php
$config->setDebug(true);
$config->setDebugFile('/path/to/debug.log');
```

### Custom HTTP Client

You can use a custom HTTP client:

```php
use GuzzleHttp\Client;

$client = new Client([
    'timeout' => 30,
    'verify' => false // Only for development
]);

$articlesApi = new ArticlesApi($client, $config);
```

## Error Handling

The library throws exceptions for API errors:

```php
try {
    $articles = $articlesApi->articlesGetAll(123);
} catch (\OngoingAPI\ApiException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
    echo "Response Code: " . $e->getCode() . "\n";
    echo "Response Body: " . $e->getResponseBody() . "\n";
} catch (\Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
```

## Pagination

Many API endpoints support pagination. Use the `max_articles_to_get` parameter:

```php
// Get first 100 articles
$articles = $articlesApi->articlesGetAll(123, null, null, 100);

// Get next 100 articles (using article_system_id_from)
$nextArticles = $articlesApi->articlesGetAll(123, null, $lastArticleId, 100);
```

## Development

### Running Tests

```bash
composer test
```

### Code Quality

```bash
# Run PHPStan static analysis
composer phpstan

# Run PHP CodeSniffer
composer phpcs

# Auto-fix coding standards
composer phpcbf
```

### Building Documentation

```bash
# Generate API documentation
composer docs
```

## Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

## Support

- **Documentation**: [Ongoing WMS API Documentation](https://developer.ongoingwarehouse.com/)
- **Email**: phpdevsec@proton.me
- **Issues**: [GitHub Issues](https://github.com/thoaud/ongoing-warehouse-php/issues)

## License

This library is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for a list of changes and version history.

## Acknowledgments

- [Ongoing Warehouse](https://www.ongoingwarehouse.com/) for providing the API
- [OpenAPI Generator](https://openapi-generator.tech/) for generating the base client code
- [Directhouse](https://directhouse.no) for development and maintenance 