<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'bitcoinVietnamClient.php';

$apiKey = 'Ctik613mZpRIKM9sEAN70J5BFhTWSlfc';
$apiSecret = '6118f18b832676d6837df733ff0b7db5d941f2339d5752f8e5743a779e1ad426faccdd6e9f80e1b068cd2336834c948ce6707e7f8aafd06f3e0c23ec556b05ed';
$apiUrl = 'http://192.168.0.15/bitcoinvietnammvc/public/api/v2';

$bitcoinVietnam = new bitcoinVietnamClient($apiKey, $apiSecret, $apiUrl);
$rsp = $bitcoinVietnam->sell(0.1);

?>

<pre><?php print_r($rsp); ?></pre>

