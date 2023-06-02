<?php
// Informações do bot
$botToken = 'SEU_TOKEN_BOT';
$botName = 'NOME_DO_BOT';


$update = json_decode(file_get_contents('php://input'), TRUE);
$message = $update['message']['text'];
$chatId = $update['message']['chat']['id'];

//COMANDO AO INICIAR BOT (/start) #nao editar
$start = file_get_contents("https://raw.githubusercontent.com/eutheuzin7/bot-telegram-OpenAI-php/main/Start");

if($message == "/start") {
    $telegramUrl = 'https://api.telegram.org/bot'.$botToken.'/sendMessage?chat_id='.$chatId.'&parse_mode=Markdown&text='.urlencode($start);
    file_get_contents($telegramUrl);
}
    

// Resposta do bot (/ia)
if ((strpos($message, "/ia") === 0)){
    $openaiUrl = 'https://api.openai.com/v1/engines/text-davinci-002/completions';
    $data = array(
        'prompt' => $message,
        'max_tokens' => 100,
        'temperature' => 0.7,
//      'stop' => '\n',
    );
    $json_data = json_encode($data);

    $ch = curl_init($openaiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer SUA_API_KEY_AQUI'
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    $answer = json_decode($response)->choices[0]->text;

    $telegramUrl = 'https://api.telegram.org/bot'.$botToken.'/sendMessage?chat_id='.$chatId.'&text='.urlencode($answer);
    file_get_contents($telegramUrl);
}

/*
🧑‍💻 dev: @EUTHEUZIN
💻 project: https://github.com/eutheuzin7/bot-telegram-OpenAI-php/
*/
