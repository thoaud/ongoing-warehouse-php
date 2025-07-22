<?php
/**
 * ReturnOrdersApi
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
 * ReturnOrdersApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class ReturnOrdersApi
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
        'returnOrdersDelete' => [
            'application/json',
        ],
        'returnOrdersDeleteByOrderNumber' => [
            'application/json',
        ],
        'returnOrdersGet' => [
            'application/json',
        ],
        'returnOrdersGetByReturnOrderId' => [
            'application/json',
        ],
        'returnOrdersGetOrderStatuses' => [
            'application/json',
        ],
        'returnOrdersGetReturnCauses' => [
            'application/json',
        ],
        'returnOrdersPatchStatus' => [
            'application/json',
        ],
        'returnOrdersPutReturnCause' => [
            'application/json',
        ],
        'returnOrdersPutReturnCauseUsingId' => [
            'application/json',
        ],
        'returnOrdersPutReturnOrder' => [
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
     * Operation returnOrdersDelete
     *
     * Cancel a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDelete'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostReturnOrderResponse
     */
    public function returnOrdersDelete($return_order_id, string $contentType = self::contentTypes['returnOrdersDelete'][0])
    {
        list($response) = $this->returnOrdersDeleteWithHttpInfo($return_order_id, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersDeleteWithHttpInfo
     *
     * Cancel a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDelete'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostReturnOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersDeleteWithHttpInfo($return_order_id, string $contentType = self::contentTypes['returnOrdersDelete'][0])
    {
        $request = $this->returnOrdersDeleteRequest($return_order_id, $contentType);

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
                    if ('\OngoingAPI\Model\PostReturnOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostReturnOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostReturnOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostReturnOrderResponse';
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
                        '\OngoingAPI\Model\PostReturnOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersDeleteAsync
     *
     * Cancel a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersDeleteAsync($return_order_id, string $contentType = self::contentTypes['returnOrdersDelete'][0])
    {
        return $this->returnOrdersDeleteAsyncWithHttpInfo($return_order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersDeleteAsyncWithHttpInfo
     *
     * Cancel a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersDeleteAsyncWithHttpInfo($return_order_id, string $contentType = self::contentTypes['returnOrdersDelete'][0])
    {
        $returnType = '\OngoingAPI\Model\PostReturnOrderResponse';
        $request = $this->returnOrdersDeleteRequest($return_order_id, $contentType);

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
     * Create request for operation 'returnOrdersDelete'
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDelete'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersDeleteRequest($return_order_id, string $contentType = self::contentTypes['returnOrdersDelete'][0])
    {

        // verify the required parameter 'return_order_id' is set
        if ($return_order_id === null || (is_array($return_order_id) && count($return_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $return_order_id when calling returnOrdersDelete'
            );
        }


        $resourcePath = '/api/v1/returnOrders/{returnOrderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($return_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'returnOrderId' . '}',
                ObjectSerializer::toPathValue($return_order_id),
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
     * Operation returnOrdersDeleteByOrderNumber
     *
     * Cancel a return order using the return order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $return_order_number Return order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostReturnOrderResponse
     */
    public function returnOrdersDeleteByOrderNumber($goods_owner_id, $return_order_number, string $contentType = self::contentTypes['returnOrdersDeleteByOrderNumber'][0])
    {
        list($response) = $this->returnOrdersDeleteByOrderNumberWithHttpInfo($goods_owner_id, $return_order_number, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersDeleteByOrderNumberWithHttpInfo
     *
     * Cancel a return order using the return order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $return_order_number Return order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostReturnOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersDeleteByOrderNumberWithHttpInfo($goods_owner_id, $return_order_number, string $contentType = self::contentTypes['returnOrdersDeleteByOrderNumber'][0])
    {
        $request = $this->returnOrdersDeleteByOrderNumberRequest($goods_owner_id, $return_order_number, $contentType);

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
                    if ('\OngoingAPI\Model\PostReturnOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostReturnOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostReturnOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostReturnOrderResponse';
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
                        '\OngoingAPI\Model\PostReturnOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersDeleteByOrderNumberAsync
     *
     * Cancel a return order using the return order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $return_order_number Return order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersDeleteByOrderNumberAsync($goods_owner_id, $return_order_number, string $contentType = self::contentTypes['returnOrdersDeleteByOrderNumber'][0])
    {
        return $this->returnOrdersDeleteByOrderNumberAsyncWithHttpInfo($goods_owner_id, $return_order_number, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersDeleteByOrderNumberAsyncWithHttpInfo
     *
     * Cancel a return order using the return order number.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $return_order_number Return order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersDeleteByOrderNumberAsyncWithHttpInfo($goods_owner_id, $return_order_number, string $contentType = self::contentTypes['returnOrdersDeleteByOrderNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\PostReturnOrderResponse';
        $request = $this->returnOrdersDeleteByOrderNumberRequest($goods_owner_id, $return_order_number, $contentType);

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
     * Create request for operation 'returnOrdersDeleteByOrderNumber'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $return_order_number Return order number. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersDeleteByOrderNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersDeleteByOrderNumberRequest($goods_owner_id, $return_order_number, string $contentType = self::contentTypes['returnOrdersDeleteByOrderNumber'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling returnOrdersDeleteByOrderNumber'
            );
        }

        // verify the required parameter 'return_order_number' is set
        if ($return_order_number === null || (is_array($return_order_number) && count($return_order_number) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $return_order_number when calling returnOrdersDeleteByOrderNumber'
            );
        }


        $resourcePath = '/api/v1/returnOrders';
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
            $return_order_number,
            'returnOrderNumber', // param base name
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
     * Operation returnOrdersGet
     *
     * Get a list of return orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID (required)
     * @param  string[] $return_order_numbers A list of return order numbers (optional)
     * @param  string[] $customer_order_numbers A list of customer order numbers (optional)
     * @param  \DateTime $goods_returned_from_date Only return orders where a return has been made after this date. (optional)
     * @param  int $return_order_status_from Only return orders whose return order status is greater than or equal to this. (optional)
     * @param  int $return_order_status_to Only return orders whose return order status is less than or equal to this. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetReturnOrderModel[]
     */
    public function returnOrdersGet($goods_owner_id, $return_order_numbers = null, $customer_order_numbers = null, $goods_returned_from_date = null, $return_order_status_from = null, $return_order_status_to = null, string $contentType = self::contentTypes['returnOrdersGet'][0])
    {
        list($response) = $this->returnOrdersGetWithHttpInfo($goods_owner_id, $return_order_numbers, $customer_order_numbers, $goods_returned_from_date, $return_order_status_from, $return_order_status_to, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersGetWithHttpInfo
     *
     * Get a list of return orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID (required)
     * @param  string[] $return_order_numbers A list of return order numbers (optional)
     * @param  string[] $customer_order_numbers A list of customer order numbers (optional)
     * @param  \DateTime $goods_returned_from_date Only return orders where a return has been made after this date. (optional)
     * @param  int $return_order_status_from Only return orders whose return order status is greater than or equal to this. (optional)
     * @param  int $return_order_status_to Only return orders whose return order status is less than or equal to this. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetReturnOrderModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersGetWithHttpInfo($goods_owner_id, $return_order_numbers = null, $customer_order_numbers = null, $goods_returned_from_date = null, $return_order_status_from = null, $return_order_status_to = null, string $contentType = self::contentTypes['returnOrdersGet'][0])
    {
        $request = $this->returnOrdersGetRequest($goods_owner_id, $return_order_numbers, $customer_order_numbers, $goods_returned_from_date, $return_order_status_from, $return_order_status_to, $contentType);

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
                    if ('\OngoingAPI\Model\GetReturnOrderModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetReturnOrderModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetReturnOrderModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetReturnOrderModel[]';
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
                        '\OngoingAPI\Model\GetReturnOrderModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersGetAsync
     *
     * Get a list of return orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID (required)
     * @param  string[] $return_order_numbers A list of return order numbers (optional)
     * @param  string[] $customer_order_numbers A list of customer order numbers (optional)
     * @param  \DateTime $goods_returned_from_date Only return orders where a return has been made after this date. (optional)
     * @param  int $return_order_status_from Only return orders whose return order status is greater than or equal to this. (optional)
     * @param  int $return_order_status_to Only return orders whose return order status is less than or equal to this. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetAsync($goods_owner_id, $return_order_numbers = null, $customer_order_numbers = null, $goods_returned_from_date = null, $return_order_status_from = null, $return_order_status_to = null, string $contentType = self::contentTypes['returnOrdersGet'][0])
    {
        return $this->returnOrdersGetAsyncWithHttpInfo($goods_owner_id, $return_order_numbers, $customer_order_numbers, $goods_returned_from_date, $return_order_status_from, $return_order_status_to, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersGetAsyncWithHttpInfo
     *
     * Get a list of return orders which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID (required)
     * @param  string[] $return_order_numbers A list of return order numbers (optional)
     * @param  string[] $customer_order_numbers A list of customer order numbers (optional)
     * @param  \DateTime $goods_returned_from_date Only return orders where a return has been made after this date. (optional)
     * @param  int $return_order_status_from Only return orders whose return order status is greater than or equal to this. (optional)
     * @param  int $return_order_status_to Only return orders whose return order status is less than or equal to this. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetAsyncWithHttpInfo($goods_owner_id, $return_order_numbers = null, $customer_order_numbers = null, $goods_returned_from_date = null, $return_order_status_from = null, $return_order_status_to = null, string $contentType = self::contentTypes['returnOrdersGet'][0])
    {
        $returnType = '\OngoingAPI\Model\GetReturnOrderModel[]';
        $request = $this->returnOrdersGetRequest($goods_owner_id, $return_order_numbers, $customer_order_numbers, $goods_returned_from_date, $return_order_status_from, $return_order_status_to, $contentType);

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
     * Create request for operation 'returnOrdersGet'
     *
     * @param  int $goods_owner_id Goods owner ID (required)
     * @param  string[] $return_order_numbers A list of return order numbers (optional)
     * @param  string[] $customer_order_numbers A list of customer order numbers (optional)
     * @param  \DateTime $goods_returned_from_date Only return orders where a return has been made after this date. (optional)
     * @param  int $return_order_status_from Only return orders whose return order status is greater than or equal to this. (optional)
     * @param  int $return_order_status_to Only return orders whose return order status is less than or equal to this. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersGetRequest($goods_owner_id, $return_order_numbers = null, $customer_order_numbers = null, $goods_returned_from_date = null, $return_order_status_from = null, $return_order_status_to = null, string $contentType = self::contentTypes['returnOrdersGet'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling returnOrdersGet'
            );
        }

        $resourcePath = '/api/v1/returnOrders';
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
            $return_order_numbers,
            'returnOrderNumbers', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $customer_order_numbers,
            'customerOrderNumbers', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $goods_returned_from_date,
            'goodsReturnedFromDate', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $return_order_status_from,
            'returnOrderStatusFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $return_order_status_to,
            'returnOrderStatusTo', // param base name
            'integer', // openApiType
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
     * Operation returnOrdersGetByReturnOrderId
     *
     * Get a return order using the return order ID.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetByReturnOrderId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetReturnOrderModel
     */
    public function returnOrdersGetByReturnOrderId($return_order_id, string $contentType = self::contentTypes['returnOrdersGetByReturnOrderId'][0])
    {
        list($response) = $this->returnOrdersGetByReturnOrderIdWithHttpInfo($return_order_id, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersGetByReturnOrderIdWithHttpInfo
     *
     * Get a return order using the return order ID.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetByReturnOrderId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetReturnOrderModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersGetByReturnOrderIdWithHttpInfo($return_order_id, string $contentType = self::contentTypes['returnOrdersGetByReturnOrderId'][0])
    {
        $request = $this->returnOrdersGetByReturnOrderIdRequest($return_order_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetReturnOrderModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetReturnOrderModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetReturnOrderModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetReturnOrderModel';
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
                        '\OngoingAPI\Model\GetReturnOrderModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersGetByReturnOrderIdAsync
     *
     * Get a return order using the return order ID.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetByReturnOrderId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetByReturnOrderIdAsync($return_order_id, string $contentType = self::contentTypes['returnOrdersGetByReturnOrderId'][0])
    {
        return $this->returnOrdersGetByReturnOrderIdAsyncWithHttpInfo($return_order_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersGetByReturnOrderIdAsyncWithHttpInfo
     *
     * Get a return order using the return order ID.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetByReturnOrderId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetByReturnOrderIdAsyncWithHttpInfo($return_order_id, string $contentType = self::contentTypes['returnOrdersGetByReturnOrderId'][0])
    {
        $returnType = '\OngoingAPI\Model\GetReturnOrderModel';
        $request = $this->returnOrdersGetByReturnOrderIdRequest($return_order_id, $contentType);

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
     * Create request for operation 'returnOrdersGetByReturnOrderId'
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetByReturnOrderId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersGetByReturnOrderIdRequest($return_order_id, string $contentType = self::contentTypes['returnOrdersGetByReturnOrderId'][0])
    {

        // verify the required parameter 'return_order_id' is set
        if ($return_order_id === null || (is_array($return_order_id) && count($return_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $return_order_id when calling returnOrdersGetByReturnOrderId'
            );
        }


        $resourcePath = '/api/v1/returnOrders/{returnOrderId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($return_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'returnOrderId' . '}',
                ObjectSerializer::toPathValue($return_order_id),
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
     * Operation returnOrdersGetOrderStatuses
     *
     * Get all return order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetReturnOrderStatusesModel
     */
    public function returnOrdersGetOrderStatuses(string $contentType = self::contentTypes['returnOrdersGetOrderStatuses'][0])
    {
        list($response) = $this->returnOrdersGetOrderStatusesWithHttpInfo($contentType);
        return $response;
    }

    /**
     * Operation returnOrdersGetOrderStatusesWithHttpInfo
     *
     * Get all return order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetReturnOrderStatusesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersGetOrderStatusesWithHttpInfo(string $contentType = self::contentTypes['returnOrdersGetOrderStatuses'][0])
    {
        $request = $this->returnOrdersGetOrderStatusesRequest($contentType);

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
                    if ('\OngoingAPI\Model\GetReturnOrderStatusesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetReturnOrderStatusesModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetReturnOrderStatusesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetReturnOrderStatusesModel';
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
                        '\OngoingAPI\Model\GetReturnOrderStatusesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersGetOrderStatusesAsync
     *
     * Get all return order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetOrderStatusesAsync(string $contentType = self::contentTypes['returnOrdersGetOrderStatuses'][0])
    {
        return $this->returnOrdersGetOrderStatusesAsyncWithHttpInfo($contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersGetOrderStatusesAsyncWithHttpInfo
     *
     * Get all return order statuses.
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetOrderStatusesAsyncWithHttpInfo(string $contentType = self::contentTypes['returnOrdersGetOrderStatuses'][0])
    {
        $returnType = '\OngoingAPI\Model\GetReturnOrderStatusesModel';
        $request = $this->returnOrdersGetOrderStatusesRequest($contentType);

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
     * Create request for operation 'returnOrdersGetOrderStatuses'
     *
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetOrderStatuses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersGetOrderStatusesRequest(string $contentType = self::contentTypes['returnOrdersGetOrderStatuses'][0])
    {


        $resourcePath = '/api/v1/returnOrders/statuses';
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
     * Operation returnOrdersGetReturnCauses
     *
     * Get all return causes.
     *
     * @param  int $goods_owner_id goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetReturnCauses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetReturnCausesModel
     */
    public function returnOrdersGetReturnCauses($goods_owner_id, string $contentType = self::contentTypes['returnOrdersGetReturnCauses'][0])
    {
        list($response) = $this->returnOrdersGetReturnCausesWithHttpInfo($goods_owner_id, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersGetReturnCausesWithHttpInfo
     *
     * Get all return causes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetReturnCauses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetReturnCausesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersGetReturnCausesWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['returnOrdersGetReturnCauses'][0])
    {
        $request = $this->returnOrdersGetReturnCausesRequest($goods_owner_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetReturnCausesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetReturnCausesModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetReturnCausesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetReturnCausesModel';
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
                        '\OngoingAPI\Model\GetReturnCausesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersGetReturnCausesAsync
     *
     * Get all return causes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetReturnCauses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetReturnCausesAsync($goods_owner_id, string $contentType = self::contentTypes['returnOrdersGetReturnCauses'][0])
    {
        return $this->returnOrdersGetReturnCausesAsyncWithHttpInfo($goods_owner_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersGetReturnCausesAsyncWithHttpInfo
     *
     * Get all return causes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetReturnCauses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersGetReturnCausesAsyncWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['returnOrdersGetReturnCauses'][0])
    {
        $returnType = '\OngoingAPI\Model\GetReturnCausesModel';
        $request = $this->returnOrdersGetReturnCausesRequest($goods_owner_id, $contentType);

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
     * Create request for operation 'returnOrdersGetReturnCauses'
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersGetReturnCauses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersGetReturnCausesRequest($goods_owner_id, string $contentType = self::contentTypes['returnOrdersGetReturnCauses'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling returnOrdersGetReturnCauses'
            );
        }


        $resourcePath = '/api/v1/returnOrders/returnCauses';
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
     * Operation returnOrdersPatchStatus
     *
     * Update the status of a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  \OngoingAPI\Model\PatchReturnOrderStatus $patch_return_order_status Object containing the new return order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchReturnOrderResponse
     */
    public function returnOrdersPatchStatus($return_order_id, $patch_return_order_status, string $contentType = self::contentTypes['returnOrdersPatchStatus'][0])
    {
        list($response) = $this->returnOrdersPatchStatusWithHttpInfo($return_order_id, $patch_return_order_status, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersPatchStatusWithHttpInfo
     *
     * Update the status of a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  \OngoingAPI\Model\PatchReturnOrderStatus $patch_return_order_status Object containing the new return order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchReturnOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersPatchStatusWithHttpInfo($return_order_id, $patch_return_order_status, string $contentType = self::contentTypes['returnOrdersPatchStatus'][0])
    {
        $request = $this->returnOrdersPatchStatusRequest($return_order_id, $patch_return_order_status, $contentType);

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
                    if ('\OngoingAPI\Model\PatchReturnOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchReturnOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchReturnOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchReturnOrderResponse';
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
                        '\OngoingAPI\Model\PatchReturnOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersPatchStatusAsync
     *
     * Update the status of a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  \OngoingAPI\Model\PatchReturnOrderStatus $patch_return_order_status Object containing the new return order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPatchStatusAsync($return_order_id, $patch_return_order_status, string $contentType = self::contentTypes['returnOrdersPatchStatus'][0])
    {
        return $this->returnOrdersPatchStatusAsyncWithHttpInfo($return_order_id, $patch_return_order_status, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersPatchStatusAsyncWithHttpInfo
     *
     * Update the status of a return order.
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  \OngoingAPI\Model\PatchReturnOrderStatus $patch_return_order_status Object containing the new return order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPatchStatusAsyncWithHttpInfo($return_order_id, $patch_return_order_status, string $contentType = self::contentTypes['returnOrdersPatchStatus'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchReturnOrderResponse';
        $request = $this->returnOrdersPatchStatusRequest($return_order_id, $patch_return_order_status, $contentType);

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
     * Create request for operation 'returnOrdersPatchStatus'
     *
     * @param  int $return_order_id Return order ID. (required)
     * @param  \OngoingAPI\Model\PatchReturnOrderStatus $patch_return_order_status Object containing the new return order status. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPatchStatus'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersPatchStatusRequest($return_order_id, $patch_return_order_status, string $contentType = self::contentTypes['returnOrdersPatchStatus'][0])
    {

        // verify the required parameter 'return_order_id' is set
        if ($return_order_id === null || (is_array($return_order_id) && count($return_order_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $return_order_id when calling returnOrdersPatchStatus'
            );
        }

        // verify the required parameter 'patch_return_order_status' is set
        if ($patch_return_order_status === null || (is_array($patch_return_order_status) && count($patch_return_order_status) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $patch_return_order_status when calling returnOrdersPatchStatus'
            );
        }


        $resourcePath = '/api/v1/returnOrders/{returnOrderId}/returnOrderStatus';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($return_order_id !== null) {
            $resourcePath = str_replace(
                '{' . 'returnOrderId' . '}',
                ObjectSerializer::toPathValue($return_order_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($patch_return_order_status)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($patch_return_order_status));
            } else {
                $httpBody = $patch_return_order_status;
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
     * Operation returnOrdersPutReturnCause
     *
     * Create or update a return cause type. If there is no return cause with the specified code, it will be created. Otherwise, the existing return cause will be updated.
     *
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCause'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostReturnCauseResponse
     */
    public function returnOrdersPutReturnCause($post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCause'][0])
    {
        list($response) = $this->returnOrdersPutReturnCauseWithHttpInfo($post_return_cause_model, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersPutReturnCauseWithHttpInfo
     *
     * Create or update a return cause type. If there is no return cause with the specified code, it will be created. Otherwise, the existing return cause will be updated.
     *
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCause'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostReturnCauseResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersPutReturnCauseWithHttpInfo($post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCause'][0])
    {
        $request = $this->returnOrdersPutReturnCauseRequest($post_return_cause_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostReturnCauseResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostReturnCauseResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostReturnCauseResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostReturnCauseResponse';
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
                        '\OngoingAPI\Model\PostReturnCauseResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersPutReturnCauseAsync
     *
     * Create or update a return cause type. If there is no return cause with the specified code, it will be created. Otherwise, the existing return cause will be updated.
     *
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCause'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPutReturnCauseAsync($post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCause'][0])
    {
        return $this->returnOrdersPutReturnCauseAsyncWithHttpInfo($post_return_cause_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersPutReturnCauseAsyncWithHttpInfo
     *
     * Create or update a return cause type. If there is no return cause with the specified code, it will be created. Otherwise, the existing return cause will be updated.
     *
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCause'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPutReturnCauseAsyncWithHttpInfo($post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCause'][0])
    {
        $returnType = '\OngoingAPI\Model\PostReturnCauseResponse';
        $request = $this->returnOrdersPutReturnCauseRequest($post_return_cause_model, $contentType);

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
     * Create request for operation 'returnOrdersPutReturnCause'
     *
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCause'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersPutReturnCauseRequest($post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCause'][0])
    {

        // verify the required parameter 'post_return_cause_model' is set
        if ($post_return_cause_model === null || (is_array($post_return_cause_model) && count($post_return_cause_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_return_cause_model when calling returnOrdersPutReturnCause'
            );
        }


        $resourcePath = '/api/v1/returnOrders/returnCauses';
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
        if (isset($post_return_cause_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_return_cause_model));
            } else {
                $httpBody = $post_return_cause_model;
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
     * Operation returnOrdersPutReturnCauseUsingId
     *
     * Update a return cause. The ID will be used to identify the return cause.
     *
     * @param  int $return_cause_id return_cause_id (required)
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCauseUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostReturnCauseResponse
     */
    public function returnOrdersPutReturnCauseUsingId($return_cause_id, $post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCauseUsingId'][0])
    {
        list($response) = $this->returnOrdersPutReturnCauseUsingIdWithHttpInfo($return_cause_id, $post_return_cause_model, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersPutReturnCauseUsingIdWithHttpInfo
     *
     * Update a return cause. The ID will be used to identify the return cause.
     *
     * @param  int $return_cause_id (required)
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCauseUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostReturnCauseResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersPutReturnCauseUsingIdWithHttpInfo($return_cause_id, $post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCauseUsingId'][0])
    {
        $request = $this->returnOrdersPutReturnCauseUsingIdRequest($return_cause_id, $post_return_cause_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostReturnCauseResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostReturnCauseResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostReturnCauseResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostReturnCauseResponse';
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
                        '\OngoingAPI\Model\PostReturnCauseResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersPutReturnCauseUsingIdAsync
     *
     * Update a return cause. The ID will be used to identify the return cause.
     *
     * @param  int $return_cause_id (required)
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCauseUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPutReturnCauseUsingIdAsync($return_cause_id, $post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCauseUsingId'][0])
    {
        return $this->returnOrdersPutReturnCauseUsingIdAsyncWithHttpInfo($return_cause_id, $post_return_cause_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersPutReturnCauseUsingIdAsyncWithHttpInfo
     *
     * Update a return cause. The ID will be used to identify the return cause.
     *
     * @param  int $return_cause_id (required)
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCauseUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPutReturnCauseUsingIdAsyncWithHttpInfo($return_cause_id, $post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCauseUsingId'][0])
    {
        $returnType = '\OngoingAPI\Model\PostReturnCauseResponse';
        $request = $this->returnOrdersPutReturnCauseUsingIdRequest($return_cause_id, $post_return_cause_model, $contentType);

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
     * Create request for operation 'returnOrdersPutReturnCauseUsingId'
     *
     * @param  int $return_cause_id (required)
     * @param  \OngoingAPI\Model\PostReturnCauseModel $post_return_cause_model An object containing the return cause type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnCauseUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersPutReturnCauseUsingIdRequest($return_cause_id, $post_return_cause_model, string $contentType = self::contentTypes['returnOrdersPutReturnCauseUsingId'][0])
    {

        // verify the required parameter 'return_cause_id' is set
        if ($return_cause_id === null || (is_array($return_cause_id) && count($return_cause_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $return_cause_id when calling returnOrdersPutReturnCauseUsingId'
            );
        }

        // verify the required parameter 'post_return_cause_model' is set
        if ($post_return_cause_model === null || (is_array($post_return_cause_model) && count($post_return_cause_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_return_cause_model when calling returnOrdersPutReturnCauseUsingId'
            );
        }


        $resourcePath = '/api/v1/returnOrders/returnCauses/{returnCauseId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($return_cause_id !== null) {
            $resourcePath = str_replace(
                '{' . 'returnCauseId' . '}',
                ObjectSerializer::toPathValue($return_cause_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_return_cause_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_return_cause_model));
            } else {
                $httpBody = $post_return_cause_model;
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
     * Operation returnOrdersPutReturnOrder
     *
     * Create or update a return order.
     *
     * @param  \OngoingAPI\Model\PostReturnOrderModel $post_return_order_model The return order. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnOrder'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostReturnOrderResponse
     */
    public function returnOrdersPutReturnOrder($post_return_order_model, string $contentType = self::contentTypes['returnOrdersPutReturnOrder'][0])
    {
        list($response) = $this->returnOrdersPutReturnOrderWithHttpInfo($post_return_order_model, $contentType);
        return $response;
    }

    /**
     * Operation returnOrdersPutReturnOrderWithHttpInfo
     *
     * Create or update a return order.
     *
     * @param  \OngoingAPI\Model\PostReturnOrderModel $post_return_order_model The return order. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnOrder'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostReturnOrderResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function returnOrdersPutReturnOrderWithHttpInfo($post_return_order_model, string $contentType = self::contentTypes['returnOrdersPutReturnOrder'][0])
    {
        $request = $this->returnOrdersPutReturnOrderRequest($post_return_order_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostReturnOrderResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostReturnOrderResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostReturnOrderResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostReturnOrderResponse';
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
                        '\OngoingAPI\Model\PostReturnOrderResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation returnOrdersPutReturnOrderAsync
     *
     * Create or update a return order.
     *
     * @param  \OngoingAPI\Model\PostReturnOrderModel $post_return_order_model The return order. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPutReturnOrderAsync($post_return_order_model, string $contentType = self::contentTypes['returnOrdersPutReturnOrder'][0])
    {
        return $this->returnOrdersPutReturnOrderAsyncWithHttpInfo($post_return_order_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation returnOrdersPutReturnOrderAsyncWithHttpInfo
     *
     * Create or update a return order.
     *
     * @param  \OngoingAPI\Model\PostReturnOrderModel $post_return_order_model The return order. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function returnOrdersPutReturnOrderAsyncWithHttpInfo($post_return_order_model, string $contentType = self::contentTypes['returnOrdersPutReturnOrder'][0])
    {
        $returnType = '\OngoingAPI\Model\PostReturnOrderResponse';
        $request = $this->returnOrdersPutReturnOrderRequest($post_return_order_model, $contentType);

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
     * Create request for operation 'returnOrdersPutReturnOrder'
     *
     * @param  \OngoingAPI\Model\PostReturnOrderModel $post_return_order_model The return order. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['returnOrdersPutReturnOrder'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function returnOrdersPutReturnOrderRequest($post_return_order_model, string $contentType = self::contentTypes['returnOrdersPutReturnOrder'][0])
    {

        // verify the required parameter 'post_return_order_model' is set
        if ($post_return_order_model === null || (is_array($post_return_order_model) && count($post_return_order_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_return_order_model when calling returnOrdersPutReturnOrder'
            );
        }


        $resourcePath = '/api/v1/returnOrders';
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
        if (isset($post_return_order_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_return_order_model));
            } else {
                $httpBody = $post_return_order_model;
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
