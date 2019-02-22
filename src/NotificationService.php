<?php

namespace Cartnotifications;

use Promedeli\Model\Config;

/**
 * Class NotificationService
 *
 * @package \Cartnotifications
 */
class NotificationService
{
    /**
     * @var \Cartnotifications\Config
     */
    private $config;

    private $commands;

    private $shouldBeDisplayed = true;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function parseMessage()
    {
        /*
         * Search for commands (pattern: {command: param}
         */
        preg_match_all('/.*\{(.*)\}.*/U', $this->config->text, $commands);

        $this->commands = $commands[1];
        $message = $this->config->text;

        foreach ($this->commands as $commandWithParam) {
            $cmd = array_map('trim', explode(':', $commandWithParam));

            $command = $cmd[0];
            $commandParam = $cmd[1];

            $parsed = '';
            switch ($command) {
                case 'leftTo':
                    $parsed = $this->executeLeftTo($commandParam);
                    break;
                case "leftToDate":
                    $parsed = $this->executeLeftTo($commandParam);
                    break;
            }

            $message = preg_replace('/{' . $command . '\:.*}/U', $parsed, $message);
        }

        return $message;
    }

    public function executeLeftTo($commandParam)
    {
        $diff = $commandParam - $this->config->getContext()->cart->getOrderTotal();
        if ($diff <= 0) {
            $this->shouldBeDisplayed = false;
        }

        return round($diff, 2);
    }

    public function executeLeftToDate($commandParam)
    {
        $time1 = strtotime($commandParam);
        $time2 = strtotime('now');

        $diffMins = ($time1 - $time2) / 60;

        if ($diffMins <= 0) {
            $this->shouldBeDisplayed = false;
        }

        if ($diffMins > 60) {
            return ceil($diffMins / 60) . ' ' .$this->config->hours_word;
        } else {
            return ceil($diffMins) . ' ' . $this->config->minutes_word;
        }
    }

    /**
     * @return bool
     */
    public function shouldBeDisplayed(): bool
    {
        return $this->shouldBeDisplayed;
    }

}
