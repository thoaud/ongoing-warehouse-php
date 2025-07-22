<?php

namespace OngoingAPI\Tests;

use PHPUnit\Framework\TestCase;
use OngoingAPI\Configuration;

class ConfigurationTest extends TestCase
{
    private Configuration $config;

    protected function setUp(): void
    {
        $this->config = new Configuration();
    }

    public function testDefaultConfiguration(): void
    {
        $this->assertInstanceOf(Configuration::class, $this->config);
        $this->assertEquals('https://api.ongoingsystems.se/Directhouse', $this->config->getHost());
        $this->assertEmpty($this->config->getUsername());
        $this->assertEmpty($this->config->getPassword());
        $this->assertFalse($this->config->getDebug());
    }

    public function testSetAndGetHost(): void
    {
        $host = 'https://api.ongoingsystems.se/test-warehouse';
        $this->config->setHost($host);
        $this->assertEquals($host, $this->config->getHost());
    }

    public function testSetAndGetUsername(): void
    {
        $username = 'test-user';
        $this->config->setUsername($username);
        $this->assertEquals($username, $this->config->getUsername());
    }

    public function testSetAndGetPassword(): void
    {
        $password = 'test-password';
        $this->config->setPassword($password);
        $this->assertEquals($password, $this->config->getPassword());
    }

    public function testSetAndGetDebug(): void
    {
        $this->config->setDebug(true);
        $this->assertTrue($this->config->getDebug());

        $this->config->setDebug(false);
        $this->assertFalse($this->config->getDebug());
    }

    public function testSetAndGetDebugFile(): void
    {
        $debugFile = '/tmp/debug.log';
        $this->config->setDebugFile($debugFile);
        $this->assertEquals($debugFile, $this->config->getDebugFile());
    }

    public function testSetAndGetUserAgent(): void
    {
        $userAgent = 'Custom User Agent';
        $this->config->setUserAgent($userAgent);
        $this->assertEquals($userAgent, $this->config->getUserAgent());
    }

    public function testGetDefaultConfiguration(): void
    {
        $defaultConfig = Configuration::getDefaultConfiguration();
        $this->assertInstanceOf(Configuration::class, $defaultConfig);
    }

    public function testSetDefaultConfiguration(): void
    {
        $newConfig = new Configuration();
        $newConfig->setHost('https://api.ongoingsystems.se/custom');
        
        Configuration::setDefaultConfiguration($newConfig);
        $defaultConfig = Configuration::getDefaultConfiguration();
        
        $this->assertEquals('https://api.ongoingsystems.se/custom', $defaultConfig->getHost());
    }

    public function testBooleanFormatForQueryString(): void
    {
        $this->config->setBooleanFormatForQueryString(Configuration::BOOLEAN_FORMAT_STRING);
        $this->assertEquals(Configuration::BOOLEAN_FORMAT_STRING, $this->config->getBooleanFormatForQueryString());

        $this->config->setBooleanFormatForQueryString(Configuration::BOOLEAN_FORMAT_INT);
        $this->assertEquals(Configuration::BOOLEAN_FORMAT_INT, $this->config->getBooleanFormatForQueryString());
    }

    public function testApiKeyManagement(): void
    {
        $apiKey = 'test-api-key';
        $this->config->setApiKey('test-key', $apiKey);
        $this->assertEquals($apiKey, $this->config->getApiKey('test-key'));
    }

    public function testApiKeyPrefixManagement(): void
    {
        $prefix = 'Bearer';
        $this->config->setApiKeyPrefix('test-key', $prefix);
        $this->assertEquals($prefix, $this->config->getApiKeyPrefix('test-key'));
    }

    public function testAccessTokenManagement(): void
    {
        $token = 'test-access-token';
        $this->config->setAccessToken($token);
        $this->assertEquals($token, $this->config->getAccessToken());
    }

    public function testTempFolderPath(): void
    {
        $tempPath = '/tmp/ongoing-api';
        $this->config->setTempFolderPath($tempPath);
        $this->assertEquals($tempPath, $this->config->getTempFolderPath());
    }
} 