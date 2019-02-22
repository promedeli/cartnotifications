<?php

namespace Promedeli\Service;

use Promedeli\Model\Config;

/**
 * Class ConfigManager
 *
 * @package \Promedeli\Service
 */
class ConfigManager
{
    /**
     * @var \ConfigurationCore
     */
    private $configurationCore;

    public function __construct($configurationCore)
    {
        $this->configurationCore = $configurationCore;
    }

    public function storeAllParams(Config $config)
    {
        $configuration = $config->getParams();

        foreach ($configuration as $key => $value) {
            $config->getStorage()->saveParam($key, $value);
        }
    }

}
