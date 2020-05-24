<?php
$BOT_TOKEN = "******";

$update = file_get_contents('php://input');
$update = json_decode($update, true);
$userChatId = $update["message"]["from"]["id"]?$update["message"]["from"]["id"]:null;

if($userChatId){
    $userMessage = $update["message"]["text"]?$update["message"]["text"]:"Nothing";
    $firstName = $update["message"]["from"]["first_name"]?$update["message"]["from"]["first_name"]:"N/A";
    $lastName = $update["message"]["from"]["last_name"]?$update["message"]["from"]["last_name"]:"N/A";
    $fullName = $firstName." ".$lastName;
    $replyMsg = "Hello ".$fullName."\nYou said: ".$userMessage;


    $parameters = array(
        "chat_id" => $userChatId,
        "text" => $replyMsg,
        "parseMode" => "html"
    );

    send("sendMessage", $parameters);
}

function send($method, $data){
    global $BOT_TOKEN;
    $url = "https://api.telegram.org/bot$BOT_TOKEN/$method";

    if(!$curld = curl_init()){
        exit;
    }
    curl_setopt($curld, CURLOPT_POST, true);
    curl_setopt($curld, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curld, CURLOPT_URL, $url);
    curl_setopt($curld, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($curld);
    curl_close($curld);
    return $output;
}

?>