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

namespace RinoBot\Protocol\Network;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use RinoBot\Utils\Curl;

class MiraiBotNetWork
{
//    private string $api;
    private Client $client;

    public function __construct($api)
    {
//        $this->api = $api;
        $this->client = new Client(['base_uri' => $api]);
    }
    ////////////////////////////////////// Session Part Start //////////////////////////////////////

    /**
     * 使用此方法验证你的身份，并返回一个会话
     * @param string $verifyKey
     * @throws GuzzleException
     */
    public function requestVerify(string $verifyKey): \Psr\Http\Message\ResponseInterface
    {
        return $this->client->request('POST', "/verify", [
            'json' => [
                "verifyKey" => $verifyKey
            ]
        ]);
    }

    /**
     * 使用此方法校验并激活你的Session，同时将Session与一个已登录的Bot绑定
     * @param string $session
     * @param int $qq
     * @return mixed
     */
    public function requestBind(string $session, int $qq)
    {
        $request = Curl::send_post($this->api . "/bind", json_encode([
            "sessionKey" => $session,
            "qq" => $qq,
        ]), 10, [
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
    public function requestRelease(string $session, int $qq)
    {
        $request = Curl::send_post($this->api . "/release", json_encode([
            "sessionKey" => $session,
            "qq" => $qq,
        ]), 10, [
            "Content-Type: application/json"
        ]);
        return json_decode((string)$request);
    }
    ////////////////////////////////////// Session Part End //////////////////////////////////////
}