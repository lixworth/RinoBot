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

namespace RinoBot\Protocol;


use RinoBot\Protocol\Network\MiraiBotNetWork;
use RinoBot\RinoBot;

class MiraiBotProtocolInterface implements ProtocolInterface
{
    public MiraiBotNetWork $miraiBotNetWork;
    public bool $connect = false;
    public array $config;
    private RinoBot $rinoBot;

    public function __construct($data)
    {
        $this->config = $data;
        $this->miraiBotNetWork = new MiraiBotNetWork($data["api"]);
        $this->rinoBot = RinoBot::getInstance();
        if (!$this->connect) {
            $this->connect();
        }
    }

    /**
     * @return RinoBot
     */
    public function getRinoBot(): RinoBot
    {
        return $this->rinoBot;
    }

    public function connect(): void
    {
        if (!$this->connect) {
            $verify = $this->getNetWork()->requestVerify($this->config["verify_key"]);
            if (@$verify->code !== null && $verify->code == 0) {
                if ($verify->session !== null) {
                    $bind = $this->getNetWork()->requestBind($verify->session, $this->config["qq"]);
                    if ($bind->code == 0) {
                        try {
                            $this->getRinoBot()->getRedis()->set('MiraiBot_' . $this->config["qq"], $verify->session);
                        } catch (\Exception $exception) {
                            $this->getRinoBot()->getLogger()->error("MirBot Error: session storage error");
                            $this->connect = false;
                            return;
                        }
                        $this->connect = true;
                        return;
                    }
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

    public function disconnect($message = null)
    {
        $this->connect = false;
        RinoBot::getInstance()->getLogger()->info("MirBot load failed $message");
    }

    public function getProtocolId(): int
    {
        return Protocol::MiraiBot;
    }

    public function getProtocolName() : string
    {
        return "Mirai QQ Bot";
    }

}