<?php
declare(strict_types=1);

namespace RinoBot\Protocol;

use RinoBot\Protocol\Network\NetWork;
use RinoBot\Protocol\Network\TelegramNetWork;

class TelegramProtocol implements \RinoBot\Protocol\Protocol
{
    public TelegramNetWork $telegramNetWork;

    public bool $is_connected;

    public function __construct($data)
    {
        $this->telegramNetWork = new TelegramNetWork();
    }

    /*
     * Telegram 协议不需要临时参数或者其他连接
     */
    public function connect(): void
    {
        $this->is_connected = true;
    }


    public function getNetWork(): TelegramNetWork
    {
        return $this->telegramNetWork;
    }

    public function setBotInfo(): void
    {
        // TODO: Implement setBotInfo() method.
    }
}
