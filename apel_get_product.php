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
  CURLOPT_POSTFIELDS => array('product_id' => '1870'),
  CURLOPT_HTTPHEADER => array(
    'Cookie: PHPSESSID=5369b73e1552eb91b4734f4b56352f89; wcboost_compare_hash=deleted',
    'Authorization: Basic ' . base64_encode($consumer_key . ':' . $consumer_secret),
    'Content-Type: multipart/form-data;'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

// raspunsul este:  {"id":1870,"product_url":"https:\/\/acaybeauty.ro\/penseta-extensii-gene-ag-150\/","sku":"00000304","category_id":"308","category":"PENSETE EXTENSII GENE","name":"PENSETA EXTENSII GENE AG-150","final_price":"65.40","special_price":"65.40","price":"109","image":"https:\/\/acaybeauty.ro\/wp-content\/uploads\/2022\/10\/penseta-AG-150.jpg","qty":51}