<?php

namespace Tests\Promedeli\Model;

use AppKernel;
use PHPUnit\Framework\TestCase;
use Promedeli\Model\Config;
use Promedeli\Service\ConfigStorage;


class ConfigTest extends TestCase
{
    public function testGetPSVersion()
    {
        $config = new Config('testmodule');
        $config->setPrestashopVersion('1.7.5');
        $this->assertSame('1.7.5', $config->getPSVersion());
    }

    public function testGetModuleName()
    {
        $config = new Config('testmodule', '1.7.5');
        $this->assertSame('testmodule', $config->getModuleName());
    }

    public function testGetMinorVersion()
    {
        $config = new Config('testmodule');
        $config->setPrestashopVersion('1.7.5');
        $this->assertSame(7, $config->getPrestashopMinorVersion());
    }

    public function testSetParams()
    {
        $config = new Config('testmodule');
        $config->setParams(['testKey' => 'testValue']);

        $this->assertSame('testValue', $config->testKey);
    }

    public function testSetAndGetParam()
    {
        $config = new Config('testmodule');

        $config->setParam('testKey', 'testValue');
        $this->assertSame('testValue', $config->getParam('testKey'));
    }

    public function testGetWithStorageEnabled()
    {
        $config = new Config('testmodule');

        $storage = $this->createMock(ConfigStorage::class);
        $storage->expects($this->once())->method('loadParam');

        $config->setStorage($storage);
        try {
            $value = $config->getParam('key');
        } catch (\Exception $e) {

        }
    }


}
