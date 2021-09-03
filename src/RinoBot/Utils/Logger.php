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

namespace RinoBot\Utils;

use RinoBot\Singleton;

/**
 * Class Logger
 * @package RinoBot\Utils
 * 日志模板
 */
class Logger extends Singleton
{
    private string $format = "";


    public static function template($from, $type, $message): string
    {
        return "[" . date("Y/H/D h:m:s") . "][" . $type . "][" . $from . "] " . $message . "\n";
    }

    /**
     * @param $message
     * @param string $from
     * @return void
     */
    public function info($message, string $from = 'Server'): void
    {
        fwrite(STDOUT, self::template($from, "INFO", $message));
    }

    /**
     * @param $message
     * @param string $from
     * @return void
     */
    public function success($message, string $from = 'Server'): void
    {
        fwrite(STDOUT, self::template($from, "SUCCESS", $message));
    }

    /**
     * @param $message
     * @param string $from
     * @return void
     */
    public function error($message, string $from = 'Server'): void
    {
        fwrite(STDOUT, self::template($from, "ERROR", $message));
    }

    /**
     * @param $message
     * @param string $from
     * @return void
     */
    public function debug($message, string $from = 'Server'): void
    {
        fwrite(STDOUT, self::template($from, "DEBUG", $message));
    }
}