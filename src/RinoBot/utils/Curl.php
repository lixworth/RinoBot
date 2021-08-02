<?php
declare(strict_types=1);

namespace RinoBot\utils;

/**
 * Class Curl
 * @package RinoBot\utils
 */
class Curl {
    /**
     * 发起get请求
     * @param string $url
     */
    public static function get (string $url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//跳过SS验证
        $data = curl_exec($curl);  
        curl_close($curl);

        return $data;
    }

    /**
     * 发起post请求
     * @param string $url
     * @param array $data
     */
    public static function post (string $url,array $PostData) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//跳过SS验证
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $PostData);
        $data = curl_exec($curl);
        curl_close($curl);
        
        return $data;
    }
}