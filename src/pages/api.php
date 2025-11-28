<?php
// require '/var/www/vendor/autoload.php';
require __DIR__ . '/../../vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::createImmutable('/var/www');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$assunto = "Personagens clássicos dos videogames";
$corpo = [
  "contents"=> [
    [
      "parts" =>[
        [
          "text"=> "A sua função é fazer um quiz sobre o assunto $assunto 
          esse quiz deverá retornar 5 questões com 4 alternativas. 
          As questões deverão ter o seguinte formato:
            ```json
                [{
                    'idQuestao': 1,
                    'questao': 'Como declaro uma variavel?'
                    'respostas': {
                        'a': 'var a = 1',
                        'b': '...'    
                    }
                    'alternativaCorreta': 'a'
                }]
            ```
          Forneça apenas JSON válido, sem explicações adicionais. Use aspas duplas.
          "
        ]
      ]
    ]
  ]
];

$apiKey = $_ENV['GOOGLE_API_KEY'];
$url = $_ENV['GEMINI_URL'];

$header = [
  "Content-Type: application/json",
  "x-goog-api-key: $apiKey"
];

$curlHandle = curl_init($url);
curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlHandle, CURLOPT_POSTFIELDS, json_encode($corpo));
curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $header);

$response = curl_exec($curlHandle);

if (curl_errno($curlHandle)) {
  $error_msg = curl_error($curlHandle);
  echo "cURL error: $error_msg";
} else {
  $result = json_decode($response, true);

  $final =  $result['candidates'][0]['content']['parts'][0]['text'];

  $final = rtrim($final, '```');
  $final  = ltrim($final, '```json');
  echo trim($final);
}