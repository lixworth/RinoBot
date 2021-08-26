<?php
/**
 * ApiController.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/26 21:32
 */

namespace RinoBot\controller;

use Swoole\Http\Response;

class ApiController extends AbstractController
{
    public function index(Response $response)
    {
        return $response->end(json_encode($this->request->all()));
    }
}