<?php
/**
 * GetArticleItemInfo
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
 * GetArticleItemInfo Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class GetArticleItemInfo implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'GetArticleItemInfo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'batch' => 'string',
        'container' => 'string',
        'expiry_date' => '\DateTime',
        'is_locked' => 'bool',
        'is_locked_for_sale' => 'bool',
        'location' => 'string',
        'number_of_items' => 'float',
        'serial' => 'string',
        'status' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'comment' => 'string',
        'warehouse' => '\OngoingAPI\Model\GetArticleItemInfoWarehouse',
        'in_date' => '\DateTime',
        'article_item_id' => 'int',
        'purchase_order_info' => '\OngoingAPI\Model\GetArticleItemInfoPurchaseOrderInfo',
        'lock_causes' => '\OngoingAPI\Model\GetArticleItemInfoLockCauses'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'batch' => null,
        'container' => null,
        'expiry_date' => 'date-time',
        'is_locked' => null,
        'is_locked_for_sale' => null,
        'location' => null,
        'number_of_items' => 'decimal',
        'serial' => null,
        'status' => null,
        'comment' => null,
        'warehouse' => null,
        'in_date' => 'date-time',
        'article_item_id' => 'int32',
        'purchase_order_info' => null,
        'lock_causes' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'batch' => true,
        'container' => true,
        'expiry_date' => true,
        'is_locked' => false,
        'is_locked_for_sale' => false,
        'location' => true,
        'number_of_items' => false,
        'serial' => true,
        'status' => true,
        'comment' => true,
        'warehouse' => true,
        'in_date' => false,
        'article_item_id' => false,
        'purchase_order_info' => true,
        'lock_causes' => true
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
        'batch' => 'batch',
        'container' => 'container',
        'expiry_date' => 'expiryDate',
        'is_locked' => 'isLocked',
        'is_locked_for_sale' => 'isLockedForSale',
        'location' => 'location',
        'number_of_items' => 'numberOfItems',
        'serial' => 'serial',
        'status' => 'status',
        'comment' => 'comment',
        'warehouse' => 'warehouse',
        'in_date' => 'inDate',
        'article_item_id' => 'articleItemId',
        'purchase_order_info' => 'purchaseOrderInfo',
        'lock_causes' => 'lockCauses'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'batch' => 'setBatch',
        'container' => 'setContainer',
        'expiry_date' => 'setExpiryDate',
        'is_locked' => 'setIsLocked',
        'is_locked_for_sale' => 'setIsLockedForSale',
        'location' => 'setLocation',
        'number_of_items' => 'setNumberOfItems',
        'serial' => 'setSerial',
        'status' => 'setStatus',
        'comment' => 'setComment',
        'warehouse' => 'setWarehouse',
        'in_date' => 'setInDate',
        'article_item_id' => 'setArticleItemId',
        'purchase_order_info' => 'setPurchaseOrderInfo',
        'lock_causes' => 'setLockCauses'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'batch' => 'getBatch',
        'container' => 'getContainer',
        'expiry_date' => 'getExpiryDate',
        'is_locked' => 'getIsLocked',
        'is_locked_for_sale' => 'getIsLockedForSale',
        'location' => 'getLocation',
        'number_of_items' => 'getNumberOfItems',
        'serial' => 'getSerial',
        'status' => 'getStatus',
        'comment' => 'getComment',
        'warehouse' => 'getWarehouse',
        'in_date' => 'getInDate',
        'article_item_id' => 'getArticleItemId',
        'purchase_order_info' => 'getPurchaseOrderInfo',
        'lock_causes' => 'getLockCauses'
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
        $this->setIfExists('batch', $data ?? [], null);
        $this->setIfExists('container', $data ?? [], null);
        $this->setIfExists('expiry_date', $data ?? [], null);
        $this->setIfExists('is_locked', $data ?? [], null);
        $this->setIfExists('is_locked_for_sale', $data ?? [], null);
        $this->setIfExists('location', $data ?? [], null);
        $this->setIfExists('number_of_items', $data ?? [], null);
        $this->setIfExists('serial', $data ?? [], null);
        $this->setIfExists('status', $data ?? [], null);
        $this->setIfExists('comment', $data ?? [], null);
        $this->setIfExists('warehouse', $data ?? [], null);
        $this->setIfExists('in_date', $data ?? [], null);
        $this->setIfExists('article_item_id', $data ?? [], null);
        $this->setIfExists('purchase_order_info', $data ?? [], null);
        $this->setIfExists('lock_causes', $data ?? [], null);
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
     * Gets the batch number for this article item.
     *
     * @return string|null The batch number
     */
    public function getBatch()
    {
        return $this->container['batch'];
    }

    /**
     * Sets batch
     *
     * @param string|null $batch batch
     *
     * @return self
     */
    public function setBatch($batch)
    {
        if (is_null($batch)) {
            array_push($this->openAPINullablesSetToNull, 'batch');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('batch', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['batch'] = $batch;

        return $this;
    }

    /**
     * Gets the container for this article item.
     *
     * @return string|null The container
     */
    public function getContainer()
    {
        return $this->container['container'];
    }

    /**
     * Sets container
     *
     * @param string|null $container container
     *
     * @return self
     */
    public function setContainer($container)
    {
        if (is_null($container)) {
            array_push($this->openAPINullablesSetToNull, 'container');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('container', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['container'] = $container;

        return $this;
    }

    /**
     * Gets the expiry date for this article item.
     *
     * @return \DateTime|null The expiry date
     */
    public function getExpiryDate()
    {
        return $this->container['expiry_date'];
    }

    /**
     * Sets expiry_date
     *
     * @param \DateTime|null $expiry_date expiry_date
     *
     * @return self
     */
    public function setExpiryDate($expiry_date)
    {
        if (is_null($expiry_date)) {
            array_push($this->openAPINullablesSetToNull, 'expiry_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('expiry_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['expiry_date'] = $expiry_date;

        return $this;
    }

    /**
     * Gets the lock status for this article item.
     *
     * @return bool|null True if locked, false otherwise
     */
    public function getIsLocked()
    {
        return $this->container['is_locked'];
    }

    /**
     * Sets is_locked
     *
     * @param bool|null $is_locked is_locked
     *
     * @return self
     */
    public function setIsLocked($is_locked)
    {
        if (is_null($is_locked)) {
            throw new \InvalidArgumentException('non-nullable is_locked cannot be null');
        }
        $this->container['is_locked'] = $is_locked;

        return $this;
    }

    /**
     * Gets the lock for sale status for this article item.
     *
     * @return bool|null True if locked for sale, false otherwise
     */
    public function getIsLockedForSale()
    {
        return $this->container['is_locked_for_sale'];
    }

    /**
     * Sets is_locked_for_sale
     *
     * @param bool|null $is_locked_for_sale is_locked_for_sale
     *
     * @return self
     */
    public function setIsLockedForSale($is_locked_for_sale)
    {
        if (is_null($is_locked_for_sale)) {
            throw new \InvalidArgumentException('non-nullable is_locked_for_sale cannot be null');
        }
        $this->container['is_locked_for_sale'] = $is_locked_for_sale;

        return $this;
    }

    /**
     * Gets the location for this article item.
     *
     * @return string|null The location
     */
    public function getLocation()
    {
        return $this->container['location'];
    }

    /**
     * Sets location
     *
     * @param string|null $location location
     *
     * @return self
     */
    public function setLocation($location)
    {
        if (is_null($location)) {
            array_push($this->openAPINullablesSetToNull, 'location');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('location', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['location'] = $location;

        return $this;
    }

    /**
     * Gets the number of items for this article item.
     *
     * @return float|null The number of items
     */
    public function getNumberOfItems()
    {
        return $this->container['number_of_items'];
    }

    /**
     * Sets number_of_items
     *
     * @param float|null $number_of_items number_of_items
     *
     * @return self
     */
    public function setNumberOfItems($number_of_items)
    {
        if (is_null($number_of_items)) {
            throw new \InvalidArgumentException('non-nullable number_of_items cannot be null');
        }
        $this->container['number_of_items'] = $number_of_items;

        return $this;
    }

    /**
     * Gets the serial number for this article item.
     *
     * @return string|null The serial number
     */
    public function getSerial()
    {
        return $this->container['serial'];
    }

    /**
     * Sets serial
     *
     * @param string|null $serial serial
     *
     * @return self
     */
    public function setSerial($serial)
    {
        if (is_null($serial)) {
            array_push($this->openAPINullablesSetToNull, 'serial');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('serial', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['serial'] = $serial;

        return $this;
    }

    /**
     * Gets the status object for this article item.
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null The status object
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $status status
     *
     * @return self
     */
    public function setStatus($status)
    {
        if (is_null($status)) {
            array_push($this->openAPINullablesSetToNull, 'status');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('status', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets the status code for this article item, if available.
     *
     * @return string|null The status code
     */
    public function getStatusCode()
    {
        $status = $this->getStatus();
        return $status ? $status->getStatusCode() : null;
    }

    /**
     * Gets the comment for this article item.
     *
     * @return string|null The comment
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
     * Gets the warehouse object for this article item.
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoWarehouse|null The warehouse object
     */
    public function getWarehouse()
    {
        return $this->container['warehouse'];
    }

    /**
     * Sets warehouse
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoWarehouse|null $warehouse warehouse
     *
     * @return self
     */
    public function setWarehouse($warehouse)
    {
        if (is_null($warehouse)) {
            array_push($this->openAPINullablesSetToNull, 'warehouse');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('warehouse', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['warehouse'] = $warehouse;

        return $this;
    }

    /**
     * Gets the in date for this article item.
     *
     * @return \DateTime|null The in date
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
            throw new \InvalidArgumentException('non-nullable in_date cannot be null');
        }
        $this->container['in_date'] = $in_date;

        return $this;
    }

    /**
     * Gets the article item ID for this article item.
     *
     * @return int|null The article item ID
     */
    public function getArticleItemId()
    {
        return $this->container['article_item_id'];
    }

    /**
     * Sets article_item_id
     *
     * @param int|null $article_item_id article_item_id
     *
     * @return self
     */
    public function setArticleItemId($article_item_id)
    {
        if (is_null($article_item_id)) {
            throw new \InvalidArgumentException('non-nullable article_item_id cannot be null');
        }
        $this->container['article_item_id'] = $article_item_id;

        return $this;
    }

    /**
     * Gets the purchase order info object for this article item.
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoPurchaseOrderInfo|null The purchase order info object
     */
    public function getPurchaseOrderInfo()
    {
        return $this->container['purchase_order_info'];
    }

    /**
     * Sets purchase_order_info
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoPurchaseOrderInfo|null $purchase_order_info purchase_order_info
     *
     * @return self
     */
    public function setPurchaseOrderInfo($purchase_order_info)
    {
        if (is_null($purchase_order_info)) {
            array_push($this->openAPINullablesSetToNull, 'purchase_order_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('purchase_order_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['purchase_order_info'] = $purchase_order_info;

        return $this;
    }

    /**
     * Gets the lock causes object for this article item.
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoLockCauses|null The lock causes object
     */
    public function getLockCauses()
    {
        return $this->container['lock_causes'];
    }

    /**
     * Sets lock_causes
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoLockCauses|null $lock_causes lock_causes
     *
     * @return self
     */
    public function setLockCauses($lock_causes)
    {
        if (is_null($lock_causes)) {
            array_push($this->openAPINullablesSetToNull, 'lock_causes');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('lock_causes', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['lock_causes'] = $lock_causes;

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


