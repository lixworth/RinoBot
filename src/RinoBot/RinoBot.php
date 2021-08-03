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

    public static RinoBot $rinoBot;

    public string $config_dir;
    public string $plugin_dir;
    public string $runtime_dir;

    public $config;

    /**
     * RinoBot 构造函数.
     */
    public function __construct($config_dir,$plugin_dir,$runtime_dir)
    {
        self::$rinoBot = $this;

        //todo error page
        if($this->check_php_ext(1) !== true){
            foreach ($this->check_php_ext(3) as $item){
                echo $item."<br>";
            }
            exit();
        }

        $this->config_dir = $config_dir;
        $this->plugin_dir = $plugin_dir;
        $this->runtime_dir = $runtime_dir;

        if(!is_writable($config_dir) || !is_writable($plugin_dir) || !is_writable($runtime_dir)){
            exit("目录不可写 请给权限blblbl");
        }
        if(!file_exists($config_dir."/rino-bot.yaml")){
            //todo
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

    /**
     * @return RinoBot
     */
    public static function getRinoBot(): RinoBot
    {
        return self::$rinoBot;
    }


    public function registerPlugin()
    {

    }
}