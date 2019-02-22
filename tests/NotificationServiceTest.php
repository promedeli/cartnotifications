<?php

namespace Tests;

use Cart;
use Cartnotifications\NotificationService;
use Context;
use PHPUnit\Framework\TestCase;
use Promedeli\Model\Config;

/**
 * Class NotificationServiceTest
 *
 * @package \Tests
 */
class NotificationServiceTest extends TestCase
{

    private $config;

    public function setUp(): void
    {
        $this->config = new Config('testmodule');
        $this->config->setPrestashopVersion(_PS_VERSION_);
        $this->config->setContext(Context::getContext());
        $this->config->getContext()->cart = $this->createMock(Cart::class);
    }

    public function testExecuteLeftTo()
    {
        $ns = new NotificationService($this->config);
        $leftToAmount = $ns->executeLeftTo(250);
        $this->assertSame(250.0, $leftToAmount);
    }

    public function testExecuteLeftToDate()
    {
        $ns = new NotificationService($this->config);
        $this->config->hours_word = 'hours';
        $this->config->minutes_word = 'minutes';
        $date = '2029-01-01';
        $leftToDateText = $ns->executeLeftToDate('2029-01-01');

        $time1 = strtotime($date);
        $time2 = strtotime('now');

        $diffMins = ($time1 - $time2) / 60;

        if ($diffMins > 60) {
            $ret = ceil($diffMins / 60) . ' hours';
        } else {
            $ret = ceil($diffMins) . ' minutes';
        }

        $this->assertSame($ret, $leftToDateText);
    }

}
