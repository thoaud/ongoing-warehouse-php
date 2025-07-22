<?php
/**
 * PurchaseOrdersApi
 * PHP version 7.4
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Ongoing WMS Goods Owner REST API
 *
 * Welcome to the documentation for Ongoing WMS Goods Owner REST API. [Ongoing WMS](https://www.ongoingwarehouse.com) is a cloud-based Warehouse Management System.  This API is intended to be used by people who wish to integrate systems such as a web shops or ERPs (Enterprise Resource Planning systems) with our WMS.  Please note that we have two other APIs as well:  * [Goods Owner SOAP API](https://developer.ongoingwarehouse.com/). The SOAP API fills a similar role as the REST API, but allows for more fine-grained control over Ongoing WMS than the REST API. * [Automation API](https://developer.ongoingwarehouse.com/automation-api). This API is intended to be used for integrations with automation equipment such as conveyor belts.  If you are unsure about whether you should use the REST API or the SOAP API, [please click here](https://developer.ongoingwarehouse.com/soap-vs-rest) to read our comparison between the two APIs.  If you have any questions, please send us an email at [contact@ongoingwarehouse.com](mailto:contact@ongoingwarehouse.com).  # REST API  [REST](https://en.wikipedia.org/wiki/Representational_state_transfer), or `Representational state transfer`, is a software architectural style used for creating Application Programming Interfaces (APIs). Our API tries to follow best practices for REST.  # How to use the API  On a basic level, the API consists of JSON requests and JSON replies being sent over HTTPS. To make it easier to use our API, we provide an [OpenAPI specification file](openapi.json) (formerly known as a Swagger specification file). Using this file you can use tools such as [Swagger CodeGen](https://swagger.io/tools/swagger-codegen/) or [NSwag](https://github.com/RicoSuter/NSwag) to automatically generate client code which lets you access the API.  ## Example C# integration  [Click here](https://github.com/OngoingWarehouse/Ongoing-Warehouse-REST-API-DotNet-Examples) to see an  example integration written in C#. We used NSwag to generate a client for accessing the API, and then used the client to make various requests.  ## Example requests and responses  [Click here](https://github.com/OngoingWarehouse/Ongoing-Warehouse-REST-API-Example-Requests) to see examples of what the requests and responses look like. The aforementioned link also contains a Postman collection of requests.  ## PUT and POST  Some of our requests support PUT and some support POST. The difference between them is: * If you make a PUT request, then the resource will either be created (if it does not already exist), or updated (if it already exists). * If you make a POST request, a new resource will always be created.  As an example, to create a new order, you make a PUT request with a new order number. If you wish to update the same order, you make another PUT request (with the same order number).  # Credentials  To integrate with our WMS, you will need the following:  1. A user name. 2. A password. 3. A goods owner ID.  Please ask the warehouse administrator for this information. [We have written a guide](https://docs.ongoingwarehouse.com/manuals/api-access) which shows how they can find it.  ## API URL  Every Ongoing WMS has its own unique URL for the API endpoint. The base API URL for a production system looks like this:  ``` API URL: https://api.ongoingsystems.se/{warehouse}/api/v1/ ```  Ask your contact person at the warehouse to specify what  ```{warehouse}``` should be in your particular case. ```{warehouse}``` can be taken from the  same URL which they use to login to the system:  ``` Login URL: https://{warehouse}.ongoingsystems.se/{warehouse} ```   # Authentication  The API uses [HTTP Basic Authentication](https://en.wikipedia.org/wiki/Basic_access_authentication).  Each request to the API must have a header called `Authorization`, which in turn must contain Base64-encoded information about your username and password, like so:  ``` Authorization: Basic QWxhZGRpbjpPcGVuU2VzYW1l ```  If the framework which you are using does not take care of this automatically, you will need to generate the header yourself. Take your username and password, and put them together in a new string with a colon between them. Then encode the result using [Base64](https://en.wikipedia.org/wiki/Base64). In pseudo code, it looks like this:  ``` var userNameAndPassword = Base64Encode(userName + \":\" + passWord); var authenticationHeader = \"Basic \" + userNameAndPassword; ```  # Security  All requests to the API must be encrypted, that is, sent using `https`.  # Content types  The API only accepts [JSON](https://en.wikipedia.org/wiki/JSON). All responses are also made as JSON.  # Time zones  ## Response  In the API responses, all times are given as UTC, like so:  ```     \"createdDate\": \"2019-04-09T10:39:31.3Z\" ```  ## Request  When you send in times in API requests, we strongly recommend that it is sent as UTC and that you specify the UTC time zone.  For instance, say that you want to know which orders the warehouse has shipped after 08:00 UTC on April 9, 2019. The date should be written like this:  ``` 2019-04-09T08:00:00.000+00:00 ```  Then it should be URL encoded:  ``` 2019-04-09T08%3A00%3A00.000%2B00%3A00 ```  Thus resulting in a request URL like this:  ``` GET api/v1/orders?goodsOwnerId=114&shippedTimeFrom=2019-04-09T08%3A00%3A00.000%2B00%3A00 ```  # Pagination  When you read data from the API, the API by default responds with all objects which match your filter. If there are too many objects which match your filter, this may cause timeouts. For instance, if the goods owner has 100 000 articles and you try to fetch them all with GetInventoryByQuery at the same time, you will most likely encounter a timeout.  We recommend that you paginate the responses for every API function which supports it. [Click here to read more about how pagination is handled in our API.](https://developer.ongoingwarehouse.com/paginating-responses)  # Entities  ## Goods owner  The clients of a warehouse are called goods owners. In other words, a goods owner is company which has hired a certain warehouse to deal with its warehousing needs. Each goods owner has a unique ID (an integer).  ## Article  An article is a stock-keeping unit (SKU). That is, articles are the things which a goods owner keeps at a warehouse. Each article needs a unique article number.  ### Stock balances  By making a GET request to the /articles endpoint, you will receive information about the inventory state for each article, in the section called `inventoryInfo`. The field called `sellableNumberOfItems` contains the number of items which can still be sold. If you create an order for an item, then the sellable number of items will be decreased accordingly. The field called `numberOfItems` contains the number of items which are physically present in the warehouse. If you are interested in more details, please see [this article](https://developer.ongoingwarehouse.com/inventory).  ## Article items  An article item represents part of the stock balance for a particular article. For instance, if the warehouse keeps the same article in two different locations, then the article will have at least two article items. For more information, [see this article](https://docs.ongoingwarehouse.com/manuals/batch-and-serial-numbers/).  By fetching all article items, you can see very detailed information about what is in stock. For instance, you can see exactly which batch numbers are in stock.  ## Order  An order is used to instruct the warehouse to ship articles to a specific customer. Each order needs a unique order number. You may not have two different orders with the same order number.  You may not update or cancel an order after the warehouse has started working on it.  ### Order lines  An order can have several order lines. For each order line, you must specify a unique number in the field `rowNumber`. If your system does not have a unique reference for each order line, you can simply use `1, 2, 3`, etc. as row numbers instead.  ### Transporter  It is possible to [set which transporter service should be used to ship an order](https://developer.ongoingwarehouse.com/transporters).  ## Purchase order  A purchase order is used to advise the warehouse of incoming deliveries. Each purchase order needs a unique purchase order number.  You may not update or cancel a purchase order after the warehouse has started working on it.  ### Purchase order lines  A purchase order can have several purchase order lines. For each purchase order line, you must specify a unique number in the field `rowNumber`. If your system does not have a unique reference for each purchase order line, you can simply use `1, 2, 3`, etc. as row numbers instead.  ## Return order  A return order is used to advise the warehouse that a customer intends to send back goods to the warehouse. Each return order refers to a particular order.  ## Warehouse  Each Ongoing WMS instance contains at least one warehouse.
 *
 * The version of the OpenAPI document: 1.0.0
 * Contact: contact@ongoingwarehouse.com
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 7.4.0-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace OngoingAPI\Api;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use OngoingAPI\ApiException;
use OngoingAPI\Configuration;
use OngoingAPI\HeaderSelector;
use OngoingAPI\ObjectSerializer;

/**
 * PurchaseOrdersApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class PurchaseOrdersApi
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var Configuration
     */
    protected $config;

    /**
     * @var HeaderSelector
     */
    protected $headerSelector;

    /**
     * @var int Host index
     */
    protected $hostIndex;

    /** @var string[] $contentTypes **/
    public const contentTypes = [
        'purchaseOrdersDelete' => [
            'application/json',
        ],
        'purchaseOrdersDeleteByOrderNumber' => [
            'application/json',
        ],
        'purchaseOrdersGet' => [
            'application/json',
        ],
        'purchaseOrdersGetAll' => [
            'application/json',
        ],
        'purchaseOrdersGetFiles' => [
            'application/json',
        ],
        'purchaseOrdersGetPurchaseOrderStatuses' => [
            'application/json',
        ],
        'purchaseOrdersGetPurchaseOrderTypes' => [
            'application/json',
        ],
        'purchaseOrdersPatchAdvisedDate' => [
            'application/json',
        ],
        'purchaseOrdersPatchFreeBool1' => [
            'application/json',
        ],
        'purchaseOrdersPatchFreeText1' => [
            'application/json',
        ],
        'purchaseOrdersPatchFreeText2' => [
            'application/json',
        ],
        'purchaseOrdersPatchFreeText3' => [
            'application/json',
        ],
        'purchaseOrdersPatchInDate' => [
            'application/json',
        ],
        'purchaseOrdersPatchPurchaseOrderLineFreeText1' => [
            'application/json',
        ],
        'purchaseOrdersPatchPurchaseOrderLineFreeText2' => [
            'application/json',
        ],
        'purchaseOrdersPatchPurchaseOrderNumber' => [
            'application/json',
        ],
        'purchaseOrdersPatchReportedNumberOfItems' => [
            'application/json',
        ],
        'purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems' => [
            'application/json',
        ],
        'purchaseOrdersPatchStatus' => [
            'application/json',
        ],
        'purchaseOrdersPostPurchaseOrderFile' => [
            'application/json',
        ],
        'purchaseOrdersPut' => [
            'application/json',
        ],
        'purchaseOrdersPut2' => [
            'application/json',
        ],
        'purchaseOrdersPutArticleItems' => [
            'application/json',
        ],
        'purchaseOrdersPutFile' => [
            'application/json',
        ],
        'purchaseOrdersPutFileUsingFilename' => [
            'application/json',
        ],
    ];

    /**
     * @param ClientInterface $client
     * @param Configuration   $config
     * @param HeaderSelector  $selector
     * @param int             $hostIndex (Optional) host index to select the list of hosts if defined in the OpenAPI spec
     */
    public function __construct(
        ClientInterface $client = null,
        Configuration $config = null,
        HeaderSelector $selector = null,
        $hostIndex = 0
    ) {
        $this->client = $client ?: new Client();
        $this->config = $config ?: new Configuration();
        $this->headerSelector = $selector ?: new HeaderSelector();
        $this->hostIndex = $hostIndex;
    }

    /**
     * Set the host index
     *
     * @param int $hostIndex Host index (required)
     */
    public function setHostIndex($hostIndex): void
    {
        $this->hostIndex = $hostIndex;
    }

    /**
     * Get the host index
     *
     * @return int Host index
     */
    public function getHostIndex()
    {
        return $this->hostIndex;
    }

    /**
     * @return Configuration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Operation purchaseOrdersDelete
     *
     * Cancel a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDelete'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostPurchaseOrderResponse
     */
    public function purchaseOrdersDelete($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersDelete'][0])
    {
        list($response) = $this->purchaseOrdersDeleteWithHttpInfo($purchase_order_id, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersDeleteWithHttpInfo
     *
     * Cancel a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDelete'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersDeleteWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersDelete'][0])
    {
        $request = $this->purchaseOrdersDeleteRequest($purchase_order_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersDeleteAsync
     *
     * Cancel a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersDeleteAsync($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersDelete'][0])
    {
        return $this->purchaseOrdersDeleteAsyncWithHttpInfo($purchase_order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersDeleteAsyncWithHttpInfo
     *
     * Cancel a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersDeleteAsyncWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersDelete'][0])
    {
        $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
        $request = $this->purchaseOrdersDeleteRequest($purchase_order_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersDelete'
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersDeleteRequest($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersDelete'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersDelete'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'DELETE',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersDeleteByOrderNumber
     *
     * Cancel a purchase order using the purchase order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostPurchaseOrderResponse
     */
    public function purchaseOrdersDeleteByOrderNumber($goods_owner_id, $purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersDeleteByOrderNumber'][0])
    {
        list($response) = $this->purchaseOrdersDeleteByOrderNumberWithHttpInfo($goods_owner_id, $purchase_order_number, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersDeleteByOrderNumberWithHttpInfo
     *
     * Cancel a purchase order using the purchase order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersDeleteByOrderNumberWithHttpInfo($goods_owner_id, $purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersDeleteByOrderNumber'][0])
    {
        $request = $this->purchaseOrdersDeleteByOrderNumberRequest($goods_owner_id, $purchase_order_number, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersDeleteByOrderNumberAsync
     *
     * Cancel a purchase order using the purchase order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersDeleteByOrderNumberAsync($goods_owner_id, $purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersDeleteByOrderNumber'][0])
    {
        return $this->purchaseOrdersDeleteByOrderNumberAsyncWithHttpInfo($goods_owner_id, $purchase_order_number, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersDeleteByOrderNumberAsyncWithHttpInfo
     *
     * Cancel a purchase order using the purchase order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersDeleteByOrderNumberAsyncWithHttpInfo($goods_owner_id, $purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersDeleteByOrderNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
        $request = $this->purchaseOrdersDeleteByOrderNumberRequest($goods_owner_id, $purchase_order_number, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersDeleteByOrderNumber'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersDeleteByOrderNumberRequest($goods_owner_id, $purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersDeleteByOrderNumber'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling purchaseOrdersDeleteByOrderNumber'
            );
        }

        // verify the required parameter 'purchase_order_number' is set
        if ($purchase_order_number === null || (is_array($purchase_order_number) && count($purchase_order_number) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_number when calling purchaseOrdersDeleteByOrderNumber'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $goods_owner_id,
            'goodsOwnerId', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $purchase_order_number,
            'purchaseOrderNumber', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);




        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'DELETE',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersGet
     *
     * Get a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetPurchaseOrderModel
     */
    public function purchaseOrdersGet($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGet'][0])
    {
        list($response) = $this->purchaseOrdersGetWithHttpInfo($purchase_order_id, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersGetWithHttpInfo
     *
     * Get a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetPurchaseOrderModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersGetWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGet'][0])
    {
        $request = $this->purchaseOrdersGetRequest($purchase_order_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetPurchaseOrderModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetPurchaseOrderModel' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetPurchaseOrderModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetPurchaseOrderModel';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\GetPurchaseOrderModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersGetAsync
     *
     * Get a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetAsync($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGet'][0])
    {
        return $this->purchaseOrdersGetAsyncWithHttpInfo($purchase_order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersGetAsyncWithHttpInfo
     *
     * Get a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetAsyncWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGet'][0])
    {
        $returnType = '\OngoingAPI\Model\GetPurchaseOrderModel';
        $request = $this->purchaseOrdersGetRequest($purchase_order_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersGet'
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersGetRequest($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGet'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersGet'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersGetAll
     *
     * Get all purchase orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (optional)
     * @param  \DateTime $last_receive_time_from Filter for purchase orders where goods have been received after this time. (optional)
     * @param  \DateTime $last_receive_time_to Filter for purchase orders where goods have been received before this time. (optional)
     * @param  int $purchase_order_status_from Filter for purchase orders whose order status is greater than or equal to this. (optional)
     * @param  int $purchase_order_status_to Filter for purchase orders whose order status is less than or equal to this. (optional)
     * @param  bool $only_purchase_orders_with_order_lines_to_report Filter for purchase orders where at least one line has ReportedNumberOfItems !&#x3D; ReceivedNumberOfItems. (optional)
     * @param  int $purchase_order_id_from Only return purchase orders whose purchase order ID is greater than or equal to this. (optional)
     * @param  int $max_purchase_orders_to_get The maximum number of purchase orders to return. (optional)
     * @param  \DateTime $purchase_order_status_changed_time_from Only return purchase orders whose status has changed after this time. (optional)
     * @param  string[] $purchase_order_numbers purchase_order_numbers (optional)
     * @param  string[] $article_numbers Filter for purchase orders which contains at least one of these article numbers. (optional)
     * @param  \DateTime $in_date_from Filter for purchase orders where the expected indate is after this date. (optional)
     * @param  \DateTime $in_date_to Filter for purchase orders where the expected indate is before this date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetPurchaseOrderModel[]
     */
    public function purchaseOrdersGetAll($goods_owner_id, $purchase_order_number = null, $last_receive_time_from = null, $last_receive_time_to = null, $purchase_order_status_from = null, $purchase_order_status_to = null, $only_purchase_orders_with_order_lines_to_report = null, $purchase_order_id_from = null, $max_purchase_orders_to_get = null, $purchase_order_status_changed_time_from = null, $purchase_order_numbers = null, $article_numbers = null, $in_date_from = null, $in_date_to = null, string $contentType = self::contentTypes['purchaseOrdersGetAll'][0])
    {
        list($response) = $this->purchaseOrdersGetAllWithHttpInfo($goods_owner_id, $purchase_order_number, $last_receive_time_from, $last_receive_time_to, $purchase_order_status_from, $purchase_order_status_to, $only_purchase_orders_with_order_lines_to_report, $purchase_order_id_from, $max_purchase_orders_to_get, $purchase_order_status_changed_time_from, $purchase_order_numbers, $article_numbers, $in_date_from, $in_date_to, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersGetAllWithHttpInfo
     *
     * Get all purchase orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (optional)
     * @param  \DateTime $last_receive_time_from Filter for purchase orders where goods have been received after this time. (optional)
     * @param  \DateTime $last_receive_time_to Filter for purchase orders where goods have been received before this time. (optional)
     * @param  int $purchase_order_status_from Filter for purchase orders whose order status is greater than or equal to this. (optional)
     * @param  int $purchase_order_status_to Filter for purchase orders whose order status is less than or equal to this. (optional)
     * @param  bool $only_purchase_orders_with_order_lines_to_report Filter for purchase orders where at least one line has ReportedNumberOfItems !&#x3D; ReceivedNumberOfItems. (optional)
     * @param  int $purchase_order_id_from Only return purchase orders whose purchase order ID is greater than or equal to this. (optional)
     * @param  int $max_purchase_orders_to_get The maximum number of purchase orders to return. (optional)
     * @param  \DateTime $purchase_order_status_changed_time_from Only return purchase orders whose status has changed after this time. (optional)
     * @param  string[] $purchase_order_numbers (optional)
     * @param  string[] $article_numbers Filter for purchase orders which contains at least one of these article numbers. (optional)
     * @param  \DateTime $in_date_from Filter for purchase orders where the expected indate is after this date. (optional)
     * @param  \DateTime $in_date_to Filter for purchase orders where the expected indate is before this date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetPurchaseOrderModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersGetAllWithHttpInfo($goods_owner_id, $purchase_order_number = null, $last_receive_time_from = null, $last_receive_time_to = null, $purchase_order_status_from = null, $purchase_order_status_to = null, $only_purchase_orders_with_order_lines_to_report = null, $purchase_order_id_from = null, $max_purchase_orders_to_get = null, $purchase_order_status_changed_time_from = null, $purchase_order_numbers = null, $article_numbers = null, $in_date_from = null, $in_date_to = null, string $contentType = self::contentTypes['purchaseOrdersGetAll'][0])
    {
        $request = $this->purchaseOrdersGetAllRequest($goods_owner_id, $purchase_order_number, $last_receive_time_from, $last_receive_time_to, $purchase_order_status_from, $purchase_order_status_to, $only_purchase_orders_with_order_lines_to_report, $purchase_order_id_from, $max_purchase_orders_to_get, $purchase_order_status_changed_time_from, $purchase_order_numbers, $article_numbers, $in_date_from, $in_date_to, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetPurchaseOrderModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetPurchaseOrderModel[]' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetPurchaseOrderModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetPurchaseOrderModel[]';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\GetPurchaseOrderModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersGetAllAsync
     *
     * Get all purchase orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (optional)
     * @param  \DateTime $last_receive_time_from Filter for purchase orders where goods have been received after this time. (optional)
     * @param  \DateTime $last_receive_time_to Filter for purchase orders where goods have been received before this time. (optional)
     * @param  int $purchase_order_status_from Filter for purchase orders whose order status is greater than or equal to this. (optional)
     * @param  int $purchase_order_status_to Filter for purchase orders whose order status is less than or equal to this. (optional)
     * @param  bool $only_purchase_orders_with_order_lines_to_report Filter for purchase orders where at least one line has ReportedNumberOfItems !&#x3D; ReceivedNumberOfItems. (optional)
     * @param  int $purchase_order_id_from Only return purchase orders whose purchase order ID is greater than or equal to this. (optional)
     * @param  int $max_purchase_orders_to_get The maximum number of purchase orders to return. (optional)
     * @param  \DateTime $purchase_order_status_changed_time_from Only return purchase orders whose status has changed after this time. (optional)
     * @param  string[] $purchase_order_numbers (optional)
     * @param  string[] $article_numbers Filter for purchase orders which contains at least one of these article numbers. (optional)
     * @param  \DateTime $in_date_from Filter for purchase orders where the expected indate is after this date. (optional)
     * @param  \DateTime $in_date_to Filter for purchase orders where the expected indate is before this date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetAllAsync($goods_owner_id, $purchase_order_number = null, $last_receive_time_from = null, $last_receive_time_to = null, $purchase_order_status_from = null, $purchase_order_status_to = null, $only_purchase_orders_with_order_lines_to_report = null, $purchase_order_id_from = null, $max_purchase_orders_to_get = null, $purchase_order_status_changed_time_from = null, $purchase_order_numbers = null, $article_numbers = null, $in_date_from = null, $in_date_to = null, string $contentType = self::contentTypes['purchaseOrdersGetAll'][0])
    {
        return $this->purchaseOrdersGetAllAsyncWithHttpInfo($goods_owner_id, $purchase_order_number, $last_receive_time_from, $last_receive_time_to, $purchase_order_status_from, $purchase_order_status_to, $only_purchase_orders_with_order_lines_to_report, $purchase_order_id_from, $max_purchase_orders_to_get, $purchase_order_status_changed_time_from, $purchase_order_numbers, $article_numbers, $in_date_from, $in_date_to, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersGetAllAsyncWithHttpInfo
     *
     * Get all purchase orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (optional)
     * @param  \DateTime $last_receive_time_from Filter for purchase orders where goods have been received after this time. (optional)
     * @param  \DateTime $last_receive_time_to Filter for purchase orders where goods have been received before this time. (optional)
     * @param  int $purchase_order_status_from Filter for purchase orders whose order status is greater than or equal to this. (optional)
     * @param  int $purchase_order_status_to Filter for purchase orders whose order status is less than or equal to this. (optional)
     * @param  bool $only_purchase_orders_with_order_lines_to_report Filter for purchase orders where at least one line has ReportedNumberOfItems !&#x3D; ReceivedNumberOfItems. (optional)
     * @param  int $purchase_order_id_from Only return purchase orders whose purchase order ID is greater than or equal to this. (optional)
     * @param  int $max_purchase_orders_to_get The maximum number of purchase orders to return. (optional)
     * @param  \DateTime $purchase_order_status_changed_time_from Only return purchase orders whose status has changed after this time. (optional)
     * @param  string[] $purchase_order_numbers (optional)
     * @param  string[] $article_numbers Filter for purchase orders which contains at least one of these article numbers. (optional)
     * @param  \DateTime $in_date_from Filter for purchase orders where the expected indate is after this date. (optional)
     * @param  \DateTime $in_date_to Filter for purchase orders where the expected indate is before this date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetAllAsyncWithHttpInfo($goods_owner_id, $purchase_order_number = null, $last_receive_time_from = null, $last_receive_time_to = null, $purchase_order_status_from = null, $purchase_order_status_to = null, $only_purchase_orders_with_order_lines_to_report = null, $purchase_order_id_from = null, $max_purchase_orders_to_get = null, $purchase_order_status_changed_time_from = null, $purchase_order_numbers = null, $article_numbers = null, $in_date_from = null, $in_date_to = null, string $contentType = self::contentTypes['purchaseOrdersGetAll'][0])
    {
        $returnType = '\OngoingAPI\Model\GetPurchaseOrderModel[]';
        $request = $this->purchaseOrdersGetAllRequest($goods_owner_id, $purchase_order_number, $last_receive_time_from, $last_receive_time_to, $purchase_order_status_from, $purchase_order_status_to, $only_purchase_orders_with_order_lines_to_report, $purchase_order_id_from, $max_purchase_orders_to_get, $purchase_order_status_changed_time_from, $purchase_order_numbers, $article_numbers, $in_date_from, $in_date_to, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersGetAll'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $purchase_order_number Purchase order number. (optional)
     * @param  \DateTime $last_receive_time_from Filter for purchase orders where goods have been received after this time. (optional)
     * @param  \DateTime $last_receive_time_to Filter for purchase orders where goods have been received before this time. (optional)
     * @param  int $purchase_order_status_from Filter for purchase orders whose order status is greater than or equal to this. (optional)
     * @param  int $purchase_order_status_to Filter for purchase orders whose order status is less than or equal to this. (optional)
     * @param  bool $only_purchase_orders_with_order_lines_to_report Filter for purchase orders where at least one line has ReportedNumberOfItems !&#x3D; ReceivedNumberOfItems. (optional)
     * @param  int $purchase_order_id_from Only return purchase orders whose purchase order ID is greater than or equal to this. (optional)
     * @param  int $max_purchase_orders_to_get The maximum number of purchase orders to return. (optional)
     * @param  \DateTime $purchase_order_status_changed_time_from Only return purchase orders whose status has changed after this time. (optional)
     * @param  string[] $purchase_order_numbers (optional)
     * @param  string[] $article_numbers Filter for purchase orders which contains at least one of these article numbers. (optional)
     * @param  \DateTime $in_date_from Filter for purchase orders where the expected indate is after this date. (optional)
     * @param  \DateTime $in_date_to Filter for purchase orders where the expected indate is before this date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersGetAllRequest($goods_owner_id, $purchase_order_number = null, $last_receive_time_from = null, $last_receive_time_to = null, $purchase_order_status_from = null, $purchase_order_status_to = null, $only_purchase_orders_with_order_lines_to_report = null, $purchase_order_id_from = null, $max_purchase_orders_to_get = null, $purchase_order_status_changed_time_from = null, $purchase_order_numbers = null, $article_numbers = null, $in_date_from = null, $in_date_to = null, string $contentType = self::contentTypes['purchaseOrdersGetAll'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling purchaseOrdersGetAll'
            );
        }















        $resourcePath = '/api/v1/purchaseOrders';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $goods_owner_id,
            'goodsOwnerId', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $purchase_order_number,
            'purchaseOrderNumber', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $last_receive_time_from,
            'lastReceiveTimeFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $last_receive_time_to,
            'lastReceiveTimeTo', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $purchase_order_status_from,
            'purchaseOrderStatusFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $purchase_order_status_to,
            'purchaseOrderStatusTo', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_purchase_orders_with_order_lines_to_report,
            'onlyPurchaseOrdersWithOrderLinesToReport', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $purchase_order_id_from,
            'purchaseOrderIdFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $max_purchase_orders_to_get,
            'maxPurchaseOrdersToGet', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $purchase_order_status_changed_time_from,
            'purchaseOrderStatusChangedTimeFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $purchase_order_numbers,
            'purchaseOrderNumbers', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $article_numbers,
            'articleNumbers', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $in_date_from,
            'inDateFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $in_date_to,
            'inDateTo', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);




        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersGetFiles
     *
     * Get all files which are attached to a specific purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetFiles'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetFileModel[]
     */
    public function purchaseOrdersGetFiles($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGetFiles'][0])
    {
        list($response) = $this->purchaseOrdersGetFilesWithHttpInfo($purchase_order_id, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersGetFilesWithHttpInfo
     *
     * Get all files which are attached to a specific purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetFiles'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetFileModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersGetFilesWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGetFiles'][0])
    {
        $request = $this->purchaseOrdersGetFilesRequest($purchase_order_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetFileModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetFileModel[]' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetFileModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetFileModel[]';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\GetFileModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersGetFilesAsync
     *
     * Get all files which are attached to a specific purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetFilesAsync($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGetFiles'][0])
    {
        return $this->purchaseOrdersGetFilesAsyncWithHttpInfo($purchase_order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersGetFilesAsyncWithHttpInfo
     *
     * Get all files which are attached to a specific purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetFilesAsyncWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGetFiles'][0])
    {
        $returnType = '\OngoingAPI\Model\GetFileModel[]';
        $request = $this->purchaseOrdersGetFilesRequest($purchase_order_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersGetFiles'
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersGetFilesRequest($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersGetFiles'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersGetFiles'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderStatuses
     *
     * Get all purchase order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetPurchaseOrderStatusesModel
     */
    public function purchaseOrdersGetPurchaseOrderStatuses(string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'][0])
    {
        list($response) = $this->purchaseOrdersGetPurchaseOrderStatusesWithHttpInfo($contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderStatusesWithHttpInfo
     *
     * Get all purchase order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetPurchaseOrderStatusesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersGetPurchaseOrderStatusesWithHttpInfo(string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'][0])
    {
        $request = $this->purchaseOrdersGetPurchaseOrderStatusesRequest($contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetPurchaseOrderStatusesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetPurchaseOrderStatusesModel' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetPurchaseOrderStatusesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetPurchaseOrderStatusesModel';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\GetPurchaseOrderStatusesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderStatusesAsync
     *
     * Get all purchase order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetPurchaseOrderStatusesAsync(string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'][0])
    {
        return $this->purchaseOrdersGetPurchaseOrderStatusesAsyncWithHttpInfo($contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderStatusesAsyncWithHttpInfo
     *
     * Get all purchase order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetPurchaseOrderStatusesAsyncWithHttpInfo(string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'][0])
    {
        $returnType = '\OngoingAPI\Model\GetPurchaseOrderStatusesModel';
        $request = $this->purchaseOrdersGetPurchaseOrderStatusesRequest($contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersGetPurchaseOrderStatuses'
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersGetPurchaseOrderStatusesRequest(string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderStatuses'][0])
    {


        $resourcePath = '/api/v1/purchaseOrders/statuses';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;





        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderTypes
     *
     * Get all purchase order types for a particular goods owner.
     *
     * @param  int $goods_owner_id goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetPurchaseOrderTypesModel
     */
    public function purchaseOrdersGetPurchaseOrderTypes($goods_owner_id, string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'][0])
    {
        list($response) = $this->purchaseOrdersGetPurchaseOrderTypesWithHttpInfo($goods_owner_id, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderTypesWithHttpInfo
     *
     * Get all purchase order types for a particular goods owner.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetPurchaseOrderTypesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersGetPurchaseOrderTypesWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'][0])
    {
        $request = $this->purchaseOrdersGetPurchaseOrderTypesRequest($goods_owner_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetPurchaseOrderTypesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetPurchaseOrderTypesModel' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetPurchaseOrderTypesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetPurchaseOrderTypesModel';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\GetPurchaseOrderTypesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderTypesAsync
     *
     * Get all purchase order types for a particular goods owner.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetPurchaseOrderTypesAsync($goods_owner_id, string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'][0])
    {
        return $this->purchaseOrdersGetPurchaseOrderTypesAsyncWithHttpInfo($goods_owner_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersGetPurchaseOrderTypesAsyncWithHttpInfo
     *
     * Get all purchase order types for a particular goods owner.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersGetPurchaseOrderTypesAsyncWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'][0])
    {
        $returnType = '\OngoingAPI\Model\GetPurchaseOrderTypesModel';
        $request = $this->purchaseOrdersGetPurchaseOrderTypesRequest($goods_owner_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersGetPurchaseOrderTypes'
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersGetPurchaseOrderTypesRequest($goods_owner_id, string $contentType = self::contentTypes['purchaseOrdersGetPurchaseOrderTypes'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling purchaseOrdersGetPurchaseOrderTypes'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/types';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $goods_owner_id,
            'goodsOwnerId', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);




        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchAdvisedDate
     *
     * Update the advisedDate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderAdvisedDate $patch_purchase_order_advised_date Object containing the advised date (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchAdvisedDate'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchAdvisedDate($purchase_order_id, $patch_purchase_order_advised_date, string $contentType = self::contentTypes['purchaseOrdersPatchAdvisedDate'][0])
    {
        list($response) = $this->purchaseOrdersPatchAdvisedDateWithHttpInfo($purchase_order_id, $patch_purchase_order_advised_date, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchAdvisedDateWithHttpInfo
     *
     * Update the advisedDate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderAdvisedDate $patch_purchase_order_advised_date Object containing the advised date (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchAdvisedDate'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchAdvisedDateWithHttpInfo($purchase_order_id, $patch_purchase_order_advised_date, string $contentType = self::contentTypes['purchaseOrdersPatchAdvisedDate'][0])
    {
        $request = $this->purchaseOrdersPatchAdvisedDateRequest($purchase_order_id, $patch_purchase_order_advised_date, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchAdvisedDateAsync
     *
     * Update the advisedDate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderAdvisedDate $patch_purchase_order_advised_date Object containing the advised date (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchAdvisedDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchAdvisedDateAsync($purchase_order_id, $patch_purchase_order_advised_date, string $contentType = self::contentTypes['purchaseOrdersPatchAdvisedDate'][0])
    {
        return $this->purchaseOrdersPatchAdvisedDateAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_advised_date, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchAdvisedDateAsyncWithHttpInfo
     *
     * Update the advisedDate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderAdvisedDate $patch_purchase_order_advised_date Object containing the advised date (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchAdvisedDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchAdvisedDateAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_advised_date, string $contentType = self::contentTypes['purchaseOrdersPatchAdvisedDate'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchAdvisedDateRequest($purchase_order_id, $patch_purchase_order_advised_date, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchAdvisedDate'
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderAdvisedDate $patch_purchase_order_advised_date Object containing the advised date (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchAdvisedDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchAdvisedDateRequest($purchase_order_id, $patch_purchase_order_advised_date, string $contentType = self::contentTypes['purchaseOrdersPatchAdvisedDate'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchAdvisedDate'
            );
        }

        // verify the required parameter 'patch_purchase_order_advised_date' is set
        if ($patch_purchase_order_advised_date === null || (is_array($patch_purchase_order_advised_date) && count($patch_purchase_order_advised_date) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_advised_date when calling purchaseOrdersPatchAdvisedDate'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/advisedDate';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_advised_date)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_advised_date));
            } else {
                $httpBody = $patch_purchase_order_advised_date;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchFreeBool1
     *
     * Update FreeBool1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeBool1 $patch_purchase_order_free_bool1 Object containing FreeBool1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeBool1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchFreeBool1($purchase_order_id, $patch_purchase_order_free_bool1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeBool1'][0])
    {
        list($response) = $this->purchaseOrdersPatchFreeBool1WithHttpInfo($purchase_order_id, $patch_purchase_order_free_bool1, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchFreeBool1WithHttpInfo
     *
     * Update FreeBool1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeBool1 $patch_purchase_order_free_bool1 Object containing FreeBool1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeBool1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchFreeBool1WithHttpInfo($purchase_order_id, $patch_purchase_order_free_bool1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeBool1'][0])
    {
        $request = $this->purchaseOrdersPatchFreeBool1Request($purchase_order_id, $patch_purchase_order_free_bool1, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchFreeBool1Async
     *
     * Update FreeBool1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeBool1 $patch_purchase_order_free_bool1 Object containing FreeBool1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeBool1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeBool1Async($purchase_order_id, $patch_purchase_order_free_bool1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeBool1'][0])
    {
        return $this->purchaseOrdersPatchFreeBool1AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_bool1, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchFreeBool1AsyncWithHttpInfo
     *
     * Update FreeBool1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeBool1 $patch_purchase_order_free_bool1 Object containing FreeBool1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeBool1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeBool1AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_bool1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeBool1'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchFreeBool1Request($purchase_order_id, $patch_purchase_order_free_bool1, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchFreeBool1'
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeBool1 $patch_purchase_order_free_bool1 Object containing FreeBool1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeBool1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchFreeBool1Request($purchase_order_id, $patch_purchase_order_free_bool1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeBool1'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchFreeBool1'
            );
        }

        // verify the required parameter 'patch_purchase_order_free_bool1' is set
        if ($patch_purchase_order_free_bool1 === null || (is_array($patch_purchase_order_free_bool1) && count($patch_purchase_order_free_bool1) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_free_bool1 when calling purchaseOrdersPatchFreeBool1'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/freeBool1';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_free_bool1)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_free_bool1));
            } else {
                $httpBody = $patch_purchase_order_free_bool1;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchFreeText1
     *
     * Update free text 1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText1 $patch_purchase_order_free_text1 Object containing free text 1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchFreeText1($purchase_order_id, $patch_purchase_order_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText1'][0])
    {
        list($response) = $this->purchaseOrdersPatchFreeText1WithHttpInfo($purchase_order_id, $patch_purchase_order_free_text1, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchFreeText1WithHttpInfo
     *
     * Update free text 1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText1 $patch_purchase_order_free_text1 Object containing free text 1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchFreeText1WithHttpInfo($purchase_order_id, $patch_purchase_order_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText1'][0])
    {
        $request = $this->purchaseOrdersPatchFreeText1Request($purchase_order_id, $patch_purchase_order_free_text1, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchFreeText1Async
     *
     * Update free text 1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText1 $patch_purchase_order_free_text1 Object containing free text 1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeText1Async($purchase_order_id, $patch_purchase_order_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText1'][0])
    {
        return $this->purchaseOrdersPatchFreeText1AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_text1, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchFreeText1AsyncWithHttpInfo
     *
     * Update free text 1 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText1 $patch_purchase_order_free_text1 Object containing free text 1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeText1AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText1'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchFreeText1Request($purchase_order_id, $patch_purchase_order_free_text1, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchFreeText1'
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText1 $patch_purchase_order_free_text1 Object containing free text 1 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchFreeText1Request($purchase_order_id, $patch_purchase_order_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText1'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchFreeText1'
            );
        }

        // verify the required parameter 'patch_purchase_order_free_text1' is set
        if ($patch_purchase_order_free_text1 === null || (is_array($patch_purchase_order_free_text1) && count($patch_purchase_order_free_text1) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_free_text1 when calling purchaseOrdersPatchFreeText1'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/freeText1';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_free_text1)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_free_text1));
            } else {
                $httpBody = $patch_purchase_order_free_text1;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchFreeText2
     *
     * Update free text 2 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText2 $patch_purchase_order_free_text2 Object containing free text 2 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchFreeText2($purchase_order_id, $patch_purchase_order_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText2'][0])
    {
        list($response) = $this->purchaseOrdersPatchFreeText2WithHttpInfo($purchase_order_id, $patch_purchase_order_free_text2, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchFreeText2WithHttpInfo
     *
     * Update free text 2 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText2 $patch_purchase_order_free_text2 Object containing free text 2 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchFreeText2WithHttpInfo($purchase_order_id, $patch_purchase_order_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText2'][0])
    {
        $request = $this->purchaseOrdersPatchFreeText2Request($purchase_order_id, $patch_purchase_order_free_text2, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchFreeText2Async
     *
     * Update free text 2 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText2 $patch_purchase_order_free_text2 Object containing free text 2 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeText2Async($purchase_order_id, $patch_purchase_order_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText2'][0])
    {
        return $this->purchaseOrdersPatchFreeText2AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_text2, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchFreeText2AsyncWithHttpInfo
     *
     * Update free text 2 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText2 $patch_purchase_order_free_text2 Object containing free text 2 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeText2AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText2'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchFreeText2Request($purchase_order_id, $patch_purchase_order_free_text2, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchFreeText2'
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText2 $patch_purchase_order_free_text2 Object containing free text 2 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchFreeText2Request($purchase_order_id, $patch_purchase_order_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText2'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchFreeText2'
            );
        }

        // verify the required parameter 'patch_purchase_order_free_text2' is set
        if ($patch_purchase_order_free_text2 === null || (is_array($patch_purchase_order_free_text2) && count($patch_purchase_order_free_text2) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_free_text2 when calling purchaseOrdersPatchFreeText2'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/freeText2';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_free_text2)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_free_text2));
            } else {
                $httpBody = $patch_purchase_order_free_text2;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchFreeText3
     *
     * Update free text 3 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText3 $patch_purchase_order_free_text3 Object containing free text 3 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText3'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchFreeText3($purchase_order_id, $patch_purchase_order_free_text3, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText3'][0])
    {
        list($response) = $this->purchaseOrdersPatchFreeText3WithHttpInfo($purchase_order_id, $patch_purchase_order_free_text3, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchFreeText3WithHttpInfo
     *
     * Update free text 3 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText3 $patch_purchase_order_free_text3 Object containing free text 3 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText3'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchFreeText3WithHttpInfo($purchase_order_id, $patch_purchase_order_free_text3, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText3'][0])
    {
        $request = $this->purchaseOrdersPatchFreeText3Request($purchase_order_id, $patch_purchase_order_free_text3, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchFreeText3Async
     *
     * Update free text 3 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText3 $patch_purchase_order_free_text3 Object containing free text 3 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText3'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeText3Async($purchase_order_id, $patch_purchase_order_free_text3, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText3'][0])
    {
        return $this->purchaseOrdersPatchFreeText3AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_text3, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchFreeText3AsyncWithHttpInfo
     *
     * Update free text 3 on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText3 $patch_purchase_order_free_text3 Object containing free text 3 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText3'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchFreeText3AsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_free_text3, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText3'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchFreeText3Request($purchase_order_id, $patch_purchase_order_free_text3, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchFreeText3'
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderFreeText3 $patch_purchase_order_free_text3 Object containing free text 3 (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchFreeText3'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchFreeText3Request($purchase_order_id, $patch_purchase_order_free_text3, string $contentType = self::contentTypes['purchaseOrdersPatchFreeText3'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchFreeText3'
            );
        }

        // verify the required parameter 'patch_purchase_order_free_text3' is set
        if ($patch_purchase_order_free_text3 === null || (is_array($patch_purchase_order_free_text3) && count($patch_purchase_order_free_text3) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_free_text3 when calling purchaseOrdersPatchFreeText3'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/freeText3';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_free_text3)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_free_text3));
            } else {
                $httpBody = $patch_purchase_order_free_text3;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchInDate
     *
     * Update the indate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderInDate $patch_purchase_order_in_date Object containing the indate (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchInDate'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchInDate($purchase_order_id, $patch_purchase_order_in_date, string $contentType = self::contentTypes['purchaseOrdersPatchInDate'][0])
    {
        list($response) = $this->purchaseOrdersPatchInDateWithHttpInfo($purchase_order_id, $patch_purchase_order_in_date, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchInDateWithHttpInfo
     *
     * Update the indate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderInDate $patch_purchase_order_in_date Object containing the indate (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchInDate'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchInDateWithHttpInfo($purchase_order_id, $patch_purchase_order_in_date, string $contentType = self::contentTypes['purchaseOrdersPatchInDate'][0])
    {
        $request = $this->purchaseOrdersPatchInDateRequest($purchase_order_id, $patch_purchase_order_in_date, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchInDateAsync
     *
     * Update the indate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderInDate $patch_purchase_order_in_date Object containing the indate (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchInDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchInDateAsync($purchase_order_id, $patch_purchase_order_in_date, string $contentType = self::contentTypes['purchaseOrdersPatchInDate'][0])
    {
        return $this->purchaseOrdersPatchInDateAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_in_date, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchInDateAsyncWithHttpInfo
     *
     * Update the indate on purchase order.
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderInDate $patch_purchase_order_in_date Object containing the indate (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchInDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchInDateAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_in_date, string $contentType = self::contentTypes['purchaseOrdersPatchInDate'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchInDateRequest($purchase_order_id, $patch_purchase_order_in_date, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchInDate'
     *
     * @param  int $purchase_order_id Purchase orders ID (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderInDate $patch_purchase_order_in_date Object containing the indate (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchInDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchInDateRequest($purchase_order_id, $patch_purchase_order_in_date, string $contentType = self::contentTypes['purchaseOrdersPatchInDate'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchInDate'
            );
        }

        // verify the required parameter 'patch_purchase_order_in_date' is set
        if ($patch_purchase_order_in_date === null || (is_array($patch_purchase_order_in_date) && count($patch_purchase_order_in_date) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_in_date when calling purchaseOrdersPatchInDate'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/inDate';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_in_date)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_in_date));
            } else {
                $httpBody = $patch_purchase_order_in_date;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText1
     *
     * Update free text 1 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText1 $patch_purchase_order_line_free_text1 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \SplFileObject
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText1($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'][0])
    {
        list($response) = $this->purchaseOrdersPatchPurchaseOrderLineFreeText1WithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText1WithHttpInfo
     *
     * Update free text 1 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText1 $patch_purchase_order_line_free_text1 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \SplFileObject, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText1WithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'][0])
    {
        $request = $this->purchaseOrdersPatchPurchaseOrderLineFreeText1Request($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\SplFileObject' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\SplFileObject' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\SplFileObject', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\SplFileObject';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\SplFileObject',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText1Async
     *
     * Update free text 1 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText1 $patch_purchase_order_line_free_text1 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText1Async($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'][0])
    {
        return $this->purchaseOrdersPatchPurchaseOrderLineFreeText1AsyncWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText1AsyncWithHttpInfo
     *
     * Update free text 1 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText1 $patch_purchase_order_line_free_text1 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText1AsyncWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'][0])
    {
        $returnType = '\SplFileObject';
        $request = $this->purchaseOrdersPatchPurchaseOrderLineFreeText1Request($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchPurchaseOrderLineFreeText1'
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText1 $patch_purchase_order_line_free_text1 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText1Request($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text1, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText1'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchPurchaseOrderLineFreeText1'
            );
        }

        // verify the required parameter 'purchase_order_line_id' is set
        if ($purchase_order_line_id === null || (is_array($purchase_order_line_id) && count($purchase_order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_line_id when calling purchaseOrdersPatchPurchaseOrderLineFreeText1'
            );
        }

        // verify the required parameter 'patch_purchase_order_line_free_text1' is set
        if ($patch_purchase_order_line_free_text1 === null || (is_array($patch_purchase_order_line_free_text1) && count($patch_purchase_order_line_free_text1) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_line_free_text1 when calling purchaseOrdersPatchPurchaseOrderLineFreeText1'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/lines/{purchaseOrderLineId}/freeText1';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }
        // path params
        if ($purchase_order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderLineId' . '}',
                ObjectSerializer::toPathValue($purchase_order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/octet-stream', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_line_free_text1)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_line_free_text1));
            } else {
                $httpBody = $patch_purchase_order_line_free_text1;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText2
     *
     * Update free text 2 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText2 $patch_purchase_order_line_free_text2 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \SplFileObject
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText2($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'][0])
    {
        list($response) = $this->purchaseOrdersPatchPurchaseOrderLineFreeText2WithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText2WithHttpInfo
     *
     * Update free text 2 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText2 $patch_purchase_order_line_free_text2 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \SplFileObject, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText2WithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'][0])
    {
        $request = $this->purchaseOrdersPatchPurchaseOrderLineFreeText2Request($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\SplFileObject' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\SplFileObject' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\SplFileObject', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\SplFileObject';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\SplFileObject',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText2Async
     *
     * Update free text 2 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText2 $patch_purchase_order_line_free_text2 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText2Async($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'][0])
    {
        return $this->purchaseOrdersPatchPurchaseOrderLineFreeText2AsyncWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderLineFreeText2AsyncWithHttpInfo
     *
     * Update free text 2 on a purchase order line.
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText2 $patch_purchase_order_line_free_text2 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText2AsyncWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'][0])
    {
        $returnType = '\SplFileObject';
        $request = $this->purchaseOrdersPatchPurchaseOrderLineFreeText2Request($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchPurchaseOrderLineFreeText2'
     *
     * @param  int $purchase_order_id Ongoing WMS internal ID of the purchase order (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderLineFreeText2 $patch_purchase_order_line_free_text2 Object containing the new free text (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchPurchaseOrderLineFreeText2Request($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_line_free_text2, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderLineFreeText2'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchPurchaseOrderLineFreeText2'
            );
        }

        // verify the required parameter 'purchase_order_line_id' is set
        if ($purchase_order_line_id === null || (is_array($purchase_order_line_id) && count($purchase_order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_line_id when calling purchaseOrdersPatchPurchaseOrderLineFreeText2'
            );
        }

        // verify the required parameter 'patch_purchase_order_line_free_text2' is set
        if ($patch_purchase_order_line_free_text2 === null || (is_array($patch_purchase_order_line_free_text2) && count($patch_purchase_order_line_free_text2) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_line_free_text2 when calling purchaseOrdersPatchPurchaseOrderLineFreeText2'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/lines/{purchaseOrderLineId}/freeText2';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }
        // path params
        if ($purchase_order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderLineId' . '}',
                ObjectSerializer::toPathValue($purchase_order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/octet-stream', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_line_free_text2)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_line_free_text2));
            } else {
                $httpBody = $patch_purchase_order_line_free_text2;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderNumber
     *
     * Update the purchase order number of a purchase order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderNumber $patch_purchase_order_number Object containing the new purchase order number . (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchPurchaseOrderNumber($purchase_order_id, $patch_purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'][0])
    {
        list($response) = $this->purchaseOrdersPatchPurchaseOrderNumberWithHttpInfo($purchase_order_id, $patch_purchase_order_number, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderNumberWithHttpInfo
     *
     * Update the purchase order number of a purchase order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderNumber $patch_purchase_order_number Object containing the new purchase order number . (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchPurchaseOrderNumberWithHttpInfo($purchase_order_id, $patch_purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'][0])
    {
        $request = $this->purchaseOrdersPatchPurchaseOrderNumberRequest($purchase_order_id, $patch_purchase_order_number, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderNumberAsync
     *
     * Update the purchase order number of a purchase order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderNumber $patch_purchase_order_number Object containing the new purchase order number . (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchPurchaseOrderNumberAsync($purchase_order_id, $patch_purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'][0])
    {
        return $this->purchaseOrdersPatchPurchaseOrderNumberAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_number, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchPurchaseOrderNumberAsyncWithHttpInfo
     *
     * Update the purchase order number of a purchase order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderNumber $patch_purchase_order_number Object containing the new purchase order number . (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchPurchaseOrderNumberAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchPurchaseOrderNumberRequest($purchase_order_id, $patch_purchase_order_number, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchPurchaseOrderNumber'
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderNumber $patch_purchase_order_number Object containing the new purchase order number . (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchPurchaseOrderNumberRequest($purchase_order_id, $patch_purchase_order_number, string $contentType = self::contentTypes['purchaseOrdersPatchPurchaseOrderNumber'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchPurchaseOrderNumber'
            );
        }

        // verify the required parameter 'patch_purchase_order_number' is set
        if ($patch_purchase_order_number === null || (is_array($patch_purchase_order_number) && count($patch_purchase_order_number) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_number when calling purchaseOrdersPatchPurchaseOrderNumber'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/purchaseOrderNumber';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_number)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_number));
            } else {
                $httpBody = $patch_purchase_order_number;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchReportedNumberOfItems
     *
     * Update the reported number of items on a particular purchase order line.
     *
     * @param  int $purchase_order_id purchase_order_id (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderReportedNumberOfItemsModel $patch_purchase_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \SplFileObject
     */
    public function purchaseOrdersPatchReportedNumberOfItems($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, string $contentType = self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'][0])
    {
        list($response) = $this->purchaseOrdersPatchReportedNumberOfItemsWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchReportedNumberOfItemsWithHttpInfo
     *
     * Update the reported number of items on a particular purchase order line.
     *
     * @param  int $purchase_order_id (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderReportedNumberOfItemsModel $patch_purchase_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \SplFileObject, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchReportedNumberOfItemsWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, string $contentType = self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'][0])
    {
        $request = $this->purchaseOrdersPatchReportedNumberOfItemsRequest($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\SplFileObject' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\SplFileObject' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\SplFileObject', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\SplFileObject';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\SplFileObject',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchReportedNumberOfItemsAsync
     *
     * Update the reported number of items on a particular purchase order line.
     *
     * @param  int $purchase_order_id (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderReportedNumberOfItemsModel $patch_purchase_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchReportedNumberOfItemsAsync($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, string $contentType = self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'][0])
    {
        return $this->purchaseOrdersPatchReportedNumberOfItemsAsyncWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchReportedNumberOfItemsAsyncWithHttpInfo
     *
     * Update the reported number of items on a particular purchase order line.
     *
     * @param  int $purchase_order_id (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderReportedNumberOfItemsModel $patch_purchase_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchReportedNumberOfItemsAsyncWithHttpInfo($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, string $contentType = self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'][0])
    {
        $returnType = '\SplFileObject';
        $request = $this->purchaseOrdersPatchReportedNumberOfItemsRequest($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchReportedNumberOfItems'
     *
     * @param  int $purchase_order_id (required)
     * @param  int $purchase_order_line_id Ongoing WMS internal ID of the purchase order line (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderReportedNumberOfItemsModel $patch_purchase_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchReportedNumberOfItemsRequest($purchase_order_id, $purchase_order_line_id, $patch_purchase_order_reported_number_of_items_model, string $contentType = self::contentTypes['purchaseOrdersPatchReportedNumberOfItems'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchReportedNumberOfItems'
            );
        }

        // verify the required parameter 'purchase_order_line_id' is set
        if ($purchase_order_line_id === null || (is_array($purchase_order_line_id) && count($purchase_order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_line_id when calling purchaseOrdersPatchReportedNumberOfItems'
            );
        }

        // verify the required parameter 'patch_purchase_order_reported_number_of_items_model' is set
        if ($patch_purchase_order_reported_number_of_items_model === null || (is_array($patch_purchase_order_reported_number_of_items_model) && count($patch_purchase_order_reported_number_of_items_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_reported_number_of_items_model when calling purchaseOrdersPatchReportedNumberOfItems'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/lines/{purchaseOrderLineId}/reportedNumberOfItems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }
        // path params
        if ($purchase_order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderLineId' . '}',
                ObjectSerializer::toPathValue($purchase_order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/octet-stream', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_reported_number_of_items_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_reported_number_of_items_model));
            } else {
                $httpBody = $patch_purchase_order_reported_number_of_items_model;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems
     *
     * Sets the reported number of items on each purchase order line to the received number of items.
     *
     * @param  int $purchase_order_id purchase_order_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \SplFileObject
     */
    public function purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'][0])
    {
        list($response) = $this->purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsWithHttpInfo($purchase_order_id, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsWithHttpInfo
     *
     * Sets the reported number of items on each purchase order line to the received number of items.
     *
     * @param  int $purchase_order_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \SplFileObject, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'][0])
    {
        $request = $this->purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsRequest($purchase_order_id, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\SplFileObject' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\SplFileObject' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\SplFileObject', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\SplFileObject';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\SplFileObject',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsAsync
     *
     * Sets the reported number of items on each purchase order line to the received number of items.
     *
     * @param  int $purchase_order_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsAsync($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'][0])
    {
        return $this->purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsAsyncWithHttpInfo($purchase_order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsAsyncWithHttpInfo
     *
     * Sets the reported number of items on each purchase order line to the received number of items.
     *
     * @param  int $purchase_order_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsAsyncWithHttpInfo($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'][0])
    {
        $returnType = '\SplFileObject';
        $request = $this->purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsRequest($purchase_order_id, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'
     *
     * @param  int $purchase_order_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItemsRequest($purchase_order_id, string $contentType = self::contentTypes['purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchSetReportedNumberOfItemsToReceivedNumberOfItems'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/setReportedNumberOfItemsToReceivedNumberOfItems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/octet-stream', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPatchStatus
     *
     * Update the status of a purchase order.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderStatus $patch_purchase_order_status Object containing the new purchase order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchPurchaseOrderResponse
     */
    public function purchaseOrdersPatchStatus($purchase_order_id, $patch_purchase_order_status, string $contentType = self::contentTypes['purchaseOrdersPatchStatus'][0])
    {
        list($response) = $this->purchaseOrdersPatchStatusWithHttpInfo($purchase_order_id, $patch_purchase_order_status, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPatchStatusWithHttpInfo
     *
     * Update the status of a purchase order.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderStatus $patch_purchase_order_status Object containing the new purchase order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPatchStatusWithHttpInfo($purchase_order_id, $patch_purchase_order_status, string $contentType = self::contentTypes['purchaseOrdersPatchStatus'][0])
    {
        $request = $this->purchaseOrdersPatchStatusRequest($purchase_order_id, $patch_purchase_order_status, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PatchPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPatchStatusAsync
     *
     * Update the status of a purchase order.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderStatus $patch_purchase_order_status Object containing the new purchase order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchStatusAsync($purchase_order_id, $patch_purchase_order_status, string $contentType = self::contentTypes['purchaseOrdersPatchStatus'][0])
    {
        return $this->purchaseOrdersPatchStatusAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_status, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPatchStatusAsyncWithHttpInfo
     *
     * Update the status of a purchase order.
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderStatus $patch_purchase_order_status Object containing the new purchase order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPatchStatusAsyncWithHttpInfo($purchase_order_id, $patch_purchase_order_status, string $contentType = self::contentTypes['purchaseOrdersPatchStatus'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchPurchaseOrderResponse';
        $request = $this->purchaseOrdersPatchStatusRequest($purchase_order_id, $patch_purchase_order_status, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPatchStatus'
     *
     * @param  int $purchase_order_id PurchaseOrderId. (required)
     * @param  \OngoingAPI\Model\PatchPurchaseOrderStatus $patch_purchase_order_status Object containing the new purchase order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPatchStatusRequest($purchase_order_id, $patch_purchase_order_status, string $contentType = self::contentTypes['purchaseOrdersPatchStatus'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPatchStatus'
            );
        }

        // verify the required parameter 'patch_purchase_order_status' is set
        if ($patch_purchase_order_status === null || (is_array($patch_purchase_order_status) && count($patch_purchase_order_status) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_purchase_order_status when calling purchaseOrdersPatchStatus'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/purchaseOrderStatus';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_purchase_order_status)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_purchase_order_status));
            } else {
                $httpBody = $patch_purchase_order_status;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPostPurchaseOrderFile
     *
     * Create a new file and attach it to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPostPurchaseOrderFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function purchaseOrdersPostPurchaseOrderFile($purchase_order_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPostPurchaseOrderFile'][0])
    {
        list($response) = $this->purchaseOrdersPostPurchaseOrderFileWithHttpInfo($purchase_order_id, $post_file_model, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPostPurchaseOrderFileWithHttpInfo
     *
     * Create a new file and attach it to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPostPurchaseOrderFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPostPurchaseOrderFileWithHttpInfo($purchase_order_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPostPurchaseOrderFile'][0])
    {
        $request = $this->purchaseOrdersPostPurchaseOrderFileRequest($purchase_order_id, $post_file_model, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostFileResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostFileResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostFileResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostFileResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostFileResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPostPurchaseOrderFileAsync
     *
     * Create a new file and attach it to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPostPurchaseOrderFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPostPurchaseOrderFileAsync($purchase_order_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPostPurchaseOrderFile'][0])
    {
        return $this->purchaseOrdersPostPurchaseOrderFileAsyncWithHttpInfo($purchase_order_id, $post_file_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPostPurchaseOrderFileAsyncWithHttpInfo
     *
     * Create a new file and attach it to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPostPurchaseOrderFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPostPurchaseOrderFileAsyncWithHttpInfo($purchase_order_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPostPurchaseOrderFile'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->purchaseOrdersPostPurchaseOrderFileRequest($purchase_order_id, $post_file_model, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPostPurchaseOrderFile'
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPostPurchaseOrderFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPostPurchaseOrderFileRequest($purchase_order_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPostPurchaseOrderFile'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPostPurchaseOrderFile'
            );
        }

        // verify the required parameter 'post_file_model' is set
        if ($post_file_model === null || (is_array($post_file_model) && count($post_file_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_model when calling purchaseOrdersPostPurchaseOrderFile'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_file_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_file_model));
            } else {
                $httpBody = $post_file_model;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'POST',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPut
     *
     * Update a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostPurchaseOrderResponse
     */
    public function purchaseOrdersPut($purchase_order_id, $post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut'][0])
    {
        list($response) = $this->purchaseOrdersPutWithHttpInfo($purchase_order_id, $post_purchase_order_model, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPutWithHttpInfo
     *
     * Update a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPutWithHttpInfo($purchase_order_id, $post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut'][0])
    {
        $request = $this->purchaseOrdersPutRequest($purchase_order_id, $post_purchase_order_model, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPutAsync
     *
     * Update a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutAsync($purchase_order_id, $post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut'][0])
    {
        return $this->purchaseOrdersPutAsyncWithHttpInfo($purchase_order_id, $post_purchase_order_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPutAsyncWithHttpInfo
     *
     * Update a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutAsyncWithHttpInfo($purchase_order_id, $post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut'][0])
    {
        $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
        $request = $this->purchaseOrdersPutRequest($purchase_order_id, $post_purchase_order_model, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPut'
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPutRequest($purchase_order_id, $post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPut'
            );
        }

        // verify the required parameter 'post_purchase_order_model' is set
        if ($post_purchase_order_model === null || (is_array($post_purchase_order_model) && count($post_purchase_order_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_purchase_order_model when calling purchaseOrdersPut'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_purchase_order_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_purchase_order_model));
            } else {
                $httpBody = $post_purchase_order_model;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPut2
     *
     * Create or update a purchase order. If no purchase order with the specified purchase order number exists, a new purchase order will be created. Otherwise the existing purchase order will be updated.
     *
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostPurchaseOrderResponse
     */
    public function purchaseOrdersPut2($post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut2'][0])
    {
        list($response) = $this->purchaseOrdersPut2WithHttpInfo($post_purchase_order_model, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPut2WithHttpInfo
     *
     * Create or update a purchase order. If no purchase order with the specified purchase order number exists, a new purchase order will be created. Otherwise the existing purchase order will be updated.
     *
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostPurchaseOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPut2WithHttpInfo($post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut2'][0])
    {
        $request = $this->purchaseOrdersPut2Request($post_purchase_order_model, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostPurchaseOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostPurchaseOrderResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostPurchaseOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostPurchaseOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPut2Async
     *
     * Create or update a purchase order. If no purchase order with the specified purchase order number exists, a new purchase order will be created. Otherwise the existing purchase order will be updated.
     *
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPut2Async($post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut2'][0])
    {
        return $this->purchaseOrdersPut2AsyncWithHttpInfo($post_purchase_order_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPut2AsyncWithHttpInfo
     *
     * Create or update a purchase order. If no purchase order with the specified purchase order number exists, a new purchase order will be created. Otherwise the existing purchase order will be updated.
     *
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPut2AsyncWithHttpInfo($post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut2'][0])
    {
        $returnType = '\OngoingAPI\Model\PostPurchaseOrderResponse';
        $request = $this->purchaseOrdersPut2Request($post_purchase_order_model, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPut2'
     *
     * @param  \OngoingAPI\Model\PostPurchaseOrderModel $post_purchase_order_model Purchase order object, containing all purchase order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPut2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPut2Request($post_purchase_order_model, string $contentType = self::contentTypes['purchaseOrdersPut2'][0])
    {

        // verify the required parameter 'post_purchase_order_model' is set
        if ($post_purchase_order_model === null || (is_array($post_purchase_order_model) && count($post_purchase_order_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_purchase_order_model when calling purchaseOrdersPut2'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;





        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_purchase_order_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_purchase_order_model));
            } else {
                $httpBody = $post_purchase_order_model;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPutArticleItems
     *
     * Add article items to a purchase order.
     *
     * @param  int $purchase_order_id The purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderArticleItemsModel $post_purchase_order_article_items_model The article items which you want to add. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutArticleItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PurchaseOrderArticleItemResponse
     */
    public function purchaseOrdersPutArticleItems($purchase_order_id, $post_purchase_order_article_items_model, string $contentType = self::contentTypes['purchaseOrdersPutArticleItems'][0])
    {
        list($response) = $this->purchaseOrdersPutArticleItemsWithHttpInfo($purchase_order_id, $post_purchase_order_article_items_model, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPutArticleItemsWithHttpInfo
     *
     * Add article items to a purchase order.
     *
     * @param  int $purchase_order_id The purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderArticleItemsModel $post_purchase_order_article_items_model The article items which you want to add. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutArticleItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PurchaseOrderArticleItemResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPutArticleItemsWithHttpInfo($purchase_order_id, $post_purchase_order_article_items_model, string $contentType = self::contentTypes['purchaseOrdersPutArticleItems'][0])
    {
        $request = $this->purchaseOrdersPutArticleItemsRequest($purchase_order_id, $post_purchase_order_article_items_model, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PurchaseOrderArticleItemResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PurchaseOrderArticleItemResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PurchaseOrderArticleItemResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PurchaseOrderArticleItemResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PurchaseOrderArticleItemResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPutArticleItemsAsync
     *
     * Add article items to a purchase order.
     *
     * @param  int $purchase_order_id The purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderArticleItemsModel $post_purchase_order_article_items_model The article items which you want to add. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutArticleItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutArticleItemsAsync($purchase_order_id, $post_purchase_order_article_items_model, string $contentType = self::contentTypes['purchaseOrdersPutArticleItems'][0])
    {
        return $this->purchaseOrdersPutArticleItemsAsyncWithHttpInfo($purchase_order_id, $post_purchase_order_article_items_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPutArticleItemsAsyncWithHttpInfo
     *
     * Add article items to a purchase order.
     *
     * @param  int $purchase_order_id The purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderArticleItemsModel $post_purchase_order_article_items_model The article items which you want to add. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutArticleItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutArticleItemsAsyncWithHttpInfo($purchase_order_id, $post_purchase_order_article_items_model, string $contentType = self::contentTypes['purchaseOrdersPutArticleItems'][0])
    {
        $returnType = '\OngoingAPI\Model\PurchaseOrderArticleItemResponse';
        $request = $this->purchaseOrdersPutArticleItemsRequest($purchase_order_id, $post_purchase_order_article_items_model, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPutArticleItems'
     *
     * @param  int $purchase_order_id The purchase order ID. (required)
     * @param  \OngoingAPI\Model\PostPurchaseOrderArticleItemsModel $post_purchase_order_article_items_model The article items which you want to add. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutArticleItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPutArticleItemsRequest($purchase_order_id, $post_purchase_order_article_items_model, string $contentType = self::contentTypes['purchaseOrdersPutArticleItems'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPutArticleItems'
            );
        }

        // verify the required parameter 'post_purchase_order_article_items_model' is set
        if ($post_purchase_order_article_items_model === null || (is_array($post_purchase_order_article_items_model) && count($post_purchase_order_article_items_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_purchase_order_article_items_model when calling purchaseOrdersPutArticleItems'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/articleItems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_purchase_order_article_items_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_purchase_order_article_items_model));
            } else {
                $httpBody = $post_purchase_order_article_items_model;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPutFile
     *
     * Update a file which is attached to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function purchaseOrdersPutFile($purchase_order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPutFile'][0])
    {
        list($response) = $this->purchaseOrdersPutFileWithHttpInfo($purchase_order_id, $file_id, $post_file_model, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPutFileWithHttpInfo
     *
     * Update a file which is attached to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPutFileWithHttpInfo($purchase_order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPutFile'][0])
    {
        $request = $this->purchaseOrdersPutFileRequest($purchase_order_id, $file_id, $post_file_model, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostFileResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostFileResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostFileResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostFileResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostFileResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPutFileAsync
     *
     * Update a file which is attached to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutFileAsync($purchase_order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPutFile'][0])
    {
        return $this->purchaseOrdersPutFileAsyncWithHttpInfo($purchase_order_id, $file_id, $post_file_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPutFileAsyncWithHttpInfo
     *
     * Update a file which is attached to a purchase order.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutFileAsyncWithHttpInfo($purchase_order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPutFile'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->purchaseOrdersPutFileRequest($purchase_order_id, $file_id, $post_file_model, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPutFile'
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPutFileRequest($purchase_order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['purchaseOrdersPutFile'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPutFile'
            );
        }

        // verify the required parameter 'file_id' is set
        if ($file_id === null || (is_array($file_id) && count($file_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file_id when calling purchaseOrdersPutFile'
            );
        }

        // verify the required parameter 'post_file_model' is set
        if ($post_file_model === null || (is_array($post_file_model) && count($post_file_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_model when calling purchaseOrdersPutFile'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/files/{fileId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }
        // path params
        if ($file_id !== null) {
            $resourcePath = str_replace(
                '{' . 'fileId' . '}',
                ObjectSerializer::toPathValue($file_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_file_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_file_model));
            } else {
                $httpBody = $post_file_model;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation purchaseOrdersPutFileUsingFilename
     *
     * Create or update a file which is attached to a purchase order. The filename will be used to check if the file already exists.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function purchaseOrdersPutFileUsingFilename($purchase_order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['purchaseOrdersPutFileUsingFilename'][0])
    {
        list($response) = $this->purchaseOrdersPutFileUsingFilenameWithHttpInfo($purchase_order_id, $file_name, $post_file_no_filename_model, $contentType);
        return $response;
    }

    /**
     * Operation purchaseOrdersPutFileUsingFilenameWithHttpInfo
     *
     * Create or update a file which is attached to a purchase order. The filename will be used to check if the file already exists.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function purchaseOrdersPutFileUsingFilenameWithHttpInfo($purchase_order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['purchaseOrdersPutFileUsingFilename'][0])
    {
        $request = $this->purchaseOrdersPutFileUsingFilenameRequest($purchase_order_id, $file_name, $post_file_no_filename_model, $contentType);

        try {
            $options = $this->createHttpClientOption();
            try {
                $response = $this->client->send($request, $options);
            } catch (RequestException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                    $e->getResponse() ? (string) $e->getResponse()->getBody() : null
                );
            } catch (ConnectException $e) {
                throw new ApiException(
                    "[{$e->getCode()}] {$e->getMessage()}",
                    (int) $e->getCode(),
                    null,
                    null
                );
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode < 200 || $statusCode > 299) {
                throw new ApiException(
                    sprintf(
                        '[%d] Error connecting to the API (%s)',
                        $statusCode,
                        (string) $request->getUri()
                    ),
                    $statusCode,
                    $response->getHeaders(),
                    (string) $response->getBody()
                );
            }

            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostFileResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostFileResponse' !== 'string') {
                            try {
                                $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                            } catch (\JsonException $exception) {
                                throw new ApiException(
                                    sprintf(
                                        'Error JSON decoding server response (%s)',
                                        $request->getUri()
                                    ),
                                    $statusCode,
                                    $response->getHeaders(),
                                    $content
                                );
                            }
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostFileResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostFileResponse';
            if ($returnType === '\SplFileObject') {
                $content = $response->getBody(); //stream goes to serializer
            } else {
                $content = (string) $response->getBody();
                if ($returnType !== 'string') {
                    try {
                        $content = json_decode($content, false, 512, JSON_THROW_ON_ERROR);
                    } catch (\JsonException $exception) {
                        throw new ApiException(
                            sprintf(
                                'Error JSON decoding server response (%s)',
                                $request->getUri()
                            ),
                            $statusCode,
                            $response->getHeaders(),
                            $content
                        );
                    }
                }
            }

            return [
                ObjectSerializer::deserialize($content, $returnType, []),
                $response->getStatusCode(),
                $response->getHeaders()
            ];

        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostFileResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation purchaseOrdersPutFileUsingFilenameAsync
     *
     * Create or update a file which is attached to a purchase order. The filename will be used to check if the file already exists.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutFileUsingFilenameAsync($purchase_order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['purchaseOrdersPutFileUsingFilename'][0])
    {
        return $this->purchaseOrdersPutFileUsingFilenameAsyncWithHttpInfo($purchase_order_id, $file_name, $post_file_no_filename_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation purchaseOrdersPutFileUsingFilenameAsyncWithHttpInfo
     *
     * Create or update a file which is attached to a purchase order. The filename will be used to check if the file already exists.
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function purchaseOrdersPutFileUsingFilenameAsyncWithHttpInfo($purchase_order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['purchaseOrdersPutFileUsingFilename'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->purchaseOrdersPutFileUsingFilenameRequest($purchase_order_id, $file_name, $post_file_no_filename_model, $contentType);

        return $this->client
            ->sendAsync($request, $this->createHttpClientOption())
            ->then(
                function ($response) use ($returnType) {
                    if ($returnType === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ($returnType !== 'string') {
                            $content = json_decode($content);
                        }
                    }

                    return [
                        ObjectSerializer::deserialize($content, $returnType, []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                },
                function ($exception) {
                    $response = $exception->getResponse();
                    $statusCode = $response->getStatusCode();
                    throw new ApiException(
                        sprintf(
                            '[%d] Error connecting to the API (%s)',
                            $statusCode,
                            $exception->getRequest()->getUri()
                        ),
                        $statusCode,
                        $response->getHeaders(),
                        (string) $response->getBody()
                    );
                }
            );
    }

    /**
     * Create request for operation 'purchaseOrdersPutFileUsingFilename'
     *
     * @param  int $purchase_order_id Purchase order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['purchaseOrdersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function purchaseOrdersPutFileUsingFilenameRequest($purchase_order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['purchaseOrdersPutFileUsingFilename'][0])
    {

        // verify the required parameter 'purchase_order_id' is set
        if ($purchase_order_id === null || (is_array($purchase_order_id) && count($purchase_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $purchase_order_id when calling purchaseOrdersPutFileUsingFilename'
            );
        }

        // verify the required parameter 'file_name' is set
        if ($file_name === null || (is_array($file_name) && count($file_name) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file_name when calling purchaseOrdersPutFileUsingFilename'
            );
        }

        // verify the required parameter 'post_file_no_filename_model' is set
        if ($post_file_no_filename_model === null || (is_array($post_file_no_filename_model) && count($post_file_no_filename_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_no_filename_model when calling purchaseOrdersPutFileUsingFilename'
            );
        }


        $resourcePath = '/api/v1/purchaseOrders/{purchaseOrderId}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $file_name,
            'fileName', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);


        // path params
        if ($purchase_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'purchaseOrderId' . '}',
                ObjectSerializer::toPathValue($purchase_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_file_no_filename_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_file_no_filename_model));
            } else {
                $httpBody = $post_file_no_filename_model;
            }
        } elseif (count($formParams) > 0) {
            if ($multipart) {
                $multipartContents = [];
                foreach ($formParams as $formParamName => $formParamValue) {
                    $formParamValueItems = is_array($formParamValue) ? $formParamValue : [$formParamValue];
                    foreach ($formParamValueItems as $formParamValueItem) {
                        $multipartContents[] = [
                            'name' => $formParamName,
                            'contents' => $formParamValueItem
                        ];
                    }
                }
                // for HTTP post (form)
                $httpBody = new MultipartStream($multipartContents);

            } elseif (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the form parameters
                $httpBody = \GuzzleHttp\Utils::jsonEncode($formParams);
            } else {
                // for HTTP post (form)
                $httpBody = ObjectSerializer::buildQuery($formParams);
            }
        }

        // this endpoint requires HTTP basic authentication
        if (!empty($this->config->getUsername()) || !(empty($this->config->getPassword()))) {
            $headers['Authorization'] = 'Basic ' . base64_encode($this->config->getUsername() . ":" . $this->config->getPassword());
        }

        $defaultHeaders = [];
        if ($this->config->getUserAgent()) {
            $defaultHeaders['User-Agent'] = $this->config->getUserAgent();
        }

        $headers = array_merge(
            $defaultHeaders,
            $headerParams,
            $headers
        );

        $operationHost = $this->config->getHost();
        $query = ObjectSerializer::buildQuery($queryParams);
        return new Request(
            'PUT',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Create http client option
     *
     * @throws \RuntimeException on file opening failure
     * @return array of http client options
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->config->getDebug()) {
            $options[RequestOptions::DEBUG] = fopen($this->config->getDebugFile(), 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \RuntimeException('Failed to open the debug file: ' . $this->config->getDebugFile());
            }
        }

        return $options;
    }
}
