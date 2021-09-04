<?php
/**
 * AbstractController.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/26 21:33
 */

namespace RinoBot\Controller;


use Swoole\Http\Request;
use Swoole\Http\Response;

abstract class AbstractController
{
    /**
     * @var Request
     */
    public $request;
    /**
     * @var Response
     */
    public $response;

    public function __construct($request,$response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}