<?php
/**
 * AbstractController.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/26 21:33
 */

namespace RinoBot\controller;


abstract class AbstractController
{
    public \Illuminate\Http\Request $request;

    public function __construct(\Swoole\Http\Request $request)
    {
        foreach (["get","post","cookie","files","server"] as $key => $item){
          if($request->$item == null){
              $request->$item = [];
          }
        }
        $this->request = new \Illuminate\Http\Request($request->get,$request->post,[],$request->cookie,$request->files,$request->server);

    }
}