<?php
/**
 * RinoBot.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 15:22
 */

declare(strict_types=1);

namespace RinoBot;

class RinoBot {

    /**
     * RinoBot 构造函数.
     */
    public function __construct()
    {
        //todo error page
        if($this->check_php_ext(3) !== true){
            foreach ($this->check_php_ext(3) as $item){
                echo $item."<br>";
            }
            exit();
        }
    }

    /**
     * 根据等级检测php扩展
     * 默认为0 几乎相当于原生PHP就可
     * level 为 1 需开启curl与redis 为响应速度提高
     * level 为 3 需手动启动守护进程 将可以实现一些自定义任务功能 当然现在可能没开发
     * @param int $level
     * @return array|bool
     */
    public function check_php_ext(int $level = 1)
    {
        $error = [];
        if($level > 1){
            if(!extension_loaded("curl")){
                $error[] = "建议开启 curl 扩展，获取更多功能";
            }
            if(!extension_loaded("redis")){
                $error[] = "建议开启 redis 扩展，当前使用predis实现于redis的缓存链接，性能低下";
            }
        }
        if($level > 2){
            if(!extension_loaded("swoole")){
                $error[] = "您当前开启最高检测等级，请安装 swoole 扩展，体验更多内容（相关区别可查看: xxx ）";
            }
        }
//        if(!extension_loaded("yaml")){
//            $error[] = "请安装 YAML 扩展";
//        }
        return (count($error) == 0)? true : $error;
    }
}