<?php
/**
 * bootstrap.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 15:18
 */

declare(strict_types=1);

if(file_exists(__DIR__."/vendor/autoload.php")){
    require_once __DIR__ . "/vendor/autoload.php";
}else {
    // 自动加载
    spl_autoload_register(function ($class) {
        if (file_exists(SOURCE_DIR . $class . ".php")) {
            include_once SOURCE_DIR . $class . ".php";
        }
    });
}

// 实例化 RinoBot
$app = new \RinoBot\RinoBot(CONFIG_DIR,PLUGIN_DIE,RUNTIME_DIE);