<?php
declare(strict_types=1);
namespace RinoBot\protocol;

use RinoBot\protocol\network\NetWork;
use RinoBot\protocol\network\TelegramNetWork;

class TelegramProtocol implements \RinoBot\protocol\Protocol{
    public TelegramNetWork $netWork;

    public function __construct()
    {
        $this->netWork = new TelegramNetWork();
    }

    public function connect(): void
    {

    }

    public function getNetWork(): TelegramNetWork
    {
        return $this->netWork;
    }

    public function setBotInfo(): void
    {
        // TODO: Implement setBotInfo() method.
    }
}