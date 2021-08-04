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

use Predis\Client;
use RinoBot\utils\Config;

/**
 * Class RinoBot
 * @package RinoBot
 */
class RinoBot {

    public static RinoBot $rinoBot;

    public string $config_dir;
    public string $plugin_dir;
    public string $runtime_dir;

    public $config;

    public $redis;

    public function __construct($config_dir,$plugin_dir,$runtime_dir)
    {
        self::$rinoBot = $this;

        //todo error page
        if ($this->check_php_ext(1) !== true) {
            foreach ($this->check_php_ext(3) as $item) {
                echo $item . "<br>";
            }
            exit();
        }

        $this->registerLogger();

        if ($this->check_php_ext(2)) {
            try {
                $redis = new \Redis();
                $redis->connect('127.0.0.1',6379);
                if($redis->isConnected()){
                    $this->redis = $redis;
                }
            }catch (\Exception $exception){

            }
        }else{
            $predis = new Client([
                'scheme' => 'tcp',
                'host' => '10.0.0.1',
                'port' => 6379,
            ]);
            if ($predis->isConnected()) {
                $this->redis = $predis;
            }
        }

        $this->config_dir = $config_dir;
        $this->plugin_dir = $plugin_dir;
        $this->runtime_dir = $runtime_dir;

        foreach ([$config_dir, $plugin_dir, $runtime_dir] as $item) {
            if(!is_dir($item)){
                if(!mkdir($item)){
                    exit("$item 目录创建失败 请检查权限");
                }
            }
            if(!is_writable($item)){
                exit("$item 目录不可写 请给目录 775 权限");
            }
        }

        if($this->config = Config::parseFile($config_dir . "rino-bot.yaml")){
            if(!Config::checkConfigStructure($config_dir . "rino-bot.yaml",["debug","bots" => []])){
                exit("rino-bot.yaml 配置文件错误 请对比实例或请删除再次运行程序重新生成");
            }
        }else{
            if(!Config::generateFile($config_dir . "rino-bot.yaml",[
                "debug" => true,
                "bots" => [
                    [
                        "bot_name" => "Rumao",
                        "bot_id" => "233",
                        "bot_key" => "233"
                    ]
                ] //todo bot structure
            ])){
                exit("rino-bot.yaml 生成错误 原因: 未知");
            }
        }
        $plugins = array();
        if ($pd = opendir($plugin_dir)) {
            while (($file = readdir($pd)) !== false) {
                if($file == "." || $file == ".."){
                    continue;
                }
                if (is_dir($plugin_dir . $file)) {
                    $plugins[] = $file;
                }
            }
            closedir($pd);
        }
        foreach ($plugins as $plugin){
            $this->registerPlugin($plugin);
        }

        unset($config_dir);
        unset($plugin_dir);
        unset($runtime_dir);
    }


    public function registerLogger()
    {
        //todo logger
    }

    public function registerPlugin(string $plugin):void
    {
        if(is_dir($this->plugin_dir . $plugin ."/")){
            if(Config::checkConfigStructure($this->plugin_dir . $plugin."/plugin.yml",[
                "name","main","author","version","api-version"
            ])){ //todo ...bug
                if($config = Config::parseFile($this->plugin_dir . $plugin . "/plugin.yml")){
                    print_r($config);
                }
            }else{
                exit("插件 $plugin 加载失败：plugin.yml 结构不符合");
            }
        }else{
            exit("插件 $plugin 加载失败：文件夹不存在");
        }
    }

    /**
     * @return Client
     */
    public function getPredis(): Client
    {
        if(!$this->redis->isConnected()){
            $this->redis->connect();
        }
        return $this->redis;
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
}
