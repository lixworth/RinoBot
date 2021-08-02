<?php
/**
 * QQProtocol.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 18:50
 */

declare(strict_types=1);
namespace RinoBot\protocol;

use RinoBot\protocol\network\NetWork;
use RinoBot\protocol\network\QQNetWork;

class QQProtocol implements \RinoBot\protocol\Protocol{
    public QQNetWork $netWork;

    public function __construct()
    {
        $this->netWork = new QQNetWork();
    }

    public function connect(): void
    {

    }

    public function getNetWork(): QQNetWork
    {
        return $this->netWork;
    }

    public function setBotInfo(): void
    {
        // TODO: Implement setBotInfo() method.
    }
}