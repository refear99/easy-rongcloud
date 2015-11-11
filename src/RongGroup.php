<?php
/**
 * RongGroup.php
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

use Refear99\EasyRongcloud\Exceptions\GroupException;

class RongGroup extends Rongcloud
{
    /**
     * 创建群组，并将用户加入该群组，用户将可以收到该群的消息。注：其实本方法是加入群组方法 /group/join 的别名。
     *
     * @param string $userId 要加入群的用户 Id。（必传）
     * @param string $groupId 要加入的群 Id。（必传）
     * @param string $groupName 要加入的群 Id 对应的名称。（必传）
     *
     * @return mixed
     * @throws Exceptions\BaseException
     * @throws GroupException
     */
    public function groupCreate($userId, $groupId, $groupName)
    {
        try {
            if (empty($userId)) {
                throw new GroupException('要加入群的用户 Id 不能为空');
            }

            if (empty($groupId)) {
                throw new GroupException('要加入的群 Id 不能为空');
            }

            if (empty($groupName)) {
                throw new GroupException('要加入的群 Id 对应的名称 不能为空');
            }

            $ret = $this->curl('/group/create', [
                'userId'    => $userId,
                'groupId'   => $groupId,
                'groupName' => $groupName
            ]);

            if (empty($ret)) {
                throw new GroupException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (GroupException $e) {
            throw new GroupException($e->getMessage());
        }
    }

    /**
     * 将用户加入指定群组，用户将可以收到该群的消息。
     *
     * @param string $userId 要加入群的用户 Id。（必传）
     * @param string $groupId 要加入的群 Id。（必传）
     *
     * @return mixed
     * @throws Exceptions\BaseException
     * @throws GroupException
     */
    public function groupJoin($userId, $groupId)
    {
        try {
            if (empty($userId)) {
                throw new GroupException('被同步群信息的用户 Id 不能为空');
            }

            if (empty($groupId)) {
                throw new GroupException('加入的群 Id 不能为空');
            }

            $ret = $this->curl('/group/join', [
                'userId'  => $userId,
                'groupId' => $groupId
            ]);

            if (empty($ret)) {
                throw new GroupException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (GroupException $e) {
            throw new GroupException($e->getMessage());
        }
    }

    /**
     * 将用户从群中移除，不再接收该群组的消息。
     *
     * @param string $userId 要退出群的用户 Id。（必传）
     * @param string $groupId 要退出的群 Id。（必传）
     *
     * @return mixed
     */
    public function groupQuit($userId, $groupId)
    {
        try {
            if (empty($userId)) {
                throw new GroupException('被同步群信息的用户 Id 不能为空');
            }

            if (empty($groupId)) {
                throw new GroupException('加入的群 Id 不能为空');
            }
            $ret =
                $this->curl('/group/quit', [
                    'userId'  => $userId,
                    "groupId" => $groupId
                ]);

            if (empty($ret)) {
                throw new GroupException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (GroupException $e) {
            throw new GroupException($e->getMessage());
        }
    }

    /**
     * TODO
     * 向融云服务器提交 userId 对应的用户当前所加入的所有群组。
     *
     * @param $userId           被同步群信息的用户Id。（必传）
     * @param array $data 该用户的群信息。（必传）array('key'=>'val')
     *
     * @return json|xml
     */
    public function groupSync($userId, $data = [])
    {
        try {
            if (empty($userId))
                throw new Exception('被同步群信息的用户 Id 不能为空');
            if (empty($data))
                throw new Exception('该用户的群信息 不能为空');
            $arrKey = array_keys($data);
            $arrVal = array_values($data);
            $params = [
                'userId' => $userId
            ];
            foreach ($data as $key => $value) {
                $params['group[' . $key . ']'] = $value;
            }

            $ret = $this->curl('/group/sync', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 解散群组方法  将该群解散，所有用户都无法再接收该群的消息。
     *
     * @param $userId           操作解散群的用户 Id。（必传）
     * @param $groupId          要解散的群 Id。（必传）
     *
     * @return mixed
     */
    public function groupDismiss($userId, $groupId)
    {
        try {
            if (empty($userId))
                throw new Exception('操作解散群的用户 Id 不能为空');
            if (empty($groupId))
                throw new Exception('要解散的群 Id 不能为空');
            $ret = $this->curl('/group/dismiss',
                ['userId' => $userId, "groupId" => $groupId]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 添加禁言群成员
     *
     * @param $userId   用户 Id。（必传）
     * @param $groupId 群组 Id。（必传）
     * @param $minute 禁言时长，以分钟为单位，可以不传此参数，默认为永久禁言。
     *
     * @return mixed
     */
    public function groupUserGagAdd($userId, $groupId, $minute)
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            if (empty($groupId))
                throw new Exception('群组 Id 不能为空');
            if (empty($minute))
                throw new Exception('禁言时长 不能为空');
            $params['userId'] = $userId;
            $params['groupId'] = $groupId;
            $params['minute'] = $minute;
            $ret = $this->curl('/group/user/gag/add', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 移除禁言群成员
     *
     * @param $userId   用户 Id。（必传）
     * @param $groupId 群组 Id。（必传）
     *
     * @return mixed
     */
    public function groupUserGagRollback($userId, $groupId)
    {
        try {
            if (empty($userId))
                throw new Exception('用户 Id 不能为空');
            if (empty($groupId))
                throw new Exception('群组 Id 不能为空');
            $params['userId'] = $userId;
            $params['groupId'] = $groupId;
            $ret = $this->curl('/group/user/gag/rollback', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 查询被禁言群成员
     *
     * @param $groupId 群组 Id。（必传）
     *
     * @return mixed
     */
    public function groupUserGagList($groupId)
    {
        try {
            if (empty($groupId))
                throw new Exception('群组 Id 不能为空');
            $params['groupId'] = $groupId;
            $ret = $this->curl('/group/user/gag/list', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}