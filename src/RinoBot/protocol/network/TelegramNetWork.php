<?php
declare(strict_types=1);

namespace RinoBot\protocol\network;

use RinoBot\utils\Curl;

class TelegramNetWork extends NetWork
{
    private string $api = "https://api.telegram.org/bot";

    /**
     * 发送信息 (纪念🐱封装的第一个网络协议)
     * https://core.telegram.org/bots/api#sendmessage
     * @param string $Token
     * @param string $ChatID 聊天ID
     * @param string $Text
     * @param string|null $ReplyToMessageId (可选)回复消息ID，不是回复消息留空
     * @param bool $DisableWebPagePreview (可选)禁用消息中的链接预览
     * @param bool $DisableNotification (可选)静默发送消息，用户将收到无声通知
     * @param bool $AllowSendingWithoutReply (可选)如果需要被回复的消息不存在是否发送
     * @return bool|string
     */
    public function sendMessage(
        string $Token, string $ChatID, string $Text,
        string $ReplyToMessageId = NULL,
        bool $DisableWebPagePreview = false,
        bool $DisableNotification = false,
        bool $AllowSendingWithoutReply = true)
    {
        if (empty($ReplyToMessageId)) {
            return Curl::get($this->api . $Token .
                "/sendMessage?chat_id=" . $ChatID .
                "&text=" . $Text .
                "&disable_web_page_preview=" . $DisableWebPagePreview .
                "&disable_notification=" . $DisableNotification . "");
        } else {
            return Curl::get($this->api . $Token .
                "/sendMessage?chat_id=" . $ChatID .
                "&text=" . $Text .
                "&reply_to_message_id=" . $ReplyToMessageId .
                "&disable_web_page_preview=" . $DisableWebPagePreview .
                "&disable_notification=" . $DisableNotification .
                "&allow_sending_without_reply=" . $AllowSendingWithoutReply);
        }
    }

    /**
     * 转发消息 (Service messages can't be forwarded)
     * https://core.telegram.org/bots/api#forwardmessage
     * @param string $Token
     * @param string $ChatID 目标聊天ID
     * @param string $FromChatId 需要被转发的消息来源的聊天ID
     * @param string $MessageId 需要被转发的消息ID
     * @param bool $DisableNotification (可选)静默发送消息，用户将收到无声通知
     * @return bool|string
     */
    public function forwardMessage(
        string $Token, string $ChatID, string $FromChatId, string $MessageId,
        bool $DisableNotification = false)
    {
        return Curl::get($this->api . $Token .
            "/forwardMessage?chat_id=" . $ChatID .
            "&from_chat_id=" . $FromChatId .
            "&message_id=" . $MessageId .
            "&disable_notification=" . $DisableNotification);
    }

    /**
     * 复制消息 (与转发消息不同，复制消息不会显示原消息链接，Service messages and invoice messages can't be copied)
     * https://core.telegram.org/bots/api#copymessage
     * @param string $Token
     * @param string $ChatID 目标聊天ID
     * @param string $FromChatId 需要被复制的消息来源的聊天ID
     * @param string $MessageId 需要被复制的消息ID
     * @param string|null $Caption (可选)Media的新标题，留空则表示使用原标题
     * @param bool $DisableNotification (可选)静默发送消息，用户将收到无声通知
     * @param string|null $ReplyToMessageId (可选)回复消息ID，不是回复消息留空
     * @param bool $AllowSendingWithoutReply (可选)如果需要被回复的消息不存在是否发送
     * @return bool|string
     */
    public function copyMessage(
        string $Token, string $ChatID, string $FromChatId, string $MessageId,
        string $Caption = NULL,
        bool $DisableNotification = false,
        string $ReplyToMessageId = NULL,
        bool $AllowSendingWithoutReply = true)
    {
        return Curl::get($this->api . $Token .
            "/forwardMessage?chat_id=" . $ChatID .
            "&from_chat_id=" . $FromChatId .
            "&message_id=" . $MessageId .
            "&caption=" . $Caption .
            "&disable_notification=" . $DisableNotification .
            "&reply_to_message_id=" . $ReplyToMessageId .
            "&allow_sending_without_reply=" . $AllowSendingWithoutReply);
    }

    /**
     * ToDo:$Photo文件流处理
     * 发送图片
     * https://core.telegram.org/bots/api#sendphoto
     * @param string $Token
     * @param string $ChatID 目标聊天ID
     * @param string $Photo 图片URL
     * @param string|null $Caption (可选)图片的标题
     * @param bool|false $disable_notification (可选)静默发送消息，用户将收到无声通知
     * @param string|null $reply_to_message_id (可选)回复消息ID，不是回复消息留空
     * @param bool|true $allow_sending_without_reply (可选)如果需要被回复的消息不存在是否发送
     * @return bool|string
     */
    public function sendPhoto(
        string $Token, string $ChatID, string $Photo,
        string $Caption = NULL,
        bool $disable_notification = false,
        string $reply_to_message_id = NULL,
        bool $allow_sending_without_reply=true)
    {
        return Curl::get($this->api.$Token.
            "/forwardMessage?chat_id=".$ChatID.
            "&photo=".$Photo.
            "&caption=".$Caption.
            "&disable_notification=".$disable_notification.
            "&reply_to_message_id=".$reply_to_message_id.
            "&allow_sending_without_reply=".$allow_sending_without_reply);
    }
}
