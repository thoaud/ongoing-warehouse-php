<?php
/**
 * PostArticleDangerousGoodsModel
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
 * PostArticleDangerousGoodsModel Class Doc Comment
 *
 * @category Class
 * @package  OngoingAPI
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<string, mixed>
 */
class PostArticleDangerousGoodsModel implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'PostArticleDangerousGoodsModel';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'un_number' => 'string',
        'un_package_type' => 'string',
        'un_label_numbers' => 'string',
        'un_is_marine_hazard' => 'bool',
        'dangerous_goods_coefficient' => 'float',
        'ems_code' => 'string',
        'flash_point' => 'float',
        'un_proper_shipping_names' => '\OngoingAPI\Model\PostArticleProperShippingNameModel[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'un_number' => null,
        'un_package_type' => null,
        'un_label_numbers' => null,
        'un_is_marine_hazard' => null,
        'dangerous_goods_coefficient' => 'decimal',
        'ems_code' => null,
        'flash_point' => 'decimal',
        'un_proper_shipping_names' => null
    ];

    /**
      * Array of nullable properties. Used for (de)serialization
      *
      * @var boolean[]
      */
    protected static array $openAPINullables = [
        'un_number' => false,
        'un_package_type' => true,
        'un_label_numbers' => true,
        'un_is_marine_hazard' => false,
        'dangerous_goods_coefficient' => true,
        'ems_code' => true,
        'flash_point' => true,
        'un_proper_shipping_names' => true
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
        'un_number' => 'unNumber',
        'un_package_type' => 'unPackageType',
        'un_label_numbers' => 'unLabelNumbers',
        'un_is_marine_hazard' => 'unIsMarineHazard',
        'dangerous_goods_coefficient' => 'dangerousGoodsCoefficient',
        'ems_code' => 'emsCode',
        'flash_point' => 'flashPoint',
        'un_proper_shipping_names' => 'unProperShippingNames'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'un_number' => 'setUnNumber',
        'un_package_type' => 'setUnPackageType',
        'un_label_numbers' => 'setUnLabelNumbers',
        'un_is_marine_hazard' => 'setUnIsMarineHazard',
        'dangerous_goods_coefficient' => 'setDangerousGoodsCoefficient',
        'ems_code' => 'setEmsCode',
        'flash_point' => 'setFlashPoint',
        'un_proper_shipping_names' => 'setUnProperShippingNames'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'un_number' => 'getUnNumber',
        'un_package_type' => 'getUnPackageType',
        'un_label_numbers' => 'getUnLabelNumbers',
        'un_is_marine_hazard' => 'getUnIsMarineHazard',
        'dangerous_goods_coefficient' => 'getDangerousGoodsCoefficient',
        'ems_code' => 'getEmsCode',
        'flash_point' => 'getFlashPoint',
        'un_proper_shipping_names' => 'getUnProperShippingNames'
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
        $this->setIfExists('un_number', $data ?? [], null);
        $this->setIfExists('un_package_type', $data ?? [], null);
        $this->setIfExists('un_label_numbers', $data ?? [], null);
        $this->setIfExists('un_is_marine_hazard', $data ?? [], null);
        $this->setIfExists('dangerous_goods_coefficient', $data ?? [], null);
        $this->setIfExists('ems_code', $data ?? [], null);
        $this->setIfExists('flash_point', $data ?? [], null);
        $this->setIfExists('un_proper_shipping_names', $data ?? [], null);
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

        if ($this->container['un_number'] === null) {
            $invalidProperties[] = "'un_number' can't be null";
        }
        if ((mb_strlen($this->container['un_number']) < 1)) {
            $invalidProperties[] = "invalid value for 'un_number', the character length must be bigger than or equal to 1.";
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
     * Gets un_number
     *
     * @return string
     */
    public function getUnNumber()
    {
        return $this->container['un_number'];
    }

    /**
     * Sets un_number
     *
     * @param string $un_number un_number
     *
     * @return self
     */
    public function setUnNumber($un_number)
    {
        if (is_null($un_number)) {
            throw new \InvalidArgumentException('non-nullable un_number cannot be null');
        }

        if ((mb_strlen($un_number) < 1)) {
            throw new \InvalidArgumentException('invalid length for $un_number when calling PostArticleDangerousGoodsModel., must be bigger than or equal to 1.');
        }

        $this->container['un_number'] = $un_number;

        return $this;
    }

    /**
     * Gets un_package_type
     *
     * @return string|null
     */
    public function getUnPackageType()
    {
        return $this->container['un_package_type'];
    }

    /**
     * Sets un_package_type
     *
     * @param string|null $un_package_type un_package_type
     *
     * @return self
     */
    public function setUnPackageType($un_package_type)
    {
        if (is_null($un_package_type)) {
            array_push($this->openAPINullablesSetToNull, 'un_package_type');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('un_package_type', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['un_package_type'] = $un_package_type;

        return $this;
    }

    /**
     * Gets un_label_numbers
     *
     * @return string|null
     */
    public function getUnLabelNumbers()
    {
        return $this->container['un_label_numbers'];
    }

    /**
     * Sets un_label_numbers
     *
     * @param string|null $un_label_numbers un_label_numbers
     *
     * @return self
     */
    public function setUnLabelNumbers($un_label_numbers)
    {
        if (is_null($un_label_numbers)) {
            array_push($this->openAPINullablesSetToNull, 'un_label_numbers');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('un_label_numbers', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['un_label_numbers'] = $un_label_numbers;

        return $this;
    }

    /**
     * Gets un_is_marine_hazard
     *
     * @return bool|null
     */
    public function getUnIsMarineHazard()
    {
        return $this->container['un_is_marine_hazard'];
    }

    /**
     * Sets un_is_marine_hazard
     *
     * @param bool|null $un_is_marine_hazard un_is_marine_hazard
     *
     * @return self
     */
    public function setUnIsMarineHazard($un_is_marine_hazard)
    {
        if (is_null($un_is_marine_hazard)) {
            throw new \InvalidArgumentException('non-nullable un_is_marine_hazard cannot be null');
        }
        $this->container['un_is_marine_hazard'] = $un_is_marine_hazard;

        return $this;
    }

    /**
     * Gets dangerous_goods_coefficient
     *
     * @return float|null
     */
    public function getDangerousGoodsCoefficient()
    {
        return $this->container['dangerous_goods_coefficient'];
    }

    /**
     * Sets dangerous_goods_coefficient
     *
     * @param float|null $dangerous_goods_coefficient dangerous_goods_coefficient
     *
     * @return self
     */
    public function setDangerousGoodsCoefficient($dangerous_goods_coefficient)
    {
        if (is_null($dangerous_goods_coefficient)) {
            array_push($this->openAPINullablesSetToNull, 'dangerous_goods_coefficient');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('dangerous_goods_coefficient', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['dangerous_goods_coefficient'] = $dangerous_goods_coefficient;

        return $this;
    }

    /**
     * Gets ems_code
     *
     * @return string|null
     */
    public function getEmsCode()
    {
        return $this->container['ems_code'];
    }

    /**
     * Sets ems_code
     *
     * @param string|null $ems_code ems_code
     *
     * @return self
     */
    public function setEmsCode($ems_code)
    {
        if (is_null($ems_code)) {
            array_push($this->openAPINullablesSetToNull, 'ems_code');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('ems_code', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['ems_code'] = $ems_code;

        return $this;
    }

    /**
     * Gets flash_point
     *
     * @return float|null
     */
    public function getFlashPoint()
    {
        return $this->container['flash_point'];
    }

    /**
     * Sets flash_point
     *
     * @param float|null $flash_point flash_point
     *
     * @return self
     */
    public function setFlashPoint($flash_point)
    {
        if (is_null($flash_point)) {
            array_push($this->openAPINullablesSetToNull, 'flash_point');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('flash_point', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['flash_point'] = $flash_point;

        return $this;
    }

    /**
     * Gets un_proper_shipping_names
     *
     * @return \OngoingAPI\Model\PostArticleProperShippingNameModel[]|null
     */
    public function getUnProperShippingNames()
    {
        return $this->container['un_proper_shipping_names'];
    }

    /**
     * Sets un_proper_shipping_names
     *
     * @param \OngoingAPI\Model\PostArticleProperShippingNameModel[]|null $un_proper_shipping_names un_proper_shipping_names
     *
     * @return self
     */
    public function setUnProperShippingNames($un_proper_shipping_names)
    {
        if (is_null($un_proper_shipping_names)) {
            array_push($this->openAPINullablesSetToNull, 'un_proper_shipping_names');
        } else {
            $nullablesSetToNull = $this->getOpenAPINullablesSetToNull();
            $index = array_search('un_proper_shipping_names', $nullablesSetToNull);
            if ($index !== FALSE) {
                unset($nullablesSetToNull[$index]);
                $this->setOpenAPINullablesSetToNull($nullablesSetToNull);
            }
        }
        $this->container['un_proper_shipping_names'] = $un_proper_shipping_names;

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


