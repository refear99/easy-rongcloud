<?php
/**
 * RongUser.php
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

class RongUser extends Rongcloud
{
    /**
     * 获取 Token 方法
     *
     * @param string $userId 用户Id，最大长度 32 字节。是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。
     * @param string $name 用户名称，最大长度 128 字节。用来在 Push 推送时，或者客户端没有提供用户信息时，显示用户的名称。
     * @param string $portraitUri 用户头像 URI，最大长度 1024 字节。
     *
     * @return mixed
     * @throws Exceptions\BaseException
     * @throws UserException
     */
    public function getToken($userId, $name, $portraitUri)
    {
        try {
            if (empty($userId))
                throw new UserException('用户 Id 不能为空');
            if (empty($name))
                throw new UserException('用户名称 不能为空');
            if (empty($portraitUri))
                throw new UserException('用户头像 URI 不能为空');

            $ret = $this->curl('/user/getToken', ['userId' => $userId, 'name' => $name, 'portraitUri' => $portraitUri]);

            if (empty($ret)) {
                throw new UserException('请求失败');
            }

            return $this->createResponse($ret);
        } catch (UserException $e) {
            throw new UserException($e->getMessage());
        }
    }

    /**
     * 检查用户在线状态 方法
     *
     * @param $userId    用户 Id。（必传）
     *
     * @return mixed
     */
    public function userCheckOnline($userId)
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            $ret = $this->curl('/user/checkOnline', ['userId' => $userId]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }


    /**
     * 封禁用户 方法
     *
     * @param $userId   用户 Id。（必传）
     * @param $minute   封禁时长,单位为分钟，最大值为43200分钟。（必传）
     *
     * @return mixed
     */
    public function userBlock($userId, $minute)
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            if (empty($minute))
                throw new Exception('封禁时长不能为空');
            $ret = $this->curl('/user/block', ['userId' => $userId, 'minute' => $minute]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }


    /**
     * 解除用户封禁 方法
     *
     * @param $userId   用户 Id。（必传）
     *
     * @return mixed
     */
    public function userUnBlock($userId)
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            $ret = $this->curl('/user/unblock', ['userId' => $userId]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 获取被封禁用户 方法
     * @return mixed
     */
    public function userBlockQuery()
    {
        try {
            $ret = $this->curl('/user/block/query', '');
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }


    /**
     *刷新用户信息 方法  说明：当您的用户昵称和头像变更时，您的 App Server 应该调用此接口刷新在融云侧保存的用户信息，以便融云发送推送消息的时候，能够正确显示用户信息
     *
     * @param $userId   用户 Id，最大长度 32 字节。是用户在 App 中的唯一标识码，必须保证在同一个 App 内不重复，重复的用户 Id 将被当作是同一用户。（必传）
     * @param string $name 用户名称，最大长度 128 字节。用来在 Push 推送时，或者客户端没有提供用户信息时，显示用户的名称。
     * @param string $portraitUri 用户头像 URI，最大长度 1024 字节
     *
     * @return mixed
     */
    public function userRefresh($userId, $name = '', $portraitUri = '')
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            if (empty($name))
                throw new Exception('用户名称不能为空');
            if (empty($portraitUri))
                throw new Exception('用户头像 URI 不能为空');
            $ret = $this->curl('/user/refresh',
                ['userId' => $userId, 'name' => $name, 'portraitUri' => $portraitUri]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }


    /**
     * 添加用户到黑名单
     *
     * @param $userId       用户 Id。（必传）
     * @param $blackUserId  被加黑的用户Id。(必传)
     *
     * @return mixed
     */
    public function userBlacklistAdd($userId, $blackUserId = [])
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            if (empty($blackUserId))
                throw new Exception('被加黑的用户 Id 不能为空');

            $params = [
                'userId'      => $userId,
                'blackUserId' => $blackUserId
            ];

            $ret = $this->curl('/user/blacklist/add', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }


    /**
     * 获取某个用户的黑名单列表
     *
     * @param $userId   用户 Id。（必传）
     *
     * @return mixed
     */
    public function userBlacklistQuery($userId)
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            $ret = $this->curl('/user/blacklist/query', ['userId' => $userId]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }


    /**
     * 从黑名单中移除用户
     *
     * @param $userId               用户 Id。（必传）
     * @param array $blackUserId 被移除的用户Id。(必传)
     *
     * @return mixed
     */
    public function userBlacklistRemove($userId, $blackUserId = [])
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            if (empty($blackUserId))
                throw new Exception('被移除的用户 Id 不能为空');

            $params = [
                'userId'      => $userId,
                'blackUserId' => $blackUserId
            ];

            $ret = $this->curl('/user/blacklist/remove', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }

    }
}