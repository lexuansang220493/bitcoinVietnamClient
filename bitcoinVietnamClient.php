<?php

class bitcoinVietnamClient{
    public $apiKey;
    public $apiSecret;
    public $url;
    public $error;

    public function __construct($apiKey, $apiSecret, $url){
        $this->apiKey = trim($apiKey);
        $this->apiSecret = trim($apiSecret);
        $this->url = $url;
        $this->status() == 'up' ? $rsp = $this : $rsp = false;
        return $rsp;
    }

    public function params($array){
        $params = base64_encode(json_encode($array, JSON_UNESCAPED_UNICODE));
        return $params;
    }

    public function signature($params){
        $signature = hash_hmac('SHA256', $params, $this->apiSecret);
        return $signature;
    }

    public function query($array){
        $array['nonce'] = intval(time());
        $params = $this->params($array);

        $header = array(
            "X-BITCOINVIETNAM-KEY: ".$this->apiKey,
            "X-BITCOINVIETNAM-PARAMS: ".$params,
            "X-BITCOINVIETNAM-SIGNATURE: ".$this->signature($params)
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $array);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($curl), TRUE);

        $res['error'] ? $this->error = $res['error'] : null;
        return $res;
    }

    public function status(){
        $params = array('method' => (string)'status');
        $response = $this->query($params);
        return $response;
    }

    public function ticker(){
        $params = array('method' => (string)'ticker');
        $response = $this->query($params);
        return $response;
    }

    public function dailydata(){
        $params = array('method' => (string)'dailydata');
        $response = $this->query($params);
        return $response;
    }

    public function account(){
        $params = array('method' => (string)'account');
        $response = $this->query($params);
        return $response;
    }

    public function price($side)
    {
        $side != 'buy' && $side != 'sell' ? $side = 'buy' : null;

        $params = array(
            'method' => (string)'price',
            'side' => (string)$side
        );

        $response = $this->query($params);
        return $response;
    }

    public function buy($amountType, $amount, $price, $btcAddress = []){

        /*
         *  Possible amount types: 'fiat', 'bitcoin'
         *  If amount type is fiat, the amount must be in fiat.
         *  If amount type is bitcoin, the amount must be in bitcoin.
         */

        $params = array(
            'method' => (string)'buy',
            'amountType' => (string)$amountType,
            'amount' => (float)$amount,
            'price' => (float)$price
        );

        is_string($btcAddress) ?
            $params['btcAddress'] = $btcAddress : $params['btcAddress'] = 'WALLET';

        $response = $this->query($params);
        return $response;
    }

    public function sell($amount){

        $params = array(
            'method' => (string)'sell',
            'amount' => (float)$amount
        );

        $response = $this->query($params);
        return $response;
    }

    public function orderstatus($orderId) {

        $params = array(
            'method' => 'orderstatus',
            'id' => $orderId
        );
        $response = $this->query($params);
        return $response;
    }
}