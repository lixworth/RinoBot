<?php
/**
 * yaml.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/4 1:02
 */

declare(strict_types=1);

include_once __DIR__ . "/../vendor/autoload.php";

try {
    $val = \Symfony\Component\Yaml\Yaml::parse("demots  ::''SDXSXSXS\CD788-908809808***********(rue");

} catch (\Symfony\Component\Yaml\Exception\ParseException $exception) {
    exit($exception->getMessage());
}
print_r($val);