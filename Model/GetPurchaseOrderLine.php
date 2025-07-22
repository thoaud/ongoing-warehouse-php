<?php
/**
 * GetPurchaseOrderLine
 *
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

namespace OngoingAPI\Model;

use \ArrayAccess;
use \OngoingAPI\ObjectSerializer;

/**
 * GetPurchaseOrderLine Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class GetPurchaseOrderLine implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'GetPurchaseOrderLine';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'id' => 'int',
        'row_number' => 'string',
        'article' => '\OngoingAPI\Model\GetPurchaseOrderLineArticle',
        'comment' => 'string',
        'row_price' => 'float',
        'advised_number_of_items' => 'float',
        'received_number_of_items' => 'float',
        'reported_number_of_items' => 'float',
        'article_items' => '\OngoingAPI\Model\GetPurchaseOrderArticleItem[]',
        'sub_purchase_order_lines' => '\OngoingAPI\Model\GetPurchaseOrderLine[]',
        'external_order_line_id' => 'string',
        'line_type' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'free_values' => '\OngoingAPI\Model\GetPurchaseOrderLineFreeValues',
        'in_date' => '\DateTime',
        'text_lines' => '\OngoingAPI\Model\GetPurchaseOrderTextLine[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'id' => 'int32',
        'row_number' => null,
        'article' => null,
        'comment' => null,
        'row_price' => 'decimal',
        'advised_number_of_items' => 'decimal',
        'received_number_of_items' => 'decimal',
        'reported_number_of_items' => 'decimal',
        'article_items' => null,
        'sub_purchase_order_lines' => null,
        'external_order_line_id' => null,
        'line_type' => null,
        'free_values' => null,
        'in_date' => 'date-time',
        'text_lines' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'id' => false,
        'row_number' => true,
        'article' => true,
        'comment' => true,
        'row_price' => true,
        'advised_number_of_items' => false,
        'received_number_of_items' => false,
        'reported_number_of_items' => true,
        'article_items' => true,
        'sub_purchase_order_lines' => true,
        'external_order_line_id' => true,
        'line_type' => true,
        'free_values' => true,
        'in_date' => true,
        'text_lines' => true
    ];

    /**
      * If a nullable field gets set to null, insert it here
      *
      * @var boolean[]
      */
    protected array $openAPINullablesSetToNull = [];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of nullable properties
     *
     * @return array
     */
    protected static function openAPINullables(): array
    {
        return self::$openAPINullables;
    }

    /**
     * Array of nullable field names deliberately set to null
     *
     * @return boolean[]
     */
    private function getOpenAPINullablesSetToNull(): array
    {
        return $this->openAPINullablesSetToNull;
    }

    /**
     * Setter - Array of nullable field names deliberately set to null
     *
     * @param boolean[] $openAPINullablesSetToNull
     */
    private function setOpenAPINullablesSetToNull(array $openAPINullablesSetToNull): void
    {
        $this->openAPINullablesSetToNull = $openAPINullablesSetToNull;
    }

    /**
     * Checks if a property is nullable
     *
     * @param string $property
     * @return bool
     */
    public static function isNullable(string $property): bool
    {
        return self::openAPINullables()[$property] ?? false;
    }

    /**
     * Checks if a nullable property is set to null.
     *
     * @param string $property
     * @return bool
     */
    public function isNullableSetToNull(string $property): bool
    {
        return in_array($property, $this->getOpenAPINullablesSetToNull(), true);
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'id' => 'id',
        'row_number' => 'rowNumber',
        'article' => 'article',
        'comment' => 'comment',
        'row_price' => 'rowPrice',
        'advised_number_of_items' => 'advisedNumberOfItems',
        'received_number_of_items' => 'receivedNumberOfItems',
        'reported_number_of_items' => 'reportedNumberOfItems',
        'article_items' => 'articleItems',
        'sub_purchase_order_lines' => 'subPurchaseOrderLines',
        'external_order_line_id' => 'externalOrderLineId',
        'line_type' => 'lineType',
        'free_values' => 'freeValues',
        'in_date' => 'inDate',
        'text_lines' => 'textLines'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'id' => 'setId',
        'row_number' => 'setRowNumber',
        'article' => 'setArticle',
        'comment' => 'setComment',
        'row_price' => 'setRowPrice',
        'advised_number_of_items' => 'setAdvisedNumberOfItems',
        'received_number_of_items' => 'setReceivedNumberOfItems',
        'reported_number_of_items' => 'setReportedNumberOfItems',
        'article_items' => 'setArticleItems',
        'sub_purchase_order_lines' => 'setSubPurchaseOrderLines',
        'external_order_line_id' => 'setExternalOrderLineId',
        'line_type' => 'setLineType',
        'free_values' => 'setFreeValues',
        'in_date' => 'setInDate',
        'text_lines' => 'setTextLines'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'id' => 'getId',
        'row_number' => 'getRowNumber',
        'article' => 'getArticle',
        'comment' => 'getComment',
        'row_price' => 'getRowPrice',
        'advised_number_of_items' => 'getAdvisedNumberOfItems',
        'received_number_of_items' => 'getReceivedNumberOfItems',
        'reported_number_of_items' => 'getReportedNumberOfItems',
        'article_items' => 'getArticleItems',
        'sub_purchase_order_lines' => 'getSubPurchaseOrderLines',
        'external_order_line_id' => 'getExternalOrderLineId',
        'line_type' => 'getLineType',
        'free_values' => 'getFreeValues',
        'in_date' => 'getInDate',
        'text_lines' => 'getTextLines'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }


    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->setIfExists('id', $data ?? [], null);
        $this->setIfExists('row_number', $data ?? [], null);
        $this->setIfExists('article', $data ?? [], null);
        $this->setIfExists('comment', $data ?? [], null);
        $this->setIfExists('row_price', $data ?? [], null);
        $this->setIfExists('advised_number_of_items', $data ?? [], null);
        $this->setIfExists('received_number_of_items', $data ?? [], null);
        $this->setIfExists('reported_number_of_items', $data ?? [], null);
        $this->setIfExists('article_items', $data ?? [], null);
        $this->setIfExists('sub_purchase_order_lines', $data ?? [], null);
        $this->setIfExists('external_order_line_id', $data ?? [], null);
        $this->setIfExists('line_type', $data ?? [], null);
        $this->setIfExists('free_values', $data ?? [], null);
        $this->setIfExists('in_date', $data ?? [], null);
        $this->setIfExists('text_lines', $data ?? [], null);
    }

    /**
    * Sets $this->container[$variableName] to the given data or to the given default Value; if $variableName
    * is nullable and its value is set to null in the $fields array, then mark it as "set to null" in the
    * $this->openAPINullablesSetToNull array
    *
    * @param string $variableName
    * @param array  $fields
    * @param mixed  $defaultValue
    */
    private function setIfExists(string $variableName, array $fields, $defaultValue): void
    {
        if (self::isNullable($variableName) && array_key_exists($variableName, $fields) && is_null($fields[$variableName])) {
            $this->openAPINullablesSetToNull[] = $variableName;
        }

        $this->container[$variableName] = $fields[$variableName] ?? $defaultValue;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets id
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->container['id'];
    }

    /**
     * Sets id
     *
     * @param int|null $id id
     *
     * @return self
     */
    public function setId($id)
    {
        if (is_null($id)) {
            throw new \InvalidArgumentException('non-nullable id cannot be null');
        }
        $this->container['id'] = $id;

        return $this;
    }

    /**
     * Gets row_number
     *
     * @return string|null
     */
    public function getRowNumber()
    {
        return $this->container['row_number'];
    }

    /**
     * Sets row_number
     *
     * @param string|null $row_number row_number
     *
     * @return self
     */
    public function setRowNumber($row_number)
    {
        if (is_null($row_number)) {
            array_push($this->openAPINullablesSetToNull, 'row_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('row_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['row_number'] = $row_number;

        return $this;
    }

    /**
     * Gets article
     *
     * @return \OngoingAPI\Model\GetPurchaseOrderLineArticle|null
     */
    public function getArticle()
    {
        return $this->container['article'];
    }

    /**
     * Sets article
     *
     * @param \OngoingAPI\Model\GetPurchaseOrderLineArticle|null $article article
     *
     * @return self
     */
    public function setArticle($article)
    {
        if (is_null($article)) {
            array_push($this->openAPINullablesSetToNull, 'article');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article'] = $article;

        return $this;
    }

    /**
     * Gets comment
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->container['comment'];
    }

    /**
     * Sets comment
     *
     * @param string|null $comment comment
     *
     * @return self
     */
    public function setComment($comment)
    {
        if (is_null($comment)) {
            array_push($this->openAPINullablesSetToNull, 'comment');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('comment', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['comment'] = $comment;

        return $this;
    }

    /**
     * Gets row_price
     *
     * @return float|null
     */
    public function getRowPrice()
    {
        return $this->container['row_price'];
    }

    /**
     * Sets row_price
     *
     * @param float|null $row_price row_price
     *
     * @return self
     */
    public function setRowPrice($row_price)
    {
        if (is_null($row_price)) {
            array_push($this->openAPINullablesSetToNull, 'row_price');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('row_price', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['row_price'] = $row_price;

        return $this;
    }

    /**
     * Gets advised_number_of_items
     *
     * @return float|null
     */
    public function getAdvisedNumberOfItems()
    {
        return $this->container['advised_number_of_items'];
    }

    /**
     * Sets advised_number_of_items
     *
     * @param float|null $advised_number_of_items advised_number_of_items
     *
     * @return self
     */
    public function setAdvisedNumberOfItems($advised_number_of_items)
    {
        if (is_null($advised_number_of_items)) {
            throw new \InvalidArgumentException('non-nullable advised_number_of_items cannot be null');
        }
        $this->container['advised_number_of_items'] = $advised_number_of_items;

        return $this;
    }

    /**
     * Gets received_number_of_items
     *
     * @return float|null
     */
    public function getReceivedNumberOfItems()
    {
        return $this->container['received_number_of_items'];
    }

    /**
     * Sets received_number_of_items
     *
     * @param float|null $received_number_of_items received_number_of_items
     *
     * @return self
     */
    public function setReceivedNumberOfItems($received_number_of_items)
    {
        if (is_null($received_number_of_items)) {
            throw new \InvalidArgumentException('non-nullable received_number_of_items cannot be null');
        }
        $this->container['received_number_of_items'] = $received_number_of_items;

        return $this;
    }

    /**
     * Gets reported_number_of_items
     *
     * @return float|null
     */
    public function getReportedNumberOfItems()
    {
        return $this->container['reported_number_of_items'];
    }

    /**
     * Sets reported_number_of_items
     *
     * @param float|null $reported_number_of_items reported_number_of_items
     *
     * @return self
     */
    public function setReportedNumberOfItems($reported_number_of_items)
    {
        if (is_null($reported_number_of_items)) {
            array_push($this->openAPINullablesSetToNull, 'reported_number_of_items');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('reported_number_of_items', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['reported_number_of_items'] = $reported_number_of_items;

        return $this;
    }

    /**
     * Gets article_items
     *
     * @return \OngoingAPI\Model\GetPurchaseOrderArticleItem[]|null
     */
    public function getArticleItems()
    {
        return $this->container['article_items'];
    }

    /**
     * Sets article_items
     *
     * @param \OngoingAPI\Model\GetPurchaseOrderArticleItem[]|null $article_items article_items
     *
     * @return self
     */
    public function setArticleItems($article_items)
    {
        if (is_null($article_items)) {
            array_push($this->openAPINullablesSetToNull, 'article_items');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_items', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_items'] = $article_items;

        return $this;
    }

    /**
     * Gets sub_purchase_order_lines
     *
     * @return \OngoingAPI\Model\GetPurchaseOrderLine[]|null
     */
    public function getSubPurchaseOrderLines()
    {
        return $this->container['sub_purchase_order_lines'];
    }

    /**
     * Sets sub_purchase_order_lines
     *
     * @param \OngoingAPI\Model\GetPurchaseOrderLine[]|null $sub_purchase_order_lines sub_purchase_order_lines
     *
     * @return self
     */
    public function setSubPurchaseOrderLines($sub_purchase_order_lines)
    {
        if (is_null($sub_purchase_order_lines)) {
            array_push($this->openAPINullablesSetToNull, 'sub_purchase_order_lines');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('sub_purchase_order_lines', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['sub_purchase_order_lines'] = $sub_purchase_order_lines;

        return $this;
    }

    /**
     * Gets external_order_line_id
     *
     * @return string|null
     */
    public function getExternalOrderLineId()
    {
        return $this->container['external_order_line_id'];
    }

    /**
     * Sets external_order_line_id
     *
     * @param string|null $external_order_line_id external_order_line_id
     *
     * @return self
     */
    public function setExternalOrderLineId($external_order_line_id)
    {
        if (is_null($external_order_line_id)) {
            array_push($this->openAPINullablesSetToNull, 'external_order_line_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('external_order_line_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['external_order_line_id'] = $external_order_line_id;

        return $this;
    }

    /**
     * Gets line_type
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getLineType()
    {
        return $this->container['line_type'];
    }

    /**
     * Sets line_type
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $line_type line_type
     *
     * @return self
     */
    public function setLineType($line_type)
    {
        if (is_null($line_type)) {
            array_push($this->openAPINullablesSetToNull, 'line_type');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('line_type', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['line_type'] = $line_type;

        return $this;
    }

    /**
     * Gets free_values
     *
     * @return \OngoingAPI\Model\GetPurchaseOrderLineFreeValues|null
     */
    public function getFreeValues()
    {
        return $this->container['free_values'];
    }

    /**
     * Sets free_values
     *
     * @param \OngoingAPI\Model\GetPurchaseOrderLineFreeValues|null $free_values free_values
     *
     * @return self
     */
    public function setFreeValues($free_values)
    {
        if (is_null($free_values)) {
            array_push($this->openAPINullablesSetToNull, 'free_values');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('free_values', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['free_values'] = $free_values;

        return $this;
    }

    /**
     * Gets in_date
     *
     * @return \DateTime|null
     */
    public function getInDate()
    {
        return $this->container['in_date'];
    }

    /**
     * Sets in_date
     *
     * @param \DateTime|null $in_date in_date
     *
     * @return self
     */
    public function setInDate($in_date)
    {
        if (is_null($in_date)) {
            array_push($this->openAPINullablesSetToNull, 'in_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('in_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['in_date'] = $in_date;

        return $this;
    }

    /**
     * Gets text_lines
     *
     * @return \OngoingAPI\Model\GetPurchaseOrderTextLine[]|null
     */
    public function getTextLines()
    {
        return $this->container['text_lines'];
    }

    /**
     * Sets text_lines
     *
     * @param \OngoingAPI\Model\GetPurchaseOrderTextLine[]|null $text_lines text_lines
     *
     * @return self
     */
    public function setTextLines($text_lines)
    {
        if (is_null($text_lines)) {
            array_push($this->openAPINullablesSetToNull, 'text_lines');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('text_lines', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['text_lines'] = $text_lines;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset): bool
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


