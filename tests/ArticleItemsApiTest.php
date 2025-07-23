<?php

use PHPUnit\Framework\TestCase;
use OngoingAPI\Api\ArticleItemsApi;
use OngoingAPI\Configuration;
use OngoingAPI\Model\GetArticleItemsModel;
use OngoingAPI\Model\GetArticleItemInfo;

class ArticleItemsApiTest extends TestCase
{
    public function setUp(): void
    {
        $this->config = $this->createMock(Configuration::class);
        $this->api = $this->getMockBuilder(ArticleItemsApi::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['articleItemsGetArticleItemsModelWithHttpInfo'])
            ->getMock();
    }

    public function testGetArticleItemsModelReturnsModel()
    {
        $mockModel = new GetArticleItemsModel([
            'article_system_id' => 1,
            'article_number' => 'ABC123',
            'items' => [
                new GetArticleItemInfo([
                    'article_item_id' => 42,
                    'batch' => 'BATCH1',
                    'serial' => 'SERIAL1',
                    'number_of_items' => 10.0,
                ])
            ],
            'goods_owner' => null
        ]);
        $this->api->expects($this->once())
            ->method('articleItemsGetArticleItemsModelWithHttpInfo')
            ->willReturn([$mockModel, 200, []]);
        $result = $this->api->articleItemsGetArticleItemsModel(123);
        $this->assertInstanceOf(GetArticleItemsModel::class, $result);
        $this->assertEquals(1, $result->getArticleSystemId());
        $this->assertEquals('ABC123', $result->getArticleNumber());
        $this->assertIsArray($result->getArticleItems());
        $this->assertInstanceOf(GetArticleItemInfo::class, $result->getArticleItems()[0]);
        $this->assertEquals(42, $result->getArticleItems()[0]->getArticleItemId());
    }

    public function testGetArticleItemsModelEmptyResponse()
    {
        $mockModel = new GetArticleItemsModel([
            'article_system_id' => 2,
            'article_number' => 'EMPTY',
            'items' => [],
            'goods_owner' => null
        ]);
        $this->api->expects($this->once())
            ->method('articleItemsGetArticleItemsModelWithHttpInfo')
            ->willReturn([$mockModel, 200, []]);
        $result = $this->api->articleItemsGetArticleItemsModel(123);
        $this->assertIsArray($result->getArticleItems());
        $this->assertCount(0, $result->getArticleItems());
    }

    public function testGetArticleItemsModelMissingFields()
    {
        $mockModel = new GetArticleItemsModel([
            // 'article_system_id' is missing
            'article_number' => null,
            'items' => null,
            'goods_owner' => null
        ]);
        $this->api->expects($this->once())
            ->method('articleItemsGetArticleItemsModelWithHttpInfo')
            ->willReturn([$mockModel, 200, []]);
        $result = $this->api->articleItemsGetArticleItemsModel(123);
        $this->assertNull($result->getArticleSystemId());
        $this->assertNull($result->getArticleNumber());
        $this->assertNull($result->getArticleItems());
    }
} 