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

use Composer\Autoload\ClassLoader;
use RinoBot\http\HttpServer;
use RinoBot\http\SwooleRouter;
use RinoBot\plugin\PluginLoader;
use RinoBot\protocol\MiraiBotProtocol;
use RinoBot\protocol\network\MiraiBotNetWork;
use RinoBot\utils\Config;
use RinoBot\utils\Logger;
use RinoBot\utils\Runtime;
use Swoole\Http\Server;
use Swoole\Process;

/**
 * Class RinoBot
 * @package RinoBot
 */
class RinoBot
{
    private static RinoBot $instance;

    public string $config_dir;
    public string $plugin_dir;
    public string $runtime_dir;

    public $config;

    public $redis;
    public ClassLoader $loader;
    private PluginLoader $pluginLoader;
    private Logger $logger;
    private \stdClass $process;
    private \stdClass $http_server;
    /**
     * RinoBot constructor.
     * @param $config_dir
     * @param $plugin_dir
     * @param $runtime_dir
     */
    public function __construct($config_dir, $plugin_dir, $runtime_dir)
    {
        Runtime::setTime(START_TIME);
        echo "RinoBot Link Start! \n";
        self::$instance = $this;

        $this->loader = new ClassLoader(PUBLIC_DIR . "/../vendor/");
        //todo error page

        // 检测最低配置需求
        if ($this->check_php_ext(1) !== true) {
            foreach ($this->check_php_ext(3) as $item) {
                echo $item . "<br>";
            }
            exit();
        }

        $this->logger = new Logger();

        if (is_array($msg = $this->check_php_ext(2))) {
            foreach ($msg as $nmsl) {
                $this->logger->error($nmsl);
            }
        }
        $this->logger->info("RinoBot Start Booting form config");
        // 校验RinoBot运行配置
        if ($this->config = Config::parseFile($config_dir . "rino-bot.yaml")) {
            if (!Config::checkConfigStructure($config_dir . "rino-bot.yaml", ["debug", "bots" => []])) {
                exit("rino-bot.yaml 配置文件错误 请对比实例或请删除再次运行程序重新生成");
            }
        } else {
            if (!Config::generateFile($config_dir . "rino-bot.yaml", [
                "debug" => true,
                "bots" => [
                    [
                        "bot_name" => "Rumao",
                        "bot_id" => "233",
                        "bot_key" => "233"
                    ]
                ] //todo bot structure
            ])) {
                exit("rino-bot.yaml 生成错误 原因: 未知");
            }
        }

        // 注册redis
        try {
            if (class_exists('\Redis')) {

                $redis = new \Redis();
                $redis->connect('127.0.0.1', 6379);
                if ($redis->isConnected()) {
                    $this->redis = $redis;
                }

            } else {
                $predis = new \Predis\Client([
                    'scheme' => 'tcp',
                    'host' => '10.0.0.1',
                    'port' => 6379,
                ]);
                if ($predis->isConnected()) {
                    $this->redis = $predis;
                }
            }
        } catch (\Exception $exception) {

        }

        if($this->redis){
            $this->logger->success("Redis Provide is enabled,connect to tcp://127.0.0.1:6379");
        }

        $this->logger->info("Start loading plugins");

        $this->config_dir = $config_dir;
        $this->plugin_dir = $plugin_dir;
        $this->runtime_dir = $runtime_dir;
        $this->plugins = [];
        // 校验目录
        foreach ([$config_dir, $plugin_dir, $runtime_dir] as $item) {
            if (!is_dir($item)) {
                if (!@mkdir($item)) {
                    exit("$item 目录创建失败 请检查权限");
                }
            }
            if (!is_writable($item)) {
                exit("$item 目录不可写 请给目录 775 权限");
            }
        }

        $this->pluginLoader = new PluginLoader($this->loader);
        $this->pluginLoader->loadPlugins($plugin_dir); // 插件自动加载
        $this->loader->register();//composer init

        $plugins_list = null;
        foreach ($this->pluginLoader->getPlugins() as $key=>$item){
            if($plugins_list === null){
                $plugins_list = $key;
            }else{
                $plugins_list = $plugins_list.",".$key;
            }
        }
        $this->logger->success("Plugins is loaded successfully ($plugins_list)");


//        print_r($this->pluginLoader->getPlugins());
        unset($config_dir);
        unset($plugin_dir);
        unset($runtime_dir);

//        new MiraiBotProtocol([
//            "api" => "",
//            "verify_key" => "",
//            "qq" => 1
//        ]);

        SwooleRouter::get("/","RinoBot\\controller\\ApiController@index","panel");


        $this->process = new \stdClass();
        $this->http_server = new \stdClass();

//        $this->process->webhook = new Process(function (){
//            $this->http_server->webhook = new HttpServer("webhook","127.0.0.1",9501);
//        });
        $this->http_server->webhook = new HttpServer("panel","127.0.0.1",9501);

//        $this->process->panel = new Process(function (){
//            $this->http_server->panel = new HttpServer("panel","127.0.0.1",9502);
//        });

        $this->logger->success("Congratulations! RinoBot Console mode started successfully! (".Runtime::end().")");
        $this->logger->info("=================================================================");
        while (true){
            $msg = trim(fgets(STDIN));
            $this->logger->info("未知指令");
        }
    }

    /**
     * @return RinoBot
     */
    public static function getInstance(): RinoBot
    {
        return self::$instance;
    }

    public function getRedis()
    {
        if (!$this->redis->isConnected()) {
            $this->redis->connect();
        }
        return $this->redis;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
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
        if(!version_compare(phpversion(),"7.4",">=")){
            $error[] = "PHP Version must >= 7.4";
        }
        if ($level > 1) {
            if (!extension_loaded("curl")) {
                $error[] = "Please enable curl extension.";
            }
            if (!extension_loaded("redis")) {
                $error[] = "Suggest enable redis extension,default use the predis project to replace,but its performance is low";
            }
        }
        if ($level > 2) {
            if (!extension_loaded("swoole")) {
                $error[] = "Suggest enable swoole extension";
            }
        }
//        if(!extension_loaded("yaml")){
//            $error[] = "请安装 YAML 扩展";
//        }
        return (count($error) == 0) ? true : $error;
    }
}
