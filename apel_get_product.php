<?php

$curl = curl_init();
$consumer_key = 'ck_9547080583b813b01e01c408b542f9100664024e';
$consumer_secret = 'cs_10127ddf938d4d7061a8aea0a7d79de1d1b71a40';
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://acaybeauty.ro/wp-json/wc/v3/whiteimage_woocommerce/product',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('product_id' => '1361'),
  CURLOPT_HTTPHEADER => array(
    'Cookie: PHPSESSID=5369b73e1552eb91b4734f4b56352f89; wcboost_compare_hash=deleted',
    'Authorization: Basic ' . base64_encode($consumer_key . ':' . $consumer_secret),
    'Content-Type: multipart/form-data; boundary=<calculated when request is sent>'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
