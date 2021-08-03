<?php
/**
 * MiraiBotNetWork.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/3 21:15
 */

declare(strict_types=1);

namespace RinoBot\protocol\network;


use RinoBot\utils\Curl;

class MiraiBotNetWork
{
    private string $api;

    public function __construct($api)
    {
        $this->api = $api;
    }
    ////////////////////////////////////// Session Part Start //////////////////////////////////////
    /**
     * 使用此方法验证你的身份，并返回一个会话
     * @param string $verifyKey
     * @return mixed
     */
    public function requestVerify(string $verifyKey)
    {
        $request = Curl::send_post($this->api."/verify",json_encode([
            "verifyKey" => $verifyKey
        ]),10,[
            "Content-Type: application/json"
        ]);
        return json_decode((string)$request);
    }

    /**
     * 使用此方法校验并激活你的Session，同时将Session与一个已登录的Bot绑定
     * @param string $session
     * @param int $qq
     * @return mixed
     */
    public function requestBind(string $session,int $qq)
    {
        $request = Curl::send_post($this->api."/bind",json_encode([
            "sessionKey" => $session,
            "qq" => $qq,
        ]),10,[
            "Content-Type: application/json"
        ]);
        return json_decode((string)$request);
    }

    /**
     * 使用此方式释放session及其相关资源
     * @param string $session
     * @param int $qq
     * @return mixed
     */
    public function requestRelease(string $session,int $qq)
    {
        $request = Curl::send_post($this->api."/release",json_encode([
            "sessionKey" => $session,
            "qq" => $qq,
        ]),10,[
            "Content-Type: application/json"
        ]);
        return json_decode((string)$request);
    }
    ////////////////////////////////////// Session Part End //////////////////////////////////////
}