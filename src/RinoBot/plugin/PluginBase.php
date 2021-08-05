<?php
/**
 * PluginBase.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 18:43
 */
declare(strict_types=1);

namespace RinoBot\plugin;


abstract class PluginBase
{
    public function __construct()
    {
        $this->onEnable();
    }

    protected function onEnable()
    {

    }
}
