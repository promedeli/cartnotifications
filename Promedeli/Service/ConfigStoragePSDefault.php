<?php

namespace Promedeli\Service;

/**
 * Class ConfigStoragePSDefault
 *
 * @package \Tests\Promedeli\Service
 */
class ConfigStoragePSDefault extends ConfigStorage
{
    /**
     * @var \Configuration
     */
    private $configurationCore;
    /**
     * @var string
     */
    private $prefix;

    public function __construct($configurationCore, $prefix = 'null')
    {
        $this->configurationCore = $configurationCore;
        $this->prefix = $prefix;
    }

    function loadParam($key)
    {
        return $this->configurationCore::get($this->prefix . '_' .$key);
    }

    function saveParam($key, $value)
    {
        return $this->configurationCore::updateValue($this->prefix . '_' . $key, $value);
    }
}
