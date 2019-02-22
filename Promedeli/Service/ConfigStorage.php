<?php

namespace Promedeli\Service;

/**
 * Class ConfigStorage
 *
 * @package \Tests\Promedeli\Service
 */
abstract class ConfigStorage
{
    abstract function loadParam($key);
    abstract function saveParam($key, $value);
}
