<?php
/**
 * HeaderSelector
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

namespace OngoingAPI;

/**
 * HeaderSelector Class Doc Comment
 *
 * @category Class
 * @package  OpenAPI\Client
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */
class HeaderSelector
{
    /**
     * @param string[] $accept
     * @param string   $contentType
     * @param bool     $isMultipart
     * @return string[]
     */
    public function selectHeaders(array $accept, string $contentType, bool $isMultipart): array
    {
        $headers = [];

        $accept = $this->selectAcceptHeader($accept);
        if ($accept !== null) {
            $headers['Accept'] = $accept;
        }

        if (!$isMultipart) {
            if($contentType === '') {
                $contentType = 'application/json';
            }

            $headers['Content-Type'] = $contentType;
        }

        return $headers;
    }

    /**
     * Return the header 'Accept' based on an array of Accept provided.
     *
     * @param string[] $accept Array of header
     *
     * @return null|string Accept (e.g. application/json)
     */
    private function selectAcceptHeader(array $accept): ?string
    {
        # filter out empty entries
        $accept = array_filter($accept);

        if (count($accept) === 0) {
            return null;
        }

        # If there's only one Accept header, just use it
        if (count($accept) === 1) {
            return reset($accept);
        }

        # If none of the available Accept headers is of type "json", then just use all them
        $headersWithJson = preg_grep('~(?i)^(application/json|[^;/ \t]+/[^;/ \t]+[+]json)[ \t]*(;.*)?$~', $accept);
        if (count($headersWithJson) === 0) {
            return implode(',', $accept);
        }

        # If we got here, then we need add quality values (weight), as described in IETF RFC 9110, Items 12.4.2/12.5.1,
        # to give the highest priority to json-like headers - recalculating the existing ones, if needed
        return $this->getAcceptHeaderWithAdjustedWeight($accept, $headersWithJson);
    }

    /**
    * Create an Accept header string from the given "Accept" headers array, recalculating all weights
    *
    * @param string[] $accept            Array of Accept Headers
    * @param string[] $headersWithJson   Array of Accept Headers of type "json"
    *
    * @return string "Accept" Header (e.g. "application/json, text/html; q=0.9")
    */
    private function getAcceptHeaderWithAdjustedWeight(array $accept, array $headersWithJson): string
    {
        $processedHeaders = [
            'withApplicationJson' => [],
            'withJson' => [],
            'withoutJson' => [],
        ];

        foreach ($accept as $header) {

            $headerData = $this->getHeaderAndWeight($header);

            if (stripos($headerData['header'], 'application/json') === 0) {
                $processedHeaders['withApplicationJson'][] = $headerData;
            } elseif (in_array($header, $headersWithJson, true)) {
                $processedHeaders['withJson'][] = $headerData;
            } else {
                $processedHeaders['withoutJson'][] = $headerData;
            }
        }

        $acceptHeaders = [];
        $currentWeight = 1000;

        $hasMoreThan28Headers = count($accept) > 28;

        foreach($processedHeaders as $headers) {
            if (count($headers) > 0) {
                $acceptHeaders[] = $this->adjustWeight($headers, $currentWeight, $hasMoreThan28Headers);
            }
        }

        $acceptHeaders = array_merge(...$acceptHeaders);

        return implode(',', $acceptHeaders);
    }

    /**
     * Given an Accept header, returns an associative array splitting the header and its weight
     *
     * @param string $header "Accept" Header
     *
     * @return array with the header and its weight
     */
    private function getHeaderAndWeight(string $header): array
    {
        # matches headers with weight, splitting the header and the weight in $outputArray
        if (preg_match('/(.*);\s*q=(1(?:\.0+)?|0\.\d+)$/', $header, $outputArray) === 1) {
            $headerData = [
                'header' => $outputArray[1],
                'weight' => (int)($outputArray[2] * 1000),
            ];
        } else {
            $headerData = [
                'header' => trim($header),
                'weight' => 1000,
            ];
        }

        return $headerData;
    }

    /**
     * @param array[] $headers
     * @param float   $currentWeight
     * @param bool    $hasMoreThan28Headers
     * @return string[] array of adjusted "Accept" headers
     */
    private function adjustWeight(array $headers, float &$currentWeight, bool $hasMoreThan28Headers): array
    {
        usort($headers, function (array $a, array $b) {
            return $b['weight'] - $a['weight'];
        });

        $acceptHeaders = [];
        foreach ($headers as $index => $header) {
            if($index > 0 && $headers[$index - 1]['weight'] > $header['weight'])
            {
                $currentWeight = $this->getNextWeight($currentWeight, $hasMoreThan28Headers);
            }

            $weight = $currentWeight;

            $acceptHeaders[] = $this->buildAcceptHeader($header['header'], $weight);
        }

        $currentWeight = $this->getNextWeight($currentWeight, $hasMoreThan28Headers);

        return $acceptHeaders;
    }

    /**
     * @param string $header
     * @param int    $weight
     * @return string
     */
    private function buildAcceptHeader(string $header, int $weight): string
    {
        if($weight === 1000) {
            return $header;
        }

        return trim($header, '; ') . ';q=' . rtrim(sprintf('%0.3f', $weight / 1000), '0');
    }

    /**
     * Calculate the next weight, based on the current one.
     *
     * If there are less than 28 "Accept" headers, the weights will be decreased by 1 on its highest significant digit, using the
     * following formula:
     *
     *    next weight = current weight - 10 ^ (floor(log(current weight - 1)))
     *
     *    ( current weight minus ( 10 raised to the power of ( floor of (log to the base 10 of ( current weight minus 1 ) ) ) ) )
     *
     * Starting from 1000, this generates the following series:
     *
     * 1000, 900, 800, 700, 600, 500, 400, 300, 200, 100, 90, 80, 70, 60, 50, 40, 30, 20, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1
     *
     * The resulting quality codes are closer to the average "normal" usage of them (like "q=0.9", "q=0.8" and so on), but it only works
     * if there is a maximum of 28 "Accept" headers. If we have more than that (which is extremely unlikely), then we fall back to a 1-by-1
     * decrement rule, which will result in quality codes like "q=0.999", "q=0.998" etc.
     *
     * @param int  $currentWeight varying from 1 to 1000 (will be divided by 1000 to build the quality value)
     * @param bool $hasMoreThan28Headers
     * @return int
     */
    public function getNextWeight(int $currentWeight, bool $hasMoreThan28Headers): int
    {
        if ($currentWeight <= 1) {
            return 1;
        }

        if ($hasMoreThan28Headers) {
            return $currentWeight - 1;
        }

        return $currentWeight - 10 ** floor( log10($currentWeight - 1) );
    }
}
