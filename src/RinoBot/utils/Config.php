<?php
/**
 * Config.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 15:43
 */

declare(strict_types=1);

namespace RinoBot\utils;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Config
 * @package RinoBot\utils
 * 配置管理 yaml
 *
 * 使用 symfony 处理 YAML 文件
 * 参考：https://symfony.com/doc/current/components/yaml.html
 */
class Config
{
    /**
     * 从文件解析配置
     * @param $file
     * @return false | array
     */
    public static function parseFile($file)
    {
        if (file_exists($file)) {
            $data = Yaml::parseFile($file);
            if (!is_array($data)) {
                return false;
            }
            return (array)$data;
        } else {
            return false;
        }
    }

    /**
     * 生成配置文件
     * @param string $file
     * @param array $config
     * @return bool
     */
    public static function generateFile(string $file, array $config)
    {
        if (file_exists($file)) {
            return false;
        } else {
            file_put_contents($file, Yaml::dump($config));
            return true;
        }
    }

    /**
     * 检测配置文件的结构是否相同 (没测试是否工作 (
     * @param $file
     * @param $config_structure
     * @return bool
     *
     * Example:
     *  Yaml File:
     *      name: xxx
     *      database:
     *          enable: true
     *          content: demo
     *  PHP Check:
     *      Config::checkConfigStructure(Yaml File,["name","database" => ["enable","content"] ])
     */
    public static function checkConfigStructure($file, $config_structure): bool
    {
        if ($config = self::parseFile($file)) {
            return self::checkArrayStructure($config, $config_structure);
        } else {
            return false;
        }
    }

    public static function checkArrayStructure($array, $structure): bool
    {
        foreach ($structure as $key => $item) {
            if (is_array($item)) {
                return self::checkArrayStructure($array[$key], $item);
            } else {
                if (!in_array($item, array_keys($array))) {
                    echo $item . "|";
                    return false;
                }
            }
        }
        return true;
    }
}
