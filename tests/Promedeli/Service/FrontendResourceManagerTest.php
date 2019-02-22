<?php

use PHPUnit\Framework\TestCase;
use Promedeli\Model\Config;
use Promedeli\Service\FrontendResourceManager;

class FrontendResourceManagerTest extends TestCase
{
    private $frontendResourceManager;
    private $context;
    private $config;

    public function setUp(): void
    {
        $this->config = new Config('testmodule');
        $this->config->setPrestashopVersion(_PS_VERSION_);
        $this->config->setContext(Context::getContext());
        $this->config->getContext()->controller = $this->createMock(FrontController::class);

        $this->frontendResourceManager = new FrontendResourceManager($this->config);
    }

    public function testAddCSS()
    {
        $expects = $this->config->getContext()->controller->expects($this->once());
        if($this->config->getPrestashopMinorVersion() >= 7) {
            $expects->method('registerStylesheet');
        } else {
            $expects->method('addCSS');
        }

        $this->frontendResourceManager->addCSS('testfile');
    }

    public function testAddJS()
    {
        $expects = $this->config->getContext()->controller->expects($this->once());
        if($this->config->getPrestashopMinorVersion() >= 7) {
            $expects->method('registerJavascript');
        } else {
            $expects->method('addJS');
        }

        $this->frontendResourceManager->addJS('testfile');
    }

}
