<?php
/**
 * RinoBot
 *
 */

declare(strict_types=1);

define("START_TIME", microtime());

// 定义全局变量
const PUBLIC_DIR = __DIR__ . "/";
const SOURCE_DIR = __DIR__ . "/../src/";
const CONFIG_DIR = __DIR__ . "/../config/";
const RUNTIME_DIE = __DIR__ . "/../runtime/";
const PLUGIN_DIE = __DIR__ . "/../plugins/";

// 引入引导程序
require_once PUBLIC_DIR . "/../bootstrap.php";