<?php
date_default_timezone_set('Asia/Tashkent');
ob_start();
define("API_KEY", "5046375589:AAGr3BvYHe2NiIPMYyzOpJalcdP2UyvC81Y");
$Admin = "829349149";
$admin_url = "https://t.me/MrUzcoin";

function bot ($method, $datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/$method";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) var_dump(curl_error($ch));
    else return json_decode($res);
}
function html($text){
    return str_replace(['<','>'],['&#60;','&#62;'],$text);
};

$update = json_decode(file_get_contents('php://input'));
file_put_contents("log.json",file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$text = $message->text;
$first_name = $message->from->first_name;
$last_name = $message->from->last_name;
$full_name = $first_name . " " . $last_name;
// replymessage
$reply_message = $message->reply_to_message;
$reply_chat_id = $message->reply_to_message->forward_from->id;
$reply_text = $message->text;

$key = json_encode([
    'inline_keyboard'=> [
        [['text'=>"Mening Profilim", 'url'=>"https://t.me/MrUzcoin"]]
    ]
]);
$key2 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"Bosh sahifa"]]
    ]
]);

if ($chat_id != $Admin) {
    if ($text == "/start") {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => 'markdownV2',
            'text' => "Assalomu alaykum [MrUzcoin](https://t.me/MrUzcoin) Qabul botiga xush kelibsiz\. Bu yerda menga Murojat yo\'llashingiz mumkin",
            'reply_markup' => $key2
        ]);
        bot('sendMessage', [
            'chat_id' => $Admin,
            'message_id' => $message_id,
            'parse_mode' => 'markdownV2',
            'text' => "Yangi foydalanuvchi",
            'reply_markup' => $key2
        ]);
        // Forward message to Admin
        bot('forwardMessage', [
            'chat_id' => $Admin,
            'message_id' => $message_id,
            'from_chat_id' => $chat_id,
            'parse_mode' => 'markdownV2',
            'reply_markup' => $key2
        ]);
    } else if ($text != "/start"){
        // Forward message to Admin
        bot('forwardMessage', [
            'chat_id' => $Admin,
            'message_id' => $message_id,
            'from_chat_id' => $chat_id,
            'parse_mode' => 'markdownV2',
            'reply_markup' => $key2
        ]);
    } else if ($text == "Bosh sahifa") {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'message_id' => $message_id,
            'parse_mode' => 'markdownV2',
            'text' => "*Bosh sahifaga xush kelibsiz*",
            'reply_markup' => $key2
        ]);
    }
} else if ($chat_id == $Admin){
    if(isset($reply_message)){
        bot('sendmessage', [
            'chat_id' => $reply_chat_id,
            'parse_mode' => "markdownV2",
            'text' => $reply_text,
        ]);
    }
    if($text == "hi" or $text == "/start"){
        bot('sendMessage', [
            'chat_id' => $Admin,
            'text' => "Salom Admin !",
        ]);
    }
}
    
ob_end_flush();
?>