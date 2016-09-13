<?php
/* Criado por Denilson */

/* Classe encapsuladora da API do tradutor BING */
require_once('lib/BingTranslation.php');

/* Instancia usando minha chave */
$gt = new BingTranslation("TDFW_PHP1_0", "+lrvYjyzVSHlnPlZ2byG8BS/43VeK7ydBwb11VqIv1g=");

$text = 'Criei uma ferramenta de interpretação semântica de textos em português feito em PHP, utilizando chamadas YQL e SOAP, e para vocês do grupo, chupa!';

$translated_text = $gt->translate(urlencode($text), "pt-br", "en");
//$translated_text = 'Italian sculptors and painters of the renaissance favored the Virgin Mary for inspiration';

echo "Original text: ".$text."<br>";
echo "Translation: ".$translated_text."<br>";

//$translated_text = urlencode($translated_text);

/* Chamada do Interpretador do Yahoo */
$yql_base_url = "http://query.yahooapis.com/v1/public/yql";  
/* Consulta usando YQL - linguagem deles */
$yql_query = "select * from contentanalysis.analyze where text=\"" . $translated_text . "\""; 

echo $yql_query."<br>";

$yql_query_url = $yql_base_url . "?q=" . urlencode($yql_query);  
$yql_query_url .= "&format=json";  

$session = curl_init($yql_query_url);  

/* Executa a chamada da API e retorna o resultado */
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($session);      

echo $json;
echo "<br>";

/* Segundo interpretador - Não muito bom, tende a gerar muito lixo */
include('lib/rake.php');
/* A stoplist são palavras a ignorar */
$rake = new Rake('lib/stoplist_smart_pt.txt');

$text = $translated_text;
$phrases = $rake->extract($text);
while (list($key, $value) = each($phrases)) {
    echo $key.": ".$value."<br />\n";
}

?>