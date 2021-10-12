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

namespace RinoBot\Protocol;

use RinoBot\Protocol\Network\NetWork;

/**
 * Interface Protocol
 * @package RinoBot\Protocol
 *
 * 协议
 */
interface ProtocolInterface
{
    public function __construct($data);

    public function connect(): void;

    public function getNetWork();

    public function setBotInfo(): void;

    public function getProtocolId() : int;

    public function getProtocolName() : string;
}