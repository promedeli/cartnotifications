<?php

namespace Promedeli\Model;

use Exception;
use Promedeli\Service\ConfigStorage;

/**
 * Class Config
 *
 * @package \Promedeli\Model
 */
class Config
{
    private $moduleName;
    private $prestashopVersion;
    private $context;
    private $params;

    /**
     * @var \Promedeli\Service\ConfigStorage
     */
    private $storage;

    /**
     * Config constructor.
     *
     * @param $moduleName
     */
    public function __construct($moduleName)
    {
        $this->moduleName = $moduleName;
        $this->params = [];
    }


    public function getPSVersion()
    {
        return $this->prestashopVersion;
    }

    public function getModuleName()
    {
        return $this->moduleName;
    }

    public function getPrestashopMinorVersion()
    {
        return (int)explode('.', $this->getPSVersion())[1];
    }

    /**
     * @param mixed $prestashopVersion
     */
    public function setPrestashopVersion($prestashopVersion)
    {
        $this->prestashopVersion = $prestashopVersion;
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param mixed $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param mixed $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParam($key)
    {
        if ($this->storage) {
            $this->params[$key] = $this->storage->loadParam($key);
        }

        if (!isset($this->params[$key])) {
            throw new Exception('Param not found');
        }

        return $this->params[$key];
    }

    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        return $this->getParam($name);
    }

    public function __set($name, $value)
    {
        $this->setParam($name, $value);
    }

    public function setStorage(ConfigStorage $storage): void
    {
        $this->storage = $storage;
    }


    public function getStorage(): ConfigStorage
    {
        return $this->storage;
    }



}
