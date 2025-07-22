<?php
/**
 * GetOrderModelOrderInfo
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
 * GetOrderModelOrderInfo Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class GetOrderModelOrderInfo implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'GetOrderModel_orderInfo';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'order_id' => 'int',
        'order_number' => 'string',
        'goods_owner_order_id' => 'string',
        'reference_number' => 'string',
        'sales_code' => 'string',
        'order_remark' => 'string',
        'delivery_instruction' => 'string',
        'service_point_code' => 'string',
        'free_text1' => 'string',
        'free_text2' => 'string',
        'free_text3' => 'string',
        'order_type' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'way_of_delivery' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'delivery_date' => '\DateTime',
        'created_date' => '\DateTime',
        'shipped_time' => '\DateTime',
        'way_bill' => 'string',
        'return_way_bill' => 'string',
        'order_status' => '\OngoingAPI\Model\GetOrderInfoOrderStatus',
        'email_notification' => '\OngoingAPI\Model\GetOrderInfoEmailNotification',
        'sms_notification' => '\OngoingAPI\Model\GetOrderInfoEmailNotification',
        'telephone_notification' => '\OngoingAPI\Model\GetOrderInfoEmailNotification',
        'ordered_number_of_items' => 'float',
        'allocated_number_of_items' => 'float',
        'picked_number_of_items' => 'float',
        'customs_info' => '\OngoingAPI\Model\GetOrderInfoCustomsInfo',
        'prepared_transport_document_id' => 'string',
        'warehouse' => '\OngoingAPI\Model\GetOrderInfoWarehouse',
        'terms_of_delivery_type' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'customer_price' => 'float',
        'consignee_order_number' => 'string',
        'warehouse_instruction' => 'string',
        'market_place' => '\OngoingAPI\Model\GetOrderInfoMarketPlace',
        'picking_priority' => 'int',
        'production_code' => 'string',
        'advanced' => '\OngoingAPI\Model\GetOrderInfoAdvanced',
        'freight_price' => 'float',
        'invoice_url' => 'string',
        'order_free_date_time1' => '\DateTime',
        'sort_location' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'order_id' => 'int32',
        'order_number' => null,
        'goods_owner_order_id' => null,
        'reference_number' => null,
        'sales_code' => null,
        'order_remark' => null,
        'delivery_instruction' => null,
        'service_point_code' => null,
        'free_text1' => null,
        'free_text2' => null,
        'free_text3' => null,
        'order_type' => null,
        'way_of_delivery' => null,
        'delivery_date' => 'date-time',
        'created_date' => 'date-time',
        'shipped_time' => 'date-time',
        'way_bill' => null,
        'return_way_bill' => null,
        'order_status' => null,
        'email_notification' => null,
        'sms_notification' => null,
        'telephone_notification' => null,
        'ordered_number_of_items' => 'decimal',
        'allocated_number_of_items' => 'decimal',
        'picked_number_of_items' => 'decimal',
        'customs_info' => null,
        'prepared_transport_document_id' => null,
        'warehouse' => null,
        'terms_of_delivery_type' => null,
        'customer_price' => 'decimal',
        'consignee_order_number' => null,
        'warehouse_instruction' => null,
        'market_place' => null,
        'picking_priority' => 'int32',
        'production_code' => null,
        'advanced' => null,
        'freight_price' => 'decimal',
        'invoice_url' => null,
        'order_free_date_time1' => 'date-time',
        'sort_location' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'order_id' => false,
        'order_number' => true,
        'goods_owner_order_id' => true,
        'reference_number' => true,
        'sales_code' => true,
        'order_remark' => true,
        'delivery_instruction' => true,
        'service_point_code' => true,
        'free_text1' => true,
        'free_text2' => true,
        'free_text3' => true,
        'order_type' => true,
        'way_of_delivery' => true,
        'delivery_date' => false,
        'created_date' => false,
        'shipped_time' => true,
        'way_bill' => true,
        'return_way_bill' => true,
        'order_status' => true,
        'email_notification' => true,
        'sms_notification' => true,
        'telephone_notification' => true,
        'ordered_number_of_items' => false,
        'allocated_number_of_items' => false,
        'picked_number_of_items' => false,
        'customs_info' => true,
        'prepared_transport_document_id' => true,
        'warehouse' => true,
        'terms_of_delivery_type' => true,
        'customer_price' => true,
        'consignee_order_number' => true,
        'warehouse_instruction' => true,
        'market_place' => true,
        'picking_priority' => true,
        'production_code' => true,
        'advanced' => true,
        'freight_price' => true,
        'invoice_url' => true,
        'order_free_date_time1' => true,
        'sort_location' => true
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
        'order_id' => 'orderId',
        'order_number' => 'orderNumber',
        'goods_owner_order_id' => 'goodsOwnerOrderId',
        'reference_number' => 'referenceNumber',
        'sales_code' => 'salesCode',
        'order_remark' => 'orderRemark',
        'delivery_instruction' => 'deliveryInstruction',
        'service_point_code' => 'servicePointCode',
        'free_text1' => 'freeText1',
        'free_text2' => 'freeText2',
        'free_text3' => 'freeText3',
        'order_type' => 'orderType',
        'way_of_delivery' => 'wayOfDelivery',
        'delivery_date' => 'deliveryDate',
        'created_date' => 'createdDate',
        'shipped_time' => 'shippedTime',
        'way_bill' => 'wayBill',
        'return_way_bill' => 'returnWayBill',
        'order_status' => 'orderStatus',
        'email_notification' => 'emailNotification',
        'sms_notification' => 'smsNotification',
        'telephone_notification' => 'telephoneNotification',
        'ordered_number_of_items' => 'orderedNumberOfItems',
        'allocated_number_of_items' => 'allocatedNumberOfItems',
        'picked_number_of_items' => 'pickedNumberOfItems',
        'customs_info' => 'customsInfo',
        'prepared_transport_document_id' => 'preparedTransportDocumentId',
        'warehouse' => 'warehouse',
        'terms_of_delivery_type' => 'termsOfDeliveryType',
        'customer_price' => 'customerPrice',
        'consignee_order_number' => 'consigneeOrderNumber',
        'warehouse_instruction' => 'warehouseInstruction',
        'market_place' => 'marketPlace',
        'picking_priority' => 'pickingPriority',
        'production_code' => 'productionCode',
        'advanced' => 'advanced',
        'freight_price' => 'freightPrice',
        'invoice_url' => 'invoiceUrl',
        'order_free_date_time1' => 'orderFreeDateTime1',
        'sort_location' => 'sortLocation'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'order_id' => 'setOrderId',
        'order_number' => 'setOrderNumber',
        'goods_owner_order_id' => 'setGoodsOwnerOrderId',
        'reference_number' => 'setReferenceNumber',
        'sales_code' => 'setSalesCode',
        'order_remark' => 'setOrderRemark',
        'delivery_instruction' => 'setDeliveryInstruction',
        'service_point_code' => 'setServicePointCode',
        'free_text1' => 'setFreeText1',
        'free_text2' => 'setFreeText2',
        'free_text3' => 'setFreeText3',
        'order_type' => 'setOrderType',
        'way_of_delivery' => 'setWayOfDelivery',
        'delivery_date' => 'setDeliveryDate',
        'created_date' => 'setCreatedDate',
        'shipped_time' => 'setShippedTime',
        'way_bill' => 'setWayBill',
        'return_way_bill' => 'setReturnWayBill',
        'order_status' => 'setOrderStatus',
        'email_notification' => 'setEmailNotification',
        'sms_notification' => 'setSmsNotification',
        'telephone_notification' => 'setTelephoneNotification',
        'ordered_number_of_items' => 'setOrderedNumberOfItems',
        'allocated_number_of_items' => 'setAllocatedNumberOfItems',
        'picked_number_of_items' => 'setPickedNumberOfItems',
        'customs_info' => 'setCustomsInfo',
        'prepared_transport_document_id' => 'setPreparedTransportDocumentId',
        'warehouse' => 'setWarehouse',
        'terms_of_delivery_type' => 'setTermsOfDeliveryType',
        'customer_price' => 'setCustomerPrice',
        'consignee_order_number' => 'setConsigneeOrderNumber',
        'warehouse_instruction' => 'setWarehouseInstruction',
        'market_place' => 'setMarketPlace',
        'picking_priority' => 'setPickingPriority',
        'production_code' => 'setProductionCode',
        'advanced' => 'setAdvanced',
        'freight_price' => 'setFreightPrice',
        'invoice_url' => 'setInvoiceUrl',
        'order_free_date_time1' => 'setOrderFreeDateTime1',
        'sort_location' => 'setSortLocation'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'order_id' => 'getOrderId',
        'order_number' => 'getOrderNumber',
        'goods_owner_order_id' => 'getGoodsOwnerOrderId',
        'reference_number' => 'getReferenceNumber',
        'sales_code' => 'getSalesCode',
        'order_remark' => 'getOrderRemark',
        'delivery_instruction' => 'getDeliveryInstruction',
        'service_point_code' => 'getServicePointCode',
        'free_text1' => 'getFreeText1',
        'free_text2' => 'getFreeText2',
        'free_text3' => 'getFreeText3',
        'order_type' => 'getOrderType',
        'way_of_delivery' => 'getWayOfDelivery',
        'delivery_date' => 'getDeliveryDate',
        'created_date' => 'getCreatedDate',
        'shipped_time' => 'getShippedTime',
        'way_bill' => 'getWayBill',
        'return_way_bill' => 'getReturnWayBill',
        'order_status' => 'getOrderStatus',
        'email_notification' => 'getEmailNotification',
        'sms_notification' => 'getSmsNotification',
        'telephone_notification' => 'getTelephoneNotification',
        'ordered_number_of_items' => 'getOrderedNumberOfItems',
        'allocated_number_of_items' => 'getAllocatedNumberOfItems',
        'picked_number_of_items' => 'getPickedNumberOfItems',
        'customs_info' => 'getCustomsInfo',
        'prepared_transport_document_id' => 'getPreparedTransportDocumentId',
        'warehouse' => 'getWarehouse',
        'terms_of_delivery_type' => 'getTermsOfDeliveryType',
        'customer_price' => 'getCustomerPrice',
        'consignee_order_number' => 'getConsigneeOrderNumber',
        'warehouse_instruction' => 'getWarehouseInstruction',
        'market_place' => 'getMarketPlace',
        'picking_priority' => 'getPickingPriority',
        'production_code' => 'getProductionCode',
        'advanced' => 'getAdvanced',
        'freight_price' => 'getFreightPrice',
        'invoice_url' => 'getInvoiceUrl',
        'order_free_date_time1' => 'getOrderFreeDateTime1',
        'sort_location' => 'getSortLocation'
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
        $this->setIfExists('order_id', $data ?? [], null);
        $this->setIfExists('order_number', $data ?? [], null);
        $this->setIfExists('goods_owner_order_id', $data ?? [], null);
        $this->setIfExists('reference_number', $data ?? [], null);
        $this->setIfExists('sales_code', $data ?? [], null);
        $this->setIfExists('order_remark', $data ?? [], null);
        $this->setIfExists('delivery_instruction', $data ?? [], null);
        $this->setIfExists('service_point_code', $data ?? [], null);
        $this->setIfExists('free_text1', $data ?? [], null);
        $this->setIfExists('free_text2', $data ?? [], null);
        $this->setIfExists('free_text3', $data ?? [], null);
        $this->setIfExists('order_type', $data ?? [], null);
        $this->setIfExists('way_of_delivery', $data ?? [], null);
        $this->setIfExists('delivery_date', $data ?? [], null);
        $this->setIfExists('created_date', $data ?? [], null);
        $this->setIfExists('shipped_time', $data ?? [], null);
        $this->setIfExists('way_bill', $data ?? [], null);
        $this->setIfExists('return_way_bill', $data ?? [], null);
        $this->setIfExists('order_status', $data ?? [], null);
        $this->setIfExists('email_notification', $data ?? [], null);
        $this->setIfExists('sms_notification', $data ?? [], null);
        $this->setIfExists('telephone_notification', $data ?? [], null);
        $this->setIfExists('ordered_number_of_items', $data ?? [], null);
        $this->setIfExists('allocated_number_of_items', $data ?? [], null);
        $this->setIfExists('picked_number_of_items', $data ?? [], null);
        $this->setIfExists('customs_info', $data ?? [], null);
        $this->setIfExists('prepared_transport_document_id', $data ?? [], null);
        $this->setIfExists('warehouse', $data ?? [], null);
        $this->setIfExists('terms_of_delivery_type', $data ?? [], null);
        $this->setIfExists('customer_price', $data ?? [], null);
        $this->setIfExists('consignee_order_number', $data ?? [], null);
        $this->setIfExists('warehouse_instruction', $data ?? [], null);
        $this->setIfExists('market_place', $data ?? [], null);
        $this->setIfExists('picking_priority', $data ?? [], null);
        $this->setIfExists('production_code', $data ?? [], null);
        $this->setIfExists('advanced', $data ?? [], null);
        $this->setIfExists('freight_price', $data ?? [], null);
        $this->setIfExists('invoice_url', $data ?? [], null);
        $this->setIfExists('order_free_date_time1', $data ?? [], null);
        $this->setIfExists('sort_location', $data ?? [], null);
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
     * Gets order_id
     *
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->container['order_id'];
    }

    /**
     * Sets order_id
     *
     * @param int|null $order_id order_id
     *
     * @return self
     */
    public function setOrderId($order_id)
    {
        if (is_null($order_id)) {
            throw new \InvalidArgumentException('non-nullable order_id cannot be null');
        }
        $this->container['order_id'] = $order_id;

        return $this;
    }

    /**
     * Gets order_number
     *
     * @return string|null
     */
    public function getOrderNumber()
    {
        return $this->container['order_number'];
    }

    /**
     * Sets order_number
     *
     * @param string|null $order_number order_number
     *
     * @return self
     */
    public function setOrderNumber($order_number)
    {
        if (is_null($order_number)) {
            array_push($this->openAPINullablesSetToNull, 'order_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['order_number'] = $order_number;

        return $this;
    }

    /**
     * Gets goods_owner_order_id
     *
     * @return string|null
     */
    public function getGoodsOwnerOrderId()
    {
        return $this->container['goods_owner_order_id'];
    }

    /**
     * Sets goods_owner_order_id
     *
     * @param string|null $goods_owner_order_id goods_owner_order_id
     *
     * @return self
     */
    public function setGoodsOwnerOrderId($goods_owner_order_id)
    {
        if (is_null($goods_owner_order_id)) {
            array_push($this->openAPINullablesSetToNull, 'goods_owner_order_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('goods_owner_order_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['goods_owner_order_id'] = $goods_owner_order_id;

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
     * Gets sales_code
     *
     * @return string|null
     */
    public function getSalesCode()
    {
        return $this->container['sales_code'];
    }

    /**
     * Sets sales_code
     *
     * @param string|null $sales_code sales_code
     *
     * @return self
     */
    public function setSalesCode($sales_code)
    {
        if (is_null($sales_code)) {
            array_push($this->openAPINullablesSetToNull, 'sales_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('sales_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['sales_code'] = $sales_code;

        return $this;
    }

    /**
     * Gets order_remark
     *
     * @return string|null
     */
    public function getOrderRemark()
    {
        return $this->container['order_remark'];
    }

    /**
     * Sets order_remark
     *
     * @param string|null $order_remark order_remark
     *
     * @return self
     */
    public function setOrderRemark($order_remark)
    {
        if (is_null($order_remark)) {
            array_push($this->openAPINullablesSetToNull, 'order_remark');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_remark', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['order_remark'] = $order_remark;

        return $this;
    }

    /**
     * Gets delivery_instruction
     *
     * @return string|null
     */
    public function getDeliveryInstruction()
    {
        return $this->container['delivery_instruction'];
    }

    /**
     * Sets delivery_instruction
     *
     * @param string|null $delivery_instruction delivery_instruction
     *
     * @return self
     */
    public function setDeliveryInstruction($delivery_instruction)
    {
        if (is_null($delivery_instruction)) {
            array_push($this->openAPINullablesSetToNull, 'delivery_instruction');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('delivery_instruction', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['delivery_instruction'] = $delivery_instruction;

        return $this;
    }

    /**
     * Gets service_point_code
     *
     * @return string|null
     */
    public function getServicePointCode()
    {
        return $this->container['service_point_code'];
    }

    /**
     * Sets service_point_code
     *
     * @param string|null $service_point_code service_point_code
     *
     * @return self
     */
    public function setServicePointCode($service_point_code)
    {
        if (is_null($service_point_code)) {
            array_push($this->openAPINullablesSetToNull, 'service_point_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('service_point_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['service_point_code'] = $service_point_code;

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
     * Gets free_text2
     *
     * @return string|null
     */
    public function getFreeText2()
    {
        return $this->container['free_text2'];
    }

    /**
     * Sets free_text2
     *
     * @param string|null $free_text2 free_text2
     *
     * @return self
     */
    public function setFreeText2($free_text2)
    {
        if (is_null($free_text2)) {
            array_push($this->openAPINullablesSetToNull, 'free_text2');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('free_text2', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['free_text2'] = $free_text2;

        return $this;
    }

    /**
     * Gets free_text3
     *
     * @return string|null
     */
    public function getFreeText3()
    {
        return $this->container['free_text3'];
    }

    /**
     * Sets free_text3
     *
     * @param string|null $free_text3 free_text3
     *
     * @return self
     */
    public function setFreeText3($free_text3)
    {
        if (is_null($free_text3)) {
            array_push($this->openAPINullablesSetToNull, 'free_text3');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('free_text3', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['free_text3'] = $free_text3;

        return $this;
    }

    /**
     * Gets order_type
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getOrderType()
    {
        return $this->container['order_type'];
    }

    /**
     * Sets order_type
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $order_type order_type
     *
     * @return self
     */
    public function setOrderType($order_type)
    {
        if (is_null($order_type)) {
            array_push($this->openAPINullablesSetToNull, 'order_type');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_type', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['order_type'] = $order_type;

        return $this;
    }

    /**
     * Gets way_of_delivery
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getWayOfDelivery()
    {
        return $this->container['way_of_delivery'];
    }

    /**
     * Sets way_of_delivery
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $way_of_delivery way_of_delivery
     *
     * @return self
     */
    public function setWayOfDelivery($way_of_delivery)
    {
        if (is_null($way_of_delivery)) {
            array_push($this->openAPINullablesSetToNull, 'way_of_delivery');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('way_of_delivery', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['way_of_delivery'] = $way_of_delivery;

        return $this;
    }

    /**
     * Gets delivery_date
     *
     * @return \DateTime|null
     */
    public function getDeliveryDate()
    {
        return $this->container['delivery_date'];
    }

    /**
     * Sets delivery_date
     *
     * @param \DateTime|null $delivery_date delivery_date
     *
     * @return self
     */
    public function setDeliveryDate($delivery_date)
    {
        if (is_null($delivery_date)) {
            throw new \InvalidArgumentException('non-nullable delivery_date cannot be null');
        }
        $this->container['delivery_date'] = $delivery_date;

        return $this;
    }

    /**
     * Gets created_date
     *
     * @return \DateTime|null
     */
    public function getCreatedDate()
    {
        return $this->container['created_date'];
    }

    /**
     * Sets created_date
     *
     * @param \DateTime|null $created_date created_date
     *
     * @return self
     */
    public function setCreatedDate($created_date)
    {
        if (is_null($created_date)) {
            throw new \InvalidArgumentException('non-nullable created_date cannot be null');
        }
        $this->container['created_date'] = $created_date;

        return $this;
    }

    /**
     * Gets shipped_time
     *
     * @return \DateTime|null
     */
    public function getShippedTime()
    {
        return $this->container['shipped_time'];
    }

    /**
     * Sets shipped_time
     *
     * @param \DateTime|null $shipped_time shipped_time
     *
     * @return self
     */
    public function setShippedTime($shipped_time)
    {
        if (is_null($shipped_time)) {
            array_push($this->openAPINullablesSetToNull, 'shipped_time');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('shipped_time', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['shipped_time'] = $shipped_time;

        return $this;
    }

    /**
     * Gets way_bill
     *
     * @return string|null
     */
    public function getWayBill()
    {
        return $this->container['way_bill'];
    }

    /**
     * Sets way_bill
     *
     * @param string|null $way_bill way_bill
     *
     * @return self
     */
    public function setWayBill($way_bill)
    {
        if (is_null($way_bill)) {
            array_push($this->openAPINullablesSetToNull, 'way_bill');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('way_bill', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['way_bill'] = $way_bill;

        return $this;
    }

    /**
     * Gets return_way_bill
     *
     * @return string|null
     */
    public function getReturnWayBill()
    {
        return $this->container['return_way_bill'];
    }

    /**
     * Sets return_way_bill
     *
     * @param string|null $return_way_bill return_way_bill
     *
     * @return self
     */
    public function setReturnWayBill($return_way_bill)
    {
        if (is_null($return_way_bill)) {
            array_push($this->openAPINullablesSetToNull, 'return_way_bill');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('return_way_bill', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['return_way_bill'] = $return_way_bill;

        return $this;
    }

    /**
     * Gets order_status
     *
     * @return \OngoingAPI\Model\GetOrderInfoOrderStatus|null
     */
    public function getOrderStatus()
    {
        return $this->container['order_status'];
    }

    /**
     * Sets order_status
     *
     * @param \OngoingAPI\Model\GetOrderInfoOrderStatus|null $order_status order_status
     *
     * @return self
     */
    public function setOrderStatus($order_status)
    {
        if (is_null($order_status)) {
            array_push($this->openAPINullablesSetToNull, 'order_status');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_status', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['order_status'] = $order_status;

        return $this;
    }

    /**
     * Gets email_notification
     *
     * @return \OngoingAPI\Model\GetOrderInfoEmailNotification|null
     */
    public function getEmailNotification()
    {
        return $this->container['email_notification'];
    }

    /**
     * Sets email_notification
     *
     * @param \OngoingAPI\Model\GetOrderInfoEmailNotification|null $email_notification email_notification
     *
     * @return self
     */
    public function setEmailNotification($email_notification)
    {
        if (is_null($email_notification)) {
            array_push($this->openAPINullablesSetToNull, 'email_notification');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('email_notification', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['email_notification'] = $email_notification;

        return $this;
    }

    /**
     * Gets sms_notification
     *
     * @return \OngoingAPI\Model\GetOrderInfoEmailNotification|null
     */
    public function getSmsNotification()
    {
        return $this->container['sms_notification'];
    }

    /**
     * Sets sms_notification
     *
     * @param \OngoingAPI\Model\GetOrderInfoEmailNotification|null $sms_notification sms_notification
     *
     * @return self
     */
    public function setSmsNotification($sms_notification)
    {
        if (is_null($sms_notification)) {
            array_push($this->openAPINullablesSetToNull, 'sms_notification');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('sms_notification', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['sms_notification'] = $sms_notification;

        return $this;
    }

    /**
     * Gets telephone_notification
     *
     * @return \OngoingAPI\Model\GetOrderInfoEmailNotification|null
     */
    public function getTelephoneNotification()
    {
        return $this->container['telephone_notification'];
    }

    /**
     * Sets telephone_notification
     *
     * @param \OngoingAPI\Model\GetOrderInfoEmailNotification|null $telephone_notification telephone_notification
     *
     * @return self
     */
    public function setTelephoneNotification($telephone_notification)
    {
        if (is_null($telephone_notification)) {
            array_push($this->openAPINullablesSetToNull, 'telephone_notification');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('telephone_notification', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['telephone_notification'] = $telephone_notification;

        return $this;
    }

    /**
     * Gets ordered_number_of_items
     *
     * @return float|null
     */
    public function getOrderedNumberOfItems()
    {
        return $this->container['ordered_number_of_items'];
    }

    /**
     * Sets ordered_number_of_items
     *
     * @param float|null $ordered_number_of_items ordered_number_of_items
     *
     * @return self
     */
    public function setOrderedNumberOfItems($ordered_number_of_items)
    {
        if (is_null($ordered_number_of_items)) {
            throw new \InvalidArgumentException('non-nullable ordered_number_of_items cannot be null');
        }
        $this->container['ordered_number_of_items'] = $ordered_number_of_items;

        return $this;
    }

    /**
     * Gets allocated_number_of_items
     *
     * @return float|null
     */
    public function getAllocatedNumberOfItems()
    {
        return $this->container['allocated_number_of_items'];
    }

    /**
     * Sets allocated_number_of_items
     *
     * @param float|null $allocated_number_of_items allocated_number_of_items
     *
     * @return self
     */
    public function setAllocatedNumberOfItems($allocated_number_of_items)
    {
        if (is_null($allocated_number_of_items)) {
            throw new \InvalidArgumentException('non-nullable allocated_number_of_items cannot be null');
        }
        $this->container['allocated_number_of_items'] = $allocated_number_of_items;

        return $this;
    }

    /**
     * Gets picked_number_of_items
     *
     * @return float|null
     */
    public function getPickedNumberOfItems()
    {
        return $this->container['picked_number_of_items'];
    }

    /**
     * Sets picked_number_of_items
     *
     * @param float|null $picked_number_of_items picked_number_of_items
     *
     * @return self
     */
    public function setPickedNumberOfItems($picked_number_of_items)
    {
        if (is_null($picked_number_of_items)) {
            throw new \InvalidArgumentException('non-nullable picked_number_of_items cannot be null');
        }
        $this->container['picked_number_of_items'] = $picked_number_of_items;

        return $this;
    }

    /**
     * Gets customs_info
     *
     * @return \OngoingAPI\Model\GetOrderInfoCustomsInfo|null
     */
    public function getCustomsInfo()
    {
        return $this->container['customs_info'];
    }

    /**
     * Sets customs_info
     *
     * @param \OngoingAPI\Model\GetOrderInfoCustomsInfo|null $customs_info customs_info
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
     * Gets prepared_transport_document_id
     *
     * @return string|null
     */
    public function getPreparedTransportDocumentId()
    {
        return $this->container['prepared_transport_document_id'];
    }

    /**
     * Sets prepared_transport_document_id
     *
     * @param string|null $prepared_transport_document_id prepared_transport_document_id
     *
     * @return self
     */
    public function setPreparedTransportDocumentId($prepared_transport_document_id)
    {
        if (is_null($prepared_transport_document_id)) {
            array_push($this->openAPINullablesSetToNull, 'prepared_transport_document_id');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('prepared_transport_document_id', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['prepared_transport_document_id'] = $prepared_transport_document_id;

        return $this;
    }

    /**
     * Gets warehouse
     *
     * @return \OngoingAPI\Model\GetOrderInfoWarehouse|null
     */
    public function getWarehouse()
    {
        return $this->container['warehouse'];
    }

    /**
     * Sets warehouse
     *
     * @param \OngoingAPI\Model\GetOrderInfoWarehouse|null $warehouse warehouse
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
     * Gets terms_of_delivery_type
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getTermsOfDeliveryType()
    {
        return $this->container['terms_of_delivery_type'];
    }

    /**
     * Sets terms_of_delivery_type
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $terms_of_delivery_type terms_of_delivery_type
     *
     * @return self
     */
    public function setTermsOfDeliveryType($terms_of_delivery_type)
    {
        if (is_null($terms_of_delivery_type)) {
            array_push($this->openAPINullablesSetToNull, 'terms_of_delivery_type');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('terms_of_delivery_type', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['terms_of_delivery_type'] = $terms_of_delivery_type;

        return $this;
    }

    /**
     * Gets customer_price
     *
     * @return float|null
     */
    public function getCustomerPrice()
    {
        return $this->container['customer_price'];
    }

    /**
     * Sets customer_price
     *
     * @param float|null $customer_price customer_price
     *
     * @return self
     */
    public function setCustomerPrice($customer_price)
    {
        if (is_null($customer_price)) {
            array_push($this->openAPINullablesSetToNull, 'customer_price');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('customer_price', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['customer_price'] = $customer_price;

        return $this;
    }

    /**
     * Gets consignee_order_number
     *
     * @return string|null
     */
    public function getConsigneeOrderNumber()
    {
        return $this->container['consignee_order_number'];
    }

    /**
     * Sets consignee_order_number
     *
     * @param string|null $consignee_order_number consignee_order_number
     *
     * @return self
     */
    public function setConsigneeOrderNumber($consignee_order_number)
    {
        if (is_null($consignee_order_number)) {
            array_push($this->openAPINullablesSetToNull, 'consignee_order_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('consignee_order_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['consignee_order_number'] = $consignee_order_number;

        return $this;
    }

    /**
     * Gets warehouse_instruction
     *
     * @return string|null
     */
    public function getWarehouseInstruction()
    {
        return $this->container['warehouse_instruction'];
    }

    /**
     * Sets warehouse_instruction
     *
     * @param string|null $warehouse_instruction warehouse_instruction
     *
     * @return self
     */
    public function setWarehouseInstruction($warehouse_instruction)
    {
        if (is_null($warehouse_instruction)) {
            array_push($this->openAPINullablesSetToNull, 'warehouse_instruction');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('warehouse_instruction', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['warehouse_instruction'] = $warehouse_instruction;

        return $this;
    }

    /**
     * Gets market_place
     *
     * @return \OngoingAPI\Model\GetOrderInfoMarketPlace|null
     */
    public function getMarketPlace()
    {
        return $this->container['market_place'];
    }

    /**
     * Sets market_place
     *
     * @param \OngoingAPI\Model\GetOrderInfoMarketPlace|null $market_place market_place
     *
     * @return self
     */
    public function setMarketPlace($market_place)
    {
        if (is_null($market_place)) {
            array_push($this->openAPINullablesSetToNull, 'market_place');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('market_place', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['market_place'] = $market_place;

        return $this;
    }

    /**
     * Gets picking_priority
     *
     * @return int|null
     */
    public function getPickingPriority()
    {
        return $this->container['picking_priority'];
    }

    /**
     * Sets picking_priority
     *
     * @param int|null $picking_priority picking_priority
     *
     * @return self
     */
    public function setPickingPriority($picking_priority)
    {
        if (is_null($picking_priority)) {
            array_push($this->openAPINullablesSetToNull, 'picking_priority');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('picking_priority', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['picking_priority'] = $picking_priority;

        return $this;
    }

    /**
     * Gets production_code
     *
     * @return string|null
     */
    public function getProductionCode()
    {
        return $this->container['production_code'];
    }

    /**
     * Sets production_code
     *
     * @param string|null $production_code production_code
     *
     * @return self
     */
    public function setProductionCode($production_code)
    {
        if (is_null($production_code)) {
            array_push($this->openAPINullablesSetToNull, 'production_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('production_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['production_code'] = $production_code;

        return $this;
    }

    /**
     * Gets advanced
     *
     * @return \OngoingAPI\Model\GetOrderInfoAdvanced|null
     */
    public function getAdvanced()
    {
        return $this->container['advanced'];
    }

    /**
     * Sets advanced
     *
     * @param \OngoingAPI\Model\GetOrderInfoAdvanced|null $advanced advanced
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
     * Gets freight_price
     *
     * @return float|null
     */
    public function getFreightPrice()
    {
        return $this->container['freight_price'];
    }

    /**
     * Sets freight_price
     *
     * @param float|null $freight_price freight_price
     *
     * @return self
     */
    public function setFreightPrice($freight_price)
    {
        if (is_null($freight_price)) {
            array_push($this->openAPINullablesSetToNull, 'freight_price');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('freight_price', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['freight_price'] = $freight_price;

        return $this;
    }

    /**
     * Gets invoice_url
     *
     * @return string|null
     */
    public function getInvoiceUrl()
    {
        return $this->container['invoice_url'];
    }

    /**
     * Sets invoice_url
     *
     * @param string|null $invoice_url invoice_url
     *
     * @return self
     */
    public function setInvoiceUrl($invoice_url)
    {
        if (is_null($invoice_url)) {
            array_push($this->openAPINullablesSetToNull, 'invoice_url');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('invoice_url', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['invoice_url'] = $invoice_url;

        return $this;
    }

    /**
     * Gets order_free_date_time1
     *
     * @return \DateTime|null
     */
    public function getOrderFreeDateTime1()
    {
        return $this->container['order_free_date_time1'];
    }

    /**
     * Sets order_free_date_time1
     *
     * @param \DateTime|null $order_free_date_time1 order_free_date_time1
     *
     * @return self
     */
    public function setOrderFreeDateTime1($order_free_date_time1)
    {
        if (is_null($order_free_date_time1)) {
            array_push($this->openAPINullablesSetToNull, 'order_free_date_time1');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('order_free_date_time1', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['order_free_date_time1'] = $order_free_date_time1;

        return $this;
    }

    /**
     * Gets sort_location
     *
     * @return string|null
     */
    public function getSortLocation()
    {
        return $this->container['sort_location'];
    }

    /**
     * Sets sort_location
     *
     * @param string|null $sort_location sort_location
     *
     * @return self
     */
    public function setSortLocation($sort_location)
    {
        if (is_null($sort_location)) {
            array_push($this->openAPINullablesSetToNull, 'sort_location');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('sort_location', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['sort_location'] = $sort_location;

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


