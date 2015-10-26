<?php
/**
 * RongChatroom.php
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

class RongChatroom extends Rongcloud
{
    /**
     * 创建聊天室
     * @param array $data   key:要创建的聊天室的id；val:要创建的聊天室的name。（必传）
     * @return json|xml
     */
    public function chatroomCreate($data = array()) {
        try{
            if(empty($data))
                throw new Exception('要加入群的用户 Id 不能为空');
            $params = array();
            foreach($data as $key=>$val) {
                $k = 'chatroom['.$key.']';
                $params["$k"] = $val;
            }
            $ret = $this->curl('/chatroom/create', $params);
            if(empty($ret))
                throw new Exception('请求失败');
            return $ret;
        }catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 销毁聊天室
     * @param $chatroomId   要销毁的聊天室 Id。（必传）
     * @return json|xml
     */
    public function chatroomDestroy($chatroomId) {
        try{
            if(empty($chatroomId))
                throw new Exception('要销毁的聊天室 Id 不能为空');
            $ret = $this->curl('/chatroom/destroy', array('chatroomId' => $chatroomId));
            if(empty($ret))
                throw new Exception('请求失败');
            return $ret;
        }catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 查询聊天室信息 方法
     * @param $chatroomId   要查询的聊天室id（必传）
     * @return json|xml
     */
    public function chatroomQuery($chatroomId) {
        try{
            if(empty($chatroomId))
                throw new Exception('要查询的聊天室 Id 不能为空');
            $ret = $this->curl('/chatroom/query', array('chatroomId' => $chatroomId));
            if(empty($ret))
                throw new Exception('请求失败');
            return $ret;
        }catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 查询聊天室内用户
     * @param $chatroomId 聊天室 Id
     */
    public function userChatroomQuery($chatroomId) {
        try{
            if(empty($chatroomId)) {
                throw new Exception('聊天室 Id 不能为空');
            }
            $ret = $this->curl('/chatroom/user/query', array('chatroomId' => $chatroomId));
            if(empty($ret)) {
                throw new Exception('请求失败');
            }
            return $ret;
        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }
}