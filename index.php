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

if ($text == "/start") {
    bot('sendMessage', [
        'chat_id' => $chat_id,
        'message_id' => $message_id,
        'parse_node' => 'markdown',
        'text' => "Botga xush kelibsiz",
        'reply_markup'=> $key
    ]);
}

ob_end_flush();
?>