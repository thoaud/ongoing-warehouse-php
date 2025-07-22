<?php
/**
 * GetOrderPickedArticleItem
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
 * GetOrderPickedArticleItem Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class GetOrderPickedArticleItem implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'GetOrderPickedArticleItem';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'second_number_of_items' => 'float',
        'article_item_id' => 'int',
        'number_of_items' => 'float',
        'in_date' => '\DateTime',
        'serial' => 'string',
        'case_number' => 'string',
        'batch_number' => 'string',
        'container' => 'string',
        'comment' => 'string',
        'weight' => 'float',
        'volume' => 'float',
        'is_picked' => 'bool',
        'is_returned' => 'bool',
        'expiry_date' => '\DateTime',
        'return_date' => '\DateTime',
        'picked_time' => '\DateTime',
        'return_cause' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'location' => 'string',
        'location_type_code' => 'string',
        'article_item_status' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'free_text1' => 'string',
        'packed_time' => '\DateTime',
        'handling' => '\OngoingAPI\Model\GetOrderPickedArticleItemHandling',
        'parcel' => '\OngoingAPI\Model\GetOrderPickedArticleItemParcel',
        'zone_name' => 'string',
        'purchase_order_info' => '\OngoingAPI\Model\GetOrderPickedArticleItemPurchaseOrderInfo',
        'original_article_item_id' => 'int',
        'production_date_date' => '\DateTime'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'second_number_of_items' => 'decimal',
        'article_item_id' => 'int32',
        'number_of_items' => 'decimal',
        'in_date' => 'date-time',
        'serial' => null,
        'case_number' => null,
        'batch_number' => null,
        'container' => null,
        'comment' => null,
        'weight' => 'decimal',
        'volume' => 'decimal',
        'is_picked' => null,
        'is_returned' => null,
        'expiry_date' => 'date-time',
        'return_date' => 'date-time',
        'picked_time' => 'date-time',
        'return_cause' => null,
        'location' => null,
        'location_type_code' => null,
        'article_item_status' => null,
        'free_text1' => null,
        'packed_time' => 'date-time',
        'handling' => null,
        'parcel' => null,
        'zone_name' => null,
        'purchase_order_info' => null,
        'original_article_item_id' => 'int32',
        'production_date_date' => 'date-time'
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'second_number_of_items' => true,
        'article_item_id' => false,
        'number_of_items' => false,
        'in_date' => false,
        'serial' => true,
        'case_number' => true,
        'batch_number' => true,
        'container' => true,
        'comment' => true,
        'weight' => true,
        'volume' => true,
        'is_picked' => false,
        'is_returned' => false,
        'expiry_date' => true,
        'return_date' => true,
        'picked_time' => true,
        'return_cause' => true,
        'location' => true,
        'location_type_code' => true,
        'article_item_status' => true,
        'free_text1' => true,
        'packed_time' => true,
        'handling' => true,
        'parcel' => true,
        'zone_name' => true,
        'purchase_order_info' => true,
        'original_article_item_id' => false,
        'production_date_date' => true
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
        'second_number_of_items' => 'secondNumberOfItems',
        'article_item_id' => 'articleItemId',
        'number_of_items' => 'numberOfItems',
        'in_date' => 'inDate',
        'serial' => 'serial',
        'case_number' => 'caseNumber',
        'batch_number' => 'batchNumber',
        'container' => 'container',
        'comment' => 'comment',
        'weight' => 'weight',
        'volume' => 'volume',
        'is_picked' => 'isPicked',
        'is_returned' => 'isReturned',
        'expiry_date' => 'expiryDate',
        'return_date' => 'returnDate',
        'picked_time' => 'pickedTime',
        'return_cause' => 'returnCause',
        'location' => 'location',
        'location_type_code' => 'locationTypeCode',
        'article_item_status' => 'articleItemStatus',
        'free_text1' => 'freeText1',
        'packed_time' => 'packedTime',
        'handling' => 'handling',
        'parcel' => 'parcel',
        'zone_name' => 'zoneName',
        'purchase_order_info' => 'purchaseOrderInfo',
        'original_article_item_id' => 'originalArticleItemId',
        'production_date_date' => 'productionDateDate'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'second_number_of_items' => 'setSecondNumberOfItems',
        'article_item_id' => 'setArticleItemId',
        'number_of_items' => 'setNumberOfItems',
        'in_date' => 'setInDate',
        'serial' => 'setSerial',
        'case_number' => 'setCaseNumber',
        'batch_number' => 'setBatchNumber',
        'container' => 'setContainer',
        'comment' => 'setComment',
        'weight' => 'setWeight',
        'volume' => 'setVolume',
        'is_picked' => 'setIsPicked',
        'is_returned' => 'setIsReturned',
        'expiry_date' => 'setExpiryDate',
        'return_date' => 'setReturnDate',
        'picked_time' => 'setPickedTime',
        'return_cause' => 'setReturnCause',
        'location' => 'setLocation',
        'location_type_code' => 'setLocationTypeCode',
        'article_item_status' => 'setArticleItemStatus',
        'free_text1' => 'setFreeText1',
        'packed_time' => 'setPackedTime',
        'handling' => 'setHandling',
        'parcel' => 'setParcel',
        'zone_name' => 'setZoneName',
        'purchase_order_info' => 'setPurchaseOrderInfo',
        'original_article_item_id' => 'setOriginalArticleItemId',
        'production_date_date' => 'setProductionDateDate'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'second_number_of_items' => 'getSecondNumberOfItems',
        'article_item_id' => 'getArticleItemId',
        'number_of_items' => 'getNumberOfItems',
        'in_date' => 'getInDate',
        'serial' => 'getSerial',
        'case_number' => 'getCaseNumber',
        'batch_number' => 'getBatchNumber',
        'container' => 'getContainer',
        'comment' => 'getComment',
        'weight' => 'getWeight',
        'volume' => 'getVolume',
        'is_picked' => 'getIsPicked',
        'is_returned' => 'getIsReturned',
        'expiry_date' => 'getExpiryDate',
        'return_date' => 'getReturnDate',
        'picked_time' => 'getPickedTime',
        'return_cause' => 'getReturnCause',
        'location' => 'getLocation',
        'location_type_code' => 'getLocationTypeCode',
        'article_item_status' => 'getArticleItemStatus',
        'free_text1' => 'getFreeText1',
        'packed_time' => 'getPackedTime',
        'handling' => 'getHandling',
        'parcel' => 'getParcel',
        'zone_name' => 'getZoneName',
        'purchase_order_info' => 'getPurchaseOrderInfo',
        'original_article_item_id' => 'getOriginalArticleItemId',
        'production_date_date' => 'getProductionDateDate'
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
        $this->setIfExists('second_number_of_items', $data ?? [], null);
        $this->setIfExists('article_item_id', $data ?? [], null);
        $this->setIfExists('number_of_items', $data ?? [], null);
        $this->setIfExists('in_date', $data ?? [], null);
        $this->setIfExists('serial', $data ?? [], null);
        $this->setIfExists('case_number', $data ?? [], null);
        $this->setIfExists('batch_number', $data ?? [], null);
        $this->setIfExists('container', $data ?? [], null);
        $this->setIfExists('comment', $data ?? [], null);
        $this->setIfExists('weight', $data ?? [], null);
        $this->setIfExists('volume', $data ?? [], null);
        $this->setIfExists('is_picked', $data ?? [], null);
        $this->setIfExists('is_returned', $data ?? [], null);
        $this->setIfExists('expiry_date', $data ?? [], null);
        $this->setIfExists('return_date', $data ?? [], null);
        $this->setIfExists('picked_time', $data ?? [], null);
        $this->setIfExists('return_cause', $data ?? [], null);
        $this->setIfExists('location', $data ?? [], null);
        $this->setIfExists('location_type_code', $data ?? [], null);
        $this->setIfExists('article_item_status', $data ?? [], null);
        $this->setIfExists('free_text1', $data ?? [], null);
        $this->setIfExists('packed_time', $data ?? [], null);
        $this->setIfExists('handling', $data ?? [], null);
        $this->setIfExists('parcel', $data ?? [], null);
        $this->setIfExists('zone_name', $data ?? [], null);
        $this->setIfExists('purchase_order_info', $data ?? [], null);
        $this->setIfExists('original_article_item_id', $data ?? [], null);
        $this->setIfExists('production_date_date', $data ?? [], null);
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
     * Gets second_number_of_items
     *
     * @return float|null
     */
    public function getSecondNumberOfItems()
    {
        return $this->container['second_number_of_items'];
    }

    /**
     * Sets second_number_of_items
     *
     * @param float|null $second_number_of_items second_number_of_items
     *
     * @return self
     */
    public function setSecondNumberOfItems($second_number_of_items)
    {
        if (is_null($second_number_of_items)) {
            array_push($this->openAPINullablesSetToNull, 'second_number_of_items');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('second_number_of_items', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['second_number_of_items'] = $second_number_of_items;

        return $this;
    }

    /**
     * Gets article_item_id
     *
     * @return int|null
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
     * Gets number_of_items
     *
     * @return float|null
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
            throw new \InvalidArgumentException('non-nullable in_date cannot be null');
        }
        $this->container['in_date'] = $in_date;

        return $this;
    }

    /**
     * Gets serial
     *
     * @return string|null
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
     * Gets case_number
     *
     * @return string|null
     */
    public function getCaseNumber()
    {
        return $this->container['case_number'];
    }

    /**
     * Sets case_number
     *
     * @param string|null $case_number case_number
     *
     * @return self
     */
    public function setCaseNumber($case_number)
    {
        if (is_null($case_number)) {
            array_push($this->openAPINullablesSetToNull, 'case_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('case_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['case_number'] = $case_number;

        return $this;
    }

    /**
     * Gets batch_number
     *
     * @return string|null
     */
    public function getBatchNumber()
    {
        return $this->container['batch_number'];
    }

    /**
     * Sets batch_number
     *
     * @param string|null $batch_number batch_number
     *
     * @return self
     */
    public function setBatchNumber($batch_number)
    {
        if (is_null($batch_number)) {
            array_push($this->openAPINullablesSetToNull, 'batch_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('batch_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['batch_number'] = $batch_number;

        return $this;
    }

    /**
     * Gets container
     *
     * @return string|null
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
     * Gets weight
     *
     * @return float|null
     */
    public function getWeight()
    {
        return $this->container['weight'];
    }

    /**
     * Sets weight
     *
     * @param float|null $weight weight
     *
     * @return self
     */
    public function setWeight($weight)
    {
        if (is_null($weight)) {
            array_push($this->openAPINullablesSetToNull, 'weight');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('weight', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['weight'] = $weight;

        return $this;
    }

    /**
     * Gets volume
     *
     * @return float|null
     */
    public function getVolume()
    {
        return $this->container['volume'];
    }

    /**
     * Sets volume
     *
     * @param float|null $volume volume
     *
     * @return self
     */
    public function setVolume($volume)
    {
        if (is_null($volume)) {
            array_push($this->openAPINullablesSetToNull, 'volume');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('volume', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['volume'] = $volume;

        return $this;
    }

    /**
     * Gets is_picked
     *
     * @return bool|null
     */
    public function getIsPicked()
    {
        return $this->container['is_picked'];
    }

    /**
     * Sets is_picked
     *
     * @param bool|null $is_picked is_picked
     *
     * @return self
     */
    public function setIsPicked($is_picked)
    {
        if (is_null($is_picked)) {
            throw new \InvalidArgumentException('non-nullable is_picked cannot be null');
        }
        $this->container['is_picked'] = $is_picked;

        return $this;
    }

    /**
     * Gets is_returned
     *
     * @return bool|null
     */
    public function getIsReturned()
    {
        return $this->container['is_returned'];
    }

    /**
     * Sets is_returned
     *
     * @param bool|null $is_returned is_returned
     *
     * @return self
     */
    public function setIsReturned($is_returned)
    {
        if (is_null($is_returned)) {
            throw new \InvalidArgumentException('non-nullable is_returned cannot be null');
        }
        $this->container['is_returned'] = $is_returned;

        return $this;
    }

    /**
     * Gets expiry_date
     *
     * @return \DateTime|null
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
     * Gets return_date
     *
     * @return \DateTime|null
     */
    public function getReturnDate()
    {
        return $this->container['return_date'];
    }

    /**
     * Sets return_date
     *
     * @param \DateTime|null $return_date return_date
     *
     * @return self
     */
    public function setReturnDate($return_date)
    {
        if (is_null($return_date)) {
            array_push($this->openAPINullablesSetToNull, 'return_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('return_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['return_date'] = $return_date;

        return $this;
    }

    /**
     * Gets picked_time
     *
     * @return \DateTime|null
     */
    public function getPickedTime()
    {
        return $this->container['picked_time'];
    }

    /**
     * Sets picked_time
     *
     * @param \DateTime|null $picked_time picked_time
     *
     * @return self
     */
    public function setPickedTime($picked_time)
    {
        if (is_null($picked_time)) {
            array_push($this->openAPINullablesSetToNull, 'picked_time');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('picked_time', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['picked_time'] = $picked_time;

        return $this;
    }

    /**
     * Gets return_cause
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getReturnCause()
    {
        return $this->container['return_cause'];
    }

    /**
     * Sets return_cause
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $return_cause return_cause
     *
     * @return self
     */
    public function setReturnCause($return_cause)
    {
        if (is_null($return_cause)) {
            array_push($this->openAPINullablesSetToNull, 'return_cause');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('return_cause', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['return_cause'] = $return_cause;

        return $this;
    }

    /**
     * Gets location
     *
     * @return string|null
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
     * Gets location_type_code
     *
     * @return string|null
     */
    public function getLocationTypeCode()
    {
        return $this->container['location_type_code'];
    }

    /**
     * Sets location_type_code
     *
     * @param string|null $location_type_code location_type_code
     *
     * @return self
     */
    public function setLocationTypeCode($location_type_code)
    {
        if (is_null($location_type_code)) {
            array_push($this->openAPINullablesSetToNull, 'location_type_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('location_type_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['location_type_code'] = $location_type_code;

        return $this;
    }

    /**
     * Gets article_item_status
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getArticleItemStatus()
    {
        return $this->container['article_item_status'];
    }

    /**
     * Sets article_item_status
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $article_item_status article_item_status
     *
     * @return self
     */
    public function setArticleItemStatus($article_item_status)
    {
        if (is_null($article_item_status)) {
            array_push($this->openAPINullablesSetToNull, 'article_item_status');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_item_status', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_item_status'] = $article_item_status;

        return $this;
    }

    /**
     * Gets free_text1
     *
     * @return string|null
     */
    public function getFreeText1()
    {
        return $this->container['free_text1'];
    }

    /**
     * Sets free_text1
     *
     * @param string|null $free_text1 free_text1
     *
     * @return self
     */
    public function setFreeText1($free_text1)
    {
        if (is_null($free_text1)) {
            array_push($this->openAPINullablesSetToNull, 'free_text1');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('free_text1', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['free_text1'] = $free_text1;

        return $this;
    }

    /**
     * Gets packed_time
     *
     * @return \DateTime|null
     */
    public function getPackedTime()
    {
        return $this->container['packed_time'];
    }

    /**
     * Sets packed_time
     *
     * @param \DateTime|null $packed_time packed_time
     *
     * @return self
     */
    public function setPackedTime($packed_time)
    {
        if (is_null($packed_time)) {
            array_push($this->openAPINullablesSetToNull, 'packed_time');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('packed_time', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['packed_time'] = $packed_time;

        return $this;
    }

    /**
     * Gets handling
     *
     * @return \OngoingAPI\Model\GetOrderPickedArticleItemHandling|null
     */
    public function getHandling()
    {
        return $this->container['handling'];
    }

    /**
     * Sets handling
     *
     * @param \OngoingAPI\Model\GetOrderPickedArticleItemHandling|null $handling handling
     *
     * @return self
     */
    public function setHandling($handling)
    {
        if (is_null($handling)) {
            array_push($this->openAPINullablesSetToNull, 'handling');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('handling', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['handling'] = $handling;

        return $this;
    }

    /**
     * Gets parcel
     *
     * @return \OngoingAPI\Model\GetOrderPickedArticleItemParcel|null
     */
    public function getParcel()
    {
        return $this->container['parcel'];
    }

    /**
     * Sets parcel
     *
     * @param \OngoingAPI\Model\GetOrderPickedArticleItemParcel|null $parcel parcel
     *
     * @return self
     */
    public function setParcel($parcel)
    {
        if (is_null($parcel)) {
            array_push($this->openAPINullablesSetToNull, 'parcel');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('parcel', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['parcel'] = $parcel;

        return $this;
    }

    /**
     * Gets zone_name
     *
     * @return string|null
     */
    public function getZoneName()
    {
        return $this->container['zone_name'];
    }

    /**
     * Sets zone_name
     *
     * @param string|null $zone_name zone_name
     *
     * @return self
     */
    public function setZoneName($zone_name)
    {
        if (is_null($zone_name)) {
            array_push($this->openAPINullablesSetToNull, 'zone_name');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('zone_name', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['zone_name'] = $zone_name;

        return $this;
    }

    /**
     * Gets purchase_order_info
     *
     * @return \OngoingAPI\Model\GetOrderPickedArticleItemPurchaseOrderInfo|null
     */
    public function getPurchaseOrderInfo()
    {
        return $this->container['purchase_order_info'];
    }

    /**
     * Sets purchase_order_info
     *
     * @param \OngoingAPI\Model\GetOrderPickedArticleItemPurchaseOrderInfo|null $purchase_order_info purchase_order_info
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
     * Gets original_article_item_id
     *
     * @return int|null
     */
    public function getOriginalArticleItemId()
    {
        return $this->container['original_article_item_id'];
    }

    /**
     * Sets original_article_item_id
     *
     * @param int|null $original_article_item_id original_article_item_id
     *
     * @return self
     */
    public function setOriginalArticleItemId($original_article_item_id)
    {
        if (is_null($original_article_item_id)) {
            throw new \InvalidArgumentException('non-nullable original_article_item_id cannot be null');
        }
        $this->container['original_article_item_id'] = $original_article_item_id;

        return $this;
    }

    /**
     * Gets production_date_date
     *
     * @return \DateTime|null
     */
    public function getProductionDateDate()
    {
        return $this->container['production_date_date'];
    }

    /**
     * Sets production_date_date
     *
     * @param \DateTime|null $production_date_date production_date_date
     *
     * @return self
     */
    public function setProductionDateDate($production_date_date)
    {
        if (is_null($production_date_date)) {
            array_push($this->openAPINullablesSetToNull, 'production_date_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('production_date_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['production_date_date'] = $production_date_date;

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


