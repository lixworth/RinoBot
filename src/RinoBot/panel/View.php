<?php
/**
 * View.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 19:23
 */

declare(strict_types=1);

namespace RinoBot\panel;

class View
{
    public static function display_error(string $title, string $subtitle, array $error = [])
    {
        exit(self::getView("error"));
    }

    public static function getView($name)
    {
        return require_once __DIR__ . "/resource/$name.php";
    }
}