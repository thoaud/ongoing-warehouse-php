<?php
/**
 * OrdersApi
 * PHP version 7.4
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Ongoing WMS Goods Owner REST API
 *
 * Welcome to the documentation for Ongoing WMS Goods Owner REST API. [Ongoing WMS](https://www.ongoingwarehouse.com) is a cloud-based Warehouse Management System.  This API is intended to be used by people who wish to integrate systems such as a web shops or ERPs (Enterprise Resource Planning systems) with our WMS.  Please note that we have two other APIs as well:  * [Goods Owner SOAP API](https://developer.ongoingwarehouse.com/). The SOAP API fills a similar role as the REST API, but allows for more fine-grained control over Ongoing WMS than the REST API. * [Automation API](https://developer.ongoingwarehouse.com/automation-api). This API is intended to be used for integrations with automation equipment such as conveyor belts.  If you are unsure about whether you should use the REST API or the SOAP API, [please click here](https://developer.ongoingwarehouse.com/soap-vs-rest) to read our comparison between the two APIs.  If you have any questions, please send us an email at [contact@ongoingwarehouse.com](mailto:contact@ongoingwarehouse.com).  # REST API  [REST](https://en.wikipedia.org/wiki/Representational_state_transfer), or `Representational state transfer`, is a software architectural style used for creating Application Programming Interfaces (APIs). Our API tries to follow best practices for REST.  # How to use the API  On a basic level, the API consists of JSON requests and JSON replies being sent over HTTPS. To make it easier to use our API, we provide an [OpenAPI specification file](openapi.json) (formerly known as a Swagger specification file). Using this file you can use tools such as [Swagger CodeGen](https://swagger.io/tools/swagger-codegen/) or [NSwag](https://github.com/RicoSuter/NSwag) to automatically generate client code which lets you access the API.  ## Example C# integration  [Click here](https://github.com/OngoingWarehouse/Ongoing-Warehouse-REST-API-DotNet-Examples) to see an  example integration written in C#. We used NSwag to generate a client for accessing the API, and then used the client to make various requests.  ## Example requests and responses  [Click here](https://github.com/OngoingWarehouse/Ongoing-Warehouse-REST-API-Example-Requests) to see examples of what the requests and responses look like. The aforementioned link also contains a Postman collection of requests.  ## PUT and POST  Some of our requests support PUT and some support POST. The difference between them is: * If you make a PUT request, then the resource will either be created (if it does not already exist), or updated (if it already exists). * If you make a POST request, a new resource will always be created.  As an example, to create a new order, you make a PUT request with a new order number. If you wish to update the same order, you make another PUT request (with the same order number).  # Credentials  To integrate with our WMS, you will need the following:  1. A user name. 2. A password. 3. A goods owner ID.  Please ask the warehouse administrator for this information. [We have written a guide](https://docs.ongoingwarehouse.com/manuals/api-access) which shows how they can find it.  ## API URL  Every Ongoing WMS has its own unique URL for the API endpoint. The base API URL for a production system looks like this:  ``` API URL: https://api.ongoingsystems.se/{warehouse}/api/v1/ ```  Ask your contact person at the warehouse to specify what  ```{warehouse}``` should be in your particular case. ```{warehouse}``` can be taken from the  same URL which they use to login to the system:  ``` Login URL: https://{warehouse}.ongoingsystems.se/{warehouse} ```  ### API URL for demo system  If you have a demo system, then the API URL is slightly different. It takes the following form::  ``` API URL: https://wms1.ongoingsystems.se/{warehouse}/api/v1/ ```   # Authentication  The API uses [HTTP Basic Authentication](https://en.wikipedia.org/wiki/Basic_access_authentication).  Each request to the API must have a header called `Authorization`, which in turn must contain Base64-encoded information about your username and password, like so:  ``` Authorization: Basic QWxhZGRpbjpPcGVuU2VzYW1l ```  If the framework which you are using does not take care of this automatically, you will need to generate the header yourself. Take your username and password, and put them together in a new string with a colon between them. Then encode the result using [Base64](https://en.wikipedia.org/wiki/Base64). In pseudo code, it looks like this:  ``` var userNameAndPassword = Base64Encode(userName + \":\" + passWord); var authenticationHeader = \"Basic \" + userNameAndPassword; ```  # Security  All requests to the API must be encrypted, that is, sent using `https`.  # Content types  The API only accepts [JSON](https://en.wikipedia.org/wiki/JSON). All responses are also made as JSON.  # Time zones  ## Response  In the API responses, all times are given as UTC, like so:  ```     \"createdDate\": \"2019-04-09T10:39:31.3Z\" ```  ## Request  When you send in times in API requests, we strongly recommend that it is sent as UTC and that you specify the UTC time zone.  For instance, say that you want to know which orders the warehouse has shipped after 08:00 UTC on April 9, 2019. The date should be written like this:  ``` 2019-04-09T08:00:00.000+00:00 ```  Then it should be URL encoded:  ``` 2019-04-09T08%3A00%3A00.000%2B00%3A00 ```  Thus resulting in a request URL like this:  ``` GET api/v1/orders?goodsOwnerId=114&shippedTimeFrom=2019-04-09T08%3A00%3A00.000%2B00%3A00 ```  # Pagination  When you read data from the API, the API by default responds with all objects which match your filter. If there are too many objects which match your filter, this may cause timeouts. For instance, if the goods owner has 100 000 articles and you try to fetch them all with GetInventoryByQuery at the same time, you will most likely encounter a timeout.  We recommend that you paginate the responses for every API function which supports it. [Click here to read more about how pagination is handled in our API.](https://developer.ongoingwarehouse.com/paginating-responses)  # Entities  ## Goods owner  The clients of a warehouse are called goods owners. In other words, a goods owner is company which has hired a certain warehouse to deal with its warehousing needs. Each goods owner has a unique ID (an integer).  ## Article  An article is a stock-keeping unit (SKU). That is, articles are the things which a goods owner keeps at a warehouse. Each article needs a unique article number.  ### Stock balances  By making a GET request to the /articles endpoint, you will receive information about the inventory state for each article, in the section called `inventoryInfo`. The field called `sellableNumberOfItems` contains the number of items which can still be sold. If you create an order for an item, then the sellable number of items will be decreased accordingly. The field called `numberOfItems` contains the number of items which are physically present in the warehouse. If you are interested in more details, please see [this article](https://developer.ongoingwarehouse.com/inventory).  ## Article items  An article item represents part of the stock balance for a particular article. For instance, if the warehouse keeps the same article in two different locations, then the article will have at least two article items. For more information, [see this article](https://docs.ongoingwarehouse.com/manuals/batch-and-serial-numbers/).  By fetching all article items, you can see very detailed information about what is in stock. For instance, you can see exactly which batch numbers are in stock.  ## Order  An order is used to instruct the warehouse to ship articles to a specific customer. Each order needs a unique order number. You may not have two different orders with the same order number.  You may not update or cancel an order after the warehouse has started working on it.  ### Order lines  An order can have several order lines. For each order line, you must specify a unique number in the field `rowNumber`. If your system does not have a unique reference for each order line, you can simply use `1, 2, 3`, etc. as row numbers instead.  ### Transporter  It is possible to [set which transporter service should be used to ship an order](https://developer.ongoingwarehouse.com/transporters).  ## Purchase order  A purchase order is used to advise the warehouse of incoming deliveries. Each purchase order needs a unique purchase order number.  You may not update or cancel a purchase order after the warehouse has started working on it.  ### Purchase order lines  A purchase order can have several purchase order lines. For each purchase order line, you must specify a unique number in the field `rowNumber`. If your system does not have a unique reference for each purchase order line, you can simply use `1, 2, 3`, etc. as row numbers instead.  ## Return order  A return order is used to advise the warehouse that a customer intends to send back goods to the warehouse. Each return order refers to a particular order.  ## Warehouse  Each Ongoing WMS instance contains at least one warehouse.
 *
 * The version of the OpenAPI document: 1.0.0
 * Contact: contact@ongoingwarehouse.com
 * Generated by: https://openapi-generator.tech
 * Generator version: 7.9.0
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
 * OrdersApi Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class OrdersApi
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
        'ordersDelete' => [
            'application/json',
        ],
        'ordersDeleteByOrderNumber' => [
            'application/json',
        ],
        'ordersDeleteFile' => [
            'application/json',
        ],
        'ordersDeleteOrderClasses' => [
            'application/json',
        ],
        'ordersDeleteParcel' => [
            'application/json',
        ],
        'ordersDeleteWayOfDeliveryType' => [
            'application/json',
        ],
        'ordersDeleteWaybillRow' => [
            'application/json',
        ],
        'ordersGet' => [
            'application/json',
        ],
        'ordersGetAll' => [
            'application/json',
        ],
        'ordersGetFiles' => [
            'application/json',
        ],
        'ordersGetInvoiceCharges' => [
            'application/json',
        ],
        'ordersGetOrderClasses' => [
            'application/json',
        ],
        'ordersGetOrderStatuses' => [
            'application/json',
        ],
        'ordersGetOrderTypes' => [
            'application/json',
        ],
        'ordersGetPickability' => [
            'application/json',
        ],
        'ordersGetWayBillRows' => [
            'application/json',
        ],
        'ordersGetWayOfDeliveryTypes' => [
            'application/json',
        ],
        'ordersPatchAddOrderClasses' => [
            'application/json',
        ],
        'ordersPatchCustomerLinePrice' => [
            'application/json',
        ],
        'ordersPatchDeliveryDate' => [
            'application/json',
        ],
        'ordersPatchLinePrice' => [
            'application/json',
        ],
        'ordersPatchOrderFreeText1' => [
            'application/json',
        ],
        'ordersPatchOrderFreeText12' => [
            'application/json',
        ],
        'ordersPatchOrderFreeText2' => [
            'application/json',
        ],
        'ordersPatchOrderLineComment' => [
            'application/json',
        ],
        'ordersPatchOrderNumber' => [
            'application/json',
        ],
        'ordersPatchOrderRemark' => [
            'application/json',
        ],
        'ordersPatchOrderStatus' => [
            'application/json',
        ],
        'ordersPatchOrderTransporterCode' => [
            'application/json',
        ],
        'ordersPatchOrderWarehouseInstruction' => [
            'application/json',
        ],
        'ordersPatchReportedNumberOfItems' => [
            'application/json',
        ],
        'ordersPatchReportedReturnedNumberOfItems' => [
            'application/json',
        ],
        'ordersPatchReturnWaybill' => [
            'application/json',
        ],
        'ordersPatchServicePointCode' => [
            'application/json',
        ],
        'ordersPatchSetOrderClasses' => [
            'application/json',
        ],
        'ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems' => [
            'application/json',
        ],
        'ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems' => [
            'application/json',
        ],
        'ordersPatchWayBillRow' => [
            'application/json',
        ],
        'ordersPatchWaybill' => [
            'application/json',
        ],
        'ordersPost' => [
            'application/json',
        ],
        'ordersPostWayBillRow' => [
            'application/json',
        ],
        'ordersPutFile' => [
            'application/json',
        ],
        'ordersPutFileUsingFilename' => [
            'application/json',
        ],
        'ordersPutOrder' => [
            'application/json',
        ],
        'ordersPutOrderTextLineUsingRowNumber' => [
            'application/json',
        ],
        'ordersPutOrderTracking' => [
            'application/json',
        ],
        'ordersPutOrderUsingOrderId' => [
            'application/json',
        ],
        'ordersPutParcel' => [
            'application/json',
        ],
        'ordersPutParcelTracking' => [
            'application/json',
        ],
        'ordersPutParcelUsingId' => [
            'application/json',
        ],
        'ordersPutWayOfDeliveryType' => [
            'application/json',
        ],
        'ordersPutWayOfDeliveryTypeUsingId' => [
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
        $this->config = $config ?: Configuration::getDefaultConfiguration();
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
     * Operation ordersDelete
     *
     * Cancel an order. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDelete'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostOrderResponse
     */
    public function ordersDelete($order_id, string $contentType = self::contentTypes['ordersDelete'][0])
    {
        list($response) = $this->ordersDeleteWithHttpInfo($order_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersDeleteWithHttpInfo
     *
     * Cancel an order. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDelete'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersDeleteWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersDelete'][0])
    {
        $request = $this->ordersDeleteRequest($order_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostOrderResponse';
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
                        '\OngoingAPI\Model\PostOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersDeleteAsync
     *
     * Cancel an order. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteAsync($order_id, string $contentType = self::contentTypes['ordersDelete'][0])
    {
        return $this->ordersDeleteAsyncWithHttpInfo($order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersDeleteAsyncWithHttpInfo
     *
     * Cancel an order. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteAsyncWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersDelete'][0])
    {
        $returnType = '\OngoingAPI\Model\PostOrderResponse';
        $request = $this->ordersDeleteRequest($order_id, $contentType);

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
     * Create request for operation 'ordersDelete'
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersDeleteRequest($order_id, string $contentType = self::contentTypes['ordersDelete'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersDelete'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersDeleteByOrderNumber
     *
     * Cancel an order using the order number. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostOrderResponse
     */
    public function ordersDeleteByOrderNumber($goods_owner_id, $order_number, string $contentType = self::contentTypes['ordersDeleteByOrderNumber'][0])
    {
        list($response) = $this->ordersDeleteByOrderNumberWithHttpInfo($goods_owner_id, $order_number, $contentType);
        return $response;
    }

    /**
     * Operation ordersDeleteByOrderNumberWithHttpInfo
     *
     * Cancel an order using the order number. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersDeleteByOrderNumberWithHttpInfo($goods_owner_id, $order_number, string $contentType = self::contentTypes['ordersDeleteByOrderNumber'][0])
    {
        $request = $this->ordersDeleteByOrderNumberRequest($goods_owner_id, $order_number, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostOrderResponse';
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
                        '\OngoingAPI\Model\PostOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersDeleteByOrderNumberAsync
     *
     * Cancel an order using the order number. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteByOrderNumberAsync($goods_owner_id, $order_number, string $contentType = self::contentTypes['ordersDeleteByOrderNumber'][0])
    {
        return $this->ordersDeleteByOrderNumberAsyncWithHttpInfo($goods_owner_id, $order_number, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersDeleteByOrderNumberAsyncWithHttpInfo
     *
     * Cancel an order using the order number. You can only cancel an order if the warehouse has not started working on it.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteByOrderNumberAsyncWithHttpInfo($goods_owner_id, $order_number, string $contentType = self::contentTypes['ordersDeleteByOrderNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\PostOrderResponse';
        $request = $this->ordersDeleteByOrderNumberRequest($goods_owner_id, $order_number, $contentType);

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
     * Create request for operation 'ordersDeleteByOrderNumber'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersDeleteByOrderNumberRequest($goods_owner_id, $order_number, string $contentType = self::contentTypes['ordersDeleteByOrderNumber'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling ordersDeleteByOrderNumber'
            );
        }

        // verify the required parameter 'order_number' is set
        if ($order_number === null || (is_array($order_number) && count($order_number) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_number when calling ordersDeleteByOrderNumber'
            );
        }


        $resourcePath = '/api/v1/orders';
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
            $order_number,
            'orderNumber', // param base name
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
     * Operation ordersDeleteFile
     *
     * Delete a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function ordersDeleteFile($order_id, $file_id, string $contentType = self::contentTypes['ordersDeleteFile'][0])
    {
        list($response) = $this->ordersDeleteFileWithHttpInfo($order_id, $file_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersDeleteFileWithHttpInfo
     *
     * Delete a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersDeleteFileWithHttpInfo($order_id, $file_id, string $contentType = self::contentTypes['ordersDeleteFile'][0])
    {
        $request = $this->ordersDeleteFileRequest($order_id, $file_id, $contentType);

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
     * Operation ordersDeleteFileAsync
     *
     * Delete a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteFileAsync($order_id, $file_id, string $contentType = self::contentTypes['ordersDeleteFile'][0])
    {
        return $this->ordersDeleteFileAsyncWithHttpInfo($order_id, $file_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersDeleteFileAsyncWithHttpInfo
     *
     * Delete a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteFileAsyncWithHttpInfo($order_id, $file_id, string $contentType = self::contentTypes['ordersDeleteFile'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->ordersDeleteFileRequest($order_id, $file_id, $contentType);

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
     * Create request for operation 'ordersDeleteFile'
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersDeleteFileRequest($order_id, $file_id, string $contentType = self::contentTypes['ordersDeleteFile'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersDeleteFile'
            );
        }

        // verify the required parameter 'file_id' is set
        if ($file_id === null || (is_array($file_id) && count($file_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file_id when calling ordersDeleteFile'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/files/{fileId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersDeleteOrderClasses
     *
     * Delete all order classes from an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  bool $only_delete_parcel_type_suggestion_order_classes If set to true, then we will only clear those order classes which are marked as being parcel type suggestions. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersDeleteOrderClasses($order_id, $only_delete_parcel_type_suggestion_order_classes = null, string $contentType = self::contentTypes['ordersDeleteOrderClasses'][0])
    {
        list($response) = $this->ordersDeleteOrderClassesWithHttpInfo($order_id, $only_delete_parcel_type_suggestion_order_classes, $contentType);
        return $response;
    }

    /**
     * Operation ordersDeleteOrderClassesWithHttpInfo
     *
     * Delete all order classes from an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  bool $only_delete_parcel_type_suggestion_order_classes If set to true, then we will only clear those order classes which are marked as being parcel type suggestions. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersDeleteOrderClassesWithHttpInfo($order_id, $only_delete_parcel_type_suggestion_order_classes = null, string $contentType = self::contentTypes['ordersDeleteOrderClasses'][0])
    {
        $request = $this->ordersDeleteOrderClassesRequest($order_id, $only_delete_parcel_type_suggestion_order_classes, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersDeleteOrderClassesAsync
     *
     * Delete all order classes from an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  bool $only_delete_parcel_type_suggestion_order_classes If set to true, then we will only clear those order classes which are marked as being parcel type suggestions. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteOrderClassesAsync($order_id, $only_delete_parcel_type_suggestion_order_classes = null, string $contentType = self::contentTypes['ordersDeleteOrderClasses'][0])
    {
        return $this->ordersDeleteOrderClassesAsyncWithHttpInfo($order_id, $only_delete_parcel_type_suggestion_order_classes, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersDeleteOrderClassesAsyncWithHttpInfo
     *
     * Delete all order classes from an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  bool $only_delete_parcel_type_suggestion_order_classes If set to true, then we will only clear those order classes which are marked as being parcel type suggestions. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteOrderClassesAsyncWithHttpInfo($order_id, $only_delete_parcel_type_suggestion_order_classes = null, string $contentType = self::contentTypes['ordersDeleteOrderClasses'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersDeleteOrderClassesRequest($order_id, $only_delete_parcel_type_suggestion_order_classes, $contentType);

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
     * Create request for operation 'ordersDeleteOrderClasses'
     *
     * @param  int $order_id OrderId. (required)
     * @param  bool $only_delete_parcel_type_suggestion_order_classes If set to true, then we will only clear those order classes which are marked as being parcel type suggestions. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersDeleteOrderClassesRequest($order_id, $only_delete_parcel_type_suggestion_order_classes = null, string $contentType = self::contentTypes['ordersDeleteOrderClasses'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersDeleteOrderClasses'
            );
        }



        $resourcePath = '/api/v1/orders/{orderId}/classes';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_delete_parcel_type_suggestion_order_classes,
            'onlyDeleteParcelTypeSuggestionOrderClasses', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);


        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersDeleteParcel
     *
     * Deletes a parcel. A parcel can only be deleted if it is empty.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $parcel_id Parcel ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteParcel'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostParcelResponse
     */
    public function ordersDeleteParcel($order_id, $parcel_id, string $contentType = self::contentTypes['ordersDeleteParcel'][0])
    {
        list($response) = $this->ordersDeleteParcelWithHttpInfo($order_id, $parcel_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersDeleteParcelWithHttpInfo
     *
     * Deletes a parcel. A parcel can only be deleted if it is empty.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $parcel_id Parcel ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteParcel'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostParcelResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersDeleteParcelWithHttpInfo($order_id, $parcel_id, string $contentType = self::contentTypes['ordersDeleteParcel'][0])
    {
        $request = $this->ordersDeleteParcelRequest($order_id, $parcel_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostParcelResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostParcelResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostParcelResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostParcelResponse';
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
                        '\OngoingAPI\Model\PostParcelResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersDeleteParcelAsync
     *
     * Deletes a parcel. A parcel can only be deleted if it is empty.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $parcel_id Parcel ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteParcel'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteParcelAsync($order_id, $parcel_id, string $contentType = self::contentTypes['ordersDeleteParcel'][0])
    {
        return $this->ordersDeleteParcelAsyncWithHttpInfo($order_id, $parcel_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersDeleteParcelAsyncWithHttpInfo
     *
     * Deletes a parcel. A parcel can only be deleted if it is empty.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $parcel_id Parcel ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteParcel'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteParcelAsyncWithHttpInfo($order_id, $parcel_id, string $contentType = self::contentTypes['ordersDeleteParcel'][0])
    {
        $returnType = '\OngoingAPI\Model\PostParcelResponse';
        $request = $this->ordersDeleteParcelRequest($order_id, $parcel_id, $contentType);

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
     * Create request for operation 'ordersDeleteParcel'
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $parcel_id Parcel ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteParcel'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersDeleteParcelRequest($order_id, $parcel_id, string $contentType = self::contentTypes['ordersDeleteParcel'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersDeleteParcel'
            );
        }

        // verify the required parameter 'parcel_id' is set
        if ($parcel_id === null || (is_array($parcel_id) && count($parcel_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $parcel_id when calling ordersDeleteParcel'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/parcels/{parcelId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($parcel_id !== null) {
            $resourcePath = str_replace(
                '{' . 'parcelId' . '}',
                ObjectSerializer::toPathValue($parcel_id),
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
     * Operation ordersDeleteWayOfDeliveryType
     *
     * Delete a way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostWayOfDeliveryTypeResponse
     */
    public function ordersDeleteWayOfDeliveryType($way_of_delivery_type_id, string $contentType = self::contentTypes['ordersDeleteWayOfDeliveryType'][0])
    {
        list($response) = $this->ordersDeleteWayOfDeliveryTypeWithHttpInfo($way_of_delivery_type_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersDeleteWayOfDeliveryTypeWithHttpInfo
     *
     * Delete a way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostWayOfDeliveryTypeResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersDeleteWayOfDeliveryTypeWithHttpInfo($way_of_delivery_type_id, string $contentType = self::contentTypes['ordersDeleteWayOfDeliveryType'][0])
    {
        $request = $this->ordersDeleteWayOfDeliveryTypeRequest($way_of_delivery_type_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostWayOfDeliveryTypeResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostWayOfDeliveryTypeResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse';
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
                        '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersDeleteWayOfDeliveryTypeAsync
     *
     * Delete a way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteWayOfDeliveryTypeAsync($way_of_delivery_type_id, string $contentType = self::contentTypes['ordersDeleteWayOfDeliveryType'][0])
    {
        return $this->ordersDeleteWayOfDeliveryTypeAsyncWithHttpInfo($way_of_delivery_type_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersDeleteWayOfDeliveryTypeAsyncWithHttpInfo
     *
     * Delete a way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteWayOfDeliveryTypeAsyncWithHttpInfo($way_of_delivery_type_id, string $contentType = self::contentTypes['ordersDeleteWayOfDeliveryType'][0])
    {
        $returnType = '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse';
        $request = $this->ordersDeleteWayOfDeliveryTypeRequest($way_of_delivery_type_id, $contentType);

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
     * Create request for operation 'ordersDeleteWayOfDeliveryType'
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersDeleteWayOfDeliveryTypeRequest($way_of_delivery_type_id, string $contentType = self::contentTypes['ordersDeleteWayOfDeliveryType'][0])
    {

        // verify the required parameter 'way_of_delivery_type_id' is set
        if ($way_of_delivery_type_id === null || (is_array($way_of_delivery_type_id) && count($way_of_delivery_type_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $way_of_delivery_type_id when calling ordersDeleteWayOfDeliveryType'
            );
        }


        $resourcePath = '/api/v1/orders/wayOfDeliveryTypes/{wayOfDeliveryTypeId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($way_of_delivery_type_id !== null) {
            $resourcePath = str_replace(
                '{' . 'wayOfDeliveryTypeId' . '}',
                ObjectSerializer::toPathValue($way_of_delivery_type_id),
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
     * Operation ordersDeleteWaybillRow
     *
     * Deletes a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWaybillRow'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostParcelResponse
     */
    public function ordersDeleteWaybillRow($order_id, $way_bill_row_id, string $contentType = self::contentTypes['ordersDeleteWaybillRow'][0])
    {
        list($response) = $this->ordersDeleteWaybillRowWithHttpInfo($order_id, $way_bill_row_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersDeleteWaybillRowWithHttpInfo
     *
     * Deletes a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWaybillRow'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostParcelResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersDeleteWaybillRowWithHttpInfo($order_id, $way_bill_row_id, string $contentType = self::contentTypes['ordersDeleteWaybillRow'][0])
    {
        $request = $this->ordersDeleteWaybillRowRequest($order_id, $way_bill_row_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostParcelResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostParcelResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostParcelResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostParcelResponse';
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
                        '\OngoingAPI\Model\PostParcelResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersDeleteWaybillRowAsync
     *
     * Deletes a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWaybillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteWaybillRowAsync($order_id, $way_bill_row_id, string $contentType = self::contentTypes['ordersDeleteWaybillRow'][0])
    {
        return $this->ordersDeleteWaybillRowAsyncWithHttpInfo($order_id, $way_bill_row_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersDeleteWaybillRowAsyncWithHttpInfo
     *
     * Deletes a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWaybillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersDeleteWaybillRowAsyncWithHttpInfo($order_id, $way_bill_row_id, string $contentType = self::contentTypes['ordersDeleteWaybillRow'][0])
    {
        $returnType = '\OngoingAPI\Model\PostParcelResponse';
        $request = $this->ordersDeleteWaybillRowRequest($order_id, $way_bill_row_id, $contentType);

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
     * Create request for operation 'ordersDeleteWaybillRow'
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersDeleteWaybillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersDeleteWaybillRowRequest($order_id, $way_bill_row_id, string $contentType = self::contentTypes['ordersDeleteWaybillRow'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersDeleteWaybillRow'
            );
        }

        // verify the required parameter 'way_bill_row_id' is set
        if ($way_bill_row_id === null || (is_array($way_bill_row_id) && count($way_bill_row_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $way_bill_row_id when calling ordersDeleteWaybillRow'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/wayBillRows/{wayBillRowId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($way_bill_row_id !== null) {
            $resourcePath = str_replace(
                '{' . 'wayBillRowId' . '}',
                ObjectSerializer::toPathValue($way_bill_row_id),
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
     * Operation ordersGet
     *
     * Get an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetOrderModel
     */
    public function ordersGet($order_id, string $contentType = self::contentTypes['ordersGet'][0])
    {
        list($response) = $this->ordersGetWithHttpInfo($order_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetWithHttpInfo
     *
     * Get an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetOrderModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGet'][0])
    {
        $request = $this->ordersGetRequest($order_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetOrderModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetOrderModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetOrderModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetOrderModel';
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
                        '\OngoingAPI\Model\GetOrderModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetAsync
     *
     * Get an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetAsync($order_id, string $contentType = self::contentTypes['ordersGet'][0])
    {
        return $this->ordersGetAsyncWithHttpInfo($order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetAsyncWithHttpInfo
     *
     * Get an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetAsyncWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGet'][0])
    {
        $returnType = '\OngoingAPI\Model\GetOrderModel';
        $request = $this->ordersGetRequest($order_id, $contentType);

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
     * Create request for operation 'ordersGet'
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetRequest($order_id, string $contentType = self::contentTypes['ordersGet'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersGet'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersGetAll
     *
     * Get all orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (optional)
     * @param  \DateTime $shipped_time_from Filter for orders which were marked as &#39;shipped&#39; after this time. (optional)
     * @param  \DateTime $shipped_time_to Filter for orders which were marked as &#39;shipped&#39; before this time. (optional)
     * @param  int $order_status_from Filter for orders whose status is greater than or equal to this. (optional)
     * @param  int $order_status_to Filter for orders whose status is lower than or equal to this. (optional)
     * @param  bool $only_orders_with_order_lines_to_report Only return orders where there are order lines with ReportedNumberOfItems &lt; PickedNumberOfItems. (optional)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  \DateTime $order_status_changed_time_from Only return orders whose status has changed after this time. (optional)
     * @param  \DateTime $last_returned_from Only return orders which have been returned on since this time. (optional)
     * @param  string[] $order_numbers order_numbers (optional)
     * @param  \DateTime $order_created_time_from Only return orders which have been created after this time. (optional)
     * @param  bool $only_orders_with_order_lines_to_report_returned Only return orders where there are order lines where ReportedReturnedNumberOfItems is less than the actual number of returned items. (optional)
     * @param  bool $only_if_transport_printed Only return orders where the transport documents have been printed. (optional)
     * @param  int $shipment_id Only return orders belonging to this shipment. (optional)
     * @param  string $pickable Filter for whether or not an order is pickable. Either &#39;All&#39; or &#39;NotPickable&#39; or &#39;NotOk&#39;. (optional)
     * @param  string $parcel_number Filter for orders which contains a pallet/package with the specified parcel number. (optional)
     * @param  \DateTime $order_created_time_to Only return orders which have been created before this time. (optional)
     * @param  string[] $article_numbers Filter for orders which contains at least one of these article numbers. (optional)
     * @param  string $serial Filter for orders which contains an item with the specified serial number. (optional)
     * @param  string $market_place market_place (optional)
     * @param  \DateTime $order_updated_time_from Only return orders which have been updated after this time. Note that this value must be at most 2 days old. (optional)
     * @param  int $back_order_for_order_id Only return orders which are back orders for the order with this order ID. (optional)
     * @param  string[] $reference_numbers Only return orders with the specified reference numbers. (optional)
     * @param  string $order_line_supplier_number Only return orders which contains order lines with articles from the given supplier. This also includes the alternative suppliers of the article. (optional)
     * @param  \DateTime $last_picking_time_from Only return orders which have been picked on since this time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetOrderModel[]
     */
    public function ordersGetAll($goods_owner_id, $order_number = null, $shipped_time_from = null, $shipped_time_to = null, $order_status_from = null, $order_status_to = null, $only_orders_with_order_lines_to_report = null, $order_id_from = null, $max_orders_to_get = null, $order_status_changed_time_from = null, $last_returned_from = null, $order_numbers = null, $order_created_time_from = null, $only_orders_with_order_lines_to_report_returned = null, $only_if_transport_printed = null, $shipment_id = null, $pickable = null, $parcel_number = null, $order_created_time_to = null, $article_numbers = null, $serial = null, $market_place = null, $order_updated_time_from = null, $back_order_for_order_id = null, $reference_numbers = null, $order_line_supplier_number = null, $last_picking_time_from = null, string $contentType = self::contentTypes['ordersGetAll'][0])
    {
        list($response) = $this->ordersGetAllWithHttpInfo($goods_owner_id, $order_number, $shipped_time_from, $shipped_time_to, $order_status_from, $order_status_to, $only_orders_with_order_lines_to_report, $order_id_from, $max_orders_to_get, $order_status_changed_time_from, $last_returned_from, $order_numbers, $order_created_time_from, $only_orders_with_order_lines_to_report_returned, $only_if_transport_printed, $shipment_id, $pickable, $parcel_number, $order_created_time_to, $article_numbers, $serial, $market_place, $order_updated_time_from, $back_order_for_order_id, $reference_numbers, $order_line_supplier_number, $last_picking_time_from, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetAllWithHttpInfo
     *
     * Get all orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (optional)
     * @param  \DateTime $shipped_time_from Filter for orders which were marked as &#39;shipped&#39; after this time. (optional)
     * @param  \DateTime $shipped_time_to Filter for orders which were marked as &#39;shipped&#39; before this time. (optional)
     * @param  int $order_status_from Filter for orders whose status is greater than or equal to this. (optional)
     * @param  int $order_status_to Filter for orders whose status is lower than or equal to this. (optional)
     * @param  bool $only_orders_with_order_lines_to_report Only return orders where there are order lines with ReportedNumberOfItems &lt; PickedNumberOfItems. (optional)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  \DateTime $order_status_changed_time_from Only return orders whose status has changed after this time. (optional)
     * @param  \DateTime $last_returned_from Only return orders which have been returned on since this time. (optional)
     * @param  string[] $order_numbers (optional)
     * @param  \DateTime $order_created_time_from Only return orders which have been created after this time. (optional)
     * @param  bool $only_orders_with_order_lines_to_report_returned Only return orders where there are order lines where ReportedReturnedNumberOfItems is less than the actual number of returned items. (optional)
     * @param  bool $only_if_transport_printed Only return orders where the transport documents have been printed. (optional)
     * @param  int $shipment_id Only return orders belonging to this shipment. (optional)
     * @param  string $pickable Filter for whether or not an order is pickable. Either &#39;All&#39; or &#39;NotPickable&#39; or &#39;NotOk&#39;. (optional)
     * @param  string $parcel_number Filter for orders which contains a pallet/package with the specified parcel number. (optional)
     * @param  \DateTime $order_created_time_to Only return orders which have been created before this time. (optional)
     * @param  string[] $article_numbers Filter for orders which contains at least one of these article numbers. (optional)
     * @param  string $serial Filter for orders which contains an item with the specified serial number. (optional)
     * @param  string $market_place (optional)
     * @param  \DateTime $order_updated_time_from Only return orders which have been updated after this time. Note that this value must be at most 2 days old. (optional)
     * @param  int $back_order_for_order_id Only return orders which are back orders for the order with this order ID. (optional)
     * @param  string[] $reference_numbers Only return orders with the specified reference numbers. (optional)
     * @param  string $order_line_supplier_number Only return orders which contains order lines with articles from the given supplier. This also includes the alternative suppliers of the article. (optional)
     * @param  \DateTime $last_picking_time_from Only return orders which have been picked on since this time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetOrderModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetAllWithHttpInfo($goods_owner_id, $order_number = null, $shipped_time_from = null, $shipped_time_to = null, $order_status_from = null, $order_status_to = null, $only_orders_with_order_lines_to_report = null, $order_id_from = null, $max_orders_to_get = null, $order_status_changed_time_from = null, $last_returned_from = null, $order_numbers = null, $order_created_time_from = null, $only_orders_with_order_lines_to_report_returned = null, $only_if_transport_printed = null, $shipment_id = null, $pickable = null, $parcel_number = null, $order_created_time_to = null, $article_numbers = null, $serial = null, $market_place = null, $order_updated_time_from = null, $back_order_for_order_id = null, $reference_numbers = null, $order_line_supplier_number = null, $last_picking_time_from = null, string $contentType = self::contentTypes['ordersGetAll'][0])
    {
        $request = $this->ordersGetAllRequest($goods_owner_id, $order_number, $shipped_time_from, $shipped_time_to, $order_status_from, $order_status_to, $only_orders_with_order_lines_to_report, $order_id_from, $max_orders_to_get, $order_status_changed_time_from, $last_returned_from, $order_numbers, $order_created_time_from, $only_orders_with_order_lines_to_report_returned, $only_if_transport_printed, $shipment_id, $pickable, $parcel_number, $order_created_time_to, $article_numbers, $serial, $market_place, $order_updated_time_from, $back_order_for_order_id, $reference_numbers, $order_line_supplier_number, $last_picking_time_from, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetOrderModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetOrderModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetOrderModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetOrderModel[]';
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
                        '\OngoingAPI\Model\GetOrderModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetAllAsync
     *
     * Get all orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (optional)
     * @param  \DateTime $shipped_time_from Filter for orders which were marked as &#39;shipped&#39; after this time. (optional)
     * @param  \DateTime $shipped_time_to Filter for orders which were marked as &#39;shipped&#39; before this time. (optional)
     * @param  int $order_status_from Filter for orders whose status is greater than or equal to this. (optional)
     * @param  int $order_status_to Filter for orders whose status is lower than or equal to this. (optional)
     * @param  bool $only_orders_with_order_lines_to_report Only return orders where there are order lines with ReportedNumberOfItems &lt; PickedNumberOfItems. (optional)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  \DateTime $order_status_changed_time_from Only return orders whose status has changed after this time. (optional)
     * @param  \DateTime $last_returned_from Only return orders which have been returned on since this time. (optional)
     * @param  string[] $order_numbers (optional)
     * @param  \DateTime $order_created_time_from Only return orders which have been created after this time. (optional)
     * @param  bool $only_orders_with_order_lines_to_report_returned Only return orders where there are order lines where ReportedReturnedNumberOfItems is less than the actual number of returned items. (optional)
     * @param  bool $only_if_transport_printed Only return orders where the transport documents have been printed. (optional)
     * @param  int $shipment_id Only return orders belonging to this shipment. (optional)
     * @param  string $pickable Filter for whether or not an order is pickable. Either &#39;All&#39; or &#39;NotPickable&#39; or &#39;NotOk&#39;. (optional)
     * @param  string $parcel_number Filter for orders which contains a pallet/package with the specified parcel number. (optional)
     * @param  \DateTime $order_created_time_to Only return orders which have been created before this time. (optional)
     * @param  string[] $article_numbers Filter for orders which contains at least one of these article numbers. (optional)
     * @param  string $serial Filter for orders which contains an item with the specified serial number. (optional)
     * @param  string $market_place (optional)
     * @param  \DateTime $order_updated_time_from Only return orders which have been updated after this time. Note that this value must be at most 2 days old. (optional)
     * @param  int $back_order_for_order_id Only return orders which are back orders for the order with this order ID. (optional)
     * @param  string[] $reference_numbers Only return orders with the specified reference numbers. (optional)
     * @param  string $order_line_supplier_number Only return orders which contains order lines with articles from the given supplier. This also includes the alternative suppliers of the article. (optional)
     * @param  \DateTime $last_picking_time_from Only return orders which have been picked on since this time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetAllAsync($goods_owner_id, $order_number = null, $shipped_time_from = null, $shipped_time_to = null, $order_status_from = null, $order_status_to = null, $only_orders_with_order_lines_to_report = null, $order_id_from = null, $max_orders_to_get = null, $order_status_changed_time_from = null, $last_returned_from = null, $order_numbers = null, $order_created_time_from = null, $only_orders_with_order_lines_to_report_returned = null, $only_if_transport_printed = null, $shipment_id = null, $pickable = null, $parcel_number = null, $order_created_time_to = null, $article_numbers = null, $serial = null, $market_place = null, $order_updated_time_from = null, $back_order_for_order_id = null, $reference_numbers = null, $order_line_supplier_number = null, $last_picking_time_from = null, string $contentType = self::contentTypes['ordersGetAll'][0])
    {
        return $this->ordersGetAllAsyncWithHttpInfo($goods_owner_id, $order_number, $shipped_time_from, $shipped_time_to, $order_status_from, $order_status_to, $only_orders_with_order_lines_to_report, $order_id_from, $max_orders_to_get, $order_status_changed_time_from, $last_returned_from, $order_numbers, $order_created_time_from, $only_orders_with_order_lines_to_report_returned, $only_if_transport_printed, $shipment_id, $pickable, $parcel_number, $order_created_time_to, $article_numbers, $serial, $market_place, $order_updated_time_from, $back_order_for_order_id, $reference_numbers, $order_line_supplier_number, $last_picking_time_from, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetAllAsyncWithHttpInfo
     *
     * Get all orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (optional)
     * @param  \DateTime $shipped_time_from Filter for orders which were marked as &#39;shipped&#39; after this time. (optional)
     * @param  \DateTime $shipped_time_to Filter for orders which were marked as &#39;shipped&#39; before this time. (optional)
     * @param  int $order_status_from Filter for orders whose status is greater than or equal to this. (optional)
     * @param  int $order_status_to Filter for orders whose status is lower than or equal to this. (optional)
     * @param  bool $only_orders_with_order_lines_to_report Only return orders where there are order lines with ReportedNumberOfItems &lt; PickedNumberOfItems. (optional)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  \DateTime $order_status_changed_time_from Only return orders whose status has changed after this time. (optional)
     * @param  \DateTime $last_returned_from Only return orders which have been returned on since this time. (optional)
     * @param  string[] $order_numbers (optional)
     * @param  \DateTime $order_created_time_from Only return orders which have been created after this time. (optional)
     * @param  bool $only_orders_with_order_lines_to_report_returned Only return orders where there are order lines where ReportedReturnedNumberOfItems is less than the actual number of returned items. (optional)
     * @param  bool $only_if_transport_printed Only return orders where the transport documents have been printed. (optional)
     * @param  int $shipment_id Only return orders belonging to this shipment. (optional)
     * @param  string $pickable Filter for whether or not an order is pickable. Either &#39;All&#39; or &#39;NotPickable&#39; or &#39;NotOk&#39;. (optional)
     * @param  string $parcel_number Filter for orders which contains a pallet/package with the specified parcel number. (optional)
     * @param  \DateTime $order_created_time_to Only return orders which have been created before this time. (optional)
     * @param  string[] $article_numbers Filter for orders which contains at least one of these article numbers. (optional)
     * @param  string $serial Filter for orders which contains an item with the specified serial number. (optional)
     * @param  string $market_place (optional)
     * @param  \DateTime $order_updated_time_from Only return orders which have been updated after this time. Note that this value must be at most 2 days old. (optional)
     * @param  int $back_order_for_order_id Only return orders which are back orders for the order with this order ID. (optional)
     * @param  string[] $reference_numbers Only return orders with the specified reference numbers. (optional)
     * @param  string $order_line_supplier_number Only return orders which contains order lines with articles from the given supplier. This also includes the alternative suppliers of the article. (optional)
     * @param  \DateTime $last_picking_time_from Only return orders which have been picked on since this time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetAllAsyncWithHttpInfo($goods_owner_id, $order_number = null, $shipped_time_from = null, $shipped_time_to = null, $order_status_from = null, $order_status_to = null, $only_orders_with_order_lines_to_report = null, $order_id_from = null, $max_orders_to_get = null, $order_status_changed_time_from = null, $last_returned_from = null, $order_numbers = null, $order_created_time_from = null, $only_orders_with_order_lines_to_report_returned = null, $only_if_transport_printed = null, $shipment_id = null, $pickable = null, $parcel_number = null, $order_created_time_to = null, $article_numbers = null, $serial = null, $market_place = null, $order_updated_time_from = null, $back_order_for_order_id = null, $reference_numbers = null, $order_line_supplier_number = null, $last_picking_time_from = null, string $contentType = self::contentTypes['ordersGetAll'][0])
    {
        $returnType = '\OngoingAPI\Model\GetOrderModel[]';
        $request = $this->ordersGetAllRequest($goods_owner_id, $order_number, $shipped_time_from, $shipped_time_to, $order_status_from, $order_status_to, $only_orders_with_order_lines_to_report, $order_id_from, $max_orders_to_get, $order_status_changed_time_from, $last_returned_from, $order_numbers, $order_created_time_from, $only_orders_with_order_lines_to_report_returned, $only_if_transport_printed, $shipment_id, $pickable, $parcel_number, $order_created_time_to, $article_numbers, $serial, $market_place, $order_updated_time_from, $back_order_for_order_id, $reference_numbers, $order_line_supplier_number, $last_picking_time_from, $contentType);

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
     * Create request for operation 'ordersGetAll'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $order_number Order number. (optional)
     * @param  \DateTime $shipped_time_from Filter for orders which were marked as &#39;shipped&#39; after this time. (optional)
     * @param  \DateTime $shipped_time_to Filter for orders which were marked as &#39;shipped&#39; before this time. (optional)
     * @param  int $order_status_from Filter for orders whose status is greater than or equal to this. (optional)
     * @param  int $order_status_to Filter for orders whose status is lower than or equal to this. (optional)
     * @param  bool $only_orders_with_order_lines_to_report Only return orders where there are order lines with ReportedNumberOfItems &lt; PickedNumberOfItems. (optional)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  \DateTime $order_status_changed_time_from Only return orders whose status has changed after this time. (optional)
     * @param  \DateTime $last_returned_from Only return orders which have been returned on since this time. (optional)
     * @param  string[] $order_numbers (optional)
     * @param  \DateTime $order_created_time_from Only return orders which have been created after this time. (optional)
     * @param  bool $only_orders_with_order_lines_to_report_returned Only return orders where there are order lines where ReportedReturnedNumberOfItems is less than the actual number of returned items. (optional)
     * @param  bool $only_if_transport_printed Only return orders where the transport documents have been printed. (optional)
     * @param  int $shipment_id Only return orders belonging to this shipment. (optional)
     * @param  string $pickable Filter for whether or not an order is pickable. Either &#39;All&#39; or &#39;NotPickable&#39; or &#39;NotOk&#39;. (optional)
     * @param  string $parcel_number Filter for orders which contains a pallet/package with the specified parcel number. (optional)
     * @param  \DateTime $order_created_time_to Only return orders which have been created before this time. (optional)
     * @param  string[] $article_numbers Filter for orders which contains at least one of these article numbers. (optional)
     * @param  string $serial Filter for orders which contains an item with the specified serial number. (optional)
     * @param  string $market_place (optional)
     * @param  \DateTime $order_updated_time_from Only return orders which have been updated after this time. Note that this value must be at most 2 days old. (optional)
     * @param  int $back_order_for_order_id Only return orders which are back orders for the order with this order ID. (optional)
     * @param  string[] $reference_numbers Only return orders with the specified reference numbers. (optional)
     * @param  string $order_line_supplier_number Only return orders which contains order lines with articles from the given supplier. This also includes the alternative suppliers of the article. (optional)
     * @param  \DateTime $last_picking_time_from Only return orders which have been picked on since this time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetAllRequest($goods_owner_id, $order_number = null, $shipped_time_from = null, $shipped_time_to = null, $order_status_from = null, $order_status_to = null, $only_orders_with_order_lines_to_report = null, $order_id_from = null, $max_orders_to_get = null, $order_status_changed_time_from = null, $last_returned_from = null, $order_numbers = null, $order_created_time_from = null, $only_orders_with_order_lines_to_report_returned = null, $only_if_transport_printed = null, $shipment_id = null, $pickable = null, $parcel_number = null, $order_created_time_to = null, $article_numbers = null, $serial = null, $market_place = null, $order_updated_time_from = null, $back_order_for_order_id = null, $reference_numbers = null, $order_line_supplier_number = null, $last_picking_time_from = null, string $contentType = self::contentTypes['ordersGetAll'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling ordersGetAll'
            );
        }




























        $resourcePath = '/api/v1/orders';
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
            $order_number,
            'orderNumber', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $shipped_time_from,
            'shippedTimeFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $shipped_time_to,
            'shippedTimeTo', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_status_from,
            'orderStatusFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_status_to,
            'orderStatusTo', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_orders_with_order_lines_to_report,
            'onlyOrdersWithOrderLinesToReport', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_id_from,
            'orderIdFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $max_orders_to_get,
            'maxOrdersToGet', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_status_changed_time_from,
            'orderStatusChangedTimeFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $last_returned_from,
            'lastReturnedFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_numbers,
            'orderNumbers', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_created_time_from,
            'orderCreatedTimeFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_orders_with_order_lines_to_report_returned,
            'onlyOrdersWithOrderLinesToReportReturned', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_if_transport_printed,
            'onlyIfTransportPrinted', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $shipment_id,
            'shipmentId', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $pickable,
            'pickable', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $parcel_number,
            'parcelNumber', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_created_time_to,
            'orderCreatedTimeTo', // param base name
            'string', // openApiType
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
            $serial,
            'serial', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $market_place,
            'marketPlace', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_updated_time_from,
            'orderUpdatedTimeFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $back_order_for_order_id,
            'backOrderForOrderId', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $reference_numbers,
            'referenceNumbers', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_line_supplier_number,
            'orderLineSupplierNumber', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $last_picking_time_from,
            'lastPickingTimeFrom', // param base name
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
     * Operation ordersGetFiles
     *
     * Get all files which are attached to a specific order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetFiles'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetFileModel[]
     */
    public function ordersGetFiles($order_id, string $contentType = self::contentTypes['ordersGetFiles'][0])
    {
        list($response) = $this->ordersGetFilesWithHttpInfo($order_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetFilesWithHttpInfo
     *
     * Get all files which are attached to a specific order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetFiles'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetFileModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetFilesWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGetFiles'][0])
    {
        $request = $this->ordersGetFilesRequest($order_id, $contentType);

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
     * Operation ordersGetFilesAsync
     *
     * Get all files which are attached to a specific order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetFilesAsync($order_id, string $contentType = self::contentTypes['ordersGetFiles'][0])
    {
        return $this->ordersGetFilesAsyncWithHttpInfo($order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetFilesAsyncWithHttpInfo
     *
     * Get all files which are attached to a specific order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetFilesAsyncWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGetFiles'][0])
    {
        $returnType = '\OngoingAPI\Model\GetFileModel[]';
        $request = $this->ordersGetFilesRequest($order_id, $contentType);

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
     * Create request for operation 'ordersGetFiles'
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetFilesRequest($order_id, string $contentType = self::contentTypes['ordersGetFiles'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersGetFiles'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersGetInvoiceCharges
     *
     * Get all invoice charges for an order. This function requires an additional permission for the API user, see Administration-&gt;Integration-&gt;API for goods owners.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetInvoiceCharges'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetOrderInvoiceChargeModel[]
     */
    public function ordersGetInvoiceCharges($order_id, string $contentType = self::contentTypes['ordersGetInvoiceCharges'][0])
    {
        list($response) = $this->ordersGetInvoiceChargesWithHttpInfo($order_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetInvoiceChargesWithHttpInfo
     *
     * Get all invoice charges for an order. This function requires an additional permission for the API user, see Administration-&gt;Integration-&gt;API for goods owners.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetInvoiceCharges'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetOrderInvoiceChargeModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetInvoiceChargesWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGetInvoiceCharges'][0])
    {
        $request = $this->ordersGetInvoiceChargesRequest($order_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetOrderInvoiceChargeModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetOrderInvoiceChargeModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetOrderInvoiceChargeModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetOrderInvoiceChargeModel[]';
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
                        '\OngoingAPI\Model\GetOrderInvoiceChargeModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetInvoiceChargesAsync
     *
     * Get all invoice charges for an order. This function requires an additional permission for the API user, see Administration-&gt;Integration-&gt;API for goods owners.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetInvoiceCharges'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetInvoiceChargesAsync($order_id, string $contentType = self::contentTypes['ordersGetInvoiceCharges'][0])
    {
        return $this->ordersGetInvoiceChargesAsyncWithHttpInfo($order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetInvoiceChargesAsyncWithHttpInfo
     *
     * Get all invoice charges for an order. This function requires an additional permission for the API user, see Administration-&gt;Integration-&gt;API for goods owners.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetInvoiceCharges'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetInvoiceChargesAsyncWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGetInvoiceCharges'][0])
    {
        $returnType = '\OngoingAPI\Model\GetOrderInvoiceChargeModel[]';
        $request = $this->ordersGetInvoiceChargesRequest($order_id, $contentType);

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
     * Create request for operation 'ordersGetInvoiceCharges'
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetInvoiceCharges'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetInvoiceChargesRequest($order_id, string $contentType = self::contentTypes['ordersGetInvoiceCharges'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersGetInvoiceCharges'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/invoiceCharges';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersGetOrderClasses
     *
     * Get all order classes.
     *
     * @param  int $goods_owner_id goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetOrderClassesModel
     */
    public function ordersGetOrderClasses($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderClasses'][0])
    {
        list($response) = $this->ordersGetOrderClassesWithHttpInfo($goods_owner_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetOrderClassesWithHttpInfo
     *
     * Get all order classes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetOrderClassesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetOrderClassesWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderClasses'][0])
    {
        $request = $this->ordersGetOrderClassesRequest($goods_owner_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetOrderClassesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetOrderClassesModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetOrderClassesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetOrderClassesModel';
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
                        '\OngoingAPI\Model\GetOrderClassesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetOrderClassesAsync
     *
     * Get all order classes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetOrderClassesAsync($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderClasses'][0])
    {
        return $this->ordersGetOrderClassesAsyncWithHttpInfo($goods_owner_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetOrderClassesAsyncWithHttpInfo
     *
     * Get all order classes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetOrderClassesAsyncWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderClasses'][0])
    {
        $returnType = '\OngoingAPI\Model\GetOrderClassesModel';
        $request = $this->ordersGetOrderClassesRequest($goods_owner_id, $contentType);

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
     * Create request for operation 'ordersGetOrderClasses'
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetOrderClassesRequest($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderClasses'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling ordersGetOrderClasses'
            );
        }


        $resourcePath = '/api/v1/orders/classes';
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
     * Operation ordersGetOrderStatuses
     *
     * Get all order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetOrderStatusesModel
     */
    public function ordersGetOrderStatuses(string $contentType = self::contentTypes['ordersGetOrderStatuses'][0])
    {
        list($response) = $this->ordersGetOrderStatusesWithHttpInfo($contentType);
        return $response;
    }

    /**
     * Operation ordersGetOrderStatusesWithHttpInfo
     *
     * Get all order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetOrderStatusesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetOrderStatusesWithHttpInfo(string $contentType = self::contentTypes['ordersGetOrderStatuses'][0])
    {
        $request = $this->ordersGetOrderStatusesRequest($contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetOrderStatusesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetOrderStatusesModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetOrderStatusesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetOrderStatusesModel';
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
                        '\OngoingAPI\Model\GetOrderStatusesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetOrderStatusesAsync
     *
     * Get all order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetOrderStatusesAsync(string $contentType = self::contentTypes['ordersGetOrderStatuses'][0])
    {
        return $this->ordersGetOrderStatusesAsyncWithHttpInfo($contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetOrderStatusesAsyncWithHttpInfo
     *
     * Get all order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetOrderStatusesAsyncWithHttpInfo(string $contentType = self::contentTypes['ordersGetOrderStatuses'][0])
    {
        $returnType = '\OngoingAPI\Model\GetOrderStatusesModel';
        $request = $this->ordersGetOrderStatusesRequest($contentType);

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
     * Create request for operation 'ordersGetOrderStatuses'
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetOrderStatusesRequest(string $contentType = self::contentTypes['ordersGetOrderStatuses'][0])
    {


        $resourcePath = '/api/v1/orders/statuses';
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
     * Operation ordersGetOrderTypes
     *
     * Get all order types for a particular goods owner.
     *
     * @param  int $goods_owner_id goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderTypes'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetOrderTypesModel
     */
    public function ordersGetOrderTypes($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderTypes'][0])
    {
        list($response) = $this->ordersGetOrderTypesWithHttpInfo($goods_owner_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetOrderTypesWithHttpInfo
     *
     * Get all order types for a particular goods owner.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderTypes'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetOrderTypesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetOrderTypesWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderTypes'][0])
    {
        $request = $this->ordersGetOrderTypesRequest($goods_owner_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetOrderTypesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetOrderTypesModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetOrderTypesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetOrderTypesModel';
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
                        '\OngoingAPI\Model\GetOrderTypesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetOrderTypesAsync
     *
     * Get all order types for a particular goods owner.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetOrderTypesAsync($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderTypes'][0])
    {
        return $this->ordersGetOrderTypesAsyncWithHttpInfo($goods_owner_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetOrderTypesAsyncWithHttpInfo
     *
     * Get all order types for a particular goods owner.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetOrderTypesAsyncWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderTypes'][0])
    {
        $returnType = '\OngoingAPI\Model\GetOrderTypesModel';
        $request = $this->ordersGetOrderTypesRequest($goods_owner_id, $contentType);

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
     * Create request for operation 'ordersGetOrderTypes'
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetOrderTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetOrderTypesRequest($goods_owner_id, string $contentType = self::contentTypes['ordersGetOrderTypes'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling ordersGetOrderTypes'
            );
        }


        $resourcePath = '/api/v1/orders/types';
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
     * Operation ordersGetPickability
     *
     * Gets the pickability statuses of orders. Please note that it is more efficient to make one request with several orders, rather than making one request per order. The possible pickabilites are \&quot;Ok\&quot;, \&quot;ByPriority\&quot;, \&quot;NotByPriority\&quot;, \&quot;NotOk\&quot; and \&quot;NothingToAllocate\&quot;
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  bool $only_booked_orders If true, the API will only return orders which are in a Booked status. (optional)
     * @param  int[] $order_ids A list of order IDs. (optional)
     * @param  string[] $order_numbers A list of order numbers. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetPickability'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetOrderPickabilityModel
     */
    public function ordersGetPickability($goods_owner_id, $order_id_from = null, $max_orders_to_get = null, $only_booked_orders = null, $order_ids = null, $order_numbers = null, string $contentType = self::contentTypes['ordersGetPickability'][0])
    {
        list($response) = $this->ordersGetPickabilityWithHttpInfo($goods_owner_id, $order_id_from, $max_orders_to_get, $only_booked_orders, $order_ids, $order_numbers, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetPickabilityWithHttpInfo
     *
     * Gets the pickability statuses of orders. Please note that it is more efficient to make one request with several orders, rather than making one request per order. The possible pickabilites are \&quot;Ok\&quot;, \&quot;ByPriority\&quot;, \&quot;NotByPriority\&quot;, \&quot;NotOk\&quot; and \&quot;NothingToAllocate\&quot;
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  bool $only_booked_orders If true, the API will only return orders which are in a Booked status. (optional)
     * @param  int[] $order_ids A list of order IDs. (optional)
     * @param  string[] $order_numbers A list of order numbers. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetPickability'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetOrderPickabilityModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetPickabilityWithHttpInfo($goods_owner_id, $order_id_from = null, $max_orders_to_get = null, $only_booked_orders = null, $order_ids = null, $order_numbers = null, string $contentType = self::contentTypes['ordersGetPickability'][0])
    {
        $request = $this->ordersGetPickabilityRequest($goods_owner_id, $order_id_from, $max_orders_to_get, $only_booked_orders, $order_ids, $order_numbers, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetOrderPickabilityModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetOrderPickabilityModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetOrderPickabilityModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetOrderPickabilityModel';
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
                        '\OngoingAPI\Model\GetOrderPickabilityModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetPickabilityAsync
     *
     * Gets the pickability statuses of orders. Please note that it is more efficient to make one request with several orders, rather than making one request per order. The possible pickabilites are \&quot;Ok\&quot;, \&quot;ByPriority\&quot;, \&quot;NotByPriority\&quot;, \&quot;NotOk\&quot; and \&quot;NothingToAllocate\&quot;
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  bool $only_booked_orders If true, the API will only return orders which are in a Booked status. (optional)
     * @param  int[] $order_ids A list of order IDs. (optional)
     * @param  string[] $order_numbers A list of order numbers. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetPickability'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetPickabilityAsync($goods_owner_id, $order_id_from = null, $max_orders_to_get = null, $only_booked_orders = null, $order_ids = null, $order_numbers = null, string $contentType = self::contentTypes['ordersGetPickability'][0])
    {
        return $this->ordersGetPickabilityAsyncWithHttpInfo($goods_owner_id, $order_id_from, $max_orders_to_get, $only_booked_orders, $order_ids, $order_numbers, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetPickabilityAsyncWithHttpInfo
     *
     * Gets the pickability statuses of orders. Please note that it is more efficient to make one request with several orders, rather than making one request per order. The possible pickabilites are \&quot;Ok\&quot;, \&quot;ByPriority\&quot;, \&quot;NotByPriority\&quot;, \&quot;NotOk\&quot; and \&quot;NothingToAllocate\&quot;
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  bool $only_booked_orders If true, the API will only return orders which are in a Booked status. (optional)
     * @param  int[] $order_ids A list of order IDs. (optional)
     * @param  string[] $order_numbers A list of order numbers. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetPickability'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetPickabilityAsyncWithHttpInfo($goods_owner_id, $order_id_from = null, $max_orders_to_get = null, $only_booked_orders = null, $order_ids = null, $order_numbers = null, string $contentType = self::contentTypes['ordersGetPickability'][0])
    {
        $returnType = '\OngoingAPI\Model\GetOrderPickabilityModel';
        $request = $this->ordersGetPickabilityRequest($goods_owner_id, $order_id_from, $max_orders_to_get, $only_booked_orders, $order_ids, $order_numbers, $contentType);

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
     * Create request for operation 'ordersGetPickability'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $order_id_from Only return orders whose order ID is greater than or equal this. (optional)
     * @param  int $max_orders_to_get The maximum number of orders to return. (optional)
     * @param  bool $only_booked_orders If true, the API will only return orders which are in a Booked status. (optional)
     * @param  int[] $order_ids A list of order IDs. (optional)
     * @param  string[] $order_numbers A list of order numbers. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetPickability'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetPickabilityRequest($goods_owner_id, $order_id_from = null, $max_orders_to_get = null, $only_booked_orders = null, $order_ids = null, $order_numbers = null, string $contentType = self::contentTypes['ordersGetPickability'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling ordersGetPickability'
            );
        }







        $resourcePath = '/api/v1/orders/pickability';
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
            $order_id_from,
            'orderIdFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $max_orders_to_get,
            'maxOrdersToGet', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_booked_orders,
            'onlyBookedOrders', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_ids,
            'orderIds', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $order_numbers,
            'orderNumbers', // param base name
            'array', // openApiType
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
     * Operation ordersGetWayBillRows
     *
     * Get all waybill rows for an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayBillRows'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetWayBillRowModel[]
     */
    public function ordersGetWayBillRows($order_id, string $contentType = self::contentTypes['ordersGetWayBillRows'][0])
    {
        list($response) = $this->ordersGetWayBillRowsWithHttpInfo($order_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetWayBillRowsWithHttpInfo
     *
     * Get all waybill rows for an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayBillRows'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetWayBillRowModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetWayBillRowsWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGetWayBillRows'][0])
    {
        $request = $this->ordersGetWayBillRowsRequest($order_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetWayBillRowModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetWayBillRowModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetWayBillRowModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetWayBillRowModel[]';
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
                        '\OngoingAPI\Model\GetWayBillRowModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetWayBillRowsAsync
     *
     * Get all waybill rows for an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayBillRows'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetWayBillRowsAsync($order_id, string $contentType = self::contentTypes['ordersGetWayBillRows'][0])
    {
        return $this->ordersGetWayBillRowsAsyncWithHttpInfo($order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetWayBillRowsAsyncWithHttpInfo
     *
     * Get all waybill rows for an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayBillRows'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetWayBillRowsAsyncWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersGetWayBillRows'][0])
    {
        $returnType = '\OngoingAPI\Model\GetWayBillRowModel[]';
        $request = $this->ordersGetWayBillRowsRequest($order_id, $contentType);

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
     * Create request for operation 'ordersGetWayBillRows'
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayBillRows'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetWayBillRowsRequest($order_id, string $contentType = self::contentTypes['ordersGetWayBillRows'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersGetWayBillRows'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/wayBillRows';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersGetWayOfDeliveryTypes
     *
     * Get all order way of delivery types.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayOfDeliveryTypes'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetWayOfDeliveryTypesModel
     */
    public function ordersGetWayOfDeliveryTypes($goods_owner_id, string $contentType = self::contentTypes['ordersGetWayOfDeliveryTypes'][0])
    {
        list($response) = $this->ordersGetWayOfDeliveryTypesWithHttpInfo($goods_owner_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersGetWayOfDeliveryTypesWithHttpInfo
     *
     * Get all order way of delivery types.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayOfDeliveryTypes'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetWayOfDeliveryTypesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersGetWayOfDeliveryTypesWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['ordersGetWayOfDeliveryTypes'][0])
    {
        $request = $this->ordersGetWayOfDeliveryTypesRequest($goods_owner_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\GetWayOfDeliveryTypesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetWayOfDeliveryTypesModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetWayOfDeliveryTypesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\GetWayOfDeliveryTypesModel';
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
                        '\OngoingAPI\Model\GetWayOfDeliveryTypesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersGetWayOfDeliveryTypesAsync
     *
     * Get all order way of delivery types.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayOfDeliveryTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetWayOfDeliveryTypesAsync($goods_owner_id, string $contentType = self::contentTypes['ordersGetWayOfDeliveryTypes'][0])
    {
        return $this->ordersGetWayOfDeliveryTypesAsyncWithHttpInfo($goods_owner_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersGetWayOfDeliveryTypesAsyncWithHttpInfo
     *
     * Get all order way of delivery types.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayOfDeliveryTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersGetWayOfDeliveryTypesAsyncWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['ordersGetWayOfDeliveryTypes'][0])
    {
        $returnType = '\OngoingAPI\Model\GetWayOfDeliveryTypesModel';
        $request = $this->ordersGetWayOfDeliveryTypesRequest($goods_owner_id, $contentType);

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
     * Create request for operation 'ordersGetWayOfDeliveryTypes'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersGetWayOfDeliveryTypes'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersGetWayOfDeliveryTypesRequest($goods_owner_id, string $contentType = self::contentTypes['ordersGetWayOfDeliveryTypes'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling ordersGetWayOfDeliveryTypes'
            );
        }


        $resourcePath = '/api/v1/orders/wayOfDeliveryTypes';
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
     * Operation ordersPatchAddOrderClasses
     *
     * Add order classes to an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchAddOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchAddOrderClasses($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchAddOrderClasses'][0])
    {
        list($response) = $this->ordersPatchAddOrderClassesWithHttpInfo($order_id, $patch_order_classes_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchAddOrderClassesWithHttpInfo
     *
     * Add order classes to an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchAddOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchAddOrderClassesWithHttpInfo($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchAddOrderClasses'][0])
    {
        $request = $this->ordersPatchAddOrderClassesRequest($order_id, $patch_order_classes_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchAddOrderClassesAsync
     *
     * Add order classes to an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchAddOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchAddOrderClassesAsync($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchAddOrderClasses'][0])
    {
        return $this->ordersPatchAddOrderClassesAsyncWithHttpInfo($order_id, $patch_order_classes_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchAddOrderClassesAsyncWithHttpInfo
     *
     * Add order classes to an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchAddOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchAddOrderClassesAsyncWithHttpInfo($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchAddOrderClasses'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchAddOrderClassesRequest($order_id, $patch_order_classes_model, $contentType);

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
     * Create request for operation 'ordersPatchAddOrderClasses'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchAddOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchAddOrderClassesRequest($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchAddOrderClasses'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchAddOrderClasses'
            );
        }

        // verify the required parameter 'patch_order_classes_model' is set
        if ($patch_order_classes_model === null || (is_array($patch_order_classes_model) && count($patch_order_classes_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_classes_model when calling ordersPatchAddOrderClasses'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/addOrderClasses';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_classes_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_classes_model));
            } else {
                $httpBody = $patch_order_classes_model;
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
     * Operation ordersPatchCustomerLinePrice
     *
     * Update the customer line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchCustomerLinePriceModel $patch_customer_line_price_model Object containing the customer line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchCustomerLinePrice'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchCustomerLinePrice($order_id, $order_line_id, $patch_customer_line_price_model, string $contentType = self::contentTypes['ordersPatchCustomerLinePrice'][0])
    {
        list($response) = $this->ordersPatchCustomerLinePriceWithHttpInfo($order_id, $order_line_id, $patch_customer_line_price_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchCustomerLinePriceWithHttpInfo
     *
     * Update the customer line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchCustomerLinePriceModel $patch_customer_line_price_model Object containing the customer line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchCustomerLinePrice'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchCustomerLinePriceWithHttpInfo($order_id, $order_line_id, $patch_customer_line_price_model, string $contentType = self::contentTypes['ordersPatchCustomerLinePrice'][0])
    {
        $request = $this->ordersPatchCustomerLinePriceRequest($order_id, $order_line_id, $patch_customer_line_price_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchCustomerLinePriceAsync
     *
     * Update the customer line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchCustomerLinePriceModel $patch_customer_line_price_model Object containing the customer line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchCustomerLinePrice'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchCustomerLinePriceAsync($order_id, $order_line_id, $patch_customer_line_price_model, string $contentType = self::contentTypes['ordersPatchCustomerLinePrice'][0])
    {
        return $this->ordersPatchCustomerLinePriceAsyncWithHttpInfo($order_id, $order_line_id, $patch_customer_line_price_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchCustomerLinePriceAsyncWithHttpInfo
     *
     * Update the customer line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchCustomerLinePriceModel $patch_customer_line_price_model Object containing the customer line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchCustomerLinePrice'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchCustomerLinePriceAsyncWithHttpInfo($order_id, $order_line_id, $patch_customer_line_price_model, string $contentType = self::contentTypes['ordersPatchCustomerLinePrice'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchCustomerLinePriceRequest($order_id, $order_line_id, $patch_customer_line_price_model, $contentType);

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
     * Create request for operation 'ordersPatchCustomerLinePrice'
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchCustomerLinePriceModel $patch_customer_line_price_model Object containing the customer line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchCustomerLinePrice'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchCustomerLinePriceRequest($order_id, $order_line_id, $patch_customer_line_price_model, string $contentType = self::contentTypes['ordersPatchCustomerLinePrice'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchCustomerLinePrice'
            );
        }

        // verify the required parameter 'order_line_id' is set
        if ($order_line_id === null || (is_array($order_line_id) && count($order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_line_id when calling ordersPatchCustomerLinePrice'
            );
        }

        // verify the required parameter 'patch_customer_line_price_model' is set
        if ($patch_customer_line_price_model === null || (is_array($patch_customer_line_price_model) && count($patch_customer_line_price_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_customer_line_price_model when calling ordersPatchCustomerLinePrice'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/lines/{orderLineId}/customerLinePrice';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderLineId' . '}',
                ObjectSerializer::toPathValue($order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_customer_line_price_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_customer_line_price_model));
            } else {
                $httpBody = $patch_customer_line_price_model;
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
     * Operation ordersPatchDeliveryDate
     *
     * Update the delivery date of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\OrdersPatchDeliveryDateRequest $orders_patch_delivery_date_request Object containing the new delivery date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchDeliveryDate'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchDeliveryDate($order_id, $orders_patch_delivery_date_request = null, string $contentType = self::contentTypes['ordersPatchDeliveryDate'][0])
    {
        list($response) = $this->ordersPatchDeliveryDateWithHttpInfo($order_id, $orders_patch_delivery_date_request, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchDeliveryDateWithHttpInfo
     *
     * Update the delivery date of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\OrdersPatchDeliveryDateRequest $orders_patch_delivery_date_request Object containing the new delivery date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchDeliveryDate'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchDeliveryDateWithHttpInfo($order_id, $orders_patch_delivery_date_request = null, string $contentType = self::contentTypes['ordersPatchDeliveryDate'][0])
    {
        $request = $this->ordersPatchDeliveryDateRequest($order_id, $orders_patch_delivery_date_request, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchDeliveryDateAsync
     *
     * Update the delivery date of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\OrdersPatchDeliveryDateRequest $orders_patch_delivery_date_request Object containing the new delivery date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchDeliveryDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchDeliveryDateAsync($order_id, $orders_patch_delivery_date_request = null, string $contentType = self::contentTypes['ordersPatchDeliveryDate'][0])
    {
        return $this->ordersPatchDeliveryDateAsyncWithHttpInfo($order_id, $orders_patch_delivery_date_request, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchDeliveryDateAsyncWithHttpInfo
     *
     * Update the delivery date of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\OrdersPatchDeliveryDateRequest $orders_patch_delivery_date_request Object containing the new delivery date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchDeliveryDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchDeliveryDateAsyncWithHttpInfo($order_id, $orders_patch_delivery_date_request = null, string $contentType = self::contentTypes['ordersPatchDeliveryDate'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchDeliveryDateRequest($order_id, $orders_patch_delivery_date_request, $contentType);

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
     * Create request for operation 'ordersPatchDeliveryDate'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\OrdersPatchDeliveryDateRequest $orders_patch_delivery_date_request Object containing the new delivery date. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchDeliveryDate'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchDeliveryDateRequest($order_id, $orders_patch_delivery_date_request = null, string $contentType = self::contentTypes['ordersPatchDeliveryDate'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchDeliveryDate'
            );
        }



        $resourcePath = '/api/v1/orders/{orderId}/deliveryDate';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($orders_patch_delivery_date_request)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($orders_patch_delivery_date_request));
            } else {
                $httpBody = $orders_patch_delivery_date_request;
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
     * Operation ordersPatchLinePrice
     *
     * Update the line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchLinePriceModel $patch_line_price_model Object containing the line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchLinePrice'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchLinePrice($order_id, $order_line_id, $patch_line_price_model, string $contentType = self::contentTypes['ordersPatchLinePrice'][0])
    {
        list($response) = $this->ordersPatchLinePriceWithHttpInfo($order_id, $order_line_id, $patch_line_price_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchLinePriceWithHttpInfo
     *
     * Update the line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchLinePriceModel $patch_line_price_model Object containing the line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchLinePrice'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchLinePriceWithHttpInfo($order_id, $order_line_id, $patch_line_price_model, string $contentType = self::contentTypes['ordersPatchLinePrice'][0])
    {
        $request = $this->ordersPatchLinePriceRequest($order_id, $order_line_id, $patch_line_price_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchLinePriceAsync
     *
     * Update the line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchLinePriceModel $patch_line_price_model Object containing the line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchLinePrice'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchLinePriceAsync($order_id, $order_line_id, $patch_line_price_model, string $contentType = self::contentTypes['ordersPatchLinePrice'][0])
    {
        return $this->ordersPatchLinePriceAsyncWithHttpInfo($order_id, $order_line_id, $patch_line_price_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchLinePriceAsyncWithHttpInfo
     *
     * Update the line price on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchLinePriceModel $patch_line_price_model Object containing the line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchLinePrice'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchLinePriceAsyncWithHttpInfo($order_id, $order_line_id, $patch_line_price_model, string $contentType = self::contentTypes['ordersPatchLinePrice'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchLinePriceRequest($order_id, $order_line_id, $patch_line_price_model, $contentType);

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
     * Create request for operation 'ordersPatchLinePrice'
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchLinePriceModel $patch_line_price_model Object containing the line price (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchLinePrice'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchLinePriceRequest($order_id, $order_line_id, $patch_line_price_model, string $contentType = self::contentTypes['ordersPatchLinePrice'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchLinePrice'
            );
        }

        // verify the required parameter 'order_line_id' is set
        if ($order_line_id === null || (is_array($order_line_id) && count($order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_line_id when calling ordersPatchLinePrice'
            );
        }

        // verify the required parameter 'patch_line_price_model' is set
        if ($patch_line_price_model === null || (is_array($patch_line_price_model) && count($patch_line_price_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_line_price_model when calling ordersPatchLinePrice'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/lines/{orderLineId}/linePrice';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderLineId' . '}',
                ObjectSerializer::toPathValue($order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_line_price_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_line_price_model));
            } else {
                $httpBody = $patch_line_price_model;
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
     * Operation ordersPatchOrderFreeText1
     *
     * Update the free text 1 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText1Model $patch_order_free_text1_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderFreeText1($order_id, $patch_order_free_text1_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText1'][0])
    {
        list($response) = $this->ordersPatchOrderFreeText1WithHttpInfo($order_id, $patch_order_free_text1_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderFreeText1WithHttpInfo
     *
     * Update the free text 1 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText1Model $patch_order_free_text1_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText1'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderFreeText1WithHttpInfo($order_id, $patch_order_free_text1_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText1'][0])
    {
        $request = $this->ordersPatchOrderFreeText1Request($order_id, $patch_order_free_text1_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderFreeText1Async
     *
     * Update the free text 1 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText1Model $patch_order_free_text1_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderFreeText1Async($order_id, $patch_order_free_text1_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText1'][0])
    {
        return $this->ordersPatchOrderFreeText1AsyncWithHttpInfo($order_id, $patch_order_free_text1_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderFreeText1AsyncWithHttpInfo
     *
     * Update the free text 1 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText1Model $patch_order_free_text1_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderFreeText1AsyncWithHttpInfo($order_id, $patch_order_free_text1_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText1'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderFreeText1Request($order_id, $patch_order_free_text1_model, $contentType);

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
     * Create request for operation 'ordersPatchOrderFreeText1'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText1Model $patch_order_free_text1_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText1'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderFreeText1Request($order_id, $patch_order_free_text1_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText1'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderFreeText1'
            );
        }

        // verify the required parameter 'patch_order_free_text1_model' is set
        if ($patch_order_free_text1_model === null || (is_array($patch_order_free_text1_model) && count($patch_order_free_text1_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_free_text1_model when calling ordersPatchOrderFreeText1'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/freeText1';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_free_text1_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_free_text1_model));
            } else {
                $httpBody = $patch_order_free_text1_model;
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
     * Operation ordersPatchOrderFreeText12
     *
     * Update the free text 3 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText3Model $patch_order_free_text3_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText12'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderFreeText12($order_id, $patch_order_free_text3_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText12'][0])
    {
        list($response) = $this->ordersPatchOrderFreeText12WithHttpInfo($order_id, $patch_order_free_text3_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderFreeText12WithHttpInfo
     *
     * Update the free text 3 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText3Model $patch_order_free_text3_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText12'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderFreeText12WithHttpInfo($order_id, $patch_order_free_text3_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText12'][0])
    {
        $request = $this->ordersPatchOrderFreeText12Request($order_id, $patch_order_free_text3_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderFreeText12Async
     *
     * Update the free text 3 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText3Model $patch_order_free_text3_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText12'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderFreeText12Async($order_id, $patch_order_free_text3_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText12'][0])
    {
        return $this->ordersPatchOrderFreeText12AsyncWithHttpInfo($order_id, $patch_order_free_text3_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderFreeText12AsyncWithHttpInfo
     *
     * Update the free text 3 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText3Model $patch_order_free_text3_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText12'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderFreeText12AsyncWithHttpInfo($order_id, $patch_order_free_text3_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText12'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderFreeText12Request($order_id, $patch_order_free_text3_model, $contentType);

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
     * Create request for operation 'ordersPatchOrderFreeText12'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText3Model $patch_order_free_text3_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText12'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderFreeText12Request($order_id, $patch_order_free_text3_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText12'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderFreeText12'
            );
        }

        // verify the required parameter 'patch_order_free_text3_model' is set
        if ($patch_order_free_text3_model === null || (is_array($patch_order_free_text3_model) && count($patch_order_free_text3_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_free_text3_model when calling ordersPatchOrderFreeText12'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/freeText3';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_free_text3_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_free_text3_model));
            } else {
                $httpBody = $patch_order_free_text3_model;
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
     * Operation ordersPatchOrderFreeText2
     *
     * Update the free text 2 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText2Model $patch_order_free_text2_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderFreeText2($order_id, $patch_order_free_text2_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText2'][0])
    {
        list($response) = $this->ordersPatchOrderFreeText2WithHttpInfo($order_id, $patch_order_free_text2_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderFreeText2WithHttpInfo
     *
     * Update the free text 2 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText2Model $patch_order_free_text2_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderFreeText2WithHttpInfo($order_id, $patch_order_free_text2_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText2'][0])
    {
        $request = $this->ordersPatchOrderFreeText2Request($order_id, $patch_order_free_text2_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderFreeText2Async
     *
     * Update the free text 2 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText2Model $patch_order_free_text2_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderFreeText2Async($order_id, $patch_order_free_text2_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText2'][0])
    {
        return $this->ordersPatchOrderFreeText2AsyncWithHttpInfo($order_id, $patch_order_free_text2_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderFreeText2AsyncWithHttpInfo
     *
     * Update the free text 2 of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText2Model $patch_order_free_text2_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderFreeText2AsyncWithHttpInfo($order_id, $patch_order_free_text2_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText2'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderFreeText2Request($order_id, $patch_order_free_text2_model, $contentType);

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
     * Create request for operation 'ordersPatchOrderFreeText2'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderFreeText2Model $patch_order_free_text2_model Object containing the free text. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderFreeText2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderFreeText2Request($order_id, $patch_order_free_text2_model, string $contentType = self::contentTypes['ordersPatchOrderFreeText2'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderFreeText2'
            );
        }

        // verify the required parameter 'patch_order_free_text2_model' is set
        if ($patch_order_free_text2_model === null || (is_array($patch_order_free_text2_model) && count($patch_order_free_text2_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_free_text2_model when calling ordersPatchOrderFreeText2'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/freeText2';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_free_text2_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_free_text2_model));
            } else {
                $httpBody = $patch_order_free_text2_model;
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
     * Operation ordersPatchOrderLineComment
     *
     * Update the comment on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderLineCommentModel $patch_order_line_comment_model Object containing the comment (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderLineComment'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderLineComment($order_id, $order_line_id, $patch_order_line_comment_model, string $contentType = self::contentTypes['ordersPatchOrderLineComment'][0])
    {
        list($response) = $this->ordersPatchOrderLineCommentWithHttpInfo($order_id, $order_line_id, $patch_order_line_comment_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderLineCommentWithHttpInfo
     *
     * Update the comment on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderLineCommentModel $patch_order_line_comment_model Object containing the comment (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderLineComment'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderLineCommentWithHttpInfo($order_id, $order_line_id, $patch_order_line_comment_model, string $contentType = self::contentTypes['ordersPatchOrderLineComment'][0])
    {
        $request = $this->ordersPatchOrderLineCommentRequest($order_id, $order_line_id, $patch_order_line_comment_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderLineCommentAsync
     *
     * Update the comment on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderLineCommentModel $patch_order_line_comment_model Object containing the comment (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderLineComment'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderLineCommentAsync($order_id, $order_line_id, $patch_order_line_comment_model, string $contentType = self::contentTypes['ordersPatchOrderLineComment'][0])
    {
        return $this->ordersPatchOrderLineCommentAsyncWithHttpInfo($order_id, $order_line_id, $patch_order_line_comment_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderLineCommentAsyncWithHttpInfo
     *
     * Update the comment on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderLineCommentModel $patch_order_line_comment_model Object containing the comment (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderLineComment'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderLineCommentAsyncWithHttpInfo($order_id, $order_line_id, $patch_order_line_comment_model, string $contentType = self::contentTypes['ordersPatchOrderLineComment'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderLineCommentRequest($order_id, $order_line_id, $patch_order_line_comment_model, $contentType);

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
     * Create request for operation 'ordersPatchOrderLineComment'
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderLineCommentModel $patch_order_line_comment_model Object containing the comment (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderLineComment'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderLineCommentRequest($order_id, $order_line_id, $patch_order_line_comment_model, string $contentType = self::contentTypes['ordersPatchOrderLineComment'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderLineComment'
            );
        }

        // verify the required parameter 'order_line_id' is set
        if ($order_line_id === null || (is_array($order_line_id) && count($order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_line_id when calling ordersPatchOrderLineComment'
            );
        }

        // verify the required parameter 'patch_order_line_comment_model' is set
        if ($patch_order_line_comment_model === null || (is_array($patch_order_line_comment_model) && count($patch_order_line_comment_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_line_comment_model when calling ordersPatchOrderLineComment'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/lines/{orderLineId}/comment';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderLineId' . '}',
                ObjectSerializer::toPathValue($order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_line_comment_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_line_comment_model));
            } else {
                $httpBody = $patch_order_line_comment_model;
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
     * Operation ordersPatchOrderNumber
     *
     * Update the order number of an existing order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderNumberModel $patch_order_number_model Object containing the new order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderNumber($order_id, $patch_order_number_model, string $contentType = self::contentTypes['ordersPatchOrderNumber'][0])
    {
        list($response) = $this->ordersPatchOrderNumberWithHttpInfo($order_id, $patch_order_number_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderNumberWithHttpInfo
     *
     * Update the order number of an existing order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderNumberModel $patch_order_number_model Object containing the new order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderNumberWithHttpInfo($order_id, $patch_order_number_model, string $contentType = self::contentTypes['ordersPatchOrderNumber'][0])
    {
        $request = $this->ordersPatchOrderNumberRequest($order_id, $patch_order_number_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderNumberAsync
     *
     * Update the order number of an existing order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderNumberModel $patch_order_number_model Object containing the new order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderNumberAsync($order_id, $patch_order_number_model, string $contentType = self::contentTypes['ordersPatchOrderNumber'][0])
    {
        return $this->ordersPatchOrderNumberAsyncWithHttpInfo($order_id, $patch_order_number_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderNumberAsyncWithHttpInfo
     *
     * Update the order number of an existing order. Note that the system will not verify that the order number is unique.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderNumberModel $patch_order_number_model Object containing the new order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderNumberAsyncWithHttpInfo($order_id, $patch_order_number_model, string $contentType = self::contentTypes['ordersPatchOrderNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderNumberRequest($order_id, $patch_order_number_model, $contentType);

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
     * Create request for operation 'ordersPatchOrderNumber'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderNumberModel $patch_order_number_model Object containing the new order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderNumberRequest($order_id, $patch_order_number_model, string $contentType = self::contentTypes['ordersPatchOrderNumber'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderNumber'
            );
        }

        // verify the required parameter 'patch_order_number_model' is set
        if ($patch_order_number_model === null || (is_array($patch_order_number_model) && count($patch_order_number_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_number_model when calling ordersPatchOrderNumber'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/orderNumber';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_number_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_number_model));
            } else {
                $httpBody = $patch_order_number_model;
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
     * Operation ordersPatchOrderRemark
     *
     * Update the remark of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderRemark $patch_order_remark Object containing the new remark. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderRemark'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderRemark($order_id, $patch_order_remark, string $contentType = self::contentTypes['ordersPatchOrderRemark'][0])
    {
        list($response) = $this->ordersPatchOrderRemarkWithHttpInfo($order_id, $patch_order_remark, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderRemarkWithHttpInfo
     *
     * Update the remark of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderRemark $patch_order_remark Object containing the new remark. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderRemark'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderRemarkWithHttpInfo($order_id, $patch_order_remark, string $contentType = self::contentTypes['ordersPatchOrderRemark'][0])
    {
        $request = $this->ordersPatchOrderRemarkRequest($order_id, $patch_order_remark, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderRemarkAsync
     *
     * Update the remark of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderRemark $patch_order_remark Object containing the new remark. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderRemark'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderRemarkAsync($order_id, $patch_order_remark, string $contentType = self::contentTypes['ordersPatchOrderRemark'][0])
    {
        return $this->ordersPatchOrderRemarkAsyncWithHttpInfo($order_id, $patch_order_remark, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderRemarkAsyncWithHttpInfo
     *
     * Update the remark of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderRemark $patch_order_remark Object containing the new remark. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderRemark'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderRemarkAsyncWithHttpInfo($order_id, $patch_order_remark, string $contentType = self::contentTypes['ordersPatchOrderRemark'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderRemarkRequest($order_id, $patch_order_remark, $contentType);

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
     * Create request for operation 'ordersPatchOrderRemark'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderRemark $patch_order_remark Object containing the new remark. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderRemark'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderRemarkRequest($order_id, $patch_order_remark, string $contentType = self::contentTypes['ordersPatchOrderRemark'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderRemark'
            );
        }

        // verify the required parameter 'patch_order_remark' is set
        if ($patch_order_remark === null || (is_array($patch_order_remark) && count($patch_order_remark) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_remark when calling ordersPatchOrderRemark'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/orderRemark';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_remark)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_remark));
            } else {
                $httpBody = $patch_order_remark;
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
     * Operation ordersPatchOrderStatus
     *
     * Update the status of an order. Note that if the warehouse has allocated goods to the order, then it&#39;s possible that this call will fail.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderStatus $patch_order_status Object containing the new order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderStatus'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderStatus($order_id, $patch_order_status, string $contentType = self::contentTypes['ordersPatchOrderStatus'][0])
    {
        list($response) = $this->ordersPatchOrderStatusWithHttpInfo($order_id, $patch_order_status, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderStatusWithHttpInfo
     *
     * Update the status of an order. Note that if the warehouse has allocated goods to the order, then it&#39;s possible that this call will fail.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderStatus $patch_order_status Object containing the new order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderStatus'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderStatusWithHttpInfo($order_id, $patch_order_status, string $contentType = self::contentTypes['ordersPatchOrderStatus'][0])
    {
        $request = $this->ordersPatchOrderStatusRequest($order_id, $patch_order_status, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderStatusAsync
     *
     * Update the status of an order. Note that if the warehouse has allocated goods to the order, then it&#39;s possible that this call will fail.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderStatus $patch_order_status Object containing the new order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderStatusAsync($order_id, $patch_order_status, string $contentType = self::contentTypes['ordersPatchOrderStatus'][0])
    {
        return $this->ordersPatchOrderStatusAsyncWithHttpInfo($order_id, $patch_order_status, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderStatusAsyncWithHttpInfo
     *
     * Update the status of an order. Note that if the warehouse has allocated goods to the order, then it&#39;s possible that this call will fail.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderStatus $patch_order_status Object containing the new order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderStatusAsyncWithHttpInfo($order_id, $patch_order_status, string $contentType = self::contentTypes['ordersPatchOrderStatus'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderStatusRequest($order_id, $patch_order_status, $contentType);

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
     * Create request for operation 'ordersPatchOrderStatus'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderStatus $patch_order_status Object containing the new order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderStatusRequest($order_id, $patch_order_status, string $contentType = self::contentTypes['ordersPatchOrderStatus'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderStatus'
            );
        }

        // verify the required parameter 'patch_order_status' is set
        if ($patch_order_status === null || (is_array($patch_order_status) && count($patch_order_status) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_status when calling ordersPatchOrderStatus'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/orderStatus';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_status)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_status));
            } else {
                $httpBody = $patch_order_status;
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
     * Operation ordersPatchOrderTransporterCode
     *
     * Update the transporter of an existing order.
     *
     * @param  int $order_id order_id (required)
     * @param  \OngoingAPI\Model\PatchOrderTransporterModel $patch_order_transporter_model patch_order_transporter_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderTransporterCode'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderTransporterCode($order_id, $patch_order_transporter_model, string $contentType = self::contentTypes['ordersPatchOrderTransporterCode'][0])
    {
        list($response) = $this->ordersPatchOrderTransporterCodeWithHttpInfo($order_id, $patch_order_transporter_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderTransporterCodeWithHttpInfo
     *
     * Update the transporter of an existing order.
     *
     * @param  int $order_id (required)
     * @param  \OngoingAPI\Model\PatchOrderTransporterModel $patch_order_transporter_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderTransporterCode'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderTransporterCodeWithHttpInfo($order_id, $patch_order_transporter_model, string $contentType = self::contentTypes['ordersPatchOrderTransporterCode'][0])
    {
        $request = $this->ordersPatchOrderTransporterCodeRequest($order_id, $patch_order_transporter_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderTransporterCodeAsync
     *
     * Update the transporter of an existing order.
     *
     * @param  int $order_id (required)
     * @param  \OngoingAPI\Model\PatchOrderTransporterModel $patch_order_transporter_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderTransporterCode'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderTransporterCodeAsync($order_id, $patch_order_transporter_model, string $contentType = self::contentTypes['ordersPatchOrderTransporterCode'][0])
    {
        return $this->ordersPatchOrderTransporterCodeAsyncWithHttpInfo($order_id, $patch_order_transporter_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderTransporterCodeAsyncWithHttpInfo
     *
     * Update the transporter of an existing order.
     *
     * @param  int $order_id (required)
     * @param  \OngoingAPI\Model\PatchOrderTransporterModel $patch_order_transporter_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderTransporterCode'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderTransporterCodeAsyncWithHttpInfo($order_id, $patch_order_transporter_model, string $contentType = self::contentTypes['ordersPatchOrderTransporterCode'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderTransporterCodeRequest($order_id, $patch_order_transporter_model, $contentType);

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
     * Create request for operation 'ordersPatchOrderTransporterCode'
     *
     * @param  int $order_id (required)
     * @param  \OngoingAPI\Model\PatchOrderTransporterModel $patch_order_transporter_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderTransporterCode'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderTransporterCodeRequest($order_id, $patch_order_transporter_model, string $contentType = self::contentTypes['ordersPatchOrderTransporterCode'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderTransporterCode'
            );
        }

        // verify the required parameter 'patch_order_transporter_model' is set
        if ($patch_order_transporter_model === null || (is_array($patch_order_transporter_model) && count($patch_order_transporter_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_transporter_model when calling ordersPatchOrderTransporterCode'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/transporter';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_transporter_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_transporter_model));
            } else {
                $httpBody = $patch_order_transporter_model;
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
     * Operation ordersPatchOrderWarehouseInstruction
     *
     * Update the warehouse instruction of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWarehouseInstruction $patch_order_warehouse_instruction Object containing the new warehouse instruction. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderWarehouseInstruction'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchOrderWarehouseInstruction($order_id, $patch_order_warehouse_instruction, string $contentType = self::contentTypes['ordersPatchOrderWarehouseInstruction'][0])
    {
        list($response) = $this->ordersPatchOrderWarehouseInstructionWithHttpInfo($order_id, $patch_order_warehouse_instruction, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchOrderWarehouseInstructionWithHttpInfo
     *
     * Update the warehouse instruction of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWarehouseInstruction $patch_order_warehouse_instruction Object containing the new warehouse instruction. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderWarehouseInstruction'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchOrderWarehouseInstructionWithHttpInfo($order_id, $patch_order_warehouse_instruction, string $contentType = self::contentTypes['ordersPatchOrderWarehouseInstruction'][0])
    {
        $request = $this->ordersPatchOrderWarehouseInstructionRequest($order_id, $patch_order_warehouse_instruction, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchOrderWarehouseInstructionAsync
     *
     * Update the warehouse instruction of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWarehouseInstruction $patch_order_warehouse_instruction Object containing the new warehouse instruction. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderWarehouseInstruction'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderWarehouseInstructionAsync($order_id, $patch_order_warehouse_instruction, string $contentType = self::contentTypes['ordersPatchOrderWarehouseInstruction'][0])
    {
        return $this->ordersPatchOrderWarehouseInstructionAsyncWithHttpInfo($order_id, $patch_order_warehouse_instruction, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchOrderWarehouseInstructionAsyncWithHttpInfo
     *
     * Update the warehouse instruction of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWarehouseInstruction $patch_order_warehouse_instruction Object containing the new warehouse instruction. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderWarehouseInstruction'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchOrderWarehouseInstructionAsyncWithHttpInfo($order_id, $patch_order_warehouse_instruction, string $contentType = self::contentTypes['ordersPatchOrderWarehouseInstruction'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchOrderWarehouseInstructionRequest($order_id, $patch_order_warehouse_instruction, $contentType);

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
     * Create request for operation 'ordersPatchOrderWarehouseInstruction'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWarehouseInstruction $patch_order_warehouse_instruction Object containing the new warehouse instruction. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchOrderWarehouseInstruction'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchOrderWarehouseInstructionRequest($order_id, $patch_order_warehouse_instruction, string $contentType = self::contentTypes['ordersPatchOrderWarehouseInstruction'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchOrderWarehouseInstruction'
            );
        }

        // verify the required parameter 'patch_order_warehouse_instruction' is set
        if ($patch_order_warehouse_instruction === null || (is_array($patch_order_warehouse_instruction) && count($patch_order_warehouse_instruction) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_warehouse_instruction when calling ordersPatchOrderWarehouseInstruction'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/warehouseInstruction';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_warehouse_instruction)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_warehouse_instruction));
            } else {
                $httpBody = $patch_order_warehouse_instruction;
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
     * Operation ordersPatchReportedNumberOfItems
     *
     * Update the reported number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedNumberOfItemsModel $patch_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchReportedNumberOfItems($order_id, $order_line_id, $patch_order_reported_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedNumberOfItems'][0])
    {
        list($response) = $this->ordersPatchReportedNumberOfItemsWithHttpInfo($order_id, $order_line_id, $patch_order_reported_number_of_items_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchReportedNumberOfItemsWithHttpInfo
     *
     * Update the reported number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedNumberOfItemsModel $patch_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchReportedNumberOfItemsWithHttpInfo($order_id, $order_line_id, $patch_order_reported_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedNumberOfItems'][0])
    {
        $request = $this->ordersPatchReportedNumberOfItemsRequest($order_id, $order_line_id, $patch_order_reported_number_of_items_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchReportedNumberOfItemsAsync
     *
     * Update the reported number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedNumberOfItemsModel $patch_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchReportedNumberOfItemsAsync($order_id, $order_line_id, $patch_order_reported_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedNumberOfItems'][0])
    {
        return $this->ordersPatchReportedNumberOfItemsAsyncWithHttpInfo($order_id, $order_line_id, $patch_order_reported_number_of_items_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchReportedNumberOfItemsAsyncWithHttpInfo
     *
     * Update the reported number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedNumberOfItemsModel $patch_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchReportedNumberOfItemsAsyncWithHttpInfo($order_id, $order_line_id, $patch_order_reported_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedNumberOfItems'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchReportedNumberOfItemsRequest($order_id, $order_line_id, $patch_order_reported_number_of_items_model, $contentType);

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
     * Create request for operation 'ordersPatchReportedNumberOfItems'
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedNumberOfItemsModel $patch_order_reported_number_of_items_model Object containing the reported number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchReportedNumberOfItemsRequest($order_id, $order_line_id, $patch_order_reported_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedNumberOfItems'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchReportedNumberOfItems'
            );
        }

        // verify the required parameter 'order_line_id' is set
        if ($order_line_id === null || (is_array($order_line_id) && count($order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_line_id when calling ordersPatchReportedNumberOfItems'
            );
        }

        // verify the required parameter 'patch_order_reported_number_of_items_model' is set
        if ($patch_order_reported_number_of_items_model === null || (is_array($patch_order_reported_number_of_items_model) && count($patch_order_reported_number_of_items_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_reported_number_of_items_model when calling ordersPatchReportedNumberOfItems'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/lines/{orderLineId}/reportedNumberOfItems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderLineId' . '}',
                ObjectSerializer::toPathValue($order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_reported_number_of_items_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_reported_number_of_items_model));
            } else {
                $httpBody = $patch_order_reported_number_of_items_model;
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
     * Operation ordersPatchReportedReturnedNumberOfItems
     *
     * Update the reported returned number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedReturnedNumberOfItemsModel $patch_order_reported_returned_number_of_items_model Object containing the reported returned number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \SplFileObject
     */
    public function ordersPatchReportedReturnedNumberOfItems($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedReturnedNumberOfItems'][0])
    {
        list($response) = $this->ordersPatchReportedReturnedNumberOfItemsWithHttpInfo($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchReportedReturnedNumberOfItemsWithHttpInfo
     *
     * Update the reported returned number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedReturnedNumberOfItemsModel $patch_order_reported_returned_number_of_items_model Object containing the reported returned number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \SplFileObject, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchReportedReturnedNumberOfItemsWithHttpInfo($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedReturnedNumberOfItems'][0])
    {
        $request = $this->ordersPatchReportedReturnedNumberOfItemsRequest($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, $contentType);

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
     * Operation ordersPatchReportedReturnedNumberOfItemsAsync
     *
     * Update the reported returned number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedReturnedNumberOfItemsModel $patch_order_reported_returned_number_of_items_model Object containing the reported returned number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchReportedReturnedNumberOfItemsAsync($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedReturnedNumberOfItems'][0])
    {
        return $this->ordersPatchReportedReturnedNumberOfItemsAsyncWithHttpInfo($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchReportedReturnedNumberOfItemsAsyncWithHttpInfo
     *
     * Update the reported returned number of items on a particular order line.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedReturnedNumberOfItemsModel $patch_order_reported_returned_number_of_items_model Object containing the reported returned number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchReportedReturnedNumberOfItemsAsyncWithHttpInfo($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedReturnedNumberOfItems'][0])
    {
        $returnType = '\SplFileObject';
        $request = $this->ordersPatchReportedReturnedNumberOfItemsRequest($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, $contentType);

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
     * Create request for operation 'ordersPatchReportedReturnedNumberOfItems'
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  int $order_line_id Ongoing WMS internal ID of the order line (required)
     * @param  \OngoingAPI\Model\PatchOrderReportedReturnedNumberOfItemsModel $patch_order_reported_returned_number_of_items_model Object containing the reported returned number of items (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReportedReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchReportedReturnedNumberOfItemsRequest($order_id, $order_line_id, $patch_order_reported_returned_number_of_items_model, string $contentType = self::contentTypes['ordersPatchReportedReturnedNumberOfItems'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchReportedReturnedNumberOfItems'
            );
        }

        // verify the required parameter 'order_line_id' is set
        if ($order_line_id === null || (is_array($order_line_id) && count($order_line_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_line_id when calling ordersPatchReportedReturnedNumberOfItems'
            );
        }

        // verify the required parameter 'patch_order_reported_returned_number_of_items_model' is set
        if ($patch_order_reported_returned_number_of_items_model === null || (is_array($patch_order_reported_returned_number_of_items_model) && count($patch_order_reported_returned_number_of_items_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_reported_returned_number_of_items_model when calling ordersPatchReportedReturnedNumberOfItems'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/lines/{orderLineId}/reportedReturnedNumberOfItems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($order_line_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderLineId' . '}',
                ObjectSerializer::toPathValue($order_line_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/octet-stream', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_reported_returned_number_of_items_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_reported_returned_number_of_items_model));
            } else {
                $httpBody = $patch_order_reported_returned_number_of_items_model;
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
     * Operation ordersPatchReturnWaybill
     *
     * Update the return waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderReturnWaybill $patch_order_return_waybill Object containing the new return waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReturnWaybill'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchReturnWaybill($order_id, $patch_order_return_waybill, string $contentType = self::contentTypes['ordersPatchReturnWaybill'][0])
    {
        list($response) = $this->ordersPatchReturnWaybillWithHttpInfo($order_id, $patch_order_return_waybill, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchReturnWaybillWithHttpInfo
     *
     * Update the return waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderReturnWaybill $patch_order_return_waybill Object containing the new return waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReturnWaybill'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchReturnWaybillWithHttpInfo($order_id, $patch_order_return_waybill, string $contentType = self::contentTypes['ordersPatchReturnWaybill'][0])
    {
        $request = $this->ordersPatchReturnWaybillRequest($order_id, $patch_order_return_waybill, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchReturnWaybillAsync
     *
     * Update the return waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderReturnWaybill $patch_order_return_waybill Object containing the new return waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReturnWaybill'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchReturnWaybillAsync($order_id, $patch_order_return_waybill, string $contentType = self::contentTypes['ordersPatchReturnWaybill'][0])
    {
        return $this->ordersPatchReturnWaybillAsyncWithHttpInfo($order_id, $patch_order_return_waybill, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchReturnWaybillAsyncWithHttpInfo
     *
     * Update the return waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderReturnWaybill $patch_order_return_waybill Object containing the new return waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReturnWaybill'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchReturnWaybillAsyncWithHttpInfo($order_id, $patch_order_return_waybill, string $contentType = self::contentTypes['ordersPatchReturnWaybill'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchReturnWaybillRequest($order_id, $patch_order_return_waybill, $contentType);

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
     * Create request for operation 'ordersPatchReturnWaybill'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderReturnWaybill $patch_order_return_waybill Object containing the new return waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchReturnWaybill'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchReturnWaybillRequest($order_id, $patch_order_return_waybill, string $contentType = self::contentTypes['ordersPatchReturnWaybill'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchReturnWaybill'
            );
        }

        // verify the required parameter 'patch_order_return_waybill' is set
        if ($patch_order_return_waybill === null || (is_array($patch_order_return_waybill) && count($patch_order_return_waybill) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_return_waybill when calling ordersPatchReturnWaybill'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/returnWaybill';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_return_waybill)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_return_waybill));
            } else {
                $httpBody = $patch_order_return_waybill;
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
     * Operation ordersPatchServicePointCode
     *
     * Update the service point code of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchServicePointCode $patch_service_point_code Object containing the new service point code. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchServicePointCode'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchServicePointCode($order_id, $patch_service_point_code, string $contentType = self::contentTypes['ordersPatchServicePointCode'][0])
    {
        list($response) = $this->ordersPatchServicePointCodeWithHttpInfo($order_id, $patch_service_point_code, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchServicePointCodeWithHttpInfo
     *
     * Update the service point code of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchServicePointCode $patch_service_point_code Object containing the new service point code. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchServicePointCode'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchServicePointCodeWithHttpInfo($order_id, $patch_service_point_code, string $contentType = self::contentTypes['ordersPatchServicePointCode'][0])
    {
        $request = $this->ordersPatchServicePointCodeRequest($order_id, $patch_service_point_code, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchServicePointCodeAsync
     *
     * Update the service point code of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchServicePointCode $patch_service_point_code Object containing the new service point code. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchServicePointCode'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchServicePointCodeAsync($order_id, $patch_service_point_code, string $contentType = self::contentTypes['ordersPatchServicePointCode'][0])
    {
        return $this->ordersPatchServicePointCodeAsyncWithHttpInfo($order_id, $patch_service_point_code, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchServicePointCodeAsyncWithHttpInfo
     *
     * Update the service point code of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchServicePointCode $patch_service_point_code Object containing the new service point code. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchServicePointCode'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchServicePointCodeAsyncWithHttpInfo($order_id, $patch_service_point_code, string $contentType = self::contentTypes['ordersPatchServicePointCode'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchServicePointCodeRequest($order_id, $patch_service_point_code, $contentType);

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
     * Create request for operation 'ordersPatchServicePointCode'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchServicePointCode $patch_service_point_code Object containing the new service point code. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchServicePointCode'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchServicePointCodeRequest($order_id, $patch_service_point_code, string $contentType = self::contentTypes['ordersPatchServicePointCode'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchServicePointCode'
            );
        }

        // verify the required parameter 'patch_service_point_code' is set
        if ($patch_service_point_code === null || (is_array($patch_service_point_code) && count($patch_service_point_code) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_service_point_code when calling ordersPatchServicePointCode'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/servicePointCode';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_service_point_code)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_service_point_code));
            } else {
                $httpBody = $patch_service_point_code;
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
     * Operation ordersPatchSetOrderClasses
     *
     * Set order classes on an existing order. If the order has any other classes which you don&#39;t send, they will be deleted from the order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchSetOrderClasses($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchSetOrderClasses'][0])
    {
        list($response) = $this->ordersPatchSetOrderClassesWithHttpInfo($order_id, $patch_order_classes_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchSetOrderClassesWithHttpInfo
     *
     * Set order classes on an existing order. If the order has any other classes which you don&#39;t send, they will be deleted from the order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetOrderClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchSetOrderClassesWithHttpInfo($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchSetOrderClasses'][0])
    {
        $request = $this->ordersPatchSetOrderClassesRequest($order_id, $patch_order_classes_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchSetOrderClassesAsync
     *
     * Set order classes on an existing order. If the order has any other classes which you don&#39;t send, they will be deleted from the order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchSetOrderClassesAsync($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchSetOrderClasses'][0])
    {
        return $this->ordersPatchSetOrderClassesAsyncWithHttpInfo($order_id, $patch_order_classes_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchSetOrderClassesAsyncWithHttpInfo
     *
     * Set order classes on an existing order. If the order has any other classes which you don&#39;t send, they will be deleted from the order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchSetOrderClassesAsyncWithHttpInfo($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchSetOrderClasses'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchSetOrderClassesRequest($order_id, $patch_order_classes_model, $contentType);

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
     * Create request for operation 'ordersPatchSetOrderClasses'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderClassesModel $patch_order_classes_model Object containing the order classes. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetOrderClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchSetOrderClassesRequest($order_id, $patch_order_classes_model, string $contentType = self::contentTypes['ordersPatchSetOrderClasses'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchSetOrderClasses'
            );
        }

        // verify the required parameter 'patch_order_classes_model' is set
        if ($patch_order_classes_model === null || (is_array($patch_order_classes_model) && count($patch_order_classes_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_classes_model when calling ordersPatchSetOrderClasses'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/setOrderClasses';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_classes_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_classes_model));
            } else {
                $httpBody = $patch_order_classes_model;
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
     * Operation ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems
     *
     * Sets the reported number of items on each order line to the picked number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems($order_id, string $contentType = self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'][0])
    {
        list($response) = $this->ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsWithHttpInfo($order_id, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsWithHttpInfo
     *
     * Sets the reported number of items on each order line to the picked number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'][0])
    {
        $request = $this->ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsRequest($order_id, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsAsync
     *
     * Sets the reported number of items on each order line to the picked number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsAsync($order_id, string $contentType = self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'][0])
    {
        return $this->ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsAsyncWithHttpInfo($order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsAsyncWithHttpInfo
     *
     * Sets the reported number of items on each order line to the picked number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsAsyncWithHttpInfo($order_id, string $contentType = self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsRequest($order_id, $contentType);

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
     * Create request for operation 'ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchSetReportedNumberOfItemsToPickedNumberOfItemsRequest($order_id, string $contentType = self::contentTypes['ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchSetReportedNumberOfItemsToPickedNumberOfItems'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/setReportedNumberOfItemsToPickedNumberOfItems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems
     *
     * Sets the reported returned number of items on each order line to the returned number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  bool $only_update_order_lines_which_have_returned_items only_update_order_lines_which_have_returned_items (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems($order_id, $only_update_order_lines_which_have_returned_items = null, string $contentType = self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'][0])
    {
        list($response) = $this->ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsWithHttpInfo($order_id, $only_update_order_lines_which_have_returned_items, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsWithHttpInfo
     *
     * Sets the reported returned number of items on each order line to the returned number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  bool $only_update_order_lines_which_have_returned_items (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsWithHttpInfo($order_id, $only_update_order_lines_which_have_returned_items = null, string $contentType = self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'][0])
    {
        $request = $this->ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsRequest($order_id, $only_update_order_lines_which_have_returned_items, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsAsync
     *
     * Sets the reported returned number of items on each order line to the returned number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  bool $only_update_order_lines_which_have_returned_items (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsAsync($order_id, $only_update_order_lines_which_have_returned_items = null, string $contentType = self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'][0])
    {
        return $this->ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsAsyncWithHttpInfo($order_id, $only_update_order_lines_which_have_returned_items, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsAsyncWithHttpInfo
     *
     * Sets the reported returned number of items on each order line to the returned number of items.
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  bool $only_update_order_lines_which_have_returned_items (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsAsyncWithHttpInfo($order_id, $only_update_order_lines_which_have_returned_items = null, string $contentType = self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsRequest($order_id, $only_update_order_lines_which_have_returned_items, $contentType);

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
     * Create request for operation 'ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'
     *
     * @param  int $order_id Ongoing WMS internal ID of the order (required)
     * @param  bool $only_update_order_lines_which_have_returned_items (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItemsRequest($order_id, $only_update_order_lines_which_have_returned_items = null, string $contentType = self::contentTypes['ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchSetReportedReturnedNumberOfItemsToReturnedNumberOfItems'
            );
        }



        $resourcePath = '/api/v1/orders/{orderId}/setReportedReturnedNumberOfItemsToReturnedNumberOfItems';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;

        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_update_order_lines_which_have_returned_items,
            'onlyUpdateOrderLinesWhichHaveReturnedItems', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);


        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
            'PATCH',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation ordersPatchWayBillRow
     *
     * Update waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWayBillRow'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostWaybillRowResponse
     */
    public function ordersPatchWayBillRow($order_id, $way_bill_row_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPatchWayBillRow'][0])
    {
        list($response) = $this->ordersPatchWayBillRowWithHttpInfo($order_id, $way_bill_row_id, $post_way_bill_row_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchWayBillRowWithHttpInfo
     *
     * Update waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWayBillRow'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostWaybillRowResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchWayBillRowWithHttpInfo($order_id, $way_bill_row_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPatchWayBillRow'][0])
    {
        $request = $this->ordersPatchWayBillRowRequest($order_id, $way_bill_row_id, $post_way_bill_row_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostWaybillRowResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostWaybillRowResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostWaybillRowResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostWaybillRowResponse';
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
                        '\OngoingAPI\Model\PostWaybillRowResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchWayBillRowAsync
     *
     * Update waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWayBillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchWayBillRowAsync($order_id, $way_bill_row_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPatchWayBillRow'][0])
    {
        return $this->ordersPatchWayBillRowAsyncWithHttpInfo($order_id, $way_bill_row_id, $post_way_bill_row_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchWayBillRowAsyncWithHttpInfo
     *
     * Update waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWayBillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchWayBillRowAsyncWithHttpInfo($order_id, $way_bill_row_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPatchWayBillRow'][0])
    {
        $returnType = '\OngoingAPI\Model\PostWaybillRowResponse';
        $request = $this->ordersPatchWayBillRowRequest($order_id, $way_bill_row_id, $post_way_bill_row_model, $contentType);

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
     * Create request for operation 'ordersPatchWayBillRow'
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $way_bill_row_id Waybill row ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWayBillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchWayBillRowRequest($order_id, $way_bill_row_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPatchWayBillRow'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchWayBillRow'
            );
        }

        // verify the required parameter 'way_bill_row_id' is set
        if ($way_bill_row_id === null || (is_array($way_bill_row_id) && count($way_bill_row_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $way_bill_row_id when calling ordersPatchWayBillRow'
            );
        }

        // verify the required parameter 'post_way_bill_row_model' is set
        if ($post_way_bill_row_model === null || (is_array($post_way_bill_row_model) && count($post_way_bill_row_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_way_bill_row_model when calling ordersPatchWayBillRow'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/wayBillRows/{wayBillRowId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }
        // path params
        if ($way_bill_row_id !== null) {
            $resourcePath = str_replace(
                '{' . 'wayBillRowId' . '}',
                ObjectSerializer::toPathValue($way_bill_row_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_way_bill_row_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_way_bill_row_model));
            } else {
                $httpBody = $post_way_bill_row_model;
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
     * Operation ordersPatchWaybill
     *
     * Update the waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWaybill $patch_order_waybill Object containing the new waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWaybill'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchOrderResponse
     */
    public function ordersPatchWaybill($order_id, $patch_order_waybill, string $contentType = self::contentTypes['ordersPatchWaybill'][0])
    {
        list($response) = $this->ordersPatchWaybillWithHttpInfo($order_id, $patch_order_waybill, $contentType);
        return $response;
    }

    /**
     * Operation ordersPatchWaybillWithHttpInfo
     *
     * Update the waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWaybill $patch_order_waybill Object containing the new waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWaybill'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPatchWaybillWithHttpInfo($order_id, $patch_order_waybill, string $contentType = self::contentTypes['ordersPatchWaybill'][0])
    {
        $request = $this->ordersPatchWaybillRequest($order_id, $patch_order_waybill, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PatchOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PatchOrderResponse';
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
                        '\OngoingAPI\Model\PatchOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPatchWaybillAsync
     *
     * Update the waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWaybill $patch_order_waybill Object containing the new waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWaybill'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchWaybillAsync($order_id, $patch_order_waybill, string $contentType = self::contentTypes['ordersPatchWaybill'][0])
    {
        return $this->ordersPatchWaybillAsyncWithHttpInfo($order_id, $patch_order_waybill, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPatchWaybillAsyncWithHttpInfo
     *
     * Update the waybill of an existing order.
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWaybill $patch_order_waybill Object containing the new waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWaybill'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPatchWaybillAsyncWithHttpInfo($order_id, $patch_order_waybill, string $contentType = self::contentTypes['ordersPatchWaybill'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchOrderResponse';
        $request = $this->ordersPatchWaybillRequest($order_id, $patch_order_waybill, $contentType);

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
     * Create request for operation 'ordersPatchWaybill'
     *
     * @param  int $order_id OrderId. (required)
     * @param  \OngoingAPI\Model\PatchOrderWaybill $patch_order_waybill Object containing the new waybill. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPatchWaybill'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPatchWaybillRequest($order_id, $patch_order_waybill, string $contentType = self::contentTypes['ordersPatchWaybill'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPatchWaybill'
            );
        }

        // verify the required parameter 'patch_order_waybill' is set
        if ($patch_order_waybill === null || (is_array($patch_order_waybill) && count($patch_order_waybill) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_order_waybill when calling ordersPatchWaybill'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/waybill';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_order_waybill)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_order_waybill));
            } else {
                $httpBody = $patch_order_waybill;
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
     * Operation ordersPost
     *
     * Create a new file and attach it to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPost'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function ordersPost($order_id, $post_file_model, string $contentType = self::contentTypes['ordersPost'][0])
    {
        list($response) = $this->ordersPostWithHttpInfo($order_id, $post_file_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPostWithHttpInfo
     *
     * Create a new file and attach it to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPost'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPostWithHttpInfo($order_id, $post_file_model, string $contentType = self::contentTypes['ordersPost'][0])
    {
        $request = $this->ordersPostRequest($order_id, $post_file_model, $contentType);

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
     * Operation ordersPostAsync
     *
     * Create a new file and attach it to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPostAsync($order_id, $post_file_model, string $contentType = self::contentTypes['ordersPost'][0])
    {
        return $this->ordersPostAsyncWithHttpInfo($order_id, $post_file_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPostAsyncWithHttpInfo
     *
     * Create a new file and attach it to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPostAsyncWithHttpInfo($order_id, $post_file_model, string $contentType = self::contentTypes['ordersPost'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->ordersPostRequest($order_id, $post_file_model, $contentType);

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
     * Create request for operation 'ordersPost'
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPostRequest($order_id, $post_file_model, string $contentType = self::contentTypes['ordersPost'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPost'
            );
        }

        // verify the required parameter 'post_file_model' is set
        if ($post_file_model === null || (is_array($post_file_model) && count($post_file_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_model when calling ordersPost'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersPostWayBillRow
     *
     * Create a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPostWayBillRow'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostWaybillRowResponse
     */
    public function ordersPostWayBillRow($order_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPostWayBillRow'][0])
    {
        list($response) = $this->ordersPostWayBillRowWithHttpInfo($order_id, $post_way_bill_row_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPostWayBillRowWithHttpInfo
     *
     * Create a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPostWayBillRow'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostWaybillRowResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPostWayBillRowWithHttpInfo($order_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPostWayBillRow'][0])
    {
        $request = $this->ordersPostWayBillRowRequest($order_id, $post_way_bill_row_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostWaybillRowResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostWaybillRowResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostWaybillRowResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostWaybillRowResponse';
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
                        '\OngoingAPI\Model\PostWaybillRowResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPostWayBillRowAsync
     *
     * Create a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPostWayBillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPostWayBillRowAsync($order_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPostWayBillRow'][0])
    {
        return $this->ordersPostWayBillRowAsyncWithHttpInfo($order_id, $post_way_bill_row_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPostWayBillRowAsyncWithHttpInfo
     *
     * Create a waybill row.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPostWayBillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPostWayBillRowAsyncWithHttpInfo($order_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPostWayBillRow'][0])
    {
        $returnType = '\OngoingAPI\Model\PostWaybillRowResponse';
        $request = $this->ordersPostWayBillRowRequest($order_id, $post_way_bill_row_model, $contentType);

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
     * Create request for operation 'ordersPostWayBillRow'
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostWayBillRowModel $post_way_bill_row_model Information about the waybill row. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPostWayBillRow'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPostWayBillRowRequest($order_id, $post_way_bill_row_model, string $contentType = self::contentTypes['ordersPostWayBillRow'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPostWayBillRow'
            );
        }

        // verify the required parameter 'post_way_bill_row_model' is set
        if ($post_way_bill_row_model === null || (is_array($post_way_bill_row_model) && count($post_way_bill_row_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_way_bill_row_model when calling ordersPostWayBillRow'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/wayBillRows';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_way_bill_row_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_way_bill_row_model));
            } else {
                $httpBody = $post_way_bill_row_model;
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
     * Operation ordersPutFile
     *
     * Update a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function ordersPutFile($order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['ordersPutFile'][0])
    {
        list($response) = $this->ordersPutFileWithHttpInfo($order_id, $file_id, $post_file_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutFileWithHttpInfo
     *
     * Update a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFile'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutFileWithHttpInfo($order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['ordersPutFile'][0])
    {
        $request = $this->ordersPutFileRequest($order_id, $file_id, $post_file_model, $contentType);

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
     * Operation ordersPutFileAsync
     *
     * Update a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutFileAsync($order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['ordersPutFile'][0])
    {
        return $this->ordersPutFileAsyncWithHttpInfo($order_id, $file_id, $post_file_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutFileAsyncWithHttpInfo
     *
     * Update a file which is attached to an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutFileAsyncWithHttpInfo($order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['ordersPutFile'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->ordersPutFileRequest($order_id, $file_id, $post_file_model, $contentType);

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
     * Create request for operation 'ordersPutFile'
     *
     * @param  int $order_id Order ID. (required)
     * @param  int $file_id File ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFile'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutFileRequest($order_id, $file_id, $post_file_model, string $contentType = self::contentTypes['ordersPutFile'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutFile'
            );
        }

        // verify the required parameter 'file_id' is set
        if ($file_id === null || (is_array($file_id) && count($file_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file_id when calling ordersPutFile'
            );
        }

        // verify the required parameter 'post_file_model' is set
        if ($post_file_model === null || (is_array($post_file_model) && count($post_file_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_model when calling ordersPutFile'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/files/{fileId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersPutFileUsingFilename
     *
     * Create or update a file which is attached to an order. The filename will be used to check if the file already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function ordersPutFileUsingFilename($order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['ordersPutFileUsingFilename'][0])
    {
        list($response) = $this->ordersPutFileUsingFilenameWithHttpInfo($order_id, $file_name, $post_file_no_filename_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutFileUsingFilenameWithHttpInfo
     *
     * Create or update a file which is attached to an order. The filename will be used to check if the file already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutFileUsingFilenameWithHttpInfo($order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['ordersPutFileUsingFilename'][0])
    {
        $request = $this->ordersPutFileUsingFilenameRequest($order_id, $file_name, $post_file_no_filename_model, $contentType);

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
     * Operation ordersPutFileUsingFilenameAsync
     *
     * Create or update a file which is attached to an order. The filename will be used to check if the file already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutFileUsingFilenameAsync($order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['ordersPutFileUsingFilename'][0])
    {
        return $this->ordersPutFileUsingFilenameAsyncWithHttpInfo($order_id, $file_name, $post_file_no_filename_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutFileUsingFilenameAsyncWithHttpInfo
     *
     * Create or update a file which is attached to an order. The filename will be used to check if the file already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutFileUsingFilenameAsyncWithHttpInfo($order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['ordersPutFileUsingFilename'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->ordersPutFileUsingFilenameRequest($order_id, $file_name, $post_file_no_filename_model, $contentType);

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
     * Create request for operation 'ordersPutFileUsingFilename'
     *
     * @param  int $order_id Order ID. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutFileUsingFilenameRequest($order_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['ordersPutFileUsingFilename'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutFileUsingFilename'
            );
        }

        // verify the required parameter 'file_name' is set
        if ($file_name === null || (is_array($file_name) && count($file_name) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file_name when calling ordersPutFileUsingFilename'
            );
        }

        // verify the required parameter 'post_file_no_filename_model' is set
        if ($post_file_no_filename_model === null || (is_array($post_file_no_filename_model) && count($post_file_no_filename_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_no_filename_model when calling ordersPutFileUsingFilename'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/files';
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
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
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
     * Operation ordersPutOrder
     *
     * Create or update an order. If there is no order with the specified order number, it will be created. Otherwise, the existing order will be updated. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrder'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostOrderResponse|\OngoingAPI\Model\PostOrderResponse
     */
    public function ordersPutOrder($post_order_model, string $contentType = self::contentTypes['ordersPutOrder'][0])
    {
        list($response) = $this->ordersPutOrderWithHttpInfo($post_order_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutOrderWithHttpInfo
     *
     * Create or update an order. If there is no order with the specified order number, it will be created. Otherwise, the existing order will be updated. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrder'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostOrderResponse|\OngoingAPI\Model\PostOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutOrderWithHttpInfo($post_order_model, string $contentType = self::contentTypes['ordersPutOrder'][0])
    {
        $request = $this->ordersPutOrderRequest($post_order_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
                case 201:
                    if ('\OngoingAPI\Model\PostOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostOrderResponse';
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
                        '\OngoingAPI\Model\PostOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
                case 201:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\OngoingAPI\Model\PostOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutOrderAsync
     *
     * Create or update an order. If there is no order with the specified order number, it will be created. Otherwise, the existing order will be updated. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderAsync($post_order_model, string $contentType = self::contentTypes['ordersPutOrder'][0])
    {
        return $this->ordersPutOrderAsyncWithHttpInfo($post_order_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutOrderAsyncWithHttpInfo
     *
     * Create or update an order. If there is no order with the specified order number, it will be created. Otherwise, the existing order will be updated. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderAsyncWithHttpInfo($post_order_model, string $contentType = self::contentTypes['ordersPutOrder'][0])
    {
        $returnType = '\OngoingAPI\Model\PostOrderResponse';
        $request = $this->ordersPutOrderRequest($post_order_model, $contentType);

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
     * Create request for operation 'ordersPutOrder'
     *
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutOrderRequest($post_order_model, string $contentType = self::contentTypes['ordersPutOrder'][0])
    {

        // verify the required parameter 'post_order_model' is set
        if ($post_order_model === null || (is_array($post_order_model) && count($post_order_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_order_model when calling ordersPutOrder'
            );
        }


        $resourcePath = '/api/v1/orders';
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
        if (isset($post_order_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_order_model));
            } else {
                $httpBody = $post_order_model;
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
     * Operation ordersPutOrderTextLineUsingRowNumber
     *
     * Create or update an order text line on an order. The row number will be used to check if the order text line already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PutOrderTextLineModel $put_order_text_line_model Object containing the order text line. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTextLineUsingRowNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PutOrderTextLineResponse
     */
    public function ordersPutOrderTextLineUsingRowNumber($order_id, $put_order_text_line_model, string $contentType = self::contentTypes['ordersPutOrderTextLineUsingRowNumber'][0])
    {
        list($response) = $this->ordersPutOrderTextLineUsingRowNumberWithHttpInfo($order_id, $put_order_text_line_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutOrderTextLineUsingRowNumberWithHttpInfo
     *
     * Create or update an order text line on an order. The row number will be used to check if the order text line already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PutOrderTextLineModel $put_order_text_line_model Object containing the order text line. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTextLineUsingRowNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PutOrderTextLineResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutOrderTextLineUsingRowNumberWithHttpInfo($order_id, $put_order_text_line_model, string $contentType = self::contentTypes['ordersPutOrderTextLineUsingRowNumber'][0])
    {
        $request = $this->ordersPutOrderTextLineUsingRowNumberRequest($order_id, $put_order_text_line_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PutOrderTextLineResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PutOrderTextLineResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PutOrderTextLineResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PutOrderTextLineResponse';
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
                        '\OngoingAPI\Model\PutOrderTextLineResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutOrderTextLineUsingRowNumberAsync
     *
     * Create or update an order text line on an order. The row number will be used to check if the order text line already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PutOrderTextLineModel $put_order_text_line_model Object containing the order text line. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTextLineUsingRowNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderTextLineUsingRowNumberAsync($order_id, $put_order_text_line_model, string $contentType = self::contentTypes['ordersPutOrderTextLineUsingRowNumber'][0])
    {
        return $this->ordersPutOrderTextLineUsingRowNumberAsyncWithHttpInfo($order_id, $put_order_text_line_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutOrderTextLineUsingRowNumberAsyncWithHttpInfo
     *
     * Create or update an order text line on an order. The row number will be used to check if the order text line already exists.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PutOrderTextLineModel $put_order_text_line_model Object containing the order text line. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTextLineUsingRowNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderTextLineUsingRowNumberAsyncWithHttpInfo($order_id, $put_order_text_line_model, string $contentType = self::contentTypes['ordersPutOrderTextLineUsingRowNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\PutOrderTextLineResponse';
        $request = $this->ordersPutOrderTextLineUsingRowNumberRequest($order_id, $put_order_text_line_model, $contentType);

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
     * Create request for operation 'ordersPutOrderTextLineUsingRowNumber'
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PutOrderTextLineModel $put_order_text_line_model Object containing the order text line. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTextLineUsingRowNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutOrderTextLineUsingRowNumberRequest($order_id, $put_order_text_line_model, string $contentType = self::contentTypes['ordersPutOrderTextLineUsingRowNumber'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutOrderTextLineUsingRowNumber'
            );
        }

        // verify the required parameter 'put_order_text_line_model' is set
        if ($put_order_text_line_model === null || (is_array($put_order_text_line_model) && count($put_order_text_line_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $put_order_text_line_model when calling ordersPutOrderTextLineUsingRowNumber'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/orderTextLines';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($put_order_text_line_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($put_order_text_line_model));
            } else {
                $httpBody = $put_order_text_line_model;
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
     * Operation ordersPutOrderTracking
     *
     * Create or update a waybill on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderTrackingModel $post_order_tracking_model Information about the order tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTracking'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostOrderTrackingResponse
     */
    public function ordersPutOrderTracking($order_id, $post_order_tracking_model, string $contentType = self::contentTypes['ordersPutOrderTracking'][0])
    {
        list($response) = $this->ordersPutOrderTrackingWithHttpInfo($order_id, $post_order_tracking_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutOrderTrackingWithHttpInfo
     *
     * Create or update a waybill on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderTrackingModel $post_order_tracking_model Information about the order tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTracking'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostOrderTrackingResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutOrderTrackingWithHttpInfo($order_id, $post_order_tracking_model, string $contentType = self::contentTypes['ordersPutOrderTracking'][0])
    {
        $request = $this->ordersPutOrderTrackingRequest($order_id, $post_order_tracking_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostOrderTrackingResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostOrderTrackingResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostOrderTrackingResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostOrderTrackingResponse';
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
                        '\OngoingAPI\Model\PostOrderTrackingResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutOrderTrackingAsync
     *
     * Create or update a waybill on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderTrackingModel $post_order_tracking_model Information about the order tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTracking'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderTrackingAsync($order_id, $post_order_tracking_model, string $contentType = self::contentTypes['ordersPutOrderTracking'][0])
    {
        return $this->ordersPutOrderTrackingAsyncWithHttpInfo($order_id, $post_order_tracking_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutOrderTrackingAsyncWithHttpInfo
     *
     * Create or update a waybill on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderTrackingModel $post_order_tracking_model Information about the order tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTracking'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderTrackingAsyncWithHttpInfo($order_id, $post_order_tracking_model, string $contentType = self::contentTypes['ordersPutOrderTracking'][0])
    {
        $returnType = '\OngoingAPI\Model\PostOrderTrackingResponse';
        $request = $this->ordersPutOrderTrackingRequest($order_id, $post_order_tracking_model, $contentType);

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
     * Create request for operation 'ordersPutOrderTracking'
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderTrackingModel $post_order_tracking_model Information about the order tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderTracking'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutOrderTrackingRequest($order_id, $post_order_tracking_model, string $contentType = self::contentTypes['ordersPutOrderTracking'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutOrderTracking'
            );
        }

        // verify the required parameter 'post_order_tracking_model' is set
        if ($post_order_tracking_model === null || (is_array($post_order_tracking_model) && count($post_order_tracking_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_order_tracking_model when calling ordersPutOrderTracking'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/orderTracking';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_order_tracking_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_order_tracking_model));
            } else {
                $httpBody = $post_order_tracking_model;
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
     * Operation ordersPutOrderUsingOrderId
     *
     * Update an order. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderUsingOrderId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostOrderResponse
     */
    public function ordersPutOrderUsingOrderId($order_id, $post_order_model, string $contentType = self::contentTypes['ordersPutOrderUsingOrderId'][0])
    {
        list($response) = $this->ordersPutOrderUsingOrderIdWithHttpInfo($order_id, $post_order_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutOrderUsingOrderIdWithHttpInfo
     *
     * Update an order. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderUsingOrderId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutOrderUsingOrderIdWithHttpInfo($order_id, $post_order_model, string $contentType = self::contentTypes['ordersPutOrderUsingOrderId'][0])
    {
        $request = $this->ordersPutOrderUsingOrderIdRequest($order_id, $post_order_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostOrderResponse';
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
                        '\OngoingAPI\Model\PostOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutOrderUsingOrderIdAsync
     *
     * Update an order. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderUsingOrderId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderUsingOrderIdAsync($order_id, $post_order_model, string $contentType = self::contentTypes['ordersPutOrderUsingOrderId'][0])
    {
        return $this->ordersPutOrderUsingOrderIdAsyncWithHttpInfo($order_id, $post_order_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutOrderUsingOrderIdAsyncWithHttpInfo
     *
     * Update an order. Note that you are not allowed to update an order after the warehouse has started working on it.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderUsingOrderId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutOrderUsingOrderIdAsyncWithHttpInfo($order_id, $post_order_model, string $contentType = self::contentTypes['ordersPutOrderUsingOrderId'][0])
    {
        $returnType = '\OngoingAPI\Model\PostOrderResponse';
        $request = $this->ordersPutOrderUsingOrderIdRequest($order_id, $post_order_model, $contentType);

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
     * Create request for operation 'ordersPutOrderUsingOrderId'
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostOrderModel $post_order_model Order object, containing all order data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutOrderUsingOrderId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutOrderUsingOrderIdRequest($order_id, $post_order_model, string $contentType = self::contentTypes['ordersPutOrderUsingOrderId'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutOrderUsingOrderId'
            );
        }

        // verify the required parameter 'post_order_model' is set
        if ($post_order_model === null || (is_array($post_order_model) && count($post_order_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_order_model when calling ordersPutOrderUsingOrderId'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_order_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_order_model));
            } else {
                $httpBody = $post_order_model;
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
     * Operation ordersPutParcel
     *
     * Create or update a parcel on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTypeModel $post_parcel_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcel'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostParcelResponse
     */
    public function ordersPutParcel($order_id, $post_parcel_type_model, string $contentType = self::contentTypes['ordersPutParcel'][0])
    {
        list($response) = $this->ordersPutParcelWithHttpInfo($order_id, $post_parcel_type_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutParcelWithHttpInfo
     *
     * Create or update a parcel on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTypeModel $post_parcel_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcel'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostParcelResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutParcelWithHttpInfo($order_id, $post_parcel_type_model, string $contentType = self::contentTypes['ordersPutParcel'][0])
    {
        $request = $this->ordersPutParcelRequest($order_id, $post_parcel_type_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostParcelResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostParcelResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostParcelResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostParcelResponse';
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
                        '\OngoingAPI\Model\PostParcelResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutParcelAsync
     *
     * Create or update a parcel on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTypeModel $post_parcel_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcel'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutParcelAsync($order_id, $post_parcel_type_model, string $contentType = self::contentTypes['ordersPutParcel'][0])
    {
        return $this->ordersPutParcelAsyncWithHttpInfo($order_id, $post_parcel_type_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutParcelAsyncWithHttpInfo
     *
     * Create or update a parcel on an order.
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTypeModel $post_parcel_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcel'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutParcelAsyncWithHttpInfo($order_id, $post_parcel_type_model, string $contentType = self::contentTypes['ordersPutParcel'][0])
    {
        $returnType = '\OngoingAPI\Model\PostParcelResponse';
        $request = $this->ordersPutParcelRequest($order_id, $post_parcel_type_model, $contentType);

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
     * Create request for operation 'ordersPutParcel'
     *
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTypeModel $post_parcel_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcel'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutParcelRequest($order_id, $post_parcel_type_model, string $contentType = self::contentTypes['ordersPutParcel'][0])
    {

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutParcel'
            );
        }

        // verify the required parameter 'post_parcel_type_model' is set
        if ($post_parcel_type_model === null || (is_array($post_parcel_type_model) && count($post_parcel_type_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_parcel_type_model when calling ordersPutParcel'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/parcels';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_parcel_type_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_parcel_type_model));
            } else {
                $httpBody = $post_parcel_type_model;
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
     * Operation ordersPutParcelTracking
     *
     * Create or update tracking on a parcel.
     *
     * @param  int $parcel_id Parcel ID. (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTrackingModel $post_parcel_tracking_model Information about the parcel tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelTracking'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostParcelResponse
     */
    public function ordersPutParcelTracking($parcel_id, $order_id, $post_parcel_tracking_model, string $contentType = self::contentTypes['ordersPutParcelTracking'][0])
    {
        list($response) = $this->ordersPutParcelTrackingWithHttpInfo($parcel_id, $order_id, $post_parcel_tracking_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutParcelTrackingWithHttpInfo
     *
     * Create or update tracking on a parcel.
     *
     * @param  int $parcel_id Parcel ID. (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTrackingModel $post_parcel_tracking_model Information about the parcel tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelTracking'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostParcelResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutParcelTrackingWithHttpInfo($parcel_id, $order_id, $post_parcel_tracking_model, string $contentType = self::contentTypes['ordersPutParcelTracking'][0])
    {
        $request = $this->ordersPutParcelTrackingRequest($parcel_id, $order_id, $post_parcel_tracking_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostParcelResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostParcelResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostParcelResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostParcelResponse';
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
                        '\OngoingAPI\Model\PostParcelResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutParcelTrackingAsync
     *
     * Create or update tracking on a parcel.
     *
     * @param  int $parcel_id Parcel ID. (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTrackingModel $post_parcel_tracking_model Information about the parcel tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelTracking'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutParcelTrackingAsync($parcel_id, $order_id, $post_parcel_tracking_model, string $contentType = self::contentTypes['ordersPutParcelTracking'][0])
    {
        return $this->ordersPutParcelTrackingAsyncWithHttpInfo($parcel_id, $order_id, $post_parcel_tracking_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutParcelTrackingAsyncWithHttpInfo
     *
     * Create or update tracking on a parcel.
     *
     * @param  int $parcel_id Parcel ID. (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTrackingModel $post_parcel_tracking_model Information about the parcel tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelTracking'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutParcelTrackingAsyncWithHttpInfo($parcel_id, $order_id, $post_parcel_tracking_model, string $contentType = self::contentTypes['ordersPutParcelTracking'][0])
    {
        $returnType = '\OngoingAPI\Model\PostParcelResponse';
        $request = $this->ordersPutParcelTrackingRequest($parcel_id, $order_id, $post_parcel_tracking_model, $contentType);

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
     * Create request for operation 'ordersPutParcelTracking'
     *
     * @param  int $parcel_id Parcel ID. (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelTrackingModel $post_parcel_tracking_model Information about the parcel tracking. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelTracking'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutParcelTrackingRequest($parcel_id, $order_id, $post_parcel_tracking_model, string $contentType = self::contentTypes['ordersPutParcelTracking'][0])
    {

        // verify the required parameter 'parcel_id' is set
        if ($parcel_id === null || (is_array($parcel_id) && count($parcel_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $parcel_id when calling ordersPutParcelTracking'
            );
        }

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutParcelTracking'
            );
        }

        // verify the required parameter 'post_parcel_tracking_model' is set
        if ($post_parcel_tracking_model === null || (is_array($post_parcel_tracking_model) && count($post_parcel_tracking_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_parcel_tracking_model when calling ordersPutParcelTracking'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/parcels/{parcelId}/parcelTracking';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($parcel_id !== null) {
            $resourcePath = str_replace(
                '{' . 'parcelId' . '}',
                ObjectSerializer::toPathValue($parcel_id),
                $resourcePath
            );
        }
        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_parcel_tracking_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_parcel_tracking_model));
            } else {
                $httpBody = $post_parcel_tracking_model;
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
     * Operation ordersPutParcelUsingId
     *
     * Update a parcel on an order.
     *
     * @param  int $parcel_id Parcel ID (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelUsingIdTypeModel $post_parcel_using_id_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostParcelResponse
     */
    public function ordersPutParcelUsingId($parcel_id, $order_id, $post_parcel_using_id_type_model, string $contentType = self::contentTypes['ordersPutParcelUsingId'][0])
    {
        list($response) = $this->ordersPutParcelUsingIdWithHttpInfo($parcel_id, $order_id, $post_parcel_using_id_type_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutParcelUsingIdWithHttpInfo
     *
     * Update a parcel on an order.
     *
     * @param  int $parcel_id Parcel ID (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelUsingIdTypeModel $post_parcel_using_id_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostParcelResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutParcelUsingIdWithHttpInfo($parcel_id, $order_id, $post_parcel_using_id_type_model, string $contentType = self::contentTypes['ordersPutParcelUsingId'][0])
    {
        $request = $this->ordersPutParcelUsingIdRequest($parcel_id, $order_id, $post_parcel_using_id_type_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostParcelResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostParcelResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostParcelResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostParcelResponse';
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
                        '\OngoingAPI\Model\PostParcelResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutParcelUsingIdAsync
     *
     * Update a parcel on an order.
     *
     * @param  int $parcel_id Parcel ID (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelUsingIdTypeModel $post_parcel_using_id_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutParcelUsingIdAsync($parcel_id, $order_id, $post_parcel_using_id_type_model, string $contentType = self::contentTypes['ordersPutParcelUsingId'][0])
    {
        return $this->ordersPutParcelUsingIdAsyncWithHttpInfo($parcel_id, $order_id, $post_parcel_using_id_type_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutParcelUsingIdAsyncWithHttpInfo
     *
     * Update a parcel on an order.
     *
     * @param  int $parcel_id Parcel ID (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelUsingIdTypeModel $post_parcel_using_id_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutParcelUsingIdAsyncWithHttpInfo($parcel_id, $order_id, $post_parcel_using_id_type_model, string $contentType = self::contentTypes['ordersPutParcelUsingId'][0])
    {
        $returnType = '\OngoingAPI\Model\PostParcelResponse';
        $request = $this->ordersPutParcelUsingIdRequest($parcel_id, $order_id, $post_parcel_using_id_type_model, $contentType);

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
     * Create request for operation 'ordersPutParcelUsingId'
     *
     * @param  int $parcel_id Parcel ID (required)
     * @param  int $order_id Order ID. (required)
     * @param  \OngoingAPI\Model\PostParcelUsingIdTypeModel $post_parcel_using_id_type_model Information about the parcel. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutParcelUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutParcelUsingIdRequest($parcel_id, $order_id, $post_parcel_using_id_type_model, string $contentType = self::contentTypes['ordersPutParcelUsingId'][0])
    {

        // verify the required parameter 'parcel_id' is set
        if ($parcel_id === null || (is_array($parcel_id) && count($parcel_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $parcel_id when calling ordersPutParcelUsingId'
            );
        }

        // verify the required parameter 'order_id' is set
        if ($order_id === null || (is_array($order_id) && count($order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $order_id when calling ordersPutParcelUsingId'
            );
        }

        // verify the required parameter 'post_parcel_using_id_type_model' is set
        if ($post_parcel_using_id_type_model === null || (is_array($post_parcel_using_id_type_model) && count($post_parcel_using_id_type_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_parcel_using_id_type_model when calling ordersPutParcelUsingId'
            );
        }


        $resourcePath = '/api/v1/orders/{orderId}/parcels/{parcelId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($parcel_id !== null) {
            $resourcePath = str_replace(
                '{' . 'parcelId' . '}',
                ObjectSerializer::toPathValue($parcel_id),
                $resourcePath
            );
        }
        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'orderId' . '}',
                ObjectSerializer::toPathValue($order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_parcel_using_id_type_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_parcel_using_id_type_model));
            } else {
                $httpBody = $post_parcel_using_id_type_model;
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
     * Operation ordersPutWayOfDeliveryType
     *
     * Create or update a way of delivery type. If there is no way of delivery type with the specified code, it will be created. Otherwise, the existing way of delivery type will be updated.
     *
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostWayOfDeliveryTypeResponse
     */
    public function ordersPutWayOfDeliveryType($post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryType'][0])
    {
        list($response) = $this->ordersPutWayOfDeliveryTypeWithHttpInfo($post_way_of_delivery_type_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutWayOfDeliveryTypeWithHttpInfo
     *
     * Create or update a way of delivery type. If there is no way of delivery type with the specified code, it will be created. Otherwise, the existing way of delivery type will be updated.
     *
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostWayOfDeliveryTypeResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutWayOfDeliveryTypeWithHttpInfo($post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryType'][0])
    {
        $request = $this->ordersPutWayOfDeliveryTypeRequest($post_way_of_delivery_type_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostWayOfDeliveryTypeResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostWayOfDeliveryTypeResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse';
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
                        '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutWayOfDeliveryTypeAsync
     *
     * Create or update a way of delivery type. If there is no way of delivery type with the specified code, it will be created. Otherwise, the existing way of delivery type will be updated.
     *
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutWayOfDeliveryTypeAsync($post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryType'][0])
    {
        return $this->ordersPutWayOfDeliveryTypeAsyncWithHttpInfo($post_way_of_delivery_type_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutWayOfDeliveryTypeAsyncWithHttpInfo
     *
     * Create or update a way of delivery type. If there is no way of delivery type with the specified code, it will be created. Otherwise, the existing way of delivery type will be updated.
     *
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutWayOfDeliveryTypeAsyncWithHttpInfo($post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryType'][0])
    {
        $returnType = '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse';
        $request = $this->ordersPutWayOfDeliveryTypeRequest($post_way_of_delivery_type_model, $contentType);

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
     * Create request for operation 'ordersPutWayOfDeliveryType'
     *
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryType'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutWayOfDeliveryTypeRequest($post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryType'][0])
    {

        // verify the required parameter 'post_way_of_delivery_type_model' is set
        if ($post_way_of_delivery_type_model === null || (is_array($post_way_of_delivery_type_model) && count($post_way_of_delivery_type_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_way_of_delivery_type_model when calling ordersPutWayOfDeliveryType'
            );
        }


        $resourcePath = '/api/v1/orders/wayOfDeliveryTypes';
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
        if (isset($post_way_of_delivery_type_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_way_of_delivery_type_model));
            } else {
                $httpBody = $post_way_of_delivery_type_model;
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
     * Operation ordersPutWayOfDeliveryTypeUsingId
     *
     * Update a way of delivery type. The ID will be used to identify the way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostWayOfDeliveryTypeResponse
     */
    public function ordersPutWayOfDeliveryTypeUsingId($way_of_delivery_type_id, $post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'][0])
    {
        list($response) = $this->ordersPutWayOfDeliveryTypeUsingIdWithHttpInfo($way_of_delivery_type_id, $post_way_of_delivery_type_model, $contentType);
        return $response;
    }

    /**
     * Operation ordersPutWayOfDeliveryTypeUsingIdWithHttpInfo
     *
     * Update a way of delivery type. The ID will be used to identify the way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostWayOfDeliveryTypeResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function ordersPutWayOfDeliveryTypeUsingIdWithHttpInfo($way_of_delivery_type_id, $post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'][0])
    {
        $request = $this->ordersPutWayOfDeliveryTypeUsingIdRequest($way_of_delivery_type_id, $post_way_of_delivery_type_model, $contentType);

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


            switch($statusCode) {
                case 200:
                    if ('\OngoingAPI\Model\PostWayOfDeliveryTypeResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostWayOfDeliveryTypeResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

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

            $returnType = '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse';
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
                        '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation ordersPutWayOfDeliveryTypeUsingIdAsync
     *
     * Update a way of delivery type. The ID will be used to identify the way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutWayOfDeliveryTypeUsingIdAsync($way_of_delivery_type_id, $post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'][0])
    {
        return $this->ordersPutWayOfDeliveryTypeUsingIdAsyncWithHttpInfo($way_of_delivery_type_id, $post_way_of_delivery_type_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation ordersPutWayOfDeliveryTypeUsingIdAsyncWithHttpInfo
     *
     * Update a way of delivery type. The ID will be used to identify the way of delivery type.
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function ordersPutWayOfDeliveryTypeUsingIdAsyncWithHttpInfo($way_of_delivery_type_id, $post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'][0])
    {
        $returnType = '\OngoingAPI\Model\PostWayOfDeliveryTypeResponse';
        $request = $this->ordersPutWayOfDeliveryTypeUsingIdRequest($way_of_delivery_type_id, $post_way_of_delivery_type_model, $contentType);

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
     * Create request for operation 'ordersPutWayOfDeliveryTypeUsingId'
     *
     * @param  int $way_of_delivery_type_id Way of delivery type ID. (required)
     * @param  \OngoingAPI\Model\PostWayOfDeliveryTypeModel $post_way_of_delivery_type_model An object containing the way of delivery type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function ordersPutWayOfDeliveryTypeUsingIdRequest($way_of_delivery_type_id, $post_way_of_delivery_type_model, string $contentType = self::contentTypes['ordersPutWayOfDeliveryTypeUsingId'][0])
    {

        // verify the required parameter 'way_of_delivery_type_id' is set
        if ($way_of_delivery_type_id === null || (is_array($way_of_delivery_type_id) && count($way_of_delivery_type_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $way_of_delivery_type_id when calling ordersPutWayOfDeliveryTypeUsingId'
            );
        }

        // verify the required parameter 'post_way_of_delivery_type_model' is set
        if ($post_way_of_delivery_type_model === null || (is_array($post_way_of_delivery_type_model) && count($post_way_of_delivery_type_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_way_of_delivery_type_model when calling ordersPutWayOfDeliveryTypeUsingId'
            );
        }


        $resourcePath = '/api/v1/orders/wayOfDeliveryTypes/{wayOfDeliveryTypeId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($way_of_delivery_type_id !== null) {
            $resourcePath = str_replace(
                '{' . 'wayOfDeliveryTypeId' . '}',
                ObjectSerializer::toPathValue($way_of_delivery_type_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_way_of_delivery_type_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_way_of_delivery_type_model));
            } else {
                $httpBody = $post_way_of_delivery_type_model;
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
