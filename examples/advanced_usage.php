<?php

/**
 * Advanced Usage Example for Ongoing Warehouse API PHP Client
 * 
 * Package: thoaud/ongoing-warehouse-php
 * Repository: https://github.com/thoaud/ongoing-warehouse-php
 * 
 * This example demonstrates:
 * - Custom HTTP client configuration
 * - Error handling and retry logic
 * - Pagination handling
 * - Async operations
 * - Complex model creation
 */

require_once __DIR__ . '/../vendor/autoload.php';

use OngoingAPI\Configuration;
use OngoingAPI\Api\ArticlesApi;
use OngoingAPI\Api\OrdersApi;
use OngoingAPI\Api\PurchaseOrdersApi;
use OngoingAPI\Api\InventoryAdjustmentsApi;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

// Custom HTTP client with retry logic
function createHttpClient(): Client
{
    $stack = HandlerStack::create();
    
    // Add retry middleware
    $stack->push(Middleware::retry(
        function ($retries, Request $request, Response $response = null, \Exception $exception = null) {
            // Retry on 5xx errors or connection failures
            if ($retries >= 3) {
                return false;
            }
            
            if ($response && $response->getStatusCode() >= 500) {
                return true;
            }
            
            if ($exception instanceof \GuzzleHttp\Exception\ConnectException) {
                return true;
            }
            
            return false;
        },
        function ($retries, Request $request, Response $response = null) {
            // Exponential backoff: 1s, 2s, 4s
            return 1000 * pow(2, $retries - 1);
        }
    ));
    
    return new Client([
        'handler' => $stack,
        'timeout' => 30,
        'connect_timeout' => 10,
        'headers' => [
            'User-Agent' => 'OngoingAPI-PHP-Client/1.0.0',
        ]
    ]);
}

// Configuration with custom client
$config = new Configuration();
$config->setHost('https://api.ongoingsystems.se/your-warehouse');
$config->setUsername('your-username');
$config->setPassword('your-password');
$config->setDebug(true);
$config->setDebugFile('/tmp/ongoing-api-advanced.log');

$httpClient = createHttpClient();

echo "=== Ongoing Warehouse API PHP Client - Advanced Usage Example ===\n\n";

// Example 1: Pagination handling
echo "1. Handling pagination for large datasets...\n";
$articlesApi = new ArticlesApi($httpClient, $config);
$goodsOwnerId = 123;

try {
    $allArticles = [];
    $maxArticlesPerRequest = 100;
    $articleSystemIdFrom = null;
    $totalArticles = 0;
    
    do {
        $articles = $articlesApi->articlesGetAll(
            $goodsOwnerId,
            null, // article_number
            $articleSystemIdFrom, // article_system_id_from
            $maxArticlesPerRequest
        );
        
        $allArticles = array_merge($allArticles, $articles);
        $totalArticles += count($articles);
        
        // Get the last article ID for next pagination
        if (!empty($articles)) {
            $lastArticle = end($articles);
            $articleSystemIdFrom = $lastArticle->getArticleSystemId();
        }
        
        echo "Retrieved " . count($articles) . " articles (Total: $totalArticles)\n";
        
    } while (count($articles) === $maxArticlesPerRequest);
    
    echo "Total articles retrieved: " . count($allArticles) . "\n\n";
    
} catch (Exception $e) {
    echo "Error during pagination: " . $e->getMessage() . "\n";
}

// Example 2: Async operations
echo "2. Using async operations...\n";
try {
    $promises = [];
    
    // Start multiple async requests
    for ($i = 1; $i <= 3; $i++) {
        $promises["article_$i"] = $articlesApi->articlesGetAllAsync($goodsOwnerId, null, null, 10);
    }
    
    // Wait for all requests to complete
    $results = \GuzzleHttp\Promise\Utils::unwrap($promises);
    
    echo "Async requests completed:\n";
    foreach ($results as $key => $articles) {
        echo "  $key: " . count($articles) . " articles\n";
    }
    echo "\n";
    
} catch (Exception $e) {
    echo "Error with async operations: " . $e->getMessage() . "\n";
}

// Example 3: Error handling with custom retry logic
echo "3. Custom error handling and retry logic...\n";

function makeApiCallWithRetry(callable $apiCall, int $maxRetries = 3): mixed
{
    $attempt = 0;
    $lastException = null;
    
    while ($attempt < $maxRetries) {
        try {
            return $apiCall();
        } catch (\OngoingAPI\ApiException $e) {
            $lastException = $e;
            
            // Don't retry on client errors (4xx)
            if ($e->getCode() >= 400 && $e->getCode() < 500) {
                throw $e;
            }
            
            $attempt++;
            if ($attempt < $maxRetries) {
                echo "Attempt $attempt failed, retrying in " . (2 ** $attempt) . " seconds...\n";
                sleep(2 ** $attempt);
            }
        } catch (Exception $e) {
            $lastException = $e;
            $attempt++;
            if ($attempt < $maxRetries) {
                echo "Attempt $attempt failed, retrying in " . (2 ** $attempt) . " seconds...\n";
                sleep(2 ** $attempt);
            }
        }
    }
    
    throw $lastException;
}

try {
    $result = makeApiCallWithRetry(function () use ($articlesApi, $goodsOwnerId) {
        return $articlesApi->articlesGetAll($goodsOwnerId, null, null, 5);
    });
    
    echo "Successfully retrieved " . count($result) . " articles with retry logic\n\n";
    
} catch (Exception $e) {
    echo "All retry attempts failed: " . $e->getMessage() . "\n";
}

// Example 4: Working with different API endpoints
echo "4. Working with multiple API endpoints...\n";

try {
    // Articles API
    $articles = $articlesApi->articlesGetAll($goodsOwnerId, null, null, 5);
    echo "Articles API: " . count($articles) . " articles found\n";
    
    // Orders API
    $ordersApi = new OrdersApi($httpClient, $config);
    $orders = $ordersApi->ordersGetAll($goodsOwnerId, null, null, 5);
    echo "Orders API: " . count($orders) . " orders found\n";
    
    // Purchase Orders API
    $purchaseOrdersApi = new PurchaseOrdersApi($httpClient, $config);
    $purchaseOrders = $purchaseOrdersApi->purchaseOrdersGetAll($goodsOwnerId, null, null, 5);
    echo "Purchase Orders API: " . count($purchaseOrders) . " purchase orders found\n";
    
    // Inventory Adjustments API
    $inventoryAdjustmentsApi = new InventoryAdjustmentsApi($httpClient, $config);
    $adjustments = $inventoryAdjustmentsApi->inventoryAdjustmentsGetAll($goodsOwnerId, null, null, 5);
    echo "Inventory Adjustments API: " . count($adjustments) . " adjustments found\n";
    
} catch (Exception $e) {
    echo "Error working with multiple APIs: " . $e->getMessage() . "\n";
}

// Example 5: Configuration management
echo "5. Configuration management...\n";

// Create different configurations for different environments
$configs = [
    'development' => (new Configuration())
        ->setHost('https://api.ongoingsystems.se/dev-warehouse')
        ->setUsername('dev-user')
        ->setPassword('dev-password')
        ->setDebug(true),
    
    'staging' => (new Configuration())
        ->setHost('https://api.ongoingsystems.se/staging-warehouse')
        ->setUsername('staging-user')
        ->setPassword('staging-password')
        ->setDebug(false),
    
    'production' => (new Configuration())
        ->setHost('https://api.ongoingsystems.se/prod-warehouse')
        ->setUsername('prod-user')
        ->setPassword('prod-password')
        ->setDebug(false)
];

foreach ($configs as $environment => $config) {
    echo "  $environment: " . $config->getHost() . "\n";
}

echo "\n=== Advanced example completed ===\n"; 

// Example 1b: Get article items for a goods owner (with pagination)
echo "1b. Getting article items with pagination...\n";
$articleItemsApi = new OngoingAPI\Api\ArticleItemsApi($httpClient, $config);
try {
    $maxArticlesToGet = 100;
    $articleSystemIdFrom = null;
    $allArticleItems = [];
    do {
        $response = $articleItemsApi->articleItemsGetArticleItemsModel(
            $goodsOwnerId,
            null, // article_number
            $articleSystemIdFrom, // article_system_id_from
            $maxArticlesToGet
        );
        foreach ($response->getArticleItems() as $item) {
            echo "  - ArticleItemId: " . $item->getArticleItemId() . "\n";
            echo "    Batch: " . $item->getBatch() . "\n";
            echo "    Serial: " . $item->getSerial() . "\n";
            echo "    Status code: " . $item->getStatusCode() . "\n";
            // ... access other fields as needed ...
            $allArticleItems[] = $item;
        }
        $articleSystemIdFrom = $response->getArticleSystemId() + 1;
    } while (count($response->getArticleItems()) === $maxArticlesToGet);
    echo "Total article items fetched: " . count($allArticleItems) . "\n";
} catch (Exception $e) {
    echo "Error getting article items: " . $e->getMessage() . "\n";
} 