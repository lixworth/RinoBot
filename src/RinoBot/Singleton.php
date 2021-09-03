<?php
/**
 * Singleton.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/2 15:22
 */
declare(strict_types=1);

namespace RinoBot;

class Singleton
{
    /** @var self|null */
    private static ?self $instance = null;

    public function __construct()
    {
        self::$instance = $this;
    }

    private static function make(): self
    {
        return new self;
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = self::make();
        }
        return self::$instance;
    }

    public static function setInstance(self $instance): void
    {
        self::$instance = $instance;
    }

    public static function reset(): void
    {
        self::$instance = null;
    }
}