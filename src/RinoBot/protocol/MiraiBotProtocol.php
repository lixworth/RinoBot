<?php
/**
 * MiraiBotProtocol.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/3 21:55
 */

declare(strict_types=1);

namespace RinoBot\protocol;


use RinoBot\protocol\network\MiraiBotNetWork;

class MiraiBotProtocol implements Protocol
{
    public MiraiBotNetWork $miraiBotNetWork;

    public function __construct($data)
    {
        $this->miraiBotNetWork = new MiraiBotNetWork($data["api"]);
    }

    public function connect(): void
    {
    }

    public function getNetWork(): MiraiBotNetWork
    {
        return $this->miraiBotNetWork;
    }

    public function setBotInfo(): void
    {
        // TODO: Implement setBotInfo() method.
    }
}