<?php
/**
 * Runtime.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/25 22:14
 */

namespace RinoBot\Utils;

class Runtime
{
    public static string $time;

    public static function setTime($time)
    {
        self::$time = $time;
    }

    public static function start()
    {
        self::$time = microtime();
    }

    public static function end()
    {
        $t1 = microtime();
        list($m0, $s0) = explode(" ", self::$time);
        list($m1, $s1) = explode(" ", $t1);
        return sprintf("%.3f ms", ($s1 + $m1 - $s0 - $m0) * 1000);
    }
}