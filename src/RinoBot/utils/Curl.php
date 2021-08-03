<?php
declare(strict_types=1);

namespace RinoBot\utils;

use Exception;

/**
 * Class Curl
 * @package RinoBot\utils
 */
class Curl
{
    /**
     * 发起get请求
     * @param string $url
     * @return bool|string
     */
    public static function get(string $url)
    {
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
     * @param array $PostData
     * @return bool|string
     */
    public static function post(string $url, array $PostData)
    {
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


    /**
     * GETs an URL using cURL
     * NOTE: This is a blocking operation and can take a significant amount of time. It is inadvisable to use this method on the main thread.
     *
     * @param int $timeout default 10
     * @param string[] $extraHeaders
     * @param string $err reference parameter, will be set to the output of curl_error(). Use this to retrieve errors that occured during the operation.
     * @param string[] $headers reference parameter
     * @param int $httpCode reference parameter
     * @phpstan-param list<string> $extraHeaders
     * @phpstan-param array<string, string> $headers
     *
     * @return string|false
     */
    public static function send_get(string $page, int $timeout = 10, array $extraHeaders = [], &$err = null, &$headers = null, &$httpCode = null)
    {
        try {
            list($ret, $headers, $httpCode) = self::curl($page, $timeout, $extraHeaders);
            return $ret;
        } catch (\Exception $ex) {
            $err = $ex->getMessage();
            return false;
        }
    }

    /**
     * POSTs data to an URL
     * NOTE: This is a blocking operation and can take a significant amount of time. It is inadvisable to use this method on the main thread.
     *
     * @param string[]|string $args
     * @param string[] $extraHeaders
     * @param string $err reference parameter, will be set to the output of curl_error(). Use this to retrieve errors that occured during the operation.
     * @param string[] $headers reference parameter
     * @param int $httpCode reference parameter
     *
     * @return string|false
     */
    public static function send_post(string $page, $args, int $timeout = 10, array $extraHeaders = [], &$err = null, &$headers = null, &$httpCode = null)
    {
        try {
            list($ret, $headers, $httpCode) = self::curl($page, $timeout, $extraHeaders, [
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $args
            ]);
            return $ret;
        } catch (Exception $ex) {
            $err = $ex->getMessage();
            return false;
        }
    }

    /**
     * General cURL shorthand function.
     * NOTE: This is a blocking operation and can take a significant amount of time. It is inadvisable to use this method on the main thread.
     *
     * @param string $page
     * @param float|int $timeout The maximum connect timeout and timeout in seconds, correct to ms.
     * @param string[] $extraHeaders extra headers to send as a plain string array
     * @param array $extraOpts extra CURLOPT_* to set as an [opt => value] map
     * @param callable|null $onSuccess function to be called if there is no error. Accepts a resource argument as the cURL handle.
     * @return array a plain array of three [result body : string, headers : string[][], HTTP response code : int]. Headers are grouped by requests with strtolower(header name) as keys and header value as values
     * @throws Exception
     */
    public static function curl(string $page, $timeout = 10, array $extraHeaders = [], array $extraOpts = [], callable $onSuccess = null): array
    {
        $ch = curl_init($page);
        if ($ch === false) {
            throw new \Exception("Unable to create new cURL session");
        }

        curl_setopt_array($ch, $extraOpts + [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_AUTOREFERER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT_MS => (int)($timeout * 1000),
                CURLOPT_TIMEOUT_MS => (int)($timeout * 1000),
                CURLOPT_HTTPHEADER => array_merge(["User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0"], $extraHeaders),
                CURLOPT_HEADER => true
            ]);
        try {
            $raw = curl_exec($ch);
            if ($raw === false) {
                throw new \Exception(curl_error($ch));
            }
            if (!is_string($raw)) throw new \Exception("curl_exec() should return string|false when CURLOPT_RETURNTRANSFER is set");
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $rawHeaders = substr($raw, 0, $headerSize);
            $body = substr($raw, $headerSize);
            $headers = [];
            foreach (explode("\r\n\r\n", $rawHeaders) as $rawHeaderGroup) {
                $headerGroup = [];
                foreach (explode("\r\n", $rawHeaderGroup) as $line) {
                    $nameValue = explode(":", $line, 2);
                    if (isset($nameValue[1])) {
                        $headerGroup[trim(strtolower($nameValue[0]))] = trim($nameValue[1]);
                    }
                }
                $headers[] = $headerGroup;
            }
            if ($onSuccess !== null) {
                $onSuccess($ch);
            }
            return [$body, $headers, $httpCode];
        } finally {
            curl_close($ch);
        }
    }
}