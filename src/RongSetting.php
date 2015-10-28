<?php
/**
 * RongSetting.php
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

use Refear99\EasyRongcloud\Exceptions\UserException;

class RongSetting extends Rongcloud
{
    /**
     * TODO
     * 添加敏感词
     * @param $word 敏感词，最长不超过 32 个字符。（必传）
     * @return mixed
     */
    public function wordfilterAdd($word) {
        try{
            if(empty($word))
                throw new Exception('敏感词不能为空');
            $params['word'] = $word;
            $ret = $this->curl('/wordfilter/add',$params);
            if(empty($ret))
                throw new Exception('请求失败');
            return $ret;
        }catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 移除敏感词
     * @param $word 敏感词，最长不超过 32 个字符。（必传）
     * @return mixed
     */
    public function wordfilterDelete($word) {
        try{
            if(empty($word))
                throw new Exception('敏感词不能为空');
            $params['word'] = $word;
            $ret = $this->curl('/wordfilter/delete',$params);
            if(empty($ret))
                throw new Exception('请求失败');
            return $ret;
        }catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
    /**
     * TODO
     * 查询敏感词列表
     * @return mixed
     */
    public function wordfilterList() {
        try{
            $ret = $this->curl('/wordfilter/list',array());
            if(empty($ret))
                throw new Exception('请求失败');
            return $ret;
        }catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}