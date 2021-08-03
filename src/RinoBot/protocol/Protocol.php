<?php
/**
 * Protocol.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 18:48
 */

declare(strict_types=1);

namespace RinoBot\protocol;

use RinoBot\protocol\network\NetWork;

/**
 * Interface Protocol
 * @package RinoBot\protocol
 *
 * 协议
 */
interface Protocol
{
    public function __construct($data);

    public function connect(): void;

    public function getNetWork();

    public function setBotInfo(): void;
}