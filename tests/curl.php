<?php
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
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//跳过SS验证L
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $PostData);
        $data = curl_exec($curl);
        curl_close($curl);
        
        return $data;
    }
}

$data = array(
    'test'=>'123'
);
print_r (Curl::post('https://sex.nyan.xyz/api',$data));