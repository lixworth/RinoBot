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
use RinoBot\utils\Logger;

class MiraiBotProtocol implements Protocol
{
    public MiraiBotNetWork $miraiBotNetWork;
    public bool $connect = false;
    public array $config;

    public function __construct($data)
    {
        $this->config = $data;
        $this->miraiBotNetWork = new MiraiBotNetWork($data["api"]);

        if(!$this->connect){
            $this->connect();
        }
    }

    public function connect(): void
    {
        if(!$this->connect){
            $verify = $this->getNetWork()->requestVerify($this->config["verify_key"]);
            if($verify->code == 0){
                $bind = $this->getNetWork()->requestBind($verify->session,$this->config["qq"]);
                if($bind->code == 0){
                    $this->connect = true;
                    return;
                }
            }
        }
        $this->disconnect();
    }

    public function getNetWork(): MiraiBotNetWork
    {
        return $this->miraiBotNetWork;
    }

    public function setBotInfo(): void
    {
        // TODO: Implement setBotInfo() method.
    }

    public function disconnect()
    {
        $this->connect = false;
//        Logger::getInstance()->info("加载失败");
    }
}