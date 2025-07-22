<?php
/**
 * PostPurchaseOrderModel
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
 * PostPurchaseOrderModel Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class PostPurchaseOrderModel implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'PostPurchaseOrderModel';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'goods_owner_id' => 'int',
        'purchase_order_number' => 'string',
        'supplier_order_number' => 'string',
        'goods_owner_reference' => 'string',
        'reference_number' => 'string',
        'in_date' => '\DateTime',
        'supplier_info' => '\OngoingAPI\Model\PostPurchaseOrderModelSupplierInfo',
        'purchase_order_type' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'purchase_order_lines' => '\OngoingAPI\Model\PostPurchaseOrderLine[]',
        'purchase_order_remark' => 'string',
        'warehouse_id' => 'int',
        'free_values' => '\OngoingAPI\Model\PostPurchaseOrderModelFreeValues',
        'advanced' => '\OngoingAPI\Model\PostPurchaseOrderModelAdvanced',
        'customs_info' => '\OngoingAPI\Model\PostPurchaseOrderModelCustomsInfo',
        'seller_info' => '\OngoingAPI\Model\PostPurchaseOrderModelSellerInfo',
        'invoice_number' => 'string',
        'classes' => '\OngoingAPI\Model\PostPurchaseOrderClass[]',
        'tracking' => '\OngoingAPI\Model\PostPurchaseOrderTracking[]',
        'text_lines' => '\OngoingAPI\Model\PostPurchaseOrderTextLine[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'goods_owner_id' => 'int32',
        'purchase_order_number' => null,
        'supplier_order_number' => null,
        'goods_owner_reference' => null,
        'reference_number' => null,
        'in_date' => 'date-time',
        'supplier_info' => null,
        'purchase_order_type' => null,
        'purchase_order_lines' => null,
        'purchase_order_remark' => null,
        'warehouse_id' => 'int32',
        'free_values' => null,
        'advanced' => null,
        'customs_info' => null,
        'seller_info' => null,
        'invoice_number' => null,
        'classes' => null,
        'tracking' => null,
        'text_lines' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'goods_owner_id' => false,
        'purchase_order_number' => false,
        'supplier_order_number' => true,
        'goods_owner_reference' => true,
        'reference_number' => true,
        'in_date' => true,
        'supplier_info' => true,
        'purchase_order_type' => true,
        'purchase_order_lines' => true,
        'purchase_order_remark' => true,
        'warehouse_id' => true,
        'free_values' => true,
        'advanced' => true,
        'customs_info' => true,
        'seller_info' => true,
        'invoice_number' => true,
        'classes' => true,
        'tracking' => true,
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
        'goods_owner_id' => 'goodsOwnerId',
        'purchase_order_number' => 'purchaseOrderNumber',
        'supplier_order_number' => 'supplierOrderNumber',
        'goods_owner_reference' => 'goodsOwnerReference',
        'reference_number' => 'referenceNumber',
        'in_date' => 'inDate',
        'supplier_info' => 'supplierInfo',
        'purchase_order_type' => 'purchaseOrderType',
        'purchase_order_lines' => 'purchaseOrderLines',
        'purchase_order_remark' => 'purchaseOrderRemark',
        'warehouse_id' => 'warehouseId',
        'free_values' => 'freeValues',
        'advanced' => 'advanced',
        'customs_info' => 'customsInfo',
        'seller_info' => 'sellerInfo',
        'invoice_number' => 'invoiceNumber',
        'classes' => 'classes',
        'tracking' => 'tracking',
        'text_lines' => 'textLines'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'goods_owner_id' => 'setGoodsOwnerId',
        'purchase_order_number' => 'setPurchaseOrderNumber',
        'supplier_order_number' => 'setSupplierOrderNumber',
        'goods_owner_reference' => 'setGoodsOwnerReference',
        'reference_number' => 'setReferenceNumber',
        'in_date' => 'setInDate',
        'supplier_info' => 'setSupplierInfo',
        'purchase_order_type' => 'setPurchaseOrderType',
        'purchase_order_lines' => 'setPurchaseOrderLines',
        'purchase_order_remark' => 'setPurchaseOrderRemark',
        'warehouse_id' => 'setWarehouseId',
        'free_values' => 'setFreeValues',
        'advanced' => 'setAdvanced',
        'customs_info' => 'setCustomsInfo',
        'seller_info' => 'setSellerInfo',
        'invoice_number' => 'setInvoiceNumber',
        'classes' => 'setClasses',
        'tracking' => 'setTracking',
        'text_lines' => 'setTextLines'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'goods_owner_id' => 'getGoodsOwnerId',
        'purchase_order_number' => 'getPurchaseOrderNumber',
        'supplier_order_number' => 'getSupplierOrderNumber',
        'goods_owner_reference' => 'getGoodsOwnerReference',
        'reference_number' => 'getReferenceNumber',
        'in_date' => 'getInDate',
        'supplier_info' => 'getSupplierInfo',
        'purchase_order_type' => 'getPurchaseOrderType',
        'purchase_order_lines' => 'getPurchaseOrderLines',
        'purchase_order_remark' => 'getPurchaseOrderRemark',
        'warehouse_id' => 'getWarehouseId',
        'free_values' => 'getFreeValues',
        'advanced' => 'getAdvanced',
        'customs_info' => 'getCustomsInfo',
        'seller_info' => 'getSellerInfo',
        'invoice_number' => 'getInvoiceNumber',
        'classes' => 'getClasses',
        'tracking' => 'getTracking',
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
        $this->setIfExists('goods_owner_id', $data ?? [], null);
        $this->setIfExists('purchase_order_number', $data ?? [], null);
        $this->setIfExists('supplier_order_number', $data ?? [], null);
        $this->setIfExists('goods_owner_reference', $data ?? [], null);
        $this->setIfExists('reference_number', $data ?? [], null);
        $this->setIfExists('in_date', $data ?? [], null);
        $this->setIfExists('supplier_info', $data ?? [], null);
        $this->setIfExists('purchase_order_type', $data ?? [], null);
        $this->setIfExists('purchase_order_lines', $data ?? [], null);
        $this->setIfExists('purchase_order_remark', $data ?? [], null);
        $this->setIfExists('warehouse_id', $data ?? [], null);
        $this->setIfExists('free_values', $data ?? [], null);
        $this->setIfExists('advanced', $data ?? [], null);
        $this->setIfExists('customs_info', $data ?? [], null);
        $this->setIfExists('seller_info', $data ?? [], null);
        $this->setIfExists('invoice_number', $data ?? [], null);
        $this->setIfExists('classes', $data ?? [], null);
        $this->setIfExists('tracking', $data ?? [], null);
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

        if ($this->container['goods_owner_id'] === null) {
            $invalidProperties[] = "'goods_owner_id' can't be null";
        }
        if ($this->container['purchase_order_number'] === null) {
            $invalidProperties[] = "'purchase_order_number' can't be null";
        }
        if ((mb_strlen($this->container['purchase_order_number']) < 1)) {
            $invalidProperties[] = "invalid value for 'purchase_order_number', the character length must be bigger than or equal to 1.";
        }

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
     * Gets goods_owner_id
     *
     * @return int
     */
    public function getGoodsOwnerId()
    {
        return $this->container['goods_owner_id'];
    }

    /**
     * Sets goods_owner_id
     *
     * @param int $goods_owner_id goods_owner_id
     *
     * @return self
     */
    public function setGoodsOwnerId($goods_owner_id)
    {
        if (is_null($goods_owner_id)) {
            throw new \InvalidArgumentException('non-nullable goods_owner_id cannot be null');
        }
        $this->container['goods_owner_id'] = $goods_owner_id;

        return $this;
    }

    /**
     * Gets purchase_order_number
     *
     * @return string
     */
    public function getPurchaseOrderNumber()
    {
        return $this->container['purchase_order_number'];
    }

    /**
     * Sets purchase_order_number
     *
     * @param string $purchase_order_number purchase_order_number
     *
     * @return self
     */
    public function setPurchaseOrderNumber($purchase_order_number)
    {
        if (is_null($purchase_order_number)) {
            throw new \InvalidArgumentException('non-nullable purchase_order_number cannot be null');
        }

        if ((mb_strlen($purchase_order_number) < 1)) {
            throw new \InvalidArgumentException('invalid length for $purchase_order_number when calling PostPurchaseOrderModel., must be bigger than or equal to 1.');
        }

        $this->container['purchase_order_number'] = $purchase_order_number;

        return $this;
    }

    /**
     * Gets supplier_order_number
     *
     * @return string|null
     */
    public function getSupplierOrderNumber()
    {
        return $this->container['supplier_order_number'];
    }

    /**
     * Sets supplier_order_number
     *
     * @param string|null $supplier_order_number supplier_order_number
     *
     * @return self
     */
    public function setSupplierOrderNumber($supplier_order_number)
    {
        if (is_null($supplier_order_number)) {
            array_push($this->openAPINullablesSetToNull, 'supplier_order_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('supplier_order_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['supplier_order_number'] = $supplier_order_number;

        return $this;
    }

    /**
     * Gets goods_owner_reference
     *
     * @return string|null
     */
    public function getGoodsOwnerReference()
    {
        return $this->container['goods_owner_reference'];
    }

    /**
     * Sets goods_owner_reference
     *
     * @param string|null $goods_owner_reference goods_owner_reference
     *
     * @return self
     */
    public function setGoodsOwnerReference($goods_owner_reference)
    {
        if (is_null($goods_owner_reference)) {
            array_push($this->openAPINullablesSetToNull, 'goods_owner_reference');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('goods_owner_reference', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['goods_owner_reference'] = $goods_owner_reference;

        return $this;
    }

    /**
     * Gets reference_number
     *
     * @return string|null
     */
    public function getReferenceNumber()
    {
        return $this->container['reference_number'];
    }

    /**
     * Sets reference_number
     *
     * @param string|null $reference_number reference_number
     *
     * @return self
     */
    public function setReferenceNumber($reference_number)
    {
        if (is_null($reference_number)) {
            array_push($this->openAPINullablesSetToNull, 'reference_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('reference_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['reference_number'] = $reference_number;

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
     * Gets supplier_info
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderModelSupplierInfo|null
     */
    public function getSupplierInfo()
    {
        return $this->container['supplier_info'];
    }

    /**
     * Sets supplier_info
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderModelSupplierInfo|null $supplier_info supplier_info
     *
     * @return self
     */
    public function setSupplierInfo($supplier_info)
    {
        if (is_null($supplier_info)) {
            array_push($this->openAPINullablesSetToNull, 'supplier_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('supplier_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['supplier_info'] = $supplier_info;

        return $this;
    }

    /**
     * Gets purchase_order_type
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getPurchaseOrderType()
    {
        return $this->container['purchase_order_type'];
    }

    /**
     * Sets purchase_order_type
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $purchase_order_type purchase_order_type
     *
     * @return self
     */
    public function setPurchaseOrderType($purchase_order_type)
    {
        if (is_null($purchase_order_type)) {
            array_push($this->openAPINullablesSetToNull, 'purchase_order_type');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('purchase_order_type', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['purchase_order_type'] = $purchase_order_type;

        return $this;
    }

    /**
     * Gets purchase_order_lines
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderLine[]|null
     */
    public function getPurchaseOrderLines()
    {
        return $this->container['purchase_order_lines'];
    }

    /**
     * Sets purchase_order_lines
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderLine[]|null $purchase_order_lines purchase_order_lines
     *
     * @return self
     */
    public function setPurchaseOrderLines($purchase_order_lines)
    {
        if (is_null($purchase_order_lines)) {
            array_push($this->openAPINullablesSetToNull, 'purchase_order_lines');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('purchase_order_lines', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['purchase_order_lines'] = $purchase_order_lines;

        return $this;
    }

    /**
     * Gets purchase_order_remark
     *
     * @return string|null
     */
    public function getPurchaseOrderRemark()
    {
        return $this->container['purchase_order_remark'];
    }

    /**
     * Sets purchase_order_remark
     *
     * @param string|null $purchase_order_remark purchase_order_remark
     *
     * @return self
     */
    public function setPurchaseOrderRemark($purchase_order_remark)
    {
        if (is_null($purchase_order_remark)) {
            array_push($this->openAPINullablesSetToNull, 'purchase_order_remark');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('purchase_order_remark', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['purchase_order_remark'] = $purchase_order_remark;

        return $this;
    }

    /**
     * Gets warehouse_id
     *
     * @return int|null
     */
    public function getWarehouseId()
    {
        return $this->container['warehouse_id'];
    }

    /**
     * Sets warehouse_id
     *
     * @param int|null $warehouse_id warehouse_id
     *
     * @return self
     */
    public function setWarehouseId($warehouse_id)
    {
        if (is_null($warehouse_id)) {
            array_push($this->openAPINullablesSetToNull, 'warehouse_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('warehouse_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['warehouse_id'] = $warehouse_id;

        return $this;
    }

    /**
     * Gets free_values
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderModelFreeValues|null
     */
    public function getFreeValues()
    {
        return $this->container['free_values'];
    }

    /**
     * Sets free_values
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderModelFreeValues|null $free_values free_values
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
     * Gets advanced
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderModelAdvanced|null
     */
    public function getAdvanced()
    {
        return $this->container['advanced'];
    }

    /**
     * Sets advanced
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderModelAdvanced|null $advanced advanced
     *
     * @return self
     */
    public function setAdvanced($advanced)
    {
        if (is_null($advanced)) {
            array_push($this->openAPINullablesSetToNull, 'advanced');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('advanced', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['advanced'] = $advanced;

        return $this;
    }

    /**
     * Gets customs_info
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderModelCustomsInfo|null
     */
    public function getCustomsInfo()
    {
        return $this->container['customs_info'];
    }

    /**
     * Sets customs_info
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderModelCustomsInfo|null $customs_info customs_info
     *
     * @return self
     */
    public function setCustomsInfo($customs_info)
    {
        if (is_null($customs_info)) {
            array_push($this->openAPINullablesSetToNull, 'customs_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('customs_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['customs_info'] = $customs_info;

        return $this;
    }

    /**
     * Gets seller_info
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderModelSellerInfo|null
     */
    public function getSellerInfo()
    {
        return $this->container['seller_info'];
    }

    /**
     * Sets seller_info
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderModelSellerInfo|null $seller_info seller_info
     *
     * @return self
     */
    public function setSellerInfo($seller_info)
    {
        if (is_null($seller_info)) {
            array_push($this->openAPINullablesSetToNull, 'seller_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('seller_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['seller_info'] = $seller_info;

        return $this;
    }

    /**
     * Gets invoice_number
     *
     * @return string|null
     */
    public function getInvoiceNumber()
    {
        return $this->container['invoice_number'];
    }

    /**
     * Sets invoice_number
     *
     * @param string|null $invoice_number invoice_number
     *
     * @return self
     */
    public function setInvoiceNumber($invoice_number)
    {
        if (is_null($invoice_number)) {
            array_push($this->openAPINullablesSetToNull, 'invoice_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('invoice_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['invoice_number'] = $invoice_number;

        return $this;
    }

    /**
     * Gets classes
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderClass[]|null
     */
    public function getClasses()
    {
        return $this->container['classes'];
    }

    /**
     * Sets classes
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderClass[]|null $classes classes
     *
     * @return self
     */
    public function setClasses($classes)
    {
        if (is_null($classes)) {
            array_push($this->openAPINullablesSetToNull, 'classes');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('classes', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['classes'] = $classes;

        return $this;
    }

    /**
     * Gets tracking
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderTracking[]|null
     */
    public function getTracking()
    {
        return $this->container['tracking'];
    }

    /**
     * Sets tracking
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderTracking[]|null $tracking tracking
     *
     * @return self
     */
    public function setTracking($tracking)
    {
        if (is_null($tracking)) {
            array_push($this->openAPINullablesSetToNull, 'tracking');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('tracking', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['tracking'] = $tracking;

        return $this;
    }

    /**
     * Gets text_lines
     *
     * @return \OngoingAPI\Model\PostPurchaseOrderTextLine[]|null
     */
    public function getTextLines()
    {
        return $this->container['text_lines'];
    }

    /**
     * Sets text_lines
     *
     * @param \OngoingAPI\Model\PostPurchaseOrderTextLine[]|null $text_lines text_lines
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


