<?php
/**
 * InventoryAdjustmentsApi
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
 * InventoryAdjustmentsApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class InventoryAdjustmentsApi
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
        'inventoryAdjustmentsGet' => [
            'application/json',
        ],
        'inventoryAdjustmentsGetAll' => [
            'application/json',
        ],
        'inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported' => [
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
     * Operation inventoryAdjustmentsGet
     *
     * Get a specific inventory adjustment.
     *
     * @param  int $inventory_id The ID of the inventory adjustment. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetInventoryAdjustmentsLine
     */
    public function inventoryAdjustmentsGet($inventory_id, string $contentType = self::contentTypes['inventoryAdjustmentsGet'][0])
    {
        list($response) = $this->inventoryAdjustmentsGetWithHttpInfo($inventory_id, $contentType);
        return $response;
    }

    /**
     * Operation inventoryAdjustmentsGetWithHttpInfo
     *
     * Get a specific inventory adjustment.
     *
     * @param  int $inventory_id The ID of the inventory adjustment. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetInventoryAdjustmentsLine, HTTP status code, HTTP response headers (array of strings)
     */
    public function inventoryAdjustmentsGetWithHttpInfo($inventory_id, string $contentType = self::contentTypes['inventoryAdjustmentsGet'][0])
    {
        $request = $this->inventoryAdjustmentsGetRequest($inventory_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetInventoryAdjustmentsLine' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetInventoryAdjustmentsLine' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetInventoryAdjustmentsLine', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetInventoryAdjustmentsLine';
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
                        '\OngoingAPI\Model\GetInventoryAdjustmentsLine',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation inventoryAdjustmentsGetAsync
     *
     * Get a specific inventory adjustment.
     *
     * @param  int $inventory_id The ID of the inventory adjustment. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function inventoryAdjustmentsGetAsync($inventory_id, string $contentType = self::contentTypes['inventoryAdjustmentsGet'][0])
    {
        return $this->inventoryAdjustmentsGetAsyncWithHttpInfo($inventory_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation inventoryAdjustmentsGetAsyncWithHttpInfo
     *
     * Get a specific inventory adjustment.
     *
     * @param  int $inventory_id The ID of the inventory adjustment. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function inventoryAdjustmentsGetAsyncWithHttpInfo($inventory_id, string $contentType = self::contentTypes['inventoryAdjustmentsGet'][0])
    {
        $returnType = '\OngoingAPI\Model\GetInventoryAdjustmentsLine';
        $request = $this->inventoryAdjustmentsGetRequest($inventory_id, $contentType);

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
     * Create request for operation 'inventoryAdjustmentsGet'
     *
     * @param  int $inventory_id The ID of the inventory adjustment. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function inventoryAdjustmentsGetRequest($inventory_id, string $contentType = self::contentTypes['inventoryAdjustmentsGet'][0])
    {

        // verify the required parameter 'inventory_id' is set
        if ($inventory_id === null || (is_array($inventory_id) && count($inventory_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $inventory_id when calling inventoryAdjustmentsGet'
            );
        }


        $resourcePath = '/api/v1/inventoryAdjustments/{inventoryId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($inventory_id !== null) {
            $resourcePath = str_replace(
                '{' . 'inventoryId' . '}',
                ObjectSerializer::toPathValue($inventory_id),
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
     * Operation inventoryAdjustmentsGetAll
     *
     * Get all inventory adjustments which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $from The &#39;from&#39; time. If specified, returns inventory adjustments which were made after this time. (optional)
     * @param  \DateTime $to Obsolete, do not use. (optional)
     * @param  \DateTime $to_time The &#39;to&#39; time. If specified, returns inventory adjustments which were made before this time. (optional)
     * @param  bool $is_reported Only return inventory adjustments which have not been marked as &#39;reported&#39;. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetInventoryAdjustmentsLine[]
     */
    public function inventoryAdjustmentsGetAll($goods_owner_id, $from = null, $to = null, $to_time = null, $is_reported = null, string $contentType = self::contentTypes['inventoryAdjustmentsGetAll'][0])
    {
        list($response) = $this->inventoryAdjustmentsGetAllWithHttpInfo($goods_owner_id, $from, $to, $to_time, $is_reported, $contentType);
        return $response;
    }

    /**
     * Operation inventoryAdjustmentsGetAllWithHttpInfo
     *
     * Get all inventory adjustments which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $from The &#39;from&#39; time. If specified, returns inventory adjustments which were made after this time. (optional)
     * @param  \DateTime $to Obsolete, do not use. (optional)
     * @param  \DateTime $to_time The &#39;to&#39; time. If specified, returns inventory adjustments which were made before this time. (optional)
     * @param  bool $is_reported Only return inventory adjustments which have not been marked as &#39;reported&#39;. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetInventoryAdjustmentsLine[], HTTP status code, HTTP response headers (array of strings)
     */
    public function inventoryAdjustmentsGetAllWithHttpInfo($goods_owner_id, $from = null, $to = null, $to_time = null, $is_reported = null, string $contentType = self::contentTypes['inventoryAdjustmentsGetAll'][0])
    {
        $request = $this->inventoryAdjustmentsGetAllRequest($goods_owner_id, $from, $to, $to_time, $is_reported, $contentType);

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
                    if ('\OngoingAPI\Model\GetInventoryAdjustmentsLine[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetInventoryAdjustmentsLine[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetInventoryAdjustmentsLine[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetInventoryAdjustmentsLine[]';
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
                        '\OngoingAPI\Model\GetInventoryAdjustmentsLine[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation inventoryAdjustmentsGetAllAsync
     *
     * Get all inventory adjustments which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $from The &#39;from&#39; time. If specified, returns inventory adjustments which were made after this time. (optional)
     * @param  \DateTime $to Obsolete, do not use. (optional)
     * @param  \DateTime $to_time The &#39;to&#39; time. If specified, returns inventory adjustments which were made before this time. (optional)
     * @param  bool $is_reported Only return inventory adjustments which have not been marked as &#39;reported&#39;. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function inventoryAdjustmentsGetAllAsync($goods_owner_id, $from = null, $to = null, $to_time = null, $is_reported = null, string $contentType = self::contentTypes['inventoryAdjustmentsGetAll'][0])
    {
        return $this->inventoryAdjustmentsGetAllAsyncWithHttpInfo($goods_owner_id, $from, $to, $to_time, $is_reported, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation inventoryAdjustmentsGetAllAsyncWithHttpInfo
     *
     * Get all inventory adjustments which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $from The &#39;from&#39; time. If specified, returns inventory adjustments which were made after this time. (optional)
     * @param  \DateTime $to Obsolete, do not use. (optional)
     * @param  \DateTime $to_time The &#39;to&#39; time. If specified, returns inventory adjustments which were made before this time. (optional)
     * @param  bool $is_reported Only return inventory adjustments which have not been marked as &#39;reported&#39;. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function inventoryAdjustmentsGetAllAsyncWithHttpInfo($goods_owner_id, $from = null, $to = null, $to_time = null, $is_reported = null, string $contentType = self::contentTypes['inventoryAdjustmentsGetAll'][0])
    {
        $returnType = '\OngoingAPI\Model\GetInventoryAdjustmentsLine[]';
        $request = $this->inventoryAdjustmentsGetAllRequest($goods_owner_id, $from, $to, $to_time, $is_reported, $contentType);

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
     * Create request for operation 'inventoryAdjustmentsGetAll'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $from The &#39;from&#39; time. If specified, returns inventory adjustments which were made after this time. (optional)
     * @param  \DateTime $to Obsolete, do not use. (optional)
     * @param  \DateTime $to_time The &#39;to&#39; time. If specified, returns inventory adjustments which were made before this time. (optional)
     * @param  bool $is_reported Only return inventory adjustments which have not been marked as &#39;reported&#39;. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function inventoryAdjustmentsGetAllRequest($goods_owner_id, $from = null, $to = null, $to_time = null, $is_reported = null, string $contentType = self::contentTypes['inventoryAdjustmentsGetAll'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling inventoryAdjustmentsGetAll'
            );
        }






        $resourcePath = '/api/v1/inventoryAdjustments';
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
            $from,
            'from', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $to,
            'to', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $to_time,
            'toTime', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $is_reported,
            'isReported', // param base name
            'boolean', // openApiType
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
     * Operation inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported
     *
     * Sets the &#39;reported&#39; flag on an inventory to true for the specified article.
     *
     * @param  int $inventory_id Inventory ID. (required)
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse
     */
    public function inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported($inventory_id, $article_system_id, string $contentType = self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'][0])
    {
        list($response) = $this->inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedWithHttpInfo($inventory_id, $article_system_id, $contentType);
        return $response;
    }

    /**
     * Operation inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedWithHttpInfo
     *
     * Sets the &#39;reported&#39; flag on an inventory to true for the specified article.
     *
     * @param  int $inventory_id Inventory ID. (required)
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedWithHttpInfo($inventory_id, $article_system_id, string $contentType = self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'][0])
    {
        $request = $this->inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedRequest($inventory_id, $article_system_id, $contentType);

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
                    if ('\OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse';
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
                        '\OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedAsync
     *
     * Sets the &#39;reported&#39; flag on an inventory to true for the specified article.
     *
     * @param  int $inventory_id Inventory ID. (required)
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedAsync($inventory_id, $article_system_id, string $contentType = self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'][0])
    {
        return $this->inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedAsyncWithHttpInfo($inventory_id, $article_system_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedAsyncWithHttpInfo
     *
     * Sets the &#39;reported&#39; flag on an inventory to true for the specified article.
     *
     * @param  int $inventory_id Inventory ID. (required)
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedAsyncWithHttpInfo($inventory_id, $article_system_id, string $contentType = self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'][0])
    {
        $returnType = '\OngoingAPI\Model\PatchInventoryAdjustmentArticlesReportedResponse';
        $request = $this->inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedRequest($inventory_id, $article_system_id, $contentType);

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
     * Create request for operation 'inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'
     *
     * @param  int $inventory_id Inventory ID. (required)
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function inventoryAdjustmentsPatchInventoryAdjustmentArticlesReportedRequest($inventory_id, $article_system_id, string $contentType = self::contentTypes['inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'][0])
    {

        // verify the required parameter 'inventory_id' is set
        if ($inventory_id === null || (is_array($inventory_id) && count($inventory_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $inventory_id when calling inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'
            );
        }

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling inventoryAdjustmentsPatchInventoryAdjustmentArticlesReported'
            );
        }


        $resourcePath = '/api/v1/inventoryAdjustments/{inventoryId}/articles/{articleSystemId}/setReported';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($inventory_id !== null) {
            $resourcePath = str_replace(
                '{' . 'inventoryId' . '}',
                ObjectSerializer::toPathValue($inventory_id),
                $resourcePath
            );
        }
        // path params
        if ($article_system_id !== null) {
            $resourcePath = str_replace(
                '{' . 'articleSystemId' . '}',
                ObjectSerializer::toPathValue($article_system_id),
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
