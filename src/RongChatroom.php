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

use Refear99\EasyRongcloud\Exceptions\ChatroomException;

class RongChatroom extends Rongcloud
{
    /**
     * 创建聊天室
     *
     * @param string $roomId
     * @param string $name
     *
     * @return mixed
     * @throws ChatroomException
     * @throws Exceptions\BaseException
     */
    public function createChatroom($roomId, $name)
    {
        try {
            if (empty($roomId)) {
                throw new ChatroomException('聊天室Id不能为空');
            }

            if (empty($name)) {
                throw new ChatroomException('聊天室名字不能为空');
            }

            $ret = $this->curl('/chatroom/create', [
                'chatroom[' . $roomId . ']' => $name
            ]);

            if (empty($ret)) {
                throw new ChatroomException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (ChatroomException $e) {
            throw new ChatroomException($e->getMessage());
        }
    }

    /**
     * TODO
     * 销毁聊天室
     *
     * @param $chatroomId   要销毁的聊天室 Id。（必传）
     *
     * @return json|xml
     */
    public function chatroomDestroy($chatroomId)
    {
        try {
            if (empty($chatroomId))
                throw new Exception('要销毁的聊天室 Id 不能为空');
            $ret = $this->curl('/chatroom/destroy', ['chatroomId' => $chatroomId]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 查询聊天室信息
     *
     * @param string $chatroomId
     *
     * @return mixed
     * @throws ChatroomException
     * @throws Exceptions\BaseException
     */
    public function chatroomQuery($chatroomId)
    {
        try {
            if (empty($chatroomId)) {
                throw new ChatroomException('要查询的聊天室 Id 不能为空');
            }

            $ret = $this->curl('/chatroom/query', ['chatroomId' => $chatroomId]);

            if (empty($ret)) {
                throw new ChatroomException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (ChatroomException $e) {
            throw new ChatroomException($e->getMessage());
        }
    }

    /**
     * 查询聊天室内用户
     *
     * @param string $chatroomId
     *
     * @return mixed
     * @throws ChatroomException
     * @throws Exceptions\BaseException
     */
    public function userChatroomQuery($chatroomId)
    {
        try {
            if (empty($chatroomId)) {
                throw new ChatroomException('聊天室 Id 不能为空');
            }

            $ret = $this->curl('/chatroom/user/query', ['chatroomId' => $chatroomId]);

            if (empty($ret)) {
                throw new ChatroomException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (ChatroomException $e) {
            throw new ChatroomException($e->getMessage());
        }
    }

    /**
     * 禁言聊天室内用户
     *
     * @param string $chatroomId
     * @param string $userId
     * @param int $minute
     *
     * @return mixed
     * @throws ChatroomException
     * @throws Exceptions\BaseException
     */
    public function gagChatroomUser($chatroomId, $userId, $minute)
    {
        try {
            if (empty($chatroomId)) {
                throw new ChatroomException('聊天室 Id 不能为空');
            }

            if (empty($userId)) {
                throw new ChatroomException('用户 Id 不能为空');
            }

            if (empty($minute)) {
                throw new ChatroomException('禁言时间不能为空');
            }

            $ret = $this->curl('/chatroom/user/gag/add', ['userId' => $userId, 'chatroomId' => $chatroomId, 'minute' => $minute]);

            if (empty($ret)) {
                throw new ChatroomException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (ChatroomException $e) {
            throw new ChatroomException($e->getMessage());
        }
    }

    /**
     * 封禁聊天室内用户
     *
     * @param string $chatroomId
     * @param string $userId
     * @param int $minute
     *
     * @return mixed
     * @throws ChatroomException
     * @throws Exceptions\BaseException
     */
    public function blockChatroomUser($chatroomId, $userId, $minute)
    {
        try {
            if (empty($chatroomId)) {
                throw new ChatroomException('聊天室 Id 不能为空');
            }

            if (empty($userId)) {
                throw new ChatroomException('用户 Id 不能为空');
            }

            if (empty($minute)) {
                throw new ChatroomException('禁言时间不能为空');
            }

            $ret = $this->curl('/chatroom/user/block/add', ['userId' => $userId, 'chatroomId' => $chatroomId, 'minute' => $minute]);

            if (empty($ret)) {
                throw new ChatroomException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (ChatroomException $e) {
            throw new ChatroomException($e->getMessage());
        }
    }
}