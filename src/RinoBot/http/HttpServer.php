<?php
/**
 * HttpServer.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/26 20:35
 */

namespace RinoBot\http;

use RinoBot\RinoBot;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Swoole\Process;

class HttpServer
{
    private Server $http;

    public function __construct(string $name = "Swoole Server",string $ip = "127.0.0.1",int $port = 9502,$config = ['enable_coroutine' => true],$inside = true)
    {
        $this->http = new Server($ip,$port);
        $this->http->set($config);

        $this->http->on('start',function () use ($name,$ip,$port,$config){
            RinoBot::getInstance()->getLogger()->info("Http Server: ".$name." is started at http://".$ip.":".$port);
            RinoBot::getInstance()->getLogger()->info("Start Config: ".json_encode($config));
        });
        $this->http->on('request', function(Request $request, Response $response) use ($name,$inside){
            if($inside){
                if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
                    $response->end();
                    return;
                }
                if ($request->server['path_info'] == '/robots.txt' || $request->server['request_uri'] == '/robots.txt') {
                    $response->end(file_get_contents(PUBLIC_DIR . "robot.txt"));
                    return;
                }
            }
            SwooleRouter::dispatch($name,$request,$response);
            return;
        });

        $this->http->start();

    }


}