<?php

/**
 * Basic Usage Example for Ongoing Warehouse API PHP Client
 * 
 * Package: thoaud/ongoing-warehouse-php
 * Repository: https://github.com/thoaud/ongoing-warehouse-php
 * 
 * This example demonstrates how to:
 * - Configure the API client
 * - Authenticate with the API
 * - Make basic API calls
 * - Handle responses and errors
 */

require_once __DIR__ . '/../vendor/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;
use OngoingAPI\Api\OrdersApi;
use OngoingAPI\Model\GetOrderModel;
use OngoingAPI\Model\GetOrderLine;

// Configuration
$config = new Configuration();

// Set your warehouse-specific API URL
$config->setHost('https://api.ongoingsystems.se/your-warehouse');

// Set your credentials
$config->setUsername('your-username');
$config->setPassword('your-password');

// Optional: Enable debug mode for troubleshooting
// $config->setDebug(true);
// $config->setDebugFile('/tmp/ongoing-api-debug.log');

echo "=== Ongoing Warehouse API PHP Client - Basic Usage Example ===\n\n";

try {
    // Example 1: Get all articles for a goods owner
    echo "1. Getting all articles...\n";
    $articlesApi = new ArticlesApi(null, $config);
    
    $goodsOwnerId = 123; // Replace with your goods owner ID
    $articles = $articlesApi->articlesGetAll($goodsOwnerId, null, null, 10); // Limit to 10 articles
    
    echo "Found " . count($articles) . " articles:\n";
    foreach ($articles as $article) {
        echo "  - Article: " . $article->getArticleName() . "\n";
        echo "    Number: " . $article->getArticleNumber() . "\n";
        echo "    Stock: " . $article->getInventoryInfo()->getSellableNumberOfItems() . " items\n";
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Error getting articles: " . $e->getMessage() . "\n";
}

try {
    // Example 2: Create a simple order
    echo "2. Creating a test order...\n";
    $ordersApi = new OrdersApi(null, $config);
    
    // Create order model
    $order = new GetOrderModel();
    $order->setOrderNumber('TEST-ORDER-' . time()); // Unique order number
    $order->setGoodsOwnerId($goodsOwnerId);
    
    // Add order line
    $orderLine = new GetOrderLine();
    $orderLine->setRowNumber(1);
    $orderLine->setArticleNumber('TEST-ARTICLE'); // Replace with actual article number
    $orderLine->setNumberOfItems(1);
    
    $order->setOrderLines([$orderLine]);
    
    // Create the order
    $result = $ordersApi->ordersPut($order);
    echo "Order created successfully!\n";
    echo "Order ID: " . $result->getOrderSystemId() . "\n\n";
    
} catch (Exception $e) {
    echo "Error creating order: " . $e->getMessage() . "\n";
}

try {
    // Example 3: Get order information
    echo "3. Getting order information...\n";
    $orderSystemId = 12345; // Replace with actual order system ID
    $order = $ordersApi->ordersGet($orderSystemId);
    
    echo "Order Details:\n";
    echo "  Order Number: " . $order->getOrderNumber() . "\n";
    echo "  Status: " . $order->getOrderInfo()->getOrderStatus()->getOrderStatusName() . "\n";
    echo "  Created: " . $order->getOrderInfo()->getCreatedDate() . "\n";
    echo "  Lines: " . count($order->getOrderLines()) . "\n\n";
    
} catch (Exception $e) {
    echo "Error getting order: " . $e->getMessage() . "\n";
}

try {
    // Example 4: Get article items for a goods owner
    echo "4. Getting article items...\n";
    $articleItemsApi = new OngoingAPI\Api\ArticleItemsApi(null, $config);
    
    $response = $articleItemsApi->articleItemsGetArticleItemsModel($goodsOwnerId, null, null, 10); // Limit to 10 articles
    
    echo "Found " . count($response->getArticleItems()) . " article items:\n";
    foreach ($response->getArticleItems() as $item) {
        echo "  - ArticleItemId: " . $item->getArticleItemId() . "\n";
        echo "    Batch: " . $item->getBatch() . "\n";
        echo "    Serial: " . $item->getSerial() . "\n";
        echo "    Status: " . $item->getStatusCode() . "\n";
        echo "    Items: " . $item->getNumberOfItems() . "\n";
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "Error getting article items: " . $e->getMessage() . "\n";
}

echo "=== Example completed ===\n"; 