<?php
declare(strict_types=1);

namespace RinoBot\protocol\network;

use RinoBot\utils\Curl;

class TelegramNetWork extends NetWork
{
    private string $api = "https://api.telegram.org/bot";

    /**
     * 发送信息 (纪念🐱封装的第一个网络协议)
     * @param string $Token
     * @param string $ChatID 聊天ID
     * @param string $Text
     * @param string|null $ReplyToMessageId (可选)回复消息ID，不是回复消息留空
     * @param bool $DisableWebPagePreview (可选)禁用消息中的链接预览
     * @param bool $DisableNotification (可选)静默发送消息，用户将收到无声通知
     * @param bool $AllowSendingWithoutReply (可选)如果需要被回复的消息没了是否发送
     */
    public function sendMessage(
        string $Token, string $ChatID, string $Text,
        string $ReplyToMessageId = NULL,
        bool $DisableWebPagePreview = false,
        bool $DisableNotification = false,
        bool $AllowSendingWithoutReply = true)
    {
        if (empty($ReplyToMessageId)) {
            return Curl::get($this->api.$Token.
                "/sendMessage?chat_id=".$ChatID.
                "&text=".$Text.
                "&disable_web_page_preview=".$DisableWebPagePreview.
                "&disable_notification=".$DisableNotification."");
        } else {
            return Curl::get($this->api.$Token.
                "/sendMessage?chat_id=".$ChatID.
                "&text=".$Text.
                "&reply_to_message_id=".$ReplyToMessageId.
                "&disable_web_page_preview=".$DisableWebPagePreview.
                "&disable_notification=".$DisableNotification.
                "&allow_sending_without_reply=".$AllowSendingWithoutReply);
        }
    }

    /**
     * 转发消息 (Service messages can't be forwarded)
     * @param string $Token
     * @param string $ChatID 目标聊天ID
     * @param string $FromChatId 需要被转发的消息来源的聊天ID
     * @param string $MessageId 需要被转发的消息ID
     * @param bool $DisableNotification (可选)静默发送消息，用户将收到无声通知
     */
    public function forwardMessage(
        string $Token, string $ChatID, string $FromChatId, string $MessageId,
        bool $DisableNotification = false)
    {
        Curl::get($this->api.$Token.
            "/forwardMessage?chat_id=".$ChatID.
            "&from_chat_id=".$FromChatId.
            "&message_id=".$MessageId.
            "&disable_notification=".$DisableNotification);
    }
}