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


abstract class AbstractController
{
    public $request;
    public $response;

    public function __construct($request,$response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}