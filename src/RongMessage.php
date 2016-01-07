<?php
/**
 * RongMessage.php
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

use Refear99\EasyRongcloud\Exceptions\MessageException;

class RongMessage extends Rongcloud
{
    /**
     * TODO
     * 发送会话消息
     *
     * @param $fromUserId   发送人用户 Id。（必传）
     * @param $toUserId     接收用户 Id，提供多个本参数可以实现向多人发送消息。（必传）
     * @param $objectName   消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     * @param $content      发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent 如果为自定义消息，定义显示的 Push 内容。(可选)
     * @param string $pushData 针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     *
     * @return json|xml
     */
    public function messagePublish($fromUserId, $toUserId = [], $objectName, $content, $pushContent = '', $pushData = '')
    {
        try {
            if (empty($fromUserId))
                throw new Exception('发送人用户 Id 不能为空');
            if (empty($toUserId))
                throw new Exception('接收用户 Id 不能为空');
            if (empty($objectName))
                throw new Exception('消息类型 不能为空');
            if (empty($content))
                throw new Exception('发送消息内容 不能为空');

            $params = [
                'fromUserId'  => $fromUserId,
                'objectName'  => $objectName,
                'content'     => $content,
                'pushContent' => $pushContent,
                'pushData'    => $pushData,
                'toUserId'    => $toUserId
            ];

            $ret = $this->curl('/message/publish', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * 以一个用户身份向群组发送消息
     *
     * @param string $fromUserId 发送人用户 Id。（必传）
     * @param array $toGroupId 接收群Id，提供多个本参数可以实现向多群发送消息。（必传）
     * @param string $objectName 消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     * @param string $content 发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent 如果为自定义消息，定义显示的 Push 内容。(可选)
     * @param string $pushData 针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     *
     * @return mixed
     * @throws Exceptions\BaseException
     * @throws MessageException
     */
    public function messageGroupPublish($fromUserId, $toGroupId = [], $objectName, $content, $pushContent = '', $pushData = '')
    {
        try {
            if (empty($fromUserId)) {
                throw new MessageException('发送人用户 Id 不能为空');
            }
            if (empty($toGroupId)) {
                throw new MessageException('接收群Id 不能为空');
            }
            if (empty($objectName)) {
                throw new MessageException('消息类型 不能为空');
            }
            if (empty($content)) {
                throw new MessageException('发送消息内容 不能为空');
            }

            $params = [
                'fromUserId'  => $fromUserId,
                'objectName'  => $objectName,
                'content'     => $content,
                'pushContent' => $pushContent,
                'pushData'    => $pushData,
                'toGroupId'   => $toGroupId
            ];

            $ret = $this->curl('/message/group/publish', $params);

            if (empty($ret)) {
                throw new MessageException('请求失败');
            }

            return $this->createResponse($ret);

        } catch (MessageException $e) {
            throw new MessageException($e->getMessage());
        }
    }

    /**
     * TODO
     * 一个用户向聊天室发送消息
     *
     * @param $fromUserId               发送人用户 Id。（必传）
     * @param $toChatroomId             接收聊天室Id，提供多个本参数可以实现向多个聊天室发送消息。（必传）
     * @param $objectName               消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     * @param $content                  发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     *
     * @return json|xml
     */
    public function messageChatroomPublish($fromUserId, $toChatroomId = [], $objectName, $content)
    {
        try {
            if (empty($fromUserId))
                throw new Exception('发送人用户 Id 不能为空');
            if (empty($toChatroomId))
                throw new Exception('接收聊天室Id 不能为空');
            if (empty($objectName))
                throw new Exception('消息类型 不能为空');
            if (empty($content))
                throw new Exception('发送消息内容 不能为空');
            $params = [
                'fromUserId'   => $fromUserId,
                'objectName'   => $objectName,
                'content'      => $content,
                'toChatroomId' => $toChatroomId
            ];

            $ret = $this->curl('/message/chatroom/publish', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 发送讨论组消息
     *
     * @param $fromUserId               发送人用户 Id。（必传）
     * @param $toDiscussionId             接收讨论组 Id。（必传）
     * @param $objectName               消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     * @param $content                  发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent 如果为自定义消息，定义显示的 Push 内容。(可选)
     * @param string $pushData 针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     *
     * @return json|xml
     */
    public function messageDiscussionPublish($fromUserId, $toDiscussionId, $objectName, $content, $pushContent = '', $pushData = '')
    {
        try {
            if (empty($fromUserId))
                throw new Exception('发送人用户 Id 不能为空');
            if (empty($toDiscussionId))
                throw new Exception('接收讨论组 Id 不能为空');
            if (empty($objectName))
                throw new Exception('消息类型 不能为空');
            if (empty($content))
                throw new Exception('发送消息内容 不能为空');

            $params = [
                'fromUserId'     => $fromUserId,
                'toDiscussionId' => $toDiscussionId,
                'objectName'     => $objectName,
                'content'        => $content,
                'pushContent'    => $pushContent,
                'pushData'       => $pushData
            ];
            $paramsString = http_build_query($params);
            $ret = $this->curl('/message/discussion/publish', $paramsString);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 一个用户向一个或多个用户发送系统消息
     *
     * @param $fromUserId       发送人用户 Id。（必传）
     * @param $toUserId         接收用户Id，提供多个本参数可以实现向多用户发送系统消息。（必传）
     * @param $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     * @param $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     * @param string $pushContent 如果为自定义消息，定义显示的 Push 内容。(可选)
     * @param string $pushData 针对 iOS 平台，Push 通知附加的 payload 字段，字段名为 appData。(可选)
     *
     * @return json|xml
     */
    public function messageSystemPublish($fromUserId, $toUserId = [], $objectName, $content, $pushContent = '', $pushData = '')
    {
        try {
            if (empty($fromUserId))
                throw new Exception('发送人用户 Id 不能为空');
            if (empty($toUserId))
                throw new Exception('接收用户 Id 不能为空');
            if (empty($objectName))
                throw new Exception('消息类型 不能为空');
            if (empty($content))
                throw new Exception('发送消息内容 不能为空');

            $params = [
                'fromUserId'  => $fromUserId,
                'objectName'  => $objectName,
                'content'     => $content,
                'pushContent' => $pushContent,
                'pushData'    => $pushData,
                'toUserId'    => $toUserId
            ];

            $ret = $this->curl('/message/system/publish', $params);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 某发送消息给一个应用下的所有注册用户。
     *
     * @param $fromUserId       发送人用户 Id。（必传）
     * @param $objectName       消息类型，参考融云消息类型表.消息标志；可自定义消息类型。（必传）
     * @param $content          发送消息内容，参考融云消息类型表.示例说明；如果 objectName 为自定义消息类型，该参数可自定义格式。（必传）
     *
     * @return json|xml
     */
    public function messageBroadcast($fromUserId, $objectName, $content)
    {
        try {
            if (empty($fromUserId))
                throw new Exception('发送人用户 Id 不能为空');
            if (empty($objectName))
                throw new Exception('消息类型不能为空');
            if (empty($content))
                throw new Exception('发送消息内容不能为空');
            $ret = $this->curl(
                '/message/broadcast',
                [
                    'fromUserId' => $fromUserId,
                    'objectName' => $objectName,
                    'content'    => $content
                ]
            );
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 获取 APP 内指定某天某小时内的所有会话消息记录的下载地址
     *
     * @param $date     指定北京时间某天某小时，格式为：2014010101,表示：2014年1月1日凌晨1点。（必传）
     *
     * @return json|xml
     */
    public function messageHistory($date)
    {
        try {
            if (empty($date))
                throw new Exception('时间不能为空');
            $ret = $this->curl('/message/history', ['date' => $date]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * TODO
     * 删除 APP 内指定某天某小时内的所有会话消息记录
     *
     * @param $date string 指定北京时间某天某小时，格式为2014010101,表示：2014年1月1日凌晨1点。（必传）
     *
     * @return mixed
     */
    public function messageHistoryDelete($date)
    {
        try {
            if (empty($date))
                throw new Exception('时间 不能为空');
            $ret = $this->curl('/message/history/delete', ['date' => $date]);
            if (empty($ret))
                throw new Exception('请求失败');

            return $ret;
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }
}