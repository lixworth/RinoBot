<?php
/**
 * Logger.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 19:10
 */

declare(strict_types=1);

namespace RinoBot\utils;

/**
 * Class Logger
 * @package RinoBot\utils
 * 日志模板
 */
class Logger
{
    private $format = "";

    public function __construct()
    {

    }

    public static function template($from, $type, $message):string
    {
        return "[".date("Y/H/D h:m:s")."][".$type."][".$from."] ".$message."\n";
    }

    /**
     * @param $message
     * @param string $from
     * @return string
     */
    public function info($message, string $from = 'Server'): string
    {
        return self::template($from,"INFO",$message);
    }

    /**
     * @param $message
     * @param string $from
     * @return string
     */
    public function success($message, string $from = 'Server'): string
    {
        return self::template($from,"SUCCESS",$message);
    }

    /**
     * @param $message
     * @param string $from
     * @return string
     */
    public function error($message, string $from = 'Server'): string
    {
        return self::template($from,"ERROR",$message);
    }
}