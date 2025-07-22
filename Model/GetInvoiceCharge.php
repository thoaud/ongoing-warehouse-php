<?php
/**
 * GetInvoiceCharge
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
 * GetInvoiceCharge Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class GetInvoiceCharge implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'GetInvoiceCharge';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'charge_id' => 'int',
        'price' => 'float',
        'number_of_items' => 'float',
        'action_date' => '\DateTime',
        'comment' => 'string',
        'profit_center_code' => 'string',
        'container' => 'string',
        'invoice_article' => '\OngoingAPI\Model\GetInvoiceChargeInvoiceArticle',
        'order_context' => '\OngoingAPI\Model\GetInvoiceChargeOrderContext',
        'purchase_order_context' => '\OngoingAPI\Model\GetInvoiceChargePurchaseOrderContext',
        'pallet_item_context' => '\OngoingAPI\Model\GetInvoiceChargePalletItemContext',
        'article_item_context' => '\OngoingAPI\Model\GetInvoiceChargeArticleItemContext',
        'article_context' => '\OngoingAPI\Model\GetInvoiceChargeArticleContext',
        'profit_center_id' => 'int',
        'profit_center_name' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'charge_id' => 'int32',
        'price' => 'decimal',
        'number_of_items' => 'decimal',
        'action_date' => 'date-time',
        'comment' => null,
        'profit_center_code' => null,
        'container' => null,
        'invoice_article' => null,
        'order_context' => null,
        'purchase_order_context' => null,
        'pallet_item_context' => null,
        'article_item_context' => null,
        'article_context' => null,
        'profit_center_id' => 'int32',
        'profit_center_name' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'charge_id' => false,
        'price' => false,
        'number_of_items' => false,
        'action_date' => true,
        'comment' => true,
        'profit_center_code' => true,
        'container' => true,
        'invoice_article' => true,
        'order_context' => true,
        'purchase_order_context' => true,
        'pallet_item_context' => true,
        'article_item_context' => true,
        'article_context' => true,
        'profit_center_id' => true,
        'profit_center_name' => true
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
        'charge_id' => 'chargeId',
        'price' => 'price',
        'number_of_items' => 'numberOfItems',
        'action_date' => 'actionDate',
        'comment' => 'comment',
        'profit_center_code' => 'profitCenterCode',
        'container' => 'container',
        'invoice_article' => 'invoiceArticle',
        'order_context' => 'orderContext',
        'purchase_order_context' => 'purchaseOrderContext',
        'pallet_item_context' => 'palletItemContext',
        'article_item_context' => 'articleItemContext',
        'article_context' => 'articleContext',
        'profit_center_id' => 'profitCenterId',
        'profit_center_name' => 'profitCenterName'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'charge_id' => 'setChargeId',
        'price' => 'setPrice',
        'number_of_items' => 'setNumberOfItems',
        'action_date' => 'setActionDate',
        'comment' => 'setComment',
        'profit_center_code' => 'setProfitCenterCode',
        'container' => 'setContainer',
        'invoice_article' => 'setInvoiceArticle',
        'order_context' => 'setOrderContext',
        'purchase_order_context' => 'setPurchaseOrderContext',
        'pallet_item_context' => 'setPalletItemContext',
        'article_item_context' => 'setArticleItemContext',
        'article_context' => 'setArticleContext',
        'profit_center_id' => 'setProfitCenterId',
        'profit_center_name' => 'setProfitCenterName'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'charge_id' => 'getChargeId',
        'price' => 'getPrice',
        'number_of_items' => 'getNumberOfItems',
        'action_date' => 'getActionDate',
        'comment' => 'getComment',
        'profit_center_code' => 'getProfitCenterCode',
        'container' => 'getContainer',
        'invoice_article' => 'getInvoiceArticle',
        'order_context' => 'getOrderContext',
        'purchase_order_context' => 'getPurchaseOrderContext',
        'pallet_item_context' => 'getPalletItemContext',
        'article_item_context' => 'getArticleItemContext',
        'article_context' => 'getArticleContext',
        'profit_center_id' => 'getProfitCenterId',
        'profit_center_name' => 'getProfitCenterName'
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
        $this->setIfExists('charge_id', $data ?? [], null);
        $this->setIfExists('price', $data ?? [], null);
        $this->setIfExists('number_of_items', $data ?? [], null);
        $this->setIfExists('action_date', $data ?? [], null);
        $this->setIfExists('comment', $data ?? [], null);
        $this->setIfExists('profit_center_code', $data ?? [], null);
        $this->setIfExists('container', $data ?? [], null);
        $this->setIfExists('invoice_article', $data ?? [], null);
        $this->setIfExists('order_context', $data ?? [], null);
        $this->setIfExists('purchase_order_context', $data ?? [], null);
        $this->setIfExists('pallet_item_context', $data ?? [], null);
        $this->setIfExists('article_item_context', $data ?? [], null);
        $this->setIfExists('article_context', $data ?? [], null);
        $this->setIfExists('profit_center_id', $data ?? [], null);
        $this->setIfExists('profit_center_name', $data ?? [], null);
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
     * Gets charge_id
     *
     * @return int|null
     */
    public function getChargeId()
    {
        return $this->container['charge_id'];
    }

    /**
     * Sets charge_id
     *
     * @param int|null $charge_id charge_id
     *
     * @return self
     */
    public function setChargeId($charge_id)
    {
        if (is_null($charge_id)) {
            throw new \InvalidArgumentException('non-nullable charge_id cannot be null');
        }
        $this->container['charge_id'] = $charge_id;

        return $this;
    }

    /**
     * Gets price
     *
     * @return float|null
     */
    public function getPrice()
    {
        return $this->container['price'];
    }

    /**
     * Sets price
     *
     * @param float|null $price price
     *
     * @return self
     */
    public function setPrice($price)
    {
        if (is_null($price)) {
            throw new \InvalidArgumentException('non-nullable price cannot be null');
        }
        $this->container['price'] = $price;

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
     * Gets action_date
     *
     * @return \DateTime|null
     */
    public function getActionDate()
    {
        return $this->container['action_date'];
    }

    /**
     * Sets action_date
     *
     * @param \DateTime|null $action_date action_date
     *
     * @return self
     */
    public function setActionDate($action_date)
    {
        if (is_null($action_date)) {
            array_push($this->openAPINullablesSetToNull, 'action_date');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('action_date', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['action_date'] = $action_date;

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
     * Gets profit_center_code
     *
     * @return string|null
     */
    public function getProfitCenterCode()
    {
        return $this->container['profit_center_code'];
    }

    /**
     * Sets profit_center_code
     *
     * @param string|null $profit_center_code profit_center_code
     *
     * @return self
     */
    public function setProfitCenterCode($profit_center_code)
    {
        if (is_null($profit_center_code)) {
            array_push($this->openAPINullablesSetToNull, 'profit_center_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('profit_center_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['profit_center_code'] = $profit_center_code;

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
     * Gets invoice_article
     *
     * @return \OngoingAPI\Model\GetInvoiceChargeInvoiceArticle|null
     */
    public function getInvoiceArticle()
    {
        return $this->container['invoice_article'];
    }

    /**
     * Sets invoice_article
     *
     * @param \OngoingAPI\Model\GetInvoiceChargeInvoiceArticle|null $invoice_article invoice_article
     *
     * @return self
     */
    public function setInvoiceArticle($invoice_article)
    {
        if (is_null($invoice_article)) {
            array_push($this->openAPINullablesSetToNull, 'invoice_article');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('invoice_article', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['invoice_article'] = $invoice_article;

        return $this;
    }

    /**
     * Gets order_context
     *
     * @return \OngoingAPI\Model\GetInvoiceChargeOrderContext|null
     */
    public function getOrderContext()
    {
        return $this->container['order_context'];
    }

    /**
     * Sets order_context
     *
     * @param \OngoingAPI\Model\GetInvoiceChargeOrderContext|null $order_context order_context
     *
     * @return self
     */
    public function setOrderContext($order_context)
    {
        if (is_null($order_context)) {
            array_push($this->openAPINullablesSetToNull, 'order_context');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_context', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['order_context'] = $order_context;

        return $this;
    }

    /**
     * Gets purchase_order_context
     *
     * @return \OngoingAPI\Model\GetInvoiceChargePurchaseOrderContext|null
     */
    public function getPurchaseOrderContext()
    {
        return $this->container['purchase_order_context'];
    }

    /**
     * Sets purchase_order_context
     *
     * @param \OngoingAPI\Model\GetInvoiceChargePurchaseOrderContext|null $purchase_order_context purchase_order_context
     *
     * @return self
     */
    public function setPurchaseOrderContext($purchase_order_context)
    {
        if (is_null($purchase_order_context)) {
            array_push($this->openAPINullablesSetToNull, 'purchase_order_context');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('purchase_order_context', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['purchase_order_context'] = $purchase_order_context;

        return $this;
    }

    /**
     * Gets pallet_item_context
     *
     * @return \OngoingAPI\Model\GetInvoiceChargePalletItemContext|null
     */
    public function getPalletItemContext()
    {
        return $this->container['pallet_item_context'];
    }

    /**
     * Sets pallet_item_context
     *
     * @param \OngoingAPI\Model\GetInvoiceChargePalletItemContext|null $pallet_item_context pallet_item_context
     *
     * @return self
     */
    public function setPalletItemContext($pallet_item_context)
    {
        if (is_null($pallet_item_context)) {
            array_push($this->openAPINullablesSetToNull, 'pallet_item_context');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('pallet_item_context', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['pallet_item_context'] = $pallet_item_context;

        return $this;
    }

    /**
     * Gets article_item_context
     *
     * @return \OngoingAPI\Model\GetInvoiceChargeArticleItemContext|null
     */
    public function getArticleItemContext()
    {
        return $this->container['article_item_context'];
    }

    /**
     * Sets article_item_context
     *
     * @param \OngoingAPI\Model\GetInvoiceChargeArticleItemContext|null $article_item_context article_item_context
     *
     * @return self
     */
    public function setArticleItemContext($article_item_context)
    {
        if (is_null($article_item_context)) {
            array_push($this->openAPINullablesSetToNull, 'article_item_context');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_item_context', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_item_context'] = $article_item_context;

        return $this;
    }

    /**
     * Gets article_context
     *
     * @return \OngoingAPI\Model\GetInvoiceChargeArticleContext|null
     */
    public function getArticleContext()
    {
        return $this->container['article_context'];
    }

    /**
     * Sets article_context
     *
     * @param \OngoingAPI\Model\GetInvoiceChargeArticleContext|null $article_context article_context
     *
     * @return self
     */
    public function setArticleContext($article_context)
    {
        if (is_null($article_context)) {
            array_push($this->openAPINullablesSetToNull, 'article_context');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_context', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_context'] = $article_context;

        return $this;
    }

    /**
     * Gets profit_center_id
     *
     * @return int|null
     */
    public function getProfitCenterId()
    {
        return $this->container['profit_center_id'];
    }

    /**
     * Sets profit_center_id
     *
     * @param int|null $profit_center_id profit_center_id
     *
     * @return self
     */
    public function setProfitCenterId($profit_center_id)
    {
        if (is_null($profit_center_id)) {
            array_push($this->openAPINullablesSetToNull, 'profit_center_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('profit_center_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['profit_center_id'] = $profit_center_id;

        return $this;
    }

    /**
     * Gets profit_center_name
     *
     * @return string|null
     */
    public function getProfitCenterName()
    {
        return $this->container['profit_center_name'];
    }

    /**
     * Sets profit_center_name
     *
     * @param string|null $profit_center_name profit_center_name
     *
     * @return self
     */
    public function setProfitCenterName($profit_center_name)
    {
        if (is_null($profit_center_name)) {
            array_push($this->openAPINullablesSetToNull, 'profit_center_name');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('profit_center_name', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['profit_center_name'] = $profit_center_name;

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


