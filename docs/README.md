# Documentation

Welcome to the Ongoing Warehouse API PHP Client documentation. This directory contains comprehensive documentation for using the library.

## Table of Contents

### Getting Started
- [Installation Guide](../INSTALLATION.md) - How to install and set up the library
- [Basic Usage](../README.md#quick-start) - Quick start guide with examples
- [Configuration](../README.md#configuration-options) - Configuration options and settings

### API Reference
- [Articles API](articles-api.md) - Working with articles and inventory
- [Orders API](orders-api.md) - Creating and managing orders
- [Purchase Orders API](purchase-orders-api.md) - Managing purchase orders
- [Inventory API](inventory-api.md) - Inventory management and adjustments
- [Warehouses API](warehouses-api.md) - Warehouse information
- [Invoices API](invoices-api.md) - Invoice management
- [Transport API](transport-api.md) - Transporter and parcel management

### Advanced Topics
- [Error Handling](error-handling.md) - Comprehensive error handling guide
- [Pagination](pagination.md) - Working with large datasets
- [Async Operations](async-operations.md) - Using async/await patterns
- [Custom HTTP Client](custom-http-client.md) - Customizing HTTP behavior
- [Security Best Practices](security.md) - Security guidelines

### Development
- [Contributing Guide](../CONTRIBUTING.md) - How to contribute to the project
- [Testing Guide](testing.md) - Running tests and writing new tests
- [Code Style](code-style.md) - Coding standards and conventions
- [Release Process](release-process.md) - How releases are made

### Examples
- [Basic Examples](../examples/basic_usage.php) - Simple usage examples
- [Advanced Examples](../examples/advanced_usage.php) - Complex scenarios
- [Integration Examples](integration-examples.md) - Real-world integration patterns

### Troubleshooting
- [Common Issues](troubleshooting.md) - Solutions to common problems
- [Debug Mode](debug-mode.md) - Using debug features
- [Performance Tips](performance.md) - Optimizing performance

## Quick Reference

### Basic Setup

```php
<?php
require_once 'vendor/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;

$config = new Configuration();
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
$config->setUsername('your-username');
$config->setPassword('your-password');

$articlesApi = new ArticlesApi(null, $config);
```

### Common Operations

```php
// Get all articles
$articles = $articlesApi->articlesGetAll($goodsOwnerId);

// Create an order
$order = new GetOrderModel();
$order->setOrderNumber('ORD-001');
$order->setGoodsOwnerId($goodsOwnerId);
$result = $ordersApi->ordersPut($order);

// Get order details
$order = $ordersApi->ordersGet($orderSystemId);
```

### Error Handling

```php
try {
    $articles = $articlesApi->articlesGetAll($goodsOwnerId);
} catch (\OngoingAPI\ApiException $e) {
    echo "API Error: " . $e->getMessage() . "\n";
    echo "Response Code: " . $e->getCode() . "\n";
} catch (Exception $e) {
    echo "General Error: " . $e->getMessage() . "\n";
}
```

## Support

- **Documentation Issues**: Create an issue on [GitHub](https://github.com/thoaud/ongoing-warehouse-php/issues)
- **API Questions**: Contact phpdevsec@proton.me
- **Library Issues**: Check the [troubleshooting guide](troubleshooting.md)
- **Security Issues**: See [SECURITY.md](../SECURITY.md)

## Contributing to Documentation

We welcome contributions to improve the documentation:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

Please follow the same coding standards as the codebase and ensure all examples are tested.

## Documentation Structure

```
docs/
├── README.md                 # This file
├── articles-api.md           # Articles API documentation
├── orders-api.md            # Orders API documentation
├── purchase-orders-api.md    # Purchase Orders API documentation
├── inventory-api.md          # Inventory API documentation
├── warehouses-api.md         # Warehouses API documentation
├── invoices-api.md           # Invoices API documentation
├── transport-api.md          # Transport API documentation
├── error-handling.md         # Error handling guide
├── pagination.md            # Pagination guide
├── async-operations.md      # Async operations guide
├── custom-http-client.md    # Custom HTTP client guide
├── security.md              # Security best practices
├── testing.md               # Testing guide
├── code-style.md            # Code style guide
├── release-process.md       # Release process
├── integration-examples.md  # Integration examples
├── troubleshooting.md       # Troubleshooting guide
├── debug-mode.md            # Debug mode guide
└── performance.md           # Performance tips
```

## Version Information

This documentation is for version 1.0.0 of the Ongoing Warehouse API PHP Client.

For version-specific information, see the [CHANGELOG.md](../CHANGELOG.md) file. 