<?php
/**
 * PostArticleModel
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
 * PostArticleModel Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class PostArticleModel implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'PostArticleModel';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'article_group' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'article_category' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'article_color' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'article_size' => '\OngoingAPI\Model\GetArticleItemInfoStatus',
        'goods_owner_id' => 'int',
        'article_number' => 'string',
        'article_name' => 'string',
        'product_code' => 'string',
        'unit_code' => 'string',
        'description' => 'string',
        'is_stock_article' => 'bool',
        'is_active' => 'bool',
        'supplier_info' => '\OngoingAPI\Model\PostArticleModelSupplierInfo',
        'bar_code_info' => '\OngoingAPI\Model\PostArticleModelBarCodeInfo',
        'quantity_per_package' => 'int',
        'quantity_per_pallet' => 'int',
        'weight' => 'float',
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
        'volume' => 'float',
        'purchase_price' => 'float',
        'stock_valuation_price' => 'float',
        'customer_price' => 'float',
        'purcase_currency_code' => 'string',
        'country_of_origin_code' => 'string',
        'statistics_number' => 'string',
        'article_name_translations' => '\OngoingAPI\Model\PostArticleNameTranslation[]',
        'stock_limit' => 'int',
        'minimum_reorder_quantity' => 'float',
        'net_weight' => 'float',
        'link_to_picture' => 'string',
        'structure_definition' => '\OngoingAPI\Model\PostArticleModelStructureDefinition',
        'quantity_per_layer_on_pallet' => 'int',
        'sub_quantity_per_item' => 'float',
        'min_days_to_expiry_date_allowed_on_delivery' => 'int',
        'storage_properties' => '\OngoingAPI\Model\PostArticleModelStorageProperties',
        'free_values' => '\OngoingAPI\Model\PostArticleModelFreeValues',
        'storage_class' => '\OngoingAPI\Model\PostArticleModelStorageClass',
        'customs_description' => 'string',
        'taric_numbers_info' => '\OngoingAPI\Model\PostArticleModelTaricNumbersInfo',
        'article_inbound_handling_comment' => 'string',
        'article_picking_handling_comment' => 'string',
        'article_return_handling_comment' => 'string',
        'alternative_suppliers_info' => '\OngoingAPI\Model\PostArticleModelAlternativeSuppliersInfo',
        'article_classes_info' => '\OngoingAPI\Model\PostArticleModelArticleClassesInfo',
        'additional_statistics_number' => 'string',
        'customs_export_conditions' => 'string',
        'advanced' => '\OngoingAPI\Model\PostArticleModelAdvanced',
        'article_packing_handling_comment' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'article_group' => null,
        'article_category' => null,
        'article_color' => null,
        'article_size' => null,
        'goods_owner_id' => 'int32',
        'article_number' => null,
        'article_name' => null,
        'product_code' => null,
        'unit_code' => null,
        'description' => null,
        'is_stock_article' => null,
        'is_active' => null,
        'supplier_info' => null,
        'bar_code_info' => null,
        'quantity_per_package' => 'int32',
        'quantity_per_pallet' => 'int32',
        'weight' => 'decimal',
        'length' => 'decimal',
        'width' => 'decimal',
        'height' => 'decimal',
        'volume' => 'decimal',
        'purchase_price' => 'decimal',
        'stock_valuation_price' => 'decimal',
        'customer_price' => 'decimal',
        'purcase_currency_code' => null,
        'country_of_origin_code' => null,
        'statistics_number' => null,
        'article_name_translations' => null,
        'stock_limit' => 'int32',
        'minimum_reorder_quantity' => 'decimal',
        'net_weight' => 'decimal',
        'link_to_picture' => null,
        'structure_definition' => null,
        'quantity_per_layer_on_pallet' => 'int32',
        'sub_quantity_per_item' => 'decimal',
        'min_days_to_expiry_date_allowed_on_delivery' => 'int32',
        'storage_properties' => null,
        'free_values' => null,
        'storage_class' => null,
        'customs_description' => null,
        'taric_numbers_info' => null,
        'article_inbound_handling_comment' => null,
        'article_picking_handling_comment' => null,
        'article_return_handling_comment' => null,
        'alternative_suppliers_info' => null,
        'article_classes_info' => null,
        'additional_statistics_number' => null,
        'customs_export_conditions' => null,
        'advanced' => null,
        'article_packing_handling_comment' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'article_group' => true,
        'article_category' => true,
        'article_color' => true,
        'article_size' => true,
        'goods_owner_id' => false,
        'article_number' => false,
        'article_name' => true,
        'product_code' => true,
        'unit_code' => true,
        'description' => true,
        'is_stock_article' => true,
        'is_active' => true,
        'supplier_info' => true,
        'bar_code_info' => true,
        'quantity_per_package' => true,
        'quantity_per_pallet' => true,
        'weight' => true,
        'length' => true,
        'width' => true,
        'height' => true,
        'volume' => true,
        'purchase_price' => true,
        'stock_valuation_price' => true,
        'customer_price' => true,
        'purcase_currency_code' => true,
        'country_of_origin_code' => true,
        'statistics_number' => true,
        'article_name_translations' => true,
        'stock_limit' => true,
        'minimum_reorder_quantity' => true,
        'net_weight' => true,
        'link_to_picture' => true,
        'structure_definition' => true,
        'quantity_per_layer_on_pallet' => true,
        'sub_quantity_per_item' => true,
        'min_days_to_expiry_date_allowed_on_delivery' => true,
        'storage_properties' => true,
        'free_values' => true,
        'storage_class' => true,
        'customs_description' => true,
        'taric_numbers_info' => true,
        'article_inbound_handling_comment' => true,
        'article_picking_handling_comment' => true,
        'article_return_handling_comment' => true,
        'alternative_suppliers_info' => true,
        'article_classes_info' => true,
        'additional_statistics_number' => true,
        'customs_export_conditions' => true,
        'advanced' => true,
        'article_packing_handling_comment' => true
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
        'article_group' => 'articleGroup',
        'article_category' => 'articleCategory',
        'article_color' => 'articleColor',
        'article_size' => 'articleSize',
        'goods_owner_id' => 'goodsOwnerId',
        'article_number' => 'articleNumber',
        'article_name' => 'articleName',
        'product_code' => 'productCode',
        'unit_code' => 'unitCode',
        'description' => 'description',
        'is_stock_article' => 'isStockArticle',
        'is_active' => 'isActive',
        'supplier_info' => 'supplierInfo',
        'bar_code_info' => 'barCodeInfo',
        'quantity_per_package' => 'quantityPerPackage',
        'quantity_per_pallet' => 'quantityPerPallet',
        'weight' => 'weight',
        'length' => 'length',
        'width' => 'width',
        'height' => 'height',
        'volume' => 'volume',
        'purchase_price' => 'purchasePrice',
        'stock_valuation_price' => 'stockValuationPrice',
        'customer_price' => 'customerPrice',
        'purcase_currency_code' => 'purcaseCurrencyCode',
        'country_of_origin_code' => 'countryOfOriginCode',
        'statistics_number' => 'statisticsNumber',
        'article_name_translations' => 'articleNameTranslations',
        'stock_limit' => 'stockLimit',
        'minimum_reorder_quantity' => 'minimumReorderQuantity',
        'net_weight' => 'netWeight',
        'link_to_picture' => 'linkToPicture',
        'structure_definition' => 'structureDefinition',
        'quantity_per_layer_on_pallet' => 'quantityPerLayerOnPallet',
        'sub_quantity_per_item' => 'subQuantityPerItem',
        'min_days_to_expiry_date_allowed_on_delivery' => 'minDaysToExpiryDateAllowedOnDelivery',
        'storage_properties' => 'storageProperties',
        'free_values' => 'freeValues',
        'storage_class' => 'storageClass',
        'customs_description' => 'customsDescription',
        'taric_numbers_info' => 'taricNumbersInfo',
        'article_inbound_handling_comment' => 'articleInboundHandlingComment',
        'article_picking_handling_comment' => 'articlePickingHandlingComment',
        'article_return_handling_comment' => 'articleReturnHandlingComment',
        'alternative_suppliers_info' => 'alternativeSuppliersInfo',
        'article_classes_info' => 'articleClassesInfo',
        'additional_statistics_number' => 'additionalStatisticsNumber',
        'customs_export_conditions' => 'customsExportConditions',
        'advanced' => 'advanced',
        'article_packing_handling_comment' => 'articlePackingHandlingComment'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'article_group' => 'setArticleGroup',
        'article_category' => 'setArticleCategory',
        'article_color' => 'setArticleColor',
        'article_size' => 'setArticleSize',
        'goods_owner_id' => 'setGoodsOwnerId',
        'article_number' => 'setArticleNumber',
        'article_name' => 'setArticleName',
        'product_code' => 'setProductCode',
        'unit_code' => 'setUnitCode',
        'description' => 'setDescription',
        'is_stock_article' => 'setIsStockArticle',
        'is_active' => 'setIsActive',
        'supplier_info' => 'setSupplierInfo',
        'bar_code_info' => 'setBarCodeInfo',
        'quantity_per_package' => 'setQuantityPerPackage',
        'quantity_per_pallet' => 'setQuantityPerPallet',
        'weight' => 'setWeight',
        'length' => 'setLength',
        'width' => 'setWidth',
        'height' => 'setHeight',
        'volume' => 'setVolume',
        'purchase_price' => 'setPurchasePrice',
        'stock_valuation_price' => 'setStockValuationPrice',
        'customer_price' => 'setCustomerPrice',
        'purcase_currency_code' => 'setPurcaseCurrencyCode',
        'country_of_origin_code' => 'setCountryOfOriginCode',
        'statistics_number' => 'setStatisticsNumber',
        'article_name_translations' => 'setArticleNameTranslations',
        'stock_limit' => 'setStockLimit',
        'minimum_reorder_quantity' => 'setMinimumReorderQuantity',
        'net_weight' => 'setNetWeight',
        'link_to_picture' => 'setLinkToPicture',
        'structure_definition' => 'setStructureDefinition',
        'quantity_per_layer_on_pallet' => 'setQuantityPerLayerOnPallet',
        'sub_quantity_per_item' => 'setSubQuantityPerItem',
        'min_days_to_expiry_date_allowed_on_delivery' => 'setMinDaysToExpiryDateAllowedOnDelivery',
        'storage_properties' => 'setStorageProperties',
        'free_values' => 'setFreeValues',
        'storage_class' => 'setStorageClass',
        'customs_description' => 'setCustomsDescription',
        'taric_numbers_info' => 'setTaricNumbersInfo',
        'article_inbound_handling_comment' => 'setArticleInboundHandlingComment',
        'article_picking_handling_comment' => 'setArticlePickingHandlingComment',
        'article_return_handling_comment' => 'setArticleReturnHandlingComment',
        'alternative_suppliers_info' => 'setAlternativeSuppliersInfo',
        'article_classes_info' => 'setArticleClassesInfo',
        'additional_statistics_number' => 'setAdditionalStatisticsNumber',
        'customs_export_conditions' => 'setCustomsExportConditions',
        'advanced' => 'setAdvanced',
        'article_packing_handling_comment' => 'setArticlePackingHandlingComment'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'article_group' => 'getArticleGroup',
        'article_category' => 'getArticleCategory',
        'article_color' => 'getArticleColor',
        'article_size' => 'getArticleSize',
        'goods_owner_id' => 'getGoodsOwnerId',
        'article_number' => 'getArticleNumber',
        'article_name' => 'getArticleName',
        'product_code' => 'getProductCode',
        'unit_code' => 'getUnitCode',
        'description' => 'getDescription',
        'is_stock_article' => 'getIsStockArticle',
        'is_active' => 'getIsActive',
        'supplier_info' => 'getSupplierInfo',
        'bar_code_info' => 'getBarCodeInfo',
        'quantity_per_package' => 'getQuantityPerPackage',
        'quantity_per_pallet' => 'getQuantityPerPallet',
        'weight' => 'getWeight',
        'length' => 'getLength',
        'width' => 'getWidth',
        'height' => 'getHeight',
        'volume' => 'getVolume',
        'purchase_price' => 'getPurchasePrice',
        'stock_valuation_price' => 'getStockValuationPrice',
        'customer_price' => 'getCustomerPrice',
        'purcase_currency_code' => 'getPurcaseCurrencyCode',
        'country_of_origin_code' => 'getCountryOfOriginCode',
        'statistics_number' => 'getStatisticsNumber',
        'article_name_translations' => 'getArticleNameTranslations',
        'stock_limit' => 'getStockLimit',
        'minimum_reorder_quantity' => 'getMinimumReorderQuantity',
        'net_weight' => 'getNetWeight',
        'link_to_picture' => 'getLinkToPicture',
        'structure_definition' => 'getStructureDefinition',
        'quantity_per_layer_on_pallet' => 'getQuantityPerLayerOnPallet',
        'sub_quantity_per_item' => 'getSubQuantityPerItem',
        'min_days_to_expiry_date_allowed_on_delivery' => 'getMinDaysToExpiryDateAllowedOnDelivery',
        'storage_properties' => 'getStorageProperties',
        'free_values' => 'getFreeValues',
        'storage_class' => 'getStorageClass',
        'customs_description' => 'getCustomsDescription',
        'taric_numbers_info' => 'getTaricNumbersInfo',
        'article_inbound_handling_comment' => 'getArticleInboundHandlingComment',
        'article_picking_handling_comment' => 'getArticlePickingHandlingComment',
        'article_return_handling_comment' => 'getArticleReturnHandlingComment',
        'alternative_suppliers_info' => 'getAlternativeSuppliersInfo',
        'article_classes_info' => 'getArticleClassesInfo',
        'additional_statistics_number' => 'getAdditionalStatisticsNumber',
        'customs_export_conditions' => 'getCustomsExportConditions',
        'advanced' => 'getAdvanced',
        'article_packing_handling_comment' => 'getArticlePackingHandlingComment'
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
        $this->setIfExists('article_group', $data ?? [], null);
        $this->setIfExists('article_category', $data ?? [], null);
        $this->setIfExists('article_color', $data ?? [], null);
        $this->setIfExists('article_size', $data ?? [], null);
        $this->setIfExists('goods_owner_id', $data ?? [], null);
        $this->setIfExists('article_number', $data ?? [], null);
        $this->setIfExists('article_name', $data ?? [], null);
        $this->setIfExists('product_code', $data ?? [], null);
        $this->setIfExists('unit_code', $data ?? [], null);
        $this->setIfExists('description', $data ?? [], null);
        $this->setIfExists('is_stock_article', $data ?? [], null);
        $this->setIfExists('is_active', $data ?? [], null);
        $this->setIfExists('supplier_info', $data ?? [], null);
        $this->setIfExists('bar_code_info', $data ?? [], null);
        $this->setIfExists('quantity_per_package', $data ?? [], null);
        $this->setIfExists('quantity_per_pallet', $data ?? [], null);
        $this->setIfExists('weight', $data ?? [], null);
        $this->setIfExists('length', $data ?? [], null);
        $this->setIfExists('width', $data ?? [], null);
        $this->setIfExists('height', $data ?? [], null);
        $this->setIfExists('volume', $data ?? [], null);
        $this->setIfExists('purchase_price', $data ?? [], null);
        $this->setIfExists('stock_valuation_price', $data ?? [], null);
        $this->setIfExists('customer_price', $data ?? [], null);
        $this->setIfExists('purcase_currency_code', $data ?? [], null);
        $this->setIfExists('country_of_origin_code', $data ?? [], null);
        $this->setIfExists('statistics_number', $data ?? [], null);
        $this->setIfExists('article_name_translations', $data ?? [], null);
        $this->setIfExists('stock_limit', $data ?? [], null);
        $this->setIfExists('minimum_reorder_quantity', $data ?? [], null);
        $this->setIfExists('net_weight', $data ?? [], null);
        $this->setIfExists('link_to_picture', $data ?? [], null);
        $this->setIfExists('structure_definition', $data ?? [], null);
        $this->setIfExists('quantity_per_layer_on_pallet', $data ?? [], null);
        $this->setIfExists('sub_quantity_per_item', $data ?? [], null);
        $this->setIfExists('min_days_to_expiry_date_allowed_on_delivery', $data ?? [], null);
        $this->setIfExists('storage_properties', $data ?? [], null);
        $this->setIfExists('free_values', $data ?? [], null);
        $this->setIfExists('storage_class', $data ?? [], null);
        $this->setIfExists('customs_description', $data ?? [], null);
        $this->setIfExists('taric_numbers_info', $data ?? [], null);
        $this->setIfExists('article_inbound_handling_comment', $data ?? [], null);
        $this->setIfExists('article_picking_handling_comment', $data ?? [], null);
        $this->setIfExists('article_return_handling_comment', $data ?? [], null);
        $this->setIfExists('alternative_suppliers_info', $data ?? [], null);
        $this->setIfExists('article_classes_info', $data ?? [], null);
        $this->setIfExists('additional_statistics_number', $data ?? [], null);
        $this->setIfExists('customs_export_conditions', $data ?? [], null);
        $this->setIfExists('advanced', $data ?? [], null);
        $this->setIfExists('article_packing_handling_comment', $data ?? [], null);
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
        if ($this->container['article_number'] === null) {
            $invalidProperties[] = "'article_number' can't be null";
        }
        if ((mb_strlen($this->container['article_number']) < 1)) {
            $invalidProperties[] = "invalid value for 'article_number', the character length must be bigger than or equal to 1.";
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
     * Gets article_group
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getArticleGroup()
    {
        return $this->container['article_group'];
    }

    /**
     * Sets article_group
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $article_group article_group
     *
     * @return self
     */
    public function setArticleGroup($article_group)
    {
        if (is_null($article_group)) {
            array_push($this->openAPINullablesSetToNull, 'article_group');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_group', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_group'] = $article_group;

        return $this;
    }

    /**
     * Gets article_category
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getArticleCategory()
    {
        return $this->container['article_category'];
    }

    /**
     * Sets article_category
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $article_category article_category
     *
     * @return self
     */
    public function setArticleCategory($article_category)
    {
        if (is_null($article_category)) {
            array_push($this->openAPINullablesSetToNull, 'article_category');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_category', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_category'] = $article_category;

        return $this;
    }

    /**
     * Gets article_color
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getArticleColor()
    {
        return $this->container['article_color'];
    }

    /**
     * Sets article_color
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $article_color article_color
     *
     * @return self
     */
    public function setArticleColor($article_color)
    {
        if (is_null($article_color)) {
            array_push($this->openAPINullablesSetToNull, 'article_color');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_color', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_color'] = $article_color;

        return $this;
    }

    /**
     * Gets article_size
     *
     * @return \OngoingAPI\Model\GetArticleItemInfoStatus|null
     */
    public function getArticleSize()
    {
        return $this->container['article_size'];
    }

    /**
     * Sets article_size
     *
     * @param \OngoingAPI\Model\GetArticleItemInfoStatus|null $article_size article_size
     *
     * @return self
     */
    public function setArticleSize($article_size)
    {
        if (is_null($article_size)) {
            array_push($this->openAPINullablesSetToNull, 'article_size');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_size', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_size'] = $article_size;

        return $this;
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
     * Gets article_number
     *
     * @return string
     */
    public function getArticleNumber()
    {
        return $this->container['article_number'];
    }

    /**
     * Sets article_number
     *
     * @param string $article_number article_number
     *
     * @return self
     */
    public function setArticleNumber($article_number)
    {
        if (is_null($article_number)) {
            throw new \InvalidArgumentException('non-nullable article_number cannot be null');
        }

        if ((mb_strlen($article_number) < 1)) {
            throw new \InvalidArgumentException('invalid length for $article_number when calling PostArticleModel., must be bigger than or equal to 1.');
        }

        $this->container['article_number'] = $article_number;

        return $this;
    }

    /**
     * Gets article_name
     *
     * @return string|null
     */
    public function getArticleName()
    {
        return $this->container['article_name'];
    }

    /**
     * Sets article_name
     *
     * @param string|null $article_name article_name
     *
     * @return self
     */
    public function setArticleName($article_name)
    {
        if (is_null($article_name)) {
            array_push($this->openAPINullablesSetToNull, 'article_name');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_name', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_name'] = $article_name;

        return $this;
    }

    /**
     * Gets product_code
     *
     * @return string|null
     */
    public function getProductCode()
    {
        return $this->container['product_code'];
    }

    /**
     * Sets product_code
     *
     * @param string|null $product_code product_code
     *
     * @return self
     */
    public function setProductCode($product_code)
    {
        if (is_null($product_code)) {
            array_push($this->openAPINullablesSetToNull, 'product_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('product_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['product_code'] = $product_code;

        return $this;
    }

    /**
     * Gets unit_code
     *
     * @return string|null
     */
    public function getUnitCode()
    {
        return $this->container['unit_code'];
    }

    /**
     * Sets unit_code
     *
     * @param string|null $unit_code unit_code
     *
     * @return self
     */
    public function setUnitCode($unit_code)
    {
        if (is_null($unit_code)) {
            array_push($this->openAPINullablesSetToNull, 'unit_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('unit_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['unit_code'] = $unit_code;

        return $this;
    }

    /**
     * Gets description
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string|null $description description
     *
     * @return self
     */
    public function setDescription($description)
    {
        if (is_null($description)) {
            array_push($this->openAPINullablesSetToNull, 'description');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('description', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets is_stock_article
     *
     * @return bool|null
     */
    public function getIsStockArticle()
    {
        return $this->container['is_stock_article'];
    }

    /**
     * Sets is_stock_article
     *
     * @param bool|null $is_stock_article is_stock_article
     *
     * @return self
     */
    public function setIsStockArticle($is_stock_article)
    {
        if (is_null($is_stock_article)) {
            array_push($this->openAPINullablesSetToNull, 'is_stock_article');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('is_stock_article', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['is_stock_article'] = $is_stock_article;

        return $this;
    }

    /**
     * Gets is_active
     *
     * @return bool|null
     */
    public function getIsActive()
    {
        return $this->container['is_active'];
    }

    /**
     * Sets is_active
     *
     * @param bool|null $is_active is_active
     *
     * @return self
     */
    public function setIsActive($is_active)
    {
        if (is_null($is_active)) {
            array_push($this->openAPINullablesSetToNull, 'is_active');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('is_active', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['is_active'] = $is_active;

        return $this;
    }

    /**
     * Gets supplier_info
     *
     * @return \OngoingAPI\Model\PostArticleModelSupplierInfo|null
     */
    public function getSupplierInfo()
    {
        return $this->container['supplier_info'];
    }

    /**
     * Sets supplier_info
     *
     * @param \OngoingAPI\Model\PostArticleModelSupplierInfo|null $supplier_info supplier_info
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
     * Gets bar_code_info
     *
     * @return \OngoingAPI\Model\PostArticleModelBarCodeInfo|null
     */
    public function getBarCodeInfo()
    {
        return $this->container['bar_code_info'];
    }

    /**
     * Sets bar_code_info
     *
     * @param \OngoingAPI\Model\PostArticleModelBarCodeInfo|null $bar_code_info bar_code_info
     *
     * @return self
     */
    public function setBarCodeInfo($bar_code_info)
    {
        if (is_null($bar_code_info)) {
            array_push($this->openAPINullablesSetToNull, 'bar_code_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('bar_code_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['bar_code_info'] = $bar_code_info;

        return $this;
    }

    /**
     * Gets quantity_per_package
     *
     * @return int|null
     */
    public function getQuantityPerPackage()
    {
        return $this->container['quantity_per_package'];
    }

    /**
     * Sets quantity_per_package
     *
     * @param int|null $quantity_per_package quantity_per_package
     *
     * @return self
     */
    public function setQuantityPerPackage($quantity_per_package)
    {
        if (is_null($quantity_per_package)) {
            array_push($this->openAPINullablesSetToNull, 'quantity_per_package');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('quantity_per_package', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['quantity_per_package'] = $quantity_per_package;

        return $this;
    }

    /**
     * Gets quantity_per_pallet
     *
     * @return int|null
     */
    public function getQuantityPerPallet()
    {
        return $this->container['quantity_per_pallet'];
    }

    /**
     * Sets quantity_per_pallet
     *
     * @param int|null $quantity_per_pallet quantity_per_pallet
     *
     * @return self
     */
    public function setQuantityPerPallet($quantity_per_pallet)
    {
        if (is_null($quantity_per_pallet)) {
            array_push($this->openAPINullablesSetToNull, 'quantity_per_pallet');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('quantity_per_pallet', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['quantity_per_pallet'] = $quantity_per_pallet;

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
     * Gets length
     *
     * @return float|null
     */
    public function getLength()
    {
        return $this->container['length'];
    }

    /**
     * Sets length
     *
     * @param float|null $length length
     *
     * @return self
     */
    public function setLength($length)
    {
        if (is_null($length)) {
            array_push($this->openAPINullablesSetToNull, 'length');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('length', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['length'] = $length;

        return $this;
    }

    /**
     * Gets width
     *
     * @return float|null
     */
    public function getWidth()
    {
        return $this->container['width'];
    }

    /**
     * Sets width
     *
     * @param float|null $width width
     *
     * @return self
     */
    public function setWidth($width)
    {
        if (is_null($width)) {
            array_push($this->openAPINullablesSetToNull, 'width');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('width', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['width'] = $width;

        return $this;
    }

    /**
     * Gets height
     *
     * @return float|null
     */
    public function getHeight()
    {
        return $this->container['height'];
    }

    /**
     * Sets height
     *
     * @param float|null $height height
     *
     * @return self
     */
    public function setHeight($height)
    {
        if (is_null($height)) {
            array_push($this->openAPINullablesSetToNull, 'height');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('height', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['height'] = $height;

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
     * Gets purchase_price
     *
     * @return float|null
     */
    public function getPurchasePrice()
    {
        return $this->container['purchase_price'];
    }

    /**
     * Sets purchase_price
     *
     * @param float|null $purchase_price purchase_price
     *
     * @return self
     */
    public function setPurchasePrice($purchase_price)
    {
        if (is_null($purchase_price)) {
            array_push($this->openAPINullablesSetToNull, 'purchase_price');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('purchase_price', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['purchase_price'] = $purchase_price;

        return $this;
    }

    /**
     * Gets stock_valuation_price
     *
     * @return float|null
     */
    public function getStockValuationPrice()
    {
        return $this->container['stock_valuation_price'];
    }

    /**
     * Sets stock_valuation_price
     *
     * @param float|null $stock_valuation_price stock_valuation_price
     *
     * @return self
     */
    public function setStockValuationPrice($stock_valuation_price)
    {
        if (is_null($stock_valuation_price)) {
            array_push($this->openAPINullablesSetToNull, 'stock_valuation_price');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('stock_valuation_price', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['stock_valuation_price'] = $stock_valuation_price;

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
     * Gets purcase_currency_code
     *
     * @return string|null
     */
    public function getPurcaseCurrencyCode()
    {
        return $this->container['purcase_currency_code'];
    }

    /**
     * Sets purcase_currency_code
     *
     * @param string|null $purcase_currency_code purcase_currency_code
     *
     * @return self
     */
    public function setPurcaseCurrencyCode($purcase_currency_code)
    {
        if (is_null($purcase_currency_code)) {
            array_push($this->openAPINullablesSetToNull, 'purcase_currency_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('purcase_currency_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['purcase_currency_code'] = $purcase_currency_code;

        return $this;
    }

    /**
     * Gets country_of_origin_code
     *
     * @return string|null
     */
    public function getCountryOfOriginCode()
    {
        return $this->container['country_of_origin_code'];
    }

    /**
     * Sets country_of_origin_code
     *
     * @param string|null $country_of_origin_code country_of_origin_code
     *
     * @return self
     */
    public function setCountryOfOriginCode($country_of_origin_code)
    {
        if (is_null($country_of_origin_code)) {
            array_push($this->openAPINullablesSetToNull, 'country_of_origin_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('country_of_origin_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['country_of_origin_code'] = $country_of_origin_code;

        return $this;
    }

    /**
     * Gets statistics_number
     *
     * @return string|null
     */
    public function getStatisticsNumber()
    {
        return $this->container['statistics_number'];
    }

    /**
     * Sets statistics_number
     *
     * @param string|null $statistics_number statistics_number
     *
     * @return self
     */
    public function setStatisticsNumber($statistics_number)
    {
        if (is_null($statistics_number)) {
            array_push($this->openAPINullablesSetToNull, 'statistics_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('statistics_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['statistics_number'] = $statistics_number;

        return $this;
    }

    /**
     * Gets article_name_translations
     *
     * @return \OngoingAPI\Model\PostArticleNameTranslation[]|null
     */
    public function getArticleNameTranslations()
    {
        return $this->container['article_name_translations'];
    }

    /**
     * Sets article_name_translations
     *
     * @param \OngoingAPI\Model\PostArticleNameTranslation[]|null $article_name_translations article_name_translations
     *
     * @return self
     */
    public function setArticleNameTranslations($article_name_translations)
    {
        if (is_null($article_name_translations)) {
            array_push($this->openAPINullablesSetToNull, 'article_name_translations');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_name_translations', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_name_translations'] = $article_name_translations;

        return $this;
    }

    /**
     * Gets stock_limit
     *
     * @return int|null
     */
    public function getStockLimit()
    {
        return $this->container['stock_limit'];
    }

    /**
     * Sets stock_limit
     *
     * @param int|null $stock_limit stock_limit
     *
     * @return self
     */
    public function setStockLimit($stock_limit)
    {
        if (is_null($stock_limit)) {
            array_push($this->openAPINullablesSetToNull, 'stock_limit');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('stock_limit', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['stock_limit'] = $stock_limit;

        return $this;
    }

    /**
     * Gets minimum_reorder_quantity
     *
     * @return float|null
     */
    public function getMinimumReorderQuantity()
    {
        return $this->container['minimum_reorder_quantity'];
    }

    /**
     * Sets minimum_reorder_quantity
     *
     * @param float|null $minimum_reorder_quantity minimum_reorder_quantity
     *
     * @return self
     */
    public function setMinimumReorderQuantity($minimum_reorder_quantity)
    {
        if (is_null($minimum_reorder_quantity)) {
            array_push($this->openAPINullablesSetToNull, 'minimum_reorder_quantity');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('minimum_reorder_quantity', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['minimum_reorder_quantity'] = $minimum_reorder_quantity;

        return $this;
    }

    /**
     * Gets net_weight
     *
     * @return float|null
     */
    public function getNetWeight()
    {
        return $this->container['net_weight'];
    }

    /**
     * Sets net_weight
     *
     * @param float|null $net_weight net_weight
     *
     * @return self
     */
    public function setNetWeight($net_weight)
    {
        if (is_null($net_weight)) {
            array_push($this->openAPINullablesSetToNull, 'net_weight');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('net_weight', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['net_weight'] = $net_weight;

        return $this;
    }

    /**
     * Gets link_to_picture
     *
     * @return string|null
     */
    public function getLinkToPicture()
    {
        return $this->container['link_to_picture'];
    }

    /**
     * Sets link_to_picture
     *
     * @param string|null $link_to_picture link_to_picture
     *
     * @return self
     */
    public function setLinkToPicture($link_to_picture)
    {
        if (is_null($link_to_picture)) {
            array_push($this->openAPINullablesSetToNull, 'link_to_picture');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('link_to_picture', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['link_to_picture'] = $link_to_picture;

        return $this;
    }

    /**
     * Gets structure_definition
     *
     * @return \OngoingAPI\Model\PostArticleModelStructureDefinition|null
     */
    public function getStructureDefinition()
    {
        return $this->container['structure_definition'];
    }

    /**
     * Sets structure_definition
     *
     * @param \OngoingAPI\Model\PostArticleModelStructureDefinition|null $structure_definition structure_definition
     *
     * @return self
     */
    public function setStructureDefinition($structure_definition)
    {
        if (is_null($structure_definition)) {
            array_push($this->openAPINullablesSetToNull, 'structure_definition');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('structure_definition', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['structure_definition'] = $structure_definition;

        return $this;
    }

    /**
     * Gets quantity_per_layer_on_pallet
     *
     * @return int|null
     */
    public function getQuantityPerLayerOnPallet()
    {
        return $this->container['quantity_per_layer_on_pallet'];
    }

    /**
     * Sets quantity_per_layer_on_pallet
     *
     * @param int|null $quantity_per_layer_on_pallet quantity_per_layer_on_pallet
     *
     * @return self
     */
    public function setQuantityPerLayerOnPallet($quantity_per_layer_on_pallet)
    {
        if (is_null($quantity_per_layer_on_pallet)) {
            array_push($this->openAPINullablesSetToNull, 'quantity_per_layer_on_pallet');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('quantity_per_layer_on_pallet', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['quantity_per_layer_on_pallet'] = $quantity_per_layer_on_pallet;

        return $this;
    }

    /**
     * Gets sub_quantity_per_item
     *
     * @return float|null
     */
    public function getSubQuantityPerItem()
    {
        return $this->container['sub_quantity_per_item'];
    }

    /**
     * Sets sub_quantity_per_item
     *
     * @param float|null $sub_quantity_per_item sub_quantity_per_item
     *
     * @return self
     */
    public function setSubQuantityPerItem($sub_quantity_per_item)
    {
        if (is_null($sub_quantity_per_item)) {
            array_push($this->openAPINullablesSetToNull, 'sub_quantity_per_item');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('sub_quantity_per_item', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['sub_quantity_per_item'] = $sub_quantity_per_item;

        return $this;
    }

    /**
     * Gets min_days_to_expiry_date_allowed_on_delivery
     *
     * @return int|null
     */
    public function getMinDaysToExpiryDateAllowedOnDelivery()
    {
        return $this->container['min_days_to_expiry_date_allowed_on_delivery'];
    }

    /**
     * Sets min_days_to_expiry_date_allowed_on_delivery
     *
     * @param int|null $min_days_to_expiry_date_allowed_on_delivery min_days_to_expiry_date_allowed_on_delivery
     *
     * @return self
     */
    public function setMinDaysToExpiryDateAllowedOnDelivery($min_days_to_expiry_date_allowed_on_delivery)
    {
        if (is_null($min_days_to_expiry_date_allowed_on_delivery)) {
            array_push($this->openAPINullablesSetToNull, 'min_days_to_expiry_date_allowed_on_delivery');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('min_days_to_expiry_date_allowed_on_delivery', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['min_days_to_expiry_date_allowed_on_delivery'] = $min_days_to_expiry_date_allowed_on_delivery;

        return $this;
    }

    /**
     * Gets storage_properties
     *
     * @return \OngoingAPI\Model\PostArticleModelStorageProperties|null
     */
    public function getStorageProperties()
    {
        return $this->container['storage_properties'];
    }

    /**
     * Sets storage_properties
     *
     * @param \OngoingAPI\Model\PostArticleModelStorageProperties|null $storage_properties storage_properties
     *
     * @return self
     */
    public function setStorageProperties($storage_properties)
    {
        if (is_null($storage_properties)) {
            array_push($this->openAPINullablesSetToNull, 'storage_properties');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('storage_properties', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['storage_properties'] = $storage_properties;

        return $this;
    }

    /**
     * Gets free_values
     *
     * @return \OngoingAPI\Model\PostArticleModelFreeValues|null
     */
    public function getFreeValues()
    {
        return $this->container['free_values'];
    }

    /**
     * Sets free_values
     *
     * @param \OngoingAPI\Model\PostArticleModelFreeValues|null $free_values free_values
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
     * Gets storage_class
     *
     * @return \OngoingAPI\Model\PostArticleModelStorageClass|null
     */
    public function getStorageClass()
    {
        return $this->container['storage_class'];
    }

    /**
     * Sets storage_class
     *
     * @param \OngoingAPI\Model\PostArticleModelStorageClass|null $storage_class storage_class
     *
     * @return self
     */
    public function setStorageClass($storage_class)
    {
        if (is_null($storage_class)) {
            array_push($this->openAPINullablesSetToNull, 'storage_class');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('storage_class', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['storage_class'] = $storage_class;

        return $this;
    }

    /**
     * Gets customs_description
     *
     * @return string|null
     */
    public function getCustomsDescription()
    {
        return $this->container['customs_description'];
    }

    /**
     * Sets customs_description
     *
     * @param string|null $customs_description customs_description
     *
     * @return self
     */
    public function setCustomsDescription($customs_description)
    {
        if (is_null($customs_description)) {
            array_push($this->openAPINullablesSetToNull, 'customs_description');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('customs_description', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['customs_description'] = $customs_description;

        return $this;
    }

    /**
     * Gets taric_numbers_info
     *
     * @return \OngoingAPI\Model\PostArticleModelTaricNumbersInfo|null
     */
    public function getTaricNumbersInfo()
    {
        return $this->container['taric_numbers_info'];
    }

    /**
     * Sets taric_numbers_info
     *
     * @param \OngoingAPI\Model\PostArticleModelTaricNumbersInfo|null $taric_numbers_info taric_numbers_info
     *
     * @return self
     */
    public function setTaricNumbersInfo($taric_numbers_info)
    {
        if (is_null($taric_numbers_info)) {
            array_push($this->openAPINullablesSetToNull, 'taric_numbers_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('taric_numbers_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['taric_numbers_info'] = $taric_numbers_info;

        return $this;
    }

    /**
     * Gets article_inbound_handling_comment
     *
     * @return string|null
     */
    public function getArticleInboundHandlingComment()
    {
        return $this->container['article_inbound_handling_comment'];
    }

    /**
     * Sets article_inbound_handling_comment
     *
     * @param string|null $article_inbound_handling_comment article_inbound_handling_comment
     *
     * @return self
     */
    public function setArticleInboundHandlingComment($article_inbound_handling_comment)
    {
        if (is_null($article_inbound_handling_comment)) {
            array_push($this->openAPINullablesSetToNull, 'article_inbound_handling_comment');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_inbound_handling_comment', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_inbound_handling_comment'] = $article_inbound_handling_comment;

        return $this;
    }

    /**
     * Gets article_picking_handling_comment
     *
     * @return string|null
     */
    public function getArticlePickingHandlingComment()
    {
        return $this->container['article_picking_handling_comment'];
    }

    /**
     * Sets article_picking_handling_comment
     *
     * @param string|null $article_picking_handling_comment article_picking_handling_comment
     *
     * @return self
     */
    public function setArticlePickingHandlingComment($article_picking_handling_comment)
    {
        if (is_null($article_picking_handling_comment)) {
            array_push($this->openAPINullablesSetToNull, 'article_picking_handling_comment');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_picking_handling_comment', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_picking_handling_comment'] = $article_picking_handling_comment;

        return $this;
    }

    /**
     * Gets article_return_handling_comment
     *
     * @return string|null
     */
    public function getArticleReturnHandlingComment()
    {
        return $this->container['article_return_handling_comment'];
    }

    /**
     * Sets article_return_handling_comment
     *
     * @param string|null $article_return_handling_comment article_return_handling_comment
     *
     * @return self
     */
    public function setArticleReturnHandlingComment($article_return_handling_comment)
    {
        if (is_null($article_return_handling_comment)) {
            array_push($this->openAPINullablesSetToNull, 'article_return_handling_comment');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_return_handling_comment', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_return_handling_comment'] = $article_return_handling_comment;

        return $this;
    }

    /**
     * Gets alternative_suppliers_info
     *
     * @return \OngoingAPI\Model\PostArticleModelAlternativeSuppliersInfo|null
     */
    public function getAlternativeSuppliersInfo()
    {
        return $this->container['alternative_suppliers_info'];
    }

    /**
     * Sets alternative_suppliers_info
     *
     * @param \OngoingAPI\Model\PostArticleModelAlternativeSuppliersInfo|null $alternative_suppliers_info alternative_suppliers_info
     *
     * @return self
     */
    public function setAlternativeSuppliersInfo($alternative_suppliers_info)
    {
        if (is_null($alternative_suppliers_info)) {
            array_push($this->openAPINullablesSetToNull, 'alternative_suppliers_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('alternative_suppliers_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['alternative_suppliers_info'] = $alternative_suppliers_info;

        return $this;
    }

    /**
     * Gets article_classes_info
     *
     * @return \OngoingAPI\Model\PostArticleModelArticleClassesInfo|null
     */
    public function getArticleClassesInfo()
    {
        return $this->container['article_classes_info'];
    }

    /**
     * Sets article_classes_info
     *
     * @param \OngoingAPI\Model\PostArticleModelArticleClassesInfo|null $article_classes_info article_classes_info
     *
     * @return self
     */
    public function setArticleClassesInfo($article_classes_info)
    {
        if (is_null($article_classes_info)) {
            array_push($this->openAPINullablesSetToNull, 'article_classes_info');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_classes_info', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_classes_info'] = $article_classes_info;

        return $this;
    }

    /**
     * Gets additional_statistics_number
     *
     * @return string|null
     */
    public function getAdditionalStatisticsNumber()
    {
        return $this->container['additional_statistics_number'];
    }

    /**
     * Sets additional_statistics_number
     *
     * @param string|null $additional_statistics_number additional_statistics_number
     *
     * @return self
     */
    public function setAdditionalStatisticsNumber($additional_statistics_number)
    {
        if (is_null($additional_statistics_number)) {
            array_push($this->openAPINullablesSetToNull, 'additional_statistics_number');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('additional_statistics_number', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['additional_statistics_number'] = $additional_statistics_number;

        return $this;
    }

    /**
     * Gets customs_export_conditions
     *
     * @return string|null
     */
    public function getCustomsExportConditions()
    {
        return $this->container['customs_export_conditions'];
    }

    /**
     * Sets customs_export_conditions
     *
     * @param string|null $customs_export_conditions customs_export_conditions
     *
     * @return self
     */
    public function setCustomsExportConditions($customs_export_conditions)
    {
        if (is_null($customs_export_conditions)) {
            array_push($this->openAPINullablesSetToNull, 'customs_export_conditions');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('customs_export_conditions', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['customs_export_conditions'] = $customs_export_conditions;

        return $this;
    }

    /**
     * Gets advanced
     *
     * @return \OngoingAPI\Model\PostArticleModelAdvanced|null
     */
    public function getAdvanced()
    {
        return $this->container['advanced'];
    }

    /**
     * Sets advanced
     *
     * @param \OngoingAPI\Model\PostArticleModelAdvanced|null $advanced advanced
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
     * Gets article_packing_handling_comment
     *
     * @return string|null
     */
    public function getArticlePackingHandlingComment()
    {
        return $this->container['article_packing_handling_comment'];
    }

    /**
     * Sets article_packing_handling_comment
     *
     * @param string|null $article_packing_handling_comment article_packing_handling_comment
     *
     * @return self
     */
    public function setArticlePackingHandlingComment($article_packing_handling_comment)
    {
        if (is_null($article_packing_handling_comment)) {
            array_push($this->openAPINullablesSetToNull, 'article_packing_handling_comment');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('article_packing_handling_comment', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['article_packing_handling_comment'] = $article_packing_handling_comment;

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


