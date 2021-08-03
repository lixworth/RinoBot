<?php
/**
 * build-release.php
 *
 * @project RinoBot
 * @author lixworth <lixworth@outlook.com>
 * @copyright RinoBot
 * @create 2021/8/4 1:42
 */

declare(strict_types=1);

$target = __DIR__ . "/build/"; // DONOT EDIT!!!!

if(is_dir($target)){
    system("rm -rf ".$target);
}

mkdir($target);

foreach (["vendor","src","public"] as $item){
    system("cp -r ".__DIR__."/../$item/ ".__DIR__ . "/build/");
}
system("cp ".__DIR__."/../bootstrap.php ".__DIR__."/build/");

