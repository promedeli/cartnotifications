<?php
namespace Promedeli\Service;

use Promedeli\Model\Config;

class FrontendResourceManager
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function addCSS($name)
    {
        if ($this->config->getPrestashopMinorVersion() < 7) {
            $this->config->getContext()->controller->addCSS('modules/views/css/'.$name.'.css', 'all');
        } else {
            $this->config->getContext()->controller->registerStylesheet($name, 'modules/' . $name . '/views/css/'.$name.'.css', ['media' => 'all', 'priority' => 150]);
        }

        return $this;
    }

    public function addJS($name)
    {
        if ($this->config->getPrestashopMinorVersion() < 7) {
            $this->config->getContext()->controller->addJS('modules/views/js/'.$name.'.js', 'all');
        } else {
            $this->config->getContext()->controller->registerJavascript($name, 'modules/' . $name . '/views/js/'.$name.'.js', ['media' => 'all', 'priority' => 150]);
        }

        return $this;
    }


}
