<?php
/**
 * ExamplePlugin.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 19:30
 */

declare(strict_types=1);

namespace ExamplePlugin;

use RinoBot\plugin\PluginBase;

class PluginMain extends PluginBase
{
    public function onEnable()
    {
//        fwrite(STDOUT, "第一个插件运行咯");
    }


    /**
     * 注册指令
     * 这里指令相当于完整匹配关键词
     * @return string[]
     */
    public function registerCommand(): array
    {
        return [
            "你好啊" => Closure::fromCallable("static::hello")
        ];
    }

    public static function hello()
    {

    }
}
