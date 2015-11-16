<?php
/**
 * Rongcloud.php
 *
 * Part of Refear99\EasyRongcloud.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    refear99 <refear99@gmail.com>
 * @copyright 2015 refear99 <refear99@gmail.com>
 * @link      https://github.com/refear99
 */

namespace Refear99\EasyRongcloud;

use Refear99\EasyRongcloud\Exceptions\BaseException;

class Rongcloud
{
    const SERVERAPIURL = 'https://api.cn.rong.io';

    private $appKey;
    private $appSecret;
    private $format;

    public function __construct($appKey, $appSecret, $format = 'json')
    {
        if (empty($appKey) || empty($appSecret) || empty($format)) {
            throw new BaseException('Config error');
        }

        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->format = $format;
    }

    /**
     * 创建http header参数
     *
     * @return array
     */
    private function createHttpHeader()
    {
        $nonce = mt_rand();
        $timeStamp = time();
        $sign = sha1($this->appSecret . $nonce . $timeStamp);

        return [
            'RC-App-Key:' . $this->appKey,
            'RC-Nonce:' . $nonce,
            'RC-Timestamp:' . $timeStamp,
            'RC-Signature:' . $sign,
        ];
    }

    /**
     * 重写实现 http_build_query 提交实现(同名key)key=val1&key=val2
     *
     * @param array $formData 数据数组
     * @param string $numericPrefix 数字索引时附加的Key前缀
     * @param string $argSeparator 参数分隔符(默认为&)
     * @param string $prefixKey key数组参数，实现同名方式调用接口
     *
     * @return string
     */
    private function build_query($formData, $numericPrefix = '', $argSeparator = '&', $prefixKey = '')
    {
        $str = '';

        foreach ($formData as $key => $val) {
            if (!is_array($val)) {
                $str .= $argSeparator;
                if ($prefixKey === '') {
                    if (is_int($key)) {
                        $str .= $numericPrefix;
                    }
                    $str .= urlencode($key) . '=' . urlencode($val);
                } else {
                    $str .= urlencode($prefixKey) . '=' . urlencode($val);
                }
            } else {
                if ($prefixKey == '') {
                    $prefixKey .= $key;
                }
                if (is_array($val[0])) {
                    $arr = [];
                    $arr[$key] = $val[0];
                    $str .= $argSeparator . http_build_query($arr);
                } else {
                    $str .= $argSeparator . $this->build_query($val, $numericPrefix, $argSeparator, $prefixKey);
                }
                $prefixKey = '';
            }
        }

        return substr($str, strlen($argSeparator));
    }

    /**
     * 发起 server 请求
     *
     * @param $action
     * @param $params
     *
     * @return int|mixed
     */
    public function curl($action, $params)
    {
        $action = self::SERVERAPIURL . $action . '.' . $this->format;

        $httpHeader = $this->createHttpHeader();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $action);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->build_query($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //处理http证书问题
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $ret = curl_exec($ch);

        if (false === $ret) {
            $ret = curl_errno($ch);
        }

        curl_close($ch);

        return $ret;
    }

    /**
     * 处理返回结果
     *
     * @param $result
     *
     * @return mixed
     * @throws BaseException
     */
    public function createResponse($result)
    {
        $response = json_decode($result, true);

        if (empty($response) || !is_array($response)) {
            throw new BaseException('Response Format Error');
        }

        if (isset($response['code']) && $response['code'] != '200') {
            if (isset($response['errorMessage'])) {
                throw new BaseException('Rongcloud: ' . $response['errorMessage']);
            } else {
                throw new BaseException('Rongcloud Error');
            }
        }

        return $response;
    }
}