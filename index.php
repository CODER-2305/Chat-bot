<?php
ob_start();
define("API_KEY", "5046375589:AAGr3BvYHe2NiIPMYyzOpJalcdP2UyvC81Y");

function bot ($method, $datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/$method";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
    $res = curl_exec($ch);
    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id;
$message_id = $message->message_id;
$text = $message->text;
$key = json_encode([
    'inline_keyboard'=> [
        [['text'=>"Mening Profilim", 'url'=>"https://t.me/MrUzcoin"]]
    ]
]);
$key2 = json_encode([
    'resize_keyboard'=>true,
    'keyboard'=>[
        [['text'=>"Github Profilim"]]
    ]
]);

if ($text == "/start") {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'parse_node' => 'markdown',
        'text' => "Botga xush kelibsiz",
        'reply_markup'=> $key
    ]);
}
if ($text == "Github Profilim") {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'parse_node' => 'markdown',
        'text' => "https://github.com/Uzcoin404",
        'reply_markup'=> $key2
    ]);
}
if ($text == "/photo") {
    bot('sendPhoto', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'parse_node' => 'markdown',
        'photo' => "https://t.me/texno_talk/1531",
        'caption' => "Endi rasm bilan",
        'reply_markup'=> $key2
    ]);
}

ob_end_flush();
?>