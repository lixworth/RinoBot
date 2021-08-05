<?php
/**
 * Cattery Mc
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Cattery Team
 */

namespace RinoBot\plugin;


use Composer\Autoload\ClassLoader;
use RinoBot\Singleton;
use RinoBot\utils\Config;
use RinoBot\utils\Logger;

class PluginLoader extends Singleton
{
    private ClassLoader $loader;
    private array $plugins;

    public function __construct(ClassLoader $loader)
    {
        parent::__construct();
        $this->loader = $loader;
    }

    public function getPlugin(string $plugin): ?object
    {
        return $this->plugins[$plugin] ?? null;
    }

    public function getPlugins():array{
        return $this->plugins;
    }

    public function loadPlugins(string $plugin_directory): void
    {
        // 读取并注册插件
        $plugin_list = [];
        if ($pd = opendir($plugin_directory)) {
            while (($file = readdir($pd)) !== false) {
                if ($file == "." || $file == "..") {
                    continue;
                }
                if (is_dir($plugin_directory . $file)) {
                    $plugin_list[] = $file;
                }
            }
            closedir($pd);
        }


        foreach ($plugin_list as $key => $plugin) {
            if ($this->verifyPlugin($plugin_directory, $plugin)) {
                $this->registerPlugin($plugin_directory, $plugin);
            }
        }
        unset($plugin_list);
    }

    public function registerPlugin(string $plugin_directory, string $plugin): void
    {
        if ($config = Config::parseFile($plugin_directory . $plugin . "/plugin.yml")) {
            $this->loader->addPsr4("", $plugin_directory . $plugin . "/src");
            $this->loader->register();
            $this->plugins[$plugin] = new $config["main"];
            unset($config);
        } else {
            exit("插件 $plugin 加载失败：plugin.yml 读取失败");
        }
    }

    public function verifyPlugin(string $plugin_directory, string $plugin): bool
    {
        if (!is_dir($plugin_directory . $plugin . "/")) {
            Logger::getInstance()->error("插件 $plugin 加载失败：文件夹不存在");
            return false;
        }
        if (!Config::checkConfigStructure($plugin_directory . $plugin . "/plugin.yml", [
            "name", "main", "author", "version", "api-version"
        ])) {
            Logger::getInstance()->error("插件 $plugin 加载失败：plugin.yml 结构不符合");
            return false;
        }
        return true;
    }
}