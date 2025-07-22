<?php
/**
 * ArticlesApi
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
 * ArticlesApi Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class ArticlesApi
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
        'articlesDeleteArticleClass' => [
            'application/json',
        ],
        'articlesGet' => [
            'application/json',
        ],
        'articlesGetAll' => [
            'application/json',
        ],
        'articlesGetArticleClasses' => [
            'application/json',
        ],
        'articlesGetDangerousGoods' => [
            'application/json',
        ],
        'articlesGetDangerousGoodsByArticleNumber' => [
            'application/json',
        ],
        'articlesGetFiles' => [
            'application/json',
        ],
        'articlesGetHistoricalInventory' => [
            'application/json',
        ],
        'articlesGetInventoryPerWarehouse' => [
            'application/json',
        ],
        'articlesGetStructureRows' => [
            'application/json',
        ],
        'articlesGetStructureRowsByArticleNumber' => [
            'application/json',
        ],
        'articlesPost' => [
            'application/json',
        ],
        'articlesPut' => [
            'application/json',
        ],
        'articlesPut2' => [
            'application/json',
        ],
        'articlesPut3' => [
            'application/json',
        ],
        'articlesPutArticleClass' => [
            'application/json',
        ],
        'articlesPutArticleClassUsingId' => [
            'application/json',
        ],
        'articlesPutDangerousGoods' => [
            'application/json',
        ],
        'articlesPutDangerousGoodsByArticleNumber' => [
            'application/json',
        ],
        'articlesPutFileUsingFilename' => [
            'application/json',
        ],
        'articlesSetArticleClasses' => [
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
     * Operation articlesDeleteArticleClass
     *
     * Delete an article class. This will affect any articles which have previously been assigned to the class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesDeleteArticleClass'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostArticleClassResponse
     */
    public function articlesDeleteArticleClass($article_class_id, string $contentType = self::contentTypes['articlesDeleteArticleClass'][0])
    {
        list($response) = $this->articlesDeleteArticleClassWithHttpInfo($article_class_id, $contentType);
        return $response;
    }

    /**
     * Operation articlesDeleteArticleClassWithHttpInfo
     *
     * Delete an article class. This will affect any articles which have previously been assigned to the class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesDeleteArticleClass'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostArticleClassResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesDeleteArticleClassWithHttpInfo($article_class_id, string $contentType = self::contentTypes['articlesDeleteArticleClass'][0])
    {
        $request = $this->articlesDeleteArticleClassRequest($article_class_id, $contentType);

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
                    if ('\OngoingAPI\Model\PostArticleClassResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostArticleClassResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostArticleClassResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostArticleClassResponse';
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
                        '\OngoingAPI\Model\PostArticleClassResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesDeleteArticleClassAsync
     *
     * Delete an article class. This will affect any articles which have previously been assigned to the class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesDeleteArticleClass'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesDeleteArticleClassAsync($article_class_id, string $contentType = self::contentTypes['articlesDeleteArticleClass'][0])
    {
        return $this->articlesDeleteArticleClassAsyncWithHttpInfo($article_class_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesDeleteArticleClassAsyncWithHttpInfo
     *
     * Delete an article class. This will affect any articles which have previously been assigned to the class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesDeleteArticleClass'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesDeleteArticleClassAsyncWithHttpInfo($article_class_id, string $contentType = self::contentTypes['articlesDeleteArticleClass'][0])
    {
        $returnType = '\OngoingAPI\Model\PostArticleClassResponse';
        $request = $this->articlesDeleteArticleClassRequest($article_class_id, $contentType);

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
     * Create request for operation 'articlesDeleteArticleClass'
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesDeleteArticleClass'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesDeleteArticleClassRequest($article_class_id, string $contentType = self::contentTypes['articlesDeleteArticleClass'][0])
    {

        // verify the required parameter 'article_class_id' is set
        if ($article_class_id === null || (is_array($article_class_id) && count($article_class_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_class_id when calling articlesDeleteArticleClass'
            );
        }


        $resourcePath = '/api/v1/articles/classes/{articleClassId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($article_class_id !== null) {
            $resourcePath = str_replace(
                '{' . 'articleClassId' . '}',
                ObjectSerializer::toPathValue($article_class_id),
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
     * Operation articlesGet
     *
     * Get an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleModel
     */
    public function articlesGet($article_system_id, string $contentType = self::contentTypes['articlesGet'][0])
    {
        list($response) = $this->articlesGetWithHttpInfo($article_system_id, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetWithHttpInfo
     *
     * Get an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGet'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGet'][0])
    {
        $request = $this->articlesGetRequest($article_system_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleModel';
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
                        '\OngoingAPI\Model\GetArticleModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetAsync
     *
     * Get an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetAsync($article_system_id, string $contentType = self::contentTypes['articlesGet'][0])
    {
        return $this->articlesGetAsyncWithHttpInfo($article_system_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetAsyncWithHttpInfo
     *
     * Get an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetAsyncWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGet'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleModel';
        $request = $this->articlesGetRequest($article_system_id, $contentType);

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
     * Create request for operation 'articlesGet'
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGet'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetRequest($article_system_id, string $contentType = self::contentTypes['articlesGet'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesGet'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation articlesGetAll
     *
     * Get all articles which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_number Article number. (optional)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock balances have changed after this time. NOTE: this value must must be within 24 hours of the current time. (optional)
     * @param  string[] $article_numbers article_numbers (optional)
     * @param  \DateTime $article_data_last_updated_from Only return articles where the article data has changed after this time. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are actually in stock (i.e. those articles having numberOfItems &gt; 0). (optional)
     * @param  string $product_code Product code. (optional)
     * @param  string[] $product_codes product_codes (optional)
     * @param  string[] $article_name_contains article_name_contains (optional)
     * @param  int[] $article_class_ids Only return articles of these article classes. (optional)
     * @param  string[] $bar_codes bar_codes (optional)
     * @param  bool $only_articles_below_stock_limit Only return articles whose physical quantity is below the stock limit. (optional)
     * @param  bool $only_articles_below_stock_limit_considering_number_of_booked_items Only return articles which have \&quot;physical quantity minus booked quantity\&quot; below the stock limit. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleModel[]
     */
    public function articlesGetAll($goods_owner_id, $article_number = null, $article_system_id_from = null, $max_articles_to_get = null, $stock_info_changed_from = null, $article_numbers = null, $article_data_last_updated_from = null, $only_articles_in_stock = null, $product_code = null, $product_codes = null, $article_name_contains = null, $article_class_ids = null, $bar_codes = null, $only_articles_below_stock_limit = null, $only_articles_below_stock_limit_considering_number_of_booked_items = null, string $contentType = self::contentTypes['articlesGetAll'][0])
    {
        list($response) = $this->articlesGetAllWithHttpInfo($goods_owner_id, $article_number, $article_system_id_from, $max_articles_to_get, $stock_info_changed_from, $article_numbers, $article_data_last_updated_from, $only_articles_in_stock, $product_code, $product_codes, $article_name_contains, $article_class_ids, $bar_codes, $only_articles_below_stock_limit, $only_articles_below_stock_limit_considering_number_of_booked_items, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetAllWithHttpInfo
     *
     * Get all articles which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_number Article number. (optional)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock balances have changed after this time. NOTE: this value must must be within 24 hours of the current time. (optional)
     * @param  string[] $article_numbers (optional)
     * @param  \DateTime $article_data_last_updated_from Only return articles where the article data has changed after this time. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are actually in stock (i.e. those articles having numberOfItems &gt; 0). (optional)
     * @param  string $product_code Product code. (optional)
     * @param  string[] $product_codes (optional)
     * @param  string[] $article_name_contains (optional)
     * @param  int[] $article_class_ids Only return articles of these article classes. (optional)
     * @param  string[] $bar_codes (optional)
     * @param  bool $only_articles_below_stock_limit Only return articles whose physical quantity is below the stock limit. (optional)
     * @param  bool $only_articles_below_stock_limit_considering_number_of_booked_items Only return articles which have \&quot;physical quantity minus booked quantity\&quot; below the stock limit. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetAll'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetAllWithHttpInfo($goods_owner_id, $article_number = null, $article_system_id_from = null, $max_articles_to_get = null, $stock_info_changed_from = null, $article_numbers = null, $article_data_last_updated_from = null, $only_articles_in_stock = null, $product_code = null, $product_codes = null, $article_name_contains = null, $article_class_ids = null, $bar_codes = null, $only_articles_below_stock_limit = null, $only_articles_below_stock_limit_considering_number_of_booked_items = null, string $contentType = self::contentTypes['articlesGetAll'][0])
    {
        $request = $this->articlesGetAllRequest($goods_owner_id, $article_number, $article_system_id_from, $max_articles_to_get, $stock_info_changed_from, $article_numbers, $article_data_last_updated_from, $only_articles_in_stock, $product_code, $product_codes, $article_name_contains, $article_class_ids, $bar_codes, $only_articles_below_stock_limit, $only_articles_below_stock_limit_considering_number_of_booked_items, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleModel[]';
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
                        '\OngoingAPI\Model\GetArticleModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetAllAsync
     *
     * Get all articles which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_number Article number. (optional)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock balances have changed after this time. NOTE: this value must must be within 24 hours of the current time. (optional)
     * @param  string[] $article_numbers (optional)
     * @param  \DateTime $article_data_last_updated_from Only return articles where the article data has changed after this time. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are actually in stock (i.e. those articles having numberOfItems &gt; 0). (optional)
     * @param  string $product_code Product code. (optional)
     * @param  string[] $product_codes (optional)
     * @param  string[] $article_name_contains (optional)
     * @param  int[] $article_class_ids Only return articles of these article classes. (optional)
     * @param  string[] $bar_codes (optional)
     * @param  bool $only_articles_below_stock_limit Only return articles whose physical quantity is below the stock limit. (optional)
     * @param  bool $only_articles_below_stock_limit_considering_number_of_booked_items Only return articles which have \&quot;physical quantity minus booked quantity\&quot; below the stock limit. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetAllAsync($goods_owner_id, $article_number = null, $article_system_id_from = null, $max_articles_to_get = null, $stock_info_changed_from = null, $article_numbers = null, $article_data_last_updated_from = null, $only_articles_in_stock = null, $product_code = null, $product_codes = null, $article_name_contains = null, $article_class_ids = null, $bar_codes = null, $only_articles_below_stock_limit = null, $only_articles_below_stock_limit_considering_number_of_booked_items = null, string $contentType = self::contentTypes['articlesGetAll'][0])
    {
        return $this->articlesGetAllAsyncWithHttpInfo($goods_owner_id, $article_number, $article_system_id_from, $max_articles_to_get, $stock_info_changed_from, $article_numbers, $article_data_last_updated_from, $only_articles_in_stock, $product_code, $product_codes, $article_name_contains, $article_class_ids, $bar_codes, $only_articles_below_stock_limit, $only_articles_below_stock_limit_considering_number_of_booked_items, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetAllAsyncWithHttpInfo
     *
     * Get all articles which match the specified search criteria.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_number Article number. (optional)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock balances have changed after this time. NOTE: this value must must be within 24 hours of the current time. (optional)
     * @param  string[] $article_numbers (optional)
     * @param  \DateTime $article_data_last_updated_from Only return articles where the article data has changed after this time. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are actually in stock (i.e. those articles having numberOfItems &gt; 0). (optional)
     * @param  string $product_code Product code. (optional)
     * @param  string[] $product_codes (optional)
     * @param  string[] $article_name_contains (optional)
     * @param  int[] $article_class_ids Only return articles of these article classes. (optional)
     * @param  string[] $bar_codes (optional)
     * @param  bool $only_articles_below_stock_limit Only return articles whose physical quantity is below the stock limit. (optional)
     * @param  bool $only_articles_below_stock_limit_considering_number_of_booked_items Only return articles which have \&quot;physical quantity minus booked quantity\&quot; below the stock limit. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetAllAsyncWithHttpInfo($goods_owner_id, $article_number = null, $article_system_id_from = null, $max_articles_to_get = null, $stock_info_changed_from = null, $article_numbers = null, $article_data_last_updated_from = null, $only_articles_in_stock = null, $product_code = null, $product_codes = null, $article_name_contains = null, $article_class_ids = null, $bar_codes = null, $only_articles_below_stock_limit = null, $only_articles_below_stock_limit_considering_number_of_booked_items = null, string $contentType = self::contentTypes['articlesGetAll'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleModel[]';
        $request = $this->articlesGetAllRequest($goods_owner_id, $article_number, $article_system_id_from, $max_articles_to_get, $stock_info_changed_from, $article_numbers, $article_data_last_updated_from, $only_articles_in_stock, $product_code, $product_codes, $article_name_contains, $article_class_ids, $bar_codes, $only_articles_below_stock_limit, $only_articles_below_stock_limit_considering_number_of_booked_items, $contentType);

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
     * Create request for operation 'articlesGetAll'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_number Article number. (optional)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock balances have changed after this time. NOTE: this value must must be within 24 hours of the current time. (optional)
     * @param  string[] $article_numbers (optional)
     * @param  \DateTime $article_data_last_updated_from Only return articles where the article data has changed after this time. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are actually in stock (i.e. those articles having numberOfItems &gt; 0). (optional)
     * @param  string $product_code Product code. (optional)
     * @param  string[] $product_codes (optional)
     * @param  string[] $article_name_contains (optional)
     * @param  int[] $article_class_ids Only return articles of these article classes. (optional)
     * @param  string[] $bar_codes (optional)
     * @param  bool $only_articles_below_stock_limit Only return articles whose physical quantity is below the stock limit. (optional)
     * @param  bool $only_articles_below_stock_limit_considering_number_of_booked_items Only return articles which have \&quot;physical quantity minus booked quantity\&quot; below the stock limit. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetAll'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetAllRequest($goods_owner_id, $article_number = null, $article_system_id_from = null, $max_articles_to_get = null, $stock_info_changed_from = null, $article_numbers = null, $article_data_last_updated_from = null, $only_articles_in_stock = null, $product_code = null, $product_codes = null, $article_name_contains = null, $article_class_ids = null, $bar_codes = null, $only_articles_below_stock_limit = null, $only_articles_below_stock_limit_considering_number_of_booked_items = null, string $contentType = self::contentTypes['articlesGetAll'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling articlesGetAll'
            );
        }
















        $resourcePath = '/api/v1/articles';
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
            $article_number,
            'articleNumber', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $article_system_id_from,
            'articleSystemIdFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $max_articles_to_get,
            'maxArticlesToGet', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $stock_info_changed_from,
            'stockInfoChangedFrom', // param base name
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
            $article_data_last_updated_from,
            'articleDataLastUpdatedFrom', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_articles_in_stock,
            'onlyArticlesInStock', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $product_code,
            'productCode', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $product_codes,
            'productCodes', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $article_name_contains,
            'articleNameContains', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $article_class_ids,
            'articleClassIds', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $bar_codes,
            'barCodes', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_articles_below_stock_limit,
            'onlyArticlesBelowStockLimit', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_articles_below_stock_limit_considering_number_of_booked_items,
            'onlyArticlesBelowStockLimitConsideringNumberOfBookedItems', // param base name
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
     * Operation articlesGetArticleClasses
     *
     * Get all article classes.
     *
     * @param  int $goods_owner_id goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetArticleClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleClassesModel
     */
    public function articlesGetArticleClasses($goods_owner_id, string $contentType = self::contentTypes['articlesGetArticleClasses'][0])
    {
        list($response) = $this->articlesGetArticleClassesWithHttpInfo($goods_owner_id, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetArticleClassesWithHttpInfo
     *
     * Get all article classes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetArticleClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleClassesModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetArticleClassesWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['articlesGetArticleClasses'][0])
    {
        $request = $this->articlesGetArticleClassesRequest($goods_owner_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleClassesModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleClassesModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleClassesModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleClassesModel';
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
                        '\OngoingAPI\Model\GetArticleClassesModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetArticleClassesAsync
     *
     * Get all article classes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetArticleClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetArticleClassesAsync($goods_owner_id, string $contentType = self::contentTypes['articlesGetArticleClasses'][0])
    {
        return $this->articlesGetArticleClassesAsyncWithHttpInfo($goods_owner_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetArticleClassesAsyncWithHttpInfo
     *
     * Get all article classes.
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetArticleClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetArticleClassesAsyncWithHttpInfo($goods_owner_id, string $contentType = self::contentTypes['articlesGetArticleClasses'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleClassesModel';
        $request = $this->articlesGetArticleClassesRequest($goods_owner_id, $contentType);

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
     * Create request for operation 'articlesGetArticleClasses'
     *
     * @param  int $goods_owner_id (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetArticleClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetArticleClassesRequest($goods_owner_id, string $contentType = self::contentTypes['articlesGetArticleClasses'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling articlesGetArticleClasses'
            );
        }


        $resourcePath = '/api/v1/articles/classes';
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
     * Operation articlesGetDangerousGoods
     *
     * Get dangerous goods info for an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoods'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleDangerousGoodsModel
     */
    public function articlesGetDangerousGoods($article_system_id, string $contentType = self::contentTypes['articlesGetDangerousGoods'][0])
    {
        list($response) = $this->articlesGetDangerousGoodsWithHttpInfo($article_system_id, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetDangerousGoodsWithHttpInfo
     *
     * Get dangerous goods info for an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoods'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleDangerousGoodsModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetDangerousGoodsWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGetDangerousGoods'][0])
    {
        $request = $this->articlesGetDangerousGoodsRequest($article_system_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleDangerousGoodsModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleDangerousGoodsModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleDangerousGoodsModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleDangerousGoodsModel';
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
                        '\OngoingAPI\Model\GetArticleDangerousGoodsModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetDangerousGoodsAsync
     *
     * Get dangerous goods info for an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoods'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetDangerousGoodsAsync($article_system_id, string $contentType = self::contentTypes['articlesGetDangerousGoods'][0])
    {
        return $this->articlesGetDangerousGoodsAsyncWithHttpInfo($article_system_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetDangerousGoodsAsyncWithHttpInfo
     *
     * Get dangerous goods info for an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoods'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetDangerousGoodsAsyncWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGetDangerousGoods'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleDangerousGoodsModel';
        $request = $this->articlesGetDangerousGoodsRequest($article_system_id, $contentType);

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
     * Create request for operation 'articlesGetDangerousGoods'
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoods'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetDangerousGoodsRequest($article_system_id, string $contentType = self::contentTypes['articlesGetDangerousGoods'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesGetDangerousGoods'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/dangerousGoods';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation articlesGetDangerousGoodsByArticleNumber
     *
     * Get dangerous goods info for articles, using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string[] $article_numbers Article numbers to get dangerous goods information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleDangerousGoodsModel[]
     */
    public function articlesGetDangerousGoodsByArticleNumber($goods_owner_id, $article_numbers = null, string $contentType = self::contentTypes['articlesGetDangerousGoodsByArticleNumber'][0])
    {
        list($response) = $this->articlesGetDangerousGoodsByArticleNumberWithHttpInfo($goods_owner_id, $article_numbers, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetDangerousGoodsByArticleNumberWithHttpInfo
     *
     * Get dangerous goods info for articles, using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string[] $article_numbers Article numbers to get dangerous goods information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleDangerousGoodsModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetDangerousGoodsByArticleNumberWithHttpInfo($goods_owner_id, $article_numbers = null, string $contentType = self::contentTypes['articlesGetDangerousGoodsByArticleNumber'][0])
    {
        $request = $this->articlesGetDangerousGoodsByArticleNumberRequest($goods_owner_id, $article_numbers, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleDangerousGoodsModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleDangerousGoodsModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleDangerousGoodsModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleDangerousGoodsModel[]';
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
                        '\OngoingAPI\Model\GetArticleDangerousGoodsModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetDangerousGoodsByArticleNumberAsync
     *
     * Get dangerous goods info for articles, using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string[] $article_numbers Article numbers to get dangerous goods information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetDangerousGoodsByArticleNumberAsync($goods_owner_id, $article_numbers = null, string $contentType = self::contentTypes['articlesGetDangerousGoodsByArticleNumber'][0])
    {
        return $this->articlesGetDangerousGoodsByArticleNumberAsyncWithHttpInfo($goods_owner_id, $article_numbers, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetDangerousGoodsByArticleNumberAsyncWithHttpInfo
     *
     * Get dangerous goods info for articles, using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string[] $article_numbers Article numbers to get dangerous goods information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetDangerousGoodsByArticleNumberAsyncWithHttpInfo($goods_owner_id, $article_numbers = null, string $contentType = self::contentTypes['articlesGetDangerousGoodsByArticleNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleDangerousGoodsModel[]';
        $request = $this->articlesGetDangerousGoodsByArticleNumberRequest($goods_owner_id, $article_numbers, $contentType);

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
     * Create request for operation 'articlesGetDangerousGoodsByArticleNumber'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string[] $article_numbers Article numbers to get dangerous goods information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetDangerousGoodsByArticleNumberRequest($goods_owner_id, $article_numbers = null, string $contentType = self::contentTypes['articlesGetDangerousGoodsByArticleNumber'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling articlesGetDangerousGoodsByArticleNumber'
            );
        }



        $resourcePath = '/api/v1/articles/dangerousGoods';
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
            $article_numbers,
            'articleNumbers', // param base name
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
     * Operation articlesGetFiles
     *
     * Get all files which are attached to a specific article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetFiles'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetFileModel[]
     */
    public function articlesGetFiles($article_system_id, string $contentType = self::contentTypes['articlesGetFiles'][0])
    {
        list($response) = $this->articlesGetFilesWithHttpInfo($article_system_id, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetFilesWithHttpInfo
     *
     * Get all files which are attached to a specific article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetFiles'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetFileModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetFilesWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGetFiles'][0])
    {
        $request = $this->articlesGetFilesRequest($article_system_id, $contentType);

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
     * Operation articlesGetFilesAsync
     *
     * Get all files which are attached to a specific article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetFilesAsync($article_system_id, string $contentType = self::contentTypes['articlesGetFiles'][0])
    {
        return $this->articlesGetFilesAsyncWithHttpInfo($article_system_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetFilesAsyncWithHttpInfo
     *
     * Get all files which are attached to a specific article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetFilesAsyncWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGetFiles'][0])
    {
        $returnType = '\OngoingAPI\Model\GetFileModel[]';
        $request = $this->articlesGetFilesRequest($article_system_id, $contentType);

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
     * Create request for operation 'articlesGetFiles'
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetFiles'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetFilesRequest($article_system_id, string $contentType = self::contentTypes['articlesGetFiles'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesGetFiles'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation articlesGetHistoricalInventory
     *
     * Get the historical stock balances for all articles at a specific time in the past.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $stock_date The date for which you want stock balance information. (required)
     * @param  int $warehouse_id If specified, will only give you the stock balances for this particular warehouse. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetHistoricalInventory'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetHistoricalInventoryModel[]
     */
    public function articlesGetHistoricalInventory($goods_owner_id, $stock_date, $warehouse_id = null, string $contentType = self::contentTypes['articlesGetHistoricalInventory'][0])
    {
        list($response) = $this->articlesGetHistoricalInventoryWithHttpInfo($goods_owner_id, $stock_date, $warehouse_id, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetHistoricalInventoryWithHttpInfo
     *
     * Get the historical stock balances for all articles at a specific time in the past.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $stock_date The date for which you want stock balance information. (required)
     * @param  int $warehouse_id If specified, will only give you the stock balances for this particular warehouse. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetHistoricalInventory'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetHistoricalInventoryModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetHistoricalInventoryWithHttpInfo($goods_owner_id, $stock_date, $warehouse_id = null, string $contentType = self::contentTypes['articlesGetHistoricalInventory'][0])
    {
        $request = $this->articlesGetHistoricalInventoryRequest($goods_owner_id, $stock_date, $warehouse_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetHistoricalInventoryModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetHistoricalInventoryModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetHistoricalInventoryModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetHistoricalInventoryModel[]';
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
                        '\OngoingAPI\Model\GetHistoricalInventoryModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetHistoricalInventoryAsync
     *
     * Get the historical stock balances for all articles at a specific time in the past.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $stock_date The date for which you want stock balance information. (required)
     * @param  int $warehouse_id If specified, will only give you the stock balances for this particular warehouse. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetHistoricalInventory'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetHistoricalInventoryAsync($goods_owner_id, $stock_date, $warehouse_id = null, string $contentType = self::contentTypes['articlesGetHistoricalInventory'][0])
    {
        return $this->articlesGetHistoricalInventoryAsyncWithHttpInfo($goods_owner_id, $stock_date, $warehouse_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetHistoricalInventoryAsyncWithHttpInfo
     *
     * Get the historical stock balances for all articles at a specific time in the past.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $stock_date The date for which you want stock balance information. (required)
     * @param  int $warehouse_id If specified, will only give you the stock balances for this particular warehouse. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetHistoricalInventory'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetHistoricalInventoryAsyncWithHttpInfo($goods_owner_id, $stock_date, $warehouse_id = null, string $contentType = self::contentTypes['articlesGetHistoricalInventory'][0])
    {
        $returnType = '\OngoingAPI\Model\GetHistoricalInventoryModel[]';
        $request = $this->articlesGetHistoricalInventoryRequest($goods_owner_id, $stock_date, $warehouse_id, $contentType);

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
     * Create request for operation 'articlesGetHistoricalInventory'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  \DateTime $stock_date The date for which you want stock balance information. (required)
     * @param  int $warehouse_id If specified, will only give you the stock balances for this particular warehouse. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetHistoricalInventory'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetHistoricalInventoryRequest($goods_owner_id, $stock_date, $warehouse_id = null, string $contentType = self::contentTypes['articlesGetHistoricalInventory'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling articlesGetHistoricalInventory'
            );
        }

        // verify the required parameter 'stock_date' is set
        if ($stock_date === null || (is_array($stock_date) && count($stock_date) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $stock_date when calling articlesGetHistoricalInventory'
            );
        }



        $resourcePath = '/api/v1/articles/historicalInventory';
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
            $stock_date,
            'stockDate', // param base name
            'string', // openApiType
            'form', // style
            true, // explode
            true // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $warehouse_id,
            'warehouseId', // param base name
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
     * Operation articlesGetInventoryPerWarehouse
     *
     * Get inventory info (specified per warehouse) for the articles which match the filter.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  string[] $article_numbers Only return info for these article numbers. (optional)
     * @param  int[] $warehouse_ids Only return info for these warehouses. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are in stock in at least one warehouse. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock info has changed after this time. Note that it must be be within 24 hours of the current time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetInventoryPerWarehouse'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[]
     */
    public function articlesGetInventoryPerWarehouse($goods_owner_id, $article_system_id_from = null, $max_articles_to_get = null, $article_numbers = null, $warehouse_ids = null, $only_articles_in_stock = null, $stock_info_changed_from = null, string $contentType = self::contentTypes['articlesGetInventoryPerWarehouse'][0])
    {
        list($response) = $this->articlesGetInventoryPerWarehouseWithHttpInfo($goods_owner_id, $article_system_id_from, $max_articles_to_get, $article_numbers, $warehouse_ids, $only_articles_in_stock, $stock_info_changed_from, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetInventoryPerWarehouseWithHttpInfo
     *
     * Get inventory info (specified per warehouse) for the articles which match the filter.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  string[] $article_numbers Only return info for these article numbers. (optional)
     * @param  int[] $warehouse_ids Only return info for these warehouses. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are in stock in at least one warehouse. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock info has changed after this time. Note that it must be be within 24 hours of the current time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetInventoryPerWarehouse'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetInventoryPerWarehouseWithHttpInfo($goods_owner_id, $article_system_id_from = null, $max_articles_to_get = null, $article_numbers = null, $warehouse_ids = null, $only_articles_in_stock = null, $stock_info_changed_from = null, string $contentType = self::contentTypes['articlesGetInventoryPerWarehouse'][0])
    {
        $request = $this->articlesGetInventoryPerWarehouseRequest($goods_owner_id, $article_system_id_from, $max_articles_to_get, $article_numbers, $warehouse_ids, $only_articles_in_stock, $stock_info_changed_from, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[]';
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
                        '\OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetInventoryPerWarehouseAsync
     *
     * Get inventory info (specified per warehouse) for the articles which match the filter.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  string[] $article_numbers Only return info for these article numbers. (optional)
     * @param  int[] $warehouse_ids Only return info for these warehouses. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are in stock in at least one warehouse. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock info has changed after this time. Note that it must be be within 24 hours of the current time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetInventoryPerWarehouse'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetInventoryPerWarehouseAsync($goods_owner_id, $article_system_id_from = null, $max_articles_to_get = null, $article_numbers = null, $warehouse_ids = null, $only_articles_in_stock = null, $stock_info_changed_from = null, string $contentType = self::contentTypes['articlesGetInventoryPerWarehouse'][0])
    {
        return $this->articlesGetInventoryPerWarehouseAsyncWithHttpInfo($goods_owner_id, $article_system_id_from, $max_articles_to_get, $article_numbers, $warehouse_ids, $only_articles_in_stock, $stock_info_changed_from, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetInventoryPerWarehouseAsyncWithHttpInfo
     *
     * Get inventory info (specified per warehouse) for the articles which match the filter.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  string[] $article_numbers Only return info for these article numbers. (optional)
     * @param  int[] $warehouse_ids Only return info for these warehouses. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are in stock in at least one warehouse. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock info has changed after this time. Note that it must be be within 24 hours of the current time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetInventoryPerWarehouse'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetInventoryPerWarehouseAsyncWithHttpInfo($goods_owner_id, $article_system_id_from = null, $max_articles_to_get = null, $article_numbers = null, $warehouse_ids = null, $only_articles_in_stock = null, $stock_info_changed_from = null, string $contentType = self::contentTypes['articlesGetInventoryPerWarehouse'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleInventoryPerWarehouseModel[]';
        $request = $this->articlesGetInventoryPerWarehouseRequest($goods_owner_id, $article_system_id_from, $max_articles_to_get, $article_numbers, $warehouse_ids, $only_articles_in_stock, $stock_info_changed_from, $contentType);

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
     * Create request for operation 'articlesGetInventoryPerWarehouse'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  int $article_system_id_from Only return articles whose article system ID is greater than or equal to this. (optional)
     * @param  int $max_articles_to_get Maximum number of articles to return. (optional)
     * @param  string[] $article_numbers Only return info for these article numbers. (optional)
     * @param  int[] $warehouse_ids Only return info for these warehouses. (optional)
     * @param  bool $only_articles_in_stock Only return articles where which are in stock in at least one warehouse. (optional)
     * @param  \DateTime $stock_info_changed_from Only return articles where the stock info has changed after this time. Note that it must be be within 24 hours of the current time. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetInventoryPerWarehouse'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetInventoryPerWarehouseRequest($goods_owner_id, $article_system_id_from = null, $max_articles_to_get = null, $article_numbers = null, $warehouse_ids = null, $only_articles_in_stock = null, $stock_info_changed_from = null, string $contentType = self::contentTypes['articlesGetInventoryPerWarehouse'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling articlesGetInventoryPerWarehouse'
            );
        }








        $resourcePath = '/api/v1/articles/inventoryPerWarehouse';
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
            $article_system_id_from,
            'articleSystemIdFrom', // param base name
            'integer', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $max_articles_to_get,
            'maxArticlesToGet', // param base name
            'integer', // openApiType
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
            $warehouse_ids,
            'warehouseIds', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $only_articles_in_stock,
            'onlyArticlesInStock', // param base name
            'boolean', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $stock_info_changed_from,
            'stockInfoChangedFrom', // param base name
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
     * Operation articlesGetStructureRows
     *
     * Get all structure rows for structure articles and production articles.
     *
     * @param  int $article_system_id Article system ID of the structure article or production article. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRows'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleStructureDefinitionModel
     */
    public function articlesGetStructureRows($article_system_id, string $contentType = self::contentTypes['articlesGetStructureRows'][0])
    {
        list($response) = $this->articlesGetStructureRowsWithHttpInfo($article_system_id, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetStructureRowsWithHttpInfo
     *
     * Get all structure rows for structure articles and production articles.
     *
     * @param  int $article_system_id Article system ID of the structure article or production article. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRows'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleStructureDefinitionModel, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetStructureRowsWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGetStructureRows'][0])
    {
        $request = $this->articlesGetStructureRowsRequest($article_system_id, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleStructureDefinitionModel' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleStructureDefinitionModel' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleStructureDefinitionModel', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleStructureDefinitionModel';
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
                        '\OngoingAPI\Model\GetArticleStructureDefinitionModel',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetStructureRowsAsync
     *
     * Get all structure rows for structure articles and production articles.
     *
     * @param  int $article_system_id Article system ID of the structure article or production article. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRows'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetStructureRowsAsync($article_system_id, string $contentType = self::contentTypes['articlesGetStructureRows'][0])
    {
        return $this->articlesGetStructureRowsAsyncWithHttpInfo($article_system_id, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetStructureRowsAsyncWithHttpInfo
     *
     * Get all structure rows for structure articles and production articles.
     *
     * @param  int $article_system_id Article system ID of the structure article or production article. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRows'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetStructureRowsAsyncWithHttpInfo($article_system_id, string $contentType = self::contentTypes['articlesGetStructureRows'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleStructureDefinitionModel';
        $request = $this->articlesGetStructureRowsRequest($article_system_id, $contentType);

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
     * Create request for operation 'articlesGetStructureRows'
     *
     * @param  int $article_system_id Article system ID of the structure article or production article. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRows'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetStructureRowsRequest($article_system_id, string $contentType = self::contentTypes['articlesGetStructureRows'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesGetStructureRows'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/structureDefinition';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation articlesGetStructureRowsByArticleNumber
     *
     * Get all structure rows for structure articles and production articles, by using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_kind If you want to filter for strucutre articles, put &#39;Structure&#39; here. If you want to filter for production articles, put &#39;Production&#39; here. (required)
     * @param  string[] $article_numbers Article numbers to get structure information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRowsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\GetArticleStructureDefinitionModel[]
     */
    public function articlesGetStructureRowsByArticleNumber($goods_owner_id, $article_kind, $article_numbers = null, string $contentType = self::contentTypes['articlesGetStructureRowsByArticleNumber'][0])
    {
        list($response) = $this->articlesGetStructureRowsByArticleNumberWithHttpInfo($goods_owner_id, $article_kind, $article_numbers, $contentType);
        return $response;
    }

    /**
     * Operation articlesGetStructureRowsByArticleNumberWithHttpInfo
     *
     * Get all structure rows for structure articles and production articles, by using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_kind If you want to filter for strucutre articles, put &#39;Structure&#39; here. If you want to filter for production articles, put &#39;Production&#39; here. (required)
     * @param  string[] $article_numbers Article numbers to get structure information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRowsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\GetArticleStructureDefinitionModel[], HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesGetStructureRowsByArticleNumberWithHttpInfo($goods_owner_id, $article_kind, $article_numbers = null, string $contentType = self::contentTypes['articlesGetStructureRowsByArticleNumber'][0])
    {
        $request = $this->articlesGetStructureRowsByArticleNumberRequest($goods_owner_id, $article_kind, $article_numbers, $contentType);

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
                    if ('\OngoingAPI\Model\GetArticleStructureDefinitionModel[]' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\GetArticleStructureDefinitionModel[]' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\GetArticleStructureDefinitionModel[]', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\GetArticleStructureDefinitionModel[]';
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
                        '\OngoingAPI\Model\GetArticleStructureDefinitionModel[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesGetStructureRowsByArticleNumberAsync
     *
     * Get all structure rows for structure articles and production articles, by using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_kind If you want to filter for strucutre articles, put &#39;Structure&#39; here. If you want to filter for production articles, put &#39;Production&#39; here. (required)
     * @param  string[] $article_numbers Article numbers to get structure information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRowsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetStructureRowsByArticleNumberAsync($goods_owner_id, $article_kind, $article_numbers = null, string $contentType = self::contentTypes['articlesGetStructureRowsByArticleNumber'][0])
    {
        return $this->articlesGetStructureRowsByArticleNumberAsyncWithHttpInfo($goods_owner_id, $article_kind, $article_numbers, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesGetStructureRowsByArticleNumberAsyncWithHttpInfo
     *
     * Get all structure rows for structure articles and production articles, by using article numbers.
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_kind If you want to filter for strucutre articles, put &#39;Structure&#39; here. If you want to filter for production articles, put &#39;Production&#39; here. (required)
     * @param  string[] $article_numbers Article numbers to get structure information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRowsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesGetStructureRowsByArticleNumberAsyncWithHttpInfo($goods_owner_id, $article_kind, $article_numbers = null, string $contentType = self::contentTypes['articlesGetStructureRowsByArticleNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\GetArticleStructureDefinitionModel[]';
        $request = $this->articlesGetStructureRowsByArticleNumberRequest($goods_owner_id, $article_kind, $article_numbers, $contentType);

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
     * Create request for operation 'articlesGetStructureRowsByArticleNumber'
     *
     * @param  int $goods_owner_id Goods owner ID. (required)
     * @param  string $article_kind If you want to filter for strucutre articles, put &#39;Structure&#39; here. If you want to filter for production articles, put &#39;Production&#39; here. (required)
     * @param  string[] $article_numbers Article numbers to get structure information for. (optional)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesGetStructureRowsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesGetStructureRowsByArticleNumberRequest($goods_owner_id, $article_kind, $article_numbers = null, string $contentType = self::contentTypes['articlesGetStructureRowsByArticleNumber'][0])
    {

        // verify the required parameter 'goods_owner_id' is set
        if ($goods_owner_id === null || (is_array($goods_owner_id) && count($goods_owner_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $goods_owner_id when calling articlesGetStructureRowsByArticleNumber'
            );
        }

        // verify the required parameter 'article_kind' is set
        if ($article_kind === null || (is_array($article_kind) && count($article_kind) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_kind when calling articlesGetStructureRowsByArticleNumber'
            );
        }



        $resourcePath = '/api/v1/articles/structureDefinitions';
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
            $article_numbers,
            'articleNumbers', // param base name
            'array', // openApiType
            'form', // style
            true, // explode
            false // required
        ) ?? []);
        // query params
        $queryParams = array_merge($queryParams, ObjectSerializer::toQueryValue(
            $article_kind,
            'articleKind', // param base name
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
            'GET',
            $operationHost . $resourcePath . ($query ? "?{$query}" : ''),
            $headers,
            $httpBody
        );
    }

    /**
     * Operation articlesPost
     *
     * Create a new file and attach it to the specified article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPost'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function articlesPost($article_system_id, $post_file_model, string $contentType = self::contentTypes['articlesPost'][0])
    {
        list($response) = $this->articlesPostWithHttpInfo($article_system_id, $post_file_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPostWithHttpInfo
     *
     * Create a new file and attach it to the specified article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPost'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPostWithHttpInfo($article_system_id, $post_file_model, string $contentType = self::contentTypes['articlesPost'][0])
    {
        $request = $this->articlesPostRequest($article_system_id, $post_file_model, $contentType);

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
     * Operation articlesPostAsync
     *
     * Create a new file and attach it to the specified article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPostAsync($article_system_id, $post_file_model, string $contentType = self::contentTypes['articlesPost'][0])
    {
        return $this->articlesPostAsyncWithHttpInfo($article_system_id, $post_file_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPostAsyncWithHttpInfo
     *
     * Create a new file and attach it to the specified article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPostAsyncWithHttpInfo($article_system_id, $post_file_model, string $contentType = self::contentTypes['articlesPost'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->articlesPostRequest($article_system_id, $post_file_model, $contentType);

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
     * Create request for operation 'articlesPost'
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPost'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPostRequest($article_system_id, $post_file_model, string $contentType = self::contentTypes['articlesPost'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesPost'
            );
        }

        // verify the required parameter 'post_file_model' is set
        if ($post_file_model === null || (is_array($post_file_model) && count($post_file_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_model when calling articlesPost'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/files';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
     * Operation articlesPut
     *
     * Update an existing article. Note that the articleSystemId refers to Ongoing WMS&#39; internal ID for the article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostArticleResponse
     */
    public function articlesPut($article_system_id, $post_article_model, string $contentType = self::contentTypes['articlesPut'][0])
    {
        list($response) = $this->articlesPutWithHttpInfo($article_system_id, $post_article_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPutWithHttpInfo
     *
     * Update an existing article. Note that the articleSystemId refers to Ongoing WMS&#39; internal ID for the article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostArticleResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPutWithHttpInfo($article_system_id, $post_article_model, string $contentType = self::contentTypes['articlesPut'][0])
    {
        $request = $this->articlesPutRequest($article_system_id, $post_article_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostArticleResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostArticleResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostArticleResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostArticleResponse';
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
                        '\OngoingAPI\Model\PostArticleResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesPutAsync
     *
     * Update an existing article. Note that the articleSystemId refers to Ongoing WMS&#39; internal ID for the article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutAsync($article_system_id, $post_article_model, string $contentType = self::contentTypes['articlesPut'][0])
    {
        return $this->articlesPutAsyncWithHttpInfo($article_system_id, $post_article_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPutAsyncWithHttpInfo
     *
     * Update an existing article. Note that the articleSystemId refers to Ongoing WMS&#39; internal ID for the article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutAsyncWithHttpInfo($article_system_id, $post_article_model, string $contentType = self::contentTypes['articlesPut'][0])
    {
        $returnType = '\OngoingAPI\Model\PostArticleResponse';
        $request = $this->articlesPutRequest($article_system_id, $post_article_model, $contentType);

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
     * Create request for operation 'articlesPut'
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPutRequest($article_system_id, $post_article_model, string $contentType = self::contentTypes['articlesPut'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesPut'
            );
        }

        // verify the required parameter 'post_article_model' is set
        if ($post_article_model === null || (is_array($post_article_model) && count($post_article_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_article_model when calling articlesPut'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
        if (isset($post_article_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_article_model));
            } else {
                $httpBody = $post_article_model;
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
     * Operation articlesPut2
     *
     * Update a file which is attached to an article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  int $file_id File ID, identifying the file which is to be updated. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function articlesPut2($article_system_id, $file_id, $post_file_model, string $contentType = self::contentTypes['articlesPut2'][0])
    {
        list($response) = $this->articlesPut2WithHttpInfo($article_system_id, $file_id, $post_file_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPut2WithHttpInfo
     *
     * Update a file which is attached to an article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  int $file_id File ID, identifying the file which is to be updated. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut2'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPut2WithHttpInfo($article_system_id, $file_id, $post_file_model, string $contentType = self::contentTypes['articlesPut2'][0])
    {
        $request = $this->articlesPut2Request($article_system_id, $file_id, $post_file_model, $contentType);

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
     * Operation articlesPut2Async
     *
     * Update a file which is attached to an article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  int $file_id File ID, identifying the file which is to be updated. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPut2Async($article_system_id, $file_id, $post_file_model, string $contentType = self::contentTypes['articlesPut2'][0])
    {
        return $this->articlesPut2AsyncWithHttpInfo($article_system_id, $file_id, $post_file_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPut2AsyncWithHttpInfo
     *
     * Update a file which is attached to an article.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  int $file_id File ID, identifying the file which is to be updated. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPut2AsyncWithHttpInfo($article_system_id, $file_id, $post_file_model, string $contentType = self::contentTypes['articlesPut2'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->articlesPut2Request($article_system_id, $file_id, $post_file_model, $contentType);

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
     * Create request for operation 'articlesPut2'
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  int $file_id File ID, identifying the file which is to be updated. (required)
     * @param  \OngoingAPI\Model\PostFileModel $post_file_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut2'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPut2Request($article_system_id, $file_id, $post_file_model, string $contentType = self::contentTypes['articlesPut2'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesPut2'
            );
        }

        // verify the required parameter 'file_id' is set
        if ($file_id === null || (is_array($file_id) && count($file_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file_id when calling articlesPut2'
            );
        }

        // verify the required parameter 'post_file_model' is set
        if ($post_file_model === null || (is_array($post_file_model) && count($post_file_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_model when calling articlesPut2'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/files/{fileId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($article_system_id !== null) {
            $resourcePath = str_replace(
                '{' . 'articleSystemId' . '}',
                ObjectSerializer::toPathValue($article_system_id),
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
     * Operation articlesPut3
     *
     * Create or update an article. If no article with the specified article number exists, it will be created. Otherwise, it will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut3'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostArticleResponse
     */
    public function articlesPut3($post_article_model, string $contentType = self::contentTypes['articlesPut3'][0])
    {
        list($response) = $this->articlesPut3WithHttpInfo($post_article_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPut3WithHttpInfo
     *
     * Create or update an article. If no article with the specified article number exists, it will be created. Otherwise, it will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut3'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostArticleResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPut3WithHttpInfo($post_article_model, string $contentType = self::contentTypes['articlesPut3'][0])
    {
        $request = $this->articlesPut3Request($post_article_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostArticleResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostArticleResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostArticleResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostArticleResponse';
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
                        '\OngoingAPI\Model\PostArticleResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesPut3Async
     *
     * Create or update an article. If no article with the specified article number exists, it will be created. Otherwise, it will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut3'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPut3Async($post_article_model, string $contentType = self::contentTypes['articlesPut3'][0])
    {
        return $this->articlesPut3AsyncWithHttpInfo($post_article_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPut3AsyncWithHttpInfo
     *
     * Create or update an article. If no article with the specified article number exists, it will be created. Otherwise, it will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut3'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPut3AsyncWithHttpInfo($post_article_model, string $contentType = self::contentTypes['articlesPut3'][0])
    {
        $returnType = '\OngoingAPI\Model\PostArticleResponse';
        $request = $this->articlesPut3Request($post_article_model, $contentType);

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
     * Create request for operation 'articlesPut3'
     *
     * @param  \OngoingAPI\Model\PostArticleModel $post_article_model Article object, containing all article data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPut3'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPut3Request($post_article_model, string $contentType = self::contentTypes['articlesPut3'][0])
    {

        // verify the required parameter 'post_article_model' is set
        if ($post_article_model === null || (is_array($post_article_model) && count($post_article_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_article_model when calling articlesPut3'
            );
        }


        $resourcePath = '/api/v1/articles';
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
        if (isset($post_article_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_article_model));
            } else {
                $httpBody = $post_article_model;
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
     * Operation articlesPutArticleClass
     *
     * Create or update an article class. If there is no article class with the specified code, it will be created. Otherwise, the existing article class will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClass'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostArticleClassResponse
     */
    public function articlesPutArticleClass($post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClass'][0])
    {
        list($response) = $this->articlesPutArticleClassWithHttpInfo($post_article_class_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPutArticleClassWithHttpInfo
     *
     * Create or update an article class. If there is no article class with the specified code, it will be created. Otherwise, the existing article class will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClass'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostArticleClassResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPutArticleClassWithHttpInfo($post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClass'][0])
    {
        $request = $this->articlesPutArticleClassRequest($post_article_class_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostArticleClassResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostArticleClassResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostArticleClassResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostArticleClassResponse';
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
                        '\OngoingAPI\Model\PostArticleClassResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesPutArticleClassAsync
     *
     * Create or update an article class. If there is no article class with the specified code, it will be created. Otherwise, the existing article class will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClass'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutArticleClassAsync($post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClass'][0])
    {
        return $this->articlesPutArticleClassAsyncWithHttpInfo($post_article_class_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPutArticleClassAsyncWithHttpInfo
     *
     * Create or update an article class. If there is no article class with the specified code, it will be created. Otherwise, the existing article class will be updated.
     *
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClass'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutArticleClassAsyncWithHttpInfo($post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClass'][0])
    {
        $returnType = '\OngoingAPI\Model\PostArticleClassResponse';
        $request = $this->articlesPutArticleClassRequest($post_article_class_model, $contentType);

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
     * Create request for operation 'articlesPutArticleClass'
     *
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class type data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClass'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPutArticleClassRequest($post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClass'][0])
    {

        // verify the required parameter 'post_article_class_model' is set
        if ($post_article_class_model === null || (is_array($post_article_class_model) && count($post_article_class_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_article_class_model when calling articlesPutArticleClass'
            );
        }


        $resourcePath = '/api/v1/articles/classes';
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
        if (isset($post_article_class_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_article_class_model));
            } else {
                $httpBody = $post_article_class_model;
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
     * Operation articlesPutArticleClassUsingId
     *
     * Update an article class. The ID will be used to identify the article class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClassUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostArticleClassResponse
     */
    public function articlesPutArticleClassUsingId($article_class_id, $post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClassUsingId'][0])
    {
        list($response) = $this->articlesPutArticleClassUsingIdWithHttpInfo($article_class_id, $post_article_class_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPutArticleClassUsingIdWithHttpInfo
     *
     * Update an article class. The ID will be used to identify the article class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClassUsingId'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostArticleClassResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPutArticleClassUsingIdWithHttpInfo($article_class_id, $post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClassUsingId'][0])
    {
        $request = $this->articlesPutArticleClassUsingIdRequest($article_class_id, $post_article_class_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostArticleClassResponse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostArticleClassResponse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostArticleClassResponse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostArticleClassResponse';
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
                        '\OngoingAPI\Model\PostArticleClassResponse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesPutArticleClassUsingIdAsync
     *
     * Update an article class. The ID will be used to identify the article class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClassUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutArticleClassUsingIdAsync($article_class_id, $post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClassUsingId'][0])
    {
        return $this->articlesPutArticleClassUsingIdAsyncWithHttpInfo($article_class_id, $post_article_class_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPutArticleClassUsingIdAsyncWithHttpInfo
     *
     * Update an article class. The ID will be used to identify the article class.
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClassUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutArticleClassUsingIdAsyncWithHttpInfo($article_class_id, $post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClassUsingId'][0])
    {
        $returnType = '\OngoingAPI\Model\PostArticleClassResponse';
        $request = $this->articlesPutArticleClassUsingIdRequest($article_class_id, $post_article_class_model, $contentType);

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
     * Create request for operation 'articlesPutArticleClassUsingId'
     *
     * @param  int $article_class_id Article class ID. (required)
     * @param  \OngoingAPI\Model\PostArticleClassModel $post_article_class_model An object containing the article class data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutArticleClassUsingId'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPutArticleClassUsingIdRequest($article_class_id, $post_article_class_model, string $contentType = self::contentTypes['articlesPutArticleClassUsingId'][0])
    {

        // verify the required parameter 'article_class_id' is set
        if ($article_class_id === null || (is_array($article_class_id) && count($article_class_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_class_id when calling articlesPutArticleClassUsingId'
            );
        }

        // verify the required parameter 'post_article_class_model' is set
        if ($post_article_class_model === null || (is_array($post_article_class_model) && count($post_article_class_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_article_class_model when calling articlesPutArticleClassUsingId'
            );
        }


        $resourcePath = '/api/v1/articles/classes/{articleClassId}';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



        // path params
        if ($article_class_id !== null) {
            $resourcePath = str_replace(
                '{' . 'articleClassId' . '}',
                ObjectSerializer::toPathValue($article_class_id),
                $resourcePath
            );
        }


        $headers = $this->headerSelector->selectHeaders(
            ['application/json', ],
            $contentType,
            $multipart
        );

        // for model (json/xml)
        if (isset($post_article_class_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_article_class_model));
            } else {
                $httpBody = $post_article_class_model;
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
     * Operation articlesPutDangerousGoods
     *
     * Update the dangerous goods info of an article. Note that the UN number must exist in Ongoing WMS before any articles can be set to that UN number.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsModel $post_article_dangerous_goods_model Dangerous goods information. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoods'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostDangerousGoodsRepsonse
     */
    public function articlesPutDangerousGoods($article_system_id, $post_article_dangerous_goods_model, string $contentType = self::contentTypes['articlesPutDangerousGoods'][0])
    {
        list($response) = $this->articlesPutDangerousGoodsWithHttpInfo($article_system_id, $post_article_dangerous_goods_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPutDangerousGoodsWithHttpInfo
     *
     * Update the dangerous goods info of an article. Note that the UN number must exist in Ongoing WMS before any articles can be set to that UN number.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsModel $post_article_dangerous_goods_model Dangerous goods information. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoods'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostDangerousGoodsRepsonse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPutDangerousGoodsWithHttpInfo($article_system_id, $post_article_dangerous_goods_model, string $contentType = self::contentTypes['articlesPutDangerousGoods'][0])
    {
        $request = $this->articlesPutDangerousGoodsRequest($article_system_id, $post_article_dangerous_goods_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostDangerousGoodsRepsonse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostDangerousGoodsRepsonse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostDangerousGoodsRepsonse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostDangerousGoodsRepsonse';
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
                        '\OngoingAPI\Model\PostDangerousGoodsRepsonse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesPutDangerousGoodsAsync
     *
     * Update the dangerous goods info of an article. Note that the UN number must exist in Ongoing WMS before any articles can be set to that UN number.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsModel $post_article_dangerous_goods_model Dangerous goods information. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoods'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutDangerousGoodsAsync($article_system_id, $post_article_dangerous_goods_model, string $contentType = self::contentTypes['articlesPutDangerousGoods'][0])
    {
        return $this->articlesPutDangerousGoodsAsyncWithHttpInfo($article_system_id, $post_article_dangerous_goods_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPutDangerousGoodsAsyncWithHttpInfo
     *
     * Update the dangerous goods info of an article. Note that the UN number must exist in Ongoing WMS before any articles can be set to that UN number.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsModel $post_article_dangerous_goods_model Dangerous goods information. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoods'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutDangerousGoodsAsyncWithHttpInfo($article_system_id, $post_article_dangerous_goods_model, string $contentType = self::contentTypes['articlesPutDangerousGoods'][0])
    {
        $returnType = '\OngoingAPI\Model\PostDangerousGoodsRepsonse';
        $request = $this->articlesPutDangerousGoodsRequest($article_system_id, $post_article_dangerous_goods_model, $contentType);

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
     * Create request for operation 'articlesPutDangerousGoods'
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsModel $post_article_dangerous_goods_model Dangerous goods information. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoods'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPutDangerousGoodsRequest($article_system_id, $post_article_dangerous_goods_model, string $contentType = self::contentTypes['articlesPutDangerousGoods'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesPutDangerousGoods'
            );
        }

        // verify the required parameter 'post_article_dangerous_goods_model' is set
        if ($post_article_dangerous_goods_model === null || (is_array($post_article_dangerous_goods_model) && count($post_article_dangerous_goods_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_article_dangerous_goods_model when calling articlesPutDangerousGoods'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/dangerousGoods';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
        if (isset($post_article_dangerous_goods_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_article_dangerous_goods_model));
            } else {
                $httpBody = $post_article_dangerous_goods_model;
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
     * Operation articlesPutDangerousGoodsByArticleNumber
     *
     * Update the dangerous goods info of an article via the article number.
     *
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsByArticleNumberModel $post_article_dangerous_goods_by_article_number_model post_article_dangerous_goods_by_article_number_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostDangerousGoodsRepsonse
     */
    public function articlesPutDangerousGoodsByArticleNumber($post_article_dangerous_goods_by_article_number_model, string $contentType = self::contentTypes['articlesPutDangerousGoodsByArticleNumber'][0])
    {
        list($response) = $this->articlesPutDangerousGoodsByArticleNumberWithHttpInfo($post_article_dangerous_goods_by_article_number_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPutDangerousGoodsByArticleNumberWithHttpInfo
     *
     * Update the dangerous goods info of an article via the article number.
     *
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsByArticleNumberModel $post_article_dangerous_goods_by_article_number_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostDangerousGoodsRepsonse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPutDangerousGoodsByArticleNumberWithHttpInfo($post_article_dangerous_goods_by_article_number_model, string $contentType = self::contentTypes['articlesPutDangerousGoodsByArticleNumber'][0])
    {
        $request = $this->articlesPutDangerousGoodsByArticleNumberRequest($post_article_dangerous_goods_by_article_number_model, $contentType);

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
                    if ('\OngoingAPI\Model\PostDangerousGoodsRepsonse' === '\SplFileObject') {
                        $content = $response->getBody(); //stream goes to serializer
                    } else {
                        $content = (string) $response->getBody();
                        if ('\OngoingAPI\Model\PostDangerousGoodsRepsonse' !== 'string') {
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
                        ObjectSerializer::deserialize($content, '\OngoingAPI\Model\PostDangerousGoodsRepsonse', []),
                        $response->getStatusCode(),
                        $response->getHeaders()
                    ];
            }

            $returnType = '\OngoingAPI\Model\PostDangerousGoodsRepsonse';
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
                        '\OngoingAPI\Model\PostDangerousGoodsRepsonse',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                    break;
            }
            throw $e;
        }
    }

    /**
     * Operation articlesPutDangerousGoodsByArticleNumberAsync
     *
     * Update the dangerous goods info of an article via the article number.
     *
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsByArticleNumberModel $post_article_dangerous_goods_by_article_number_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutDangerousGoodsByArticleNumberAsync($post_article_dangerous_goods_by_article_number_model, string $contentType = self::contentTypes['articlesPutDangerousGoodsByArticleNumber'][0])
    {
        return $this->articlesPutDangerousGoodsByArticleNumberAsyncWithHttpInfo($post_article_dangerous_goods_by_article_number_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPutDangerousGoodsByArticleNumberAsyncWithHttpInfo
     *
     * Update the dangerous goods info of an article via the article number.
     *
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsByArticleNumberModel $post_article_dangerous_goods_by_article_number_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutDangerousGoodsByArticleNumberAsyncWithHttpInfo($post_article_dangerous_goods_by_article_number_model, string $contentType = self::contentTypes['articlesPutDangerousGoodsByArticleNumber'][0])
    {
        $returnType = '\OngoingAPI\Model\PostDangerousGoodsRepsonse';
        $request = $this->articlesPutDangerousGoodsByArticleNumberRequest($post_article_dangerous_goods_by_article_number_model, $contentType);

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
     * Create request for operation 'articlesPutDangerousGoodsByArticleNumber'
     *
     * @param  \OngoingAPI\Model\PostArticleDangerousGoodsByArticleNumberModel $post_article_dangerous_goods_by_article_number_model (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutDangerousGoodsByArticleNumber'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPutDangerousGoodsByArticleNumberRequest($post_article_dangerous_goods_by_article_number_model, string $contentType = self::contentTypes['articlesPutDangerousGoodsByArticleNumber'][0])
    {

        // verify the required parameter 'post_article_dangerous_goods_by_article_number_model' is set
        if ($post_article_dangerous_goods_by_article_number_model === null || (is_array($post_article_dangerous_goods_by_article_number_model) && count($post_article_dangerous_goods_by_article_number_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_article_dangerous_goods_by_article_number_model when calling articlesPutDangerousGoodsByArticleNumber'
            );
        }


        $resourcePath = '/api/v1/articles/dangerousGoods';
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
        if (isset($post_article_dangerous_goods_by_article_number_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($post_article_dangerous_goods_by_article_number_model));
            } else {
                $httpBody = $post_article_dangerous_goods_by_article_number_model;
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
     * Operation articlesPutFileUsingFilename
     *
     * Create or update a file which is attached to an article. The filename will be used to check if the file already exists.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function articlesPutFileUsingFilename($article_system_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['articlesPutFileUsingFilename'][0])
    {
        list($response) = $this->articlesPutFileUsingFilenameWithHttpInfo($article_system_id, $file_name, $post_file_no_filename_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesPutFileUsingFilenameWithHttpInfo
     *
     * Create or update a file which is attached to an article. The filename will be used to check if the file already exists.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesPutFileUsingFilenameWithHttpInfo($article_system_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['articlesPutFileUsingFilename'][0])
    {
        $request = $this->articlesPutFileUsingFilenameRequest($article_system_id, $file_name, $post_file_no_filename_model, $contentType);

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
     * Operation articlesPutFileUsingFilenameAsync
     *
     * Create or update a file which is attached to an article. The filename will be used to check if the file already exists.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutFileUsingFilenameAsync($article_system_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['articlesPutFileUsingFilename'][0])
    {
        return $this->articlesPutFileUsingFilenameAsyncWithHttpInfo($article_system_id, $file_name, $post_file_no_filename_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesPutFileUsingFilenameAsyncWithHttpInfo
     *
     * Create or update a file which is attached to an article. The filename will be used to check if the file already exists.
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesPutFileUsingFilenameAsyncWithHttpInfo($article_system_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['articlesPutFileUsingFilename'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->articlesPutFileUsingFilenameRequest($article_system_id, $file_name, $post_file_no_filename_model, $contentType);

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
     * Create request for operation 'articlesPutFileUsingFilename'
     *
     * @param  int $article_system_id Article system ID for the article which the file is attached to. (required)
     * @param  string $file_name File name. (required)
     * @param  \OngoingAPI\Model\PostFileNoFilenameModel $post_file_no_filename_model File object, containing all file data. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesPutFileUsingFilename'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesPutFileUsingFilenameRequest($article_system_id, $file_name, $post_file_no_filename_model, string $contentType = self::contentTypes['articlesPutFileUsingFilename'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesPutFileUsingFilename'
            );
        }

        // verify the required parameter 'file_name' is set
        if ($file_name === null || (is_array($file_name) && count($file_name) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $file_name when calling articlesPutFileUsingFilename'
            );
        }

        // verify the required parameter 'post_file_no_filename_model' is set
        if ($post_file_no_filename_model === null || (is_array($post_file_no_filename_model) && count($post_file_no_filename_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $post_file_no_filename_model when calling articlesPutFileUsingFilename'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/files';
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
     * Operation articlesSetArticleClasses
     *
     * Set the classes on an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PortArticleArticleClassesModel $port_article_article_classes_model Contains the article class IDs. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesSetArticleClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return \OngoingAPI\Model\PostFileResponse
     */
    public function articlesSetArticleClasses($article_system_id, $port_article_article_classes_model, string $contentType = self::contentTypes['articlesSetArticleClasses'][0])
    {
        list($response) = $this->articlesSetArticleClassesWithHttpInfo($article_system_id, $port_article_article_classes_model, $contentType);
        return $response;
    }

    /**
     * Operation articlesSetArticleClassesWithHttpInfo
     *
     * Set the classes on an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PortArticleArticleClassesModel $port_article_article_classes_model Contains the article class IDs. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesSetArticleClasses'] to see the possible values for this operation
     *
     * @throws \OngoingAPI\ApiException on non-2xx response or if the response body is not in the expected format
     * @throws \InvalidArgumentException
     * @return array of \OngoingAPI\Model\PostFileResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function articlesSetArticleClassesWithHttpInfo($article_system_id, $port_article_article_classes_model, string $contentType = self::contentTypes['articlesSetArticleClasses'][0])
    {
        $request = $this->articlesSetArticleClassesRequest($article_system_id, $port_article_article_classes_model, $contentType);

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
     * Operation articlesSetArticleClassesAsync
     *
     * Set the classes on an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PortArticleArticleClassesModel $port_article_article_classes_model Contains the article class IDs. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesSetArticleClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesSetArticleClassesAsync($article_system_id, $port_article_article_classes_model, string $contentType = self::contentTypes['articlesSetArticleClasses'][0])
    {
        return $this->articlesSetArticleClassesAsyncWithHttpInfo($article_system_id, $port_article_article_classes_model, $contentType)
            ->then(
                function ($response) {
                    return $response[0];
                }
            );
    }

    /**
     * Operation articlesSetArticleClassesAsyncWithHttpInfo
     *
     * Set the classes on an article.
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PortArticleArticleClassesModel $port_article_article_classes_model Contains the article class IDs. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesSetArticleClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function articlesSetArticleClassesAsyncWithHttpInfo($article_system_id, $port_article_article_classes_model, string $contentType = self::contentTypes['articlesSetArticleClasses'][0])
    {
        $returnType = '\OngoingAPI\Model\PostFileResponse';
        $request = $this->articlesSetArticleClassesRequest($article_system_id, $port_article_article_classes_model, $contentType);

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
     * Create request for operation 'articlesSetArticleClasses'
     *
     * @param  int $article_system_id Article system ID. (required)
     * @param  \OngoingAPI\Model\PortArticleArticleClassesModel $port_article_article_classes_model Contains the article class IDs. (required)
     * @param  string $contentType The value for the Content-Type header. Check self::contentTypes['articlesSetArticleClasses'] to see the possible values for this operation
     *
     * @throws \InvalidArgumentException
     * @return \GuzzleHttp\Psr7\Request
     */
    public function articlesSetArticleClassesRequest($article_system_id, $port_article_article_classes_model, string $contentType = self::contentTypes['articlesSetArticleClasses'][0])
    {

        // verify the required parameter 'article_system_id' is set
        if ($article_system_id === null || (is_array($article_system_id) && count($article_system_id) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $article_system_id when calling articlesSetArticleClasses'
            );
        }

        // verify the required parameter 'port_article_article_classes_model' is set
        if ($port_article_article_classes_model === null || (is_array($port_article_article_classes_model) && count($port_article_article_classes_model) === 0)) {
            throw new \InvalidArgumentException(
                'Missing the required parameter $port_article_article_classes_model when calling articlesSetArticleClasses'
            );
        }


        $resourcePath = '/api/v1/articles/{articleSystemId}/classes';
        $formParams = [];
        $queryParams = [];
        $headerParams = [];
        $httpBody = '';
        $multipart = false;



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
        if (isset($port_article_article_classes_model)) {
            if (stripos($headers['Content-Type'], 'application/json') !== false) {
                # if Content-Type contains "application/json", json_encode the body
                $httpBody = \GuzzleHttp\Utils::jsonEncode(ObjectSerializer::sanitizeForSerialization($port_article_article_classes_model));
            } else {
                $httpBody = $port_article_article_classes_model;
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
