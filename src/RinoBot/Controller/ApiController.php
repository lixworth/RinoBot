<?php
/**
 * ApiController.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/26 21:32
 */

namespace RinoBot\Controller;

class ApiController extends AbstractController
{
    public function index()
    {
        return $this->response->end(json_encode($this->request));
    }
}