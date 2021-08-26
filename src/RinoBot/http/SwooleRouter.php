<?php
/**
 * SwooleRouter.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/26 20:42
 */

namespace RinoBot\http;

use RinoBot\Singleton;
use Swoole\Http\Request;
use Swoole\Http\Response;

class SwooleRouter extends Singleton implements RouterInterface
{
    private static array $callbacks;

    /**
     * @return array
     */
    public static function getCallbacks(): array
    {
        return self::$callbacks;
    }

    public static function get($router,$target,$name = null)
    {
        self::$callbacks[$name][$router] = [
            "method" => "GET",
            "target" => $target
        ];
    }

    public static function post($router,$target,$name = null)
    {
        self::$callbacks[$name][$router] = [
            "method" => "POST",
            "target" => $target
        ];
    }

    public static function dispatch(string $name,Request $request, Response $response)
    {
        if($callback = self::$callbacks[$name][$request->server["request_uri"]]){
            if($callback["method"] == $request->server["request_method"]){
                $target = explode("@",$callback["target"]);
                $action = $target[1];
                (new $target[0]($request))->$action($response);
                return;
            }
        }
        $response->end("404");
    }
}