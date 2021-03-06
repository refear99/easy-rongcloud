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
     * 获取消息类型对应的消息体结构
     *
     * @param string $type 消息类型
     * @param array $data 消息数据
     * @param array $extra 消息附加信息
     *
     * @return array
     * @throws MessageException
     */
    private static function getMessageStructure($type, array $data, array $extra = [])
    {
        switch ($type) {

            case 'RC:TxtMsg':
                $result = [
                    'content' => $data['content']
                ];
                break;

            case 'RC:ImgMsg':
                $result = [
                    'content'  => $data['content'],
                    'imageUri' => $data['image_url']
                ];
                break;

            case 'RC:VcMsg':
                $result = [
                    'content'  => $data['content'],
                    'duration' => $data['duration']
                ];
                break;

            case 'RC:ImgTextMsg':
                $result = [
                    'title'    => $data['title'],
                    'content'  => $data['content'],
                    'imageUri' => $data['image_url'],
                    'url'      => $data['url'],
                ];
                break;

            case 'RC:LBSMsg':
                $result = [
                    'content'   => $data['content'],
                    'latitude'  => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'poi'       => $data['poi'],
                ];
                break;

            case 'RC:ContactNtf':
                $result = [
                    'operation'    => $data['operation'],
                    'sourceUserId' => $data['from_user_id'],
                    'targetUserId' => $data['to_user_id'],
                    'message'      => $data['message'],
                ];
                break;

            case 'RC:InfoNtf':
                $result = [
                    'message' => $data['message']
                ];
                break;

            case 'RC:ProfileNtf':
                $result = [
                    'operation' => $data['operation'],
                    'data'      => $data['data']
                ];
                break;

            case 'RC:CmdNtf':
                $result = [
                    'name' => $data['operation'],
                    'data' => $data['data']
                ];
                break;

            case 'RC:CmdMsg':
                $result = [
                    'name' => $data['operation'],
                    'data' => $data['data']
                ];
                break;

            default:
                throw new MessageException('Invalid Message Type');
        }

        $result['extra'] = $extra;

        return $result;
    }

    /**
     * 文本消息
     *
     * @param string $message
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function textMessage($message, $extra = [])
    {
        $data = self::getMessageStructure('RC:TxtMsg', ['content' => $message], $extra);

        return ['type' => 'RC:TxtMsg', 'data' => json_encode($data)];
    }

    /**
     * 图片消息
     *
     * @param string $message
     * @param string $image
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function imageMessage($message, $image, $extra = [])
    {
        $data = self::getMessageStructure('RC:ImgMsg', ['content' => $message, 'image_url' => $image], $extra);

        return ['type' => 'RC:ImgMsg', 'data' => json_encode($data)];
    }

    /**
     * 语音消息
     *
     * @param string $message
     * @param string $duration
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function voiceMessage($message, $duration, $extra = [])
    {
        $data = self::getMessageStructure('RC:VcMsg', ['content' => $message, 'duration' => $duration], $extra);

        return ['type' => 'RC:VcMsg', 'data' => json_encode($data)];
    }

    /**
     * 图文消息
     *
     * @param string $title
     * @param string $message
     * @param string $image
     * @param string $url
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function newsMessage($title, $message, $image, $url, $extra = [])
    {
        $data = self::getMessageStructure('RC:ImgTextMsg', ['title' => $title, 'content' => $message, 'image_url' => $image, 'url' => $url], $extra);

        return ['type' => 'RC:ImgTextMsg', 'data' => json_encode($data)];
    }

    /**
     * 位置消息
     *
     * @param string $message
     * @param string $latitude
     * @param string $longitude
     * @param string $poi
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function locationMessage($message, $latitude, $longitude, $poi, $extra = [])
    {
        $data = self::getMessageStructure('RC:LBSMsg', ['content' => $message, 'latitude' => $latitude, 'longitude' => $longitude, 'poi' => $poi], $extra);

        return ['type' => 'RC:LBSMsg', 'data' => json_encode($data)];
    }

    /**
     * 联系人消息
     *
     * @param string $message
     * @param string $operation
     * @param string $from_user_id
     * @param string $to_user_id
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function contactMessage($message, $operation, $from_user_id, $to_user_id, $extra = [])
    {
        $data = self::getMessageStructure('RC:ContactNtf', ['message' => $message, 'operation' => $operation, 'from_user_id' => $from_user_id, 'to_user_id' => $to_user_id], $extra);

        return ['type' => 'RC:ContactNtf', 'data' => json_encode($data)];
    }

    /**
     * 提示消息
     *
     * @param string $message
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function infoMessage($message, $extra = [])
    {
        $data = self::getMessageStructure('RC:InfoNtf', ['message' => $message], $extra);

        return ['type' => 'RC:InfoNtf', 'data' => json_encode($data)];
    }

    /**
     * 资料更新消息
     *
     * @param string $operation
     * @param array $data
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function profileMessage($operation, array $data, $extra = [])
    {
        $data = self::getMessageStructure('RC:ProfileNtf', ['operation' => $operation, 'data' => $data], $extra);

        return ['type' => 'RC:ProfileNtf', 'data' => json_encode($data)];
    }

    /**
     * 命令通知消息
     *
     * @param string $operation
     * @param array $data
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function cmdNotifyMessage($operation, array $data, $extra = [])
    {
        $data = self::getMessageStructure('RC:CmdNtf', ['operation' => $operation, 'data' => $data], $extra);

        return ['type' => 'RC:CmdNtf', 'data' => json_encode($data)];
    }

    /**
     * 命令消息
     *
     * @param string $operation
     * @param array $data
     * @param array $extra
     *
     * @return array
     * @throws MessageException
     */
    public static function cmdMessage($operation, array $data, $extra = [])
    {
        $data = self::getMessageStructure('RC:CmdMsg', ['operation' => $operation, 'data' => $data], $extra);

        return ['type' => 'RC:CmdMsg', 'data' => json_encode($data)];
    }

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