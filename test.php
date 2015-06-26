<?php

include 'bitcoinVietnamClient.php';

$apiKey = '[[ YOUR API KEY ]]';
$apiSecret = '[[ YOUR API SECRET ]]';
$apiUrl = 'https://www.bitcoinvietnam.com.vn/api/v2';

$bitcoinVietnam = new bitcoinVietnamClient($apiKey, $apiSecret, $apiUrl);
$rsp = $bitcoinVietnam->account();

?>

<pre><?=var_dump($rsp)?></pre>