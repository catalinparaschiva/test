<?php



class SyncFromRemote {

    public static function curlGetClientJson($method, $list_id = false, $product_id = false) {
        require (dirname(__FILE__) . '/../../classes/site_activity/wiSyncClientUrlsConfig.php');

        $client = $client_urls_config[$list_id];
        $client['return'] = true;
        $client['product_id'] = $product_id;
            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($product_id), 1) . "\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($client), 1) . "\n\n", FILE_APPEND);

        if($list_id == 4600) {
            $client['item_id'] = $product_id;
        }
        //file_put_contents('/mnt/drive2/tmp/silviu/alextesting.log', "product id: " . $product_id ."\n\n", FILE_APPEND);

        $poststring = "method=" . urlencode($method);
        $poststring .= '&local_fields='.urldecode(serialize($client['local_fields']));
        if(!empty($client['attributes'])) $poststring .= '&attributes='.serialize($client['attributes']);

        foreach($client as $ps_a => $ps_v) {
            if(!is_array($ps_v) && $ps_a != 'method' && $ps_a != 'local_fields' && $ps_a != 'attributes' && $ps_a != 'has_magento' && $ps_a != 'url_magento' && $ps_a != 'url_general') {
                $poststring .= '&'.$ps_a.'='.$ps_v;
            }
        }

        $host = $client['has_magento'] ? $client['url_magento'] : $client['url_general'];

            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($client), 1) . "\n\n", FILE_APPEND);
        if($list_id=='3275' || $list_id == '4131'){
            $host .= 'WIGetProduct/';
            $wlm_method = "getProduct";
            $poststring = json_encode(array_merge($client['params']['login'], $client['params'][$wlm_method]));
            $poststring = sprintf($poststring,  $client['product_id']);

        }
        if($list_id=='8240' || $list_id=='8239'){
            $poststring = http_build_query(['sync_key'=> $client['acces_token'],'method' => $method, 'item_id' => $client['product_id']]);
        }

        // if($list_id=='5748' || $list_id=='7063'){
        //     mail( 'catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, $host.json_encode($client));
        // }

        if ( $client['has_magento_2']) {
            $host .= 'product'; 
            $poststring = json_encode(['item_id' => $client['product_id']]);    
        }elseif ($client['has_shopify']){
            $host .= 'product';
            $poststring = json_encode(['shop' => $client['shop'],'product_id' => 'gid://shopify/Product/'.$client['product_id']]);
        }elseif ($client['has_merchantpro']){
            $host .= 'product';
            $poststring = json_encode(['store' => $client['store'],'item_id' => $client['product_id']]);
        }

        // If the site is multi-language, the language will be determined based on list_id
        if (isset($client['multi_language'])) {
            $poststring .= '&list_id=' . $list_id;
        }

        if ($host == "http://www.salamandershop.ro/whitesyncnew/sync/syncSitemapToWlmService?") {
            $poststring = "method=" . urlencode($method) . "&product_id=" . $product_id;
            // mail('gabi.stan@whiteimage.ro', 'curlGetClientJson' . __LINE__, json_encode($poststring) . " " . $product_id);
        }
        if ($host == "http://www.melkior.ro/modules/whiteplatform/cron-white.php") {
            //mail('catalin.paraschiva@whiteimage.ro', 'curlGetClientJson' . __LINE__, json_encode($poststring) . " ##################" . $product_id);
        }
        file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($host), 1) . "\n\n", FILE_APPEND);
        try {
            //$host = 'http://qanoriel.evozon.com/index.php/wiproducts?sku=NOR6937';
            $ch = curl_init($host);
            file_put_contents('/tmp/romstal.log', "poststring:" . $poststring . " " . $host . "\n\n", FILE_APPEND);
            if($client['method'] == 'post') curl_setopt($ch, CURLOPT_POST, 1);
            else curl_setopt($ch, CURLOPT_POST, 0);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);  // DO NOT RETURN HTTP HEADERS
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
            curl_setopt($ch, CURLOPT_VERBOSE, true);

            // Romstal Basic Auth
            if ($list_id == '4600') {
                $username = 'whiteImage';
                $password = 'whitepwd0981';
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: Basic " . base64_encode($username . ":" . $password)
                    ));
            }

            if ( $client['has_magento_2']) {

    //                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: Bearer " . $client['acces_token'],
                        'Content-Type: application/json'
                        )
                );
                
            }elseif ($client['has_shopify']) {
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array(
                        "X-Internal-Access-Key: " . $client['acces_token']
                        ,
                        'Content-Type: application/json'
                        )
                );
            }elseif ($client['has_merchantpro']) {
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: Bearer " . $client['acces_token'],
                        'Content-Type: application/json'
                        )
                );
            }
            if ($list_id == '8240') {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            }

            if($list_id=='3275' || $list_id == '4131'|| $list_id=='7042'){
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            }
            
            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($poststring), 1) . "\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($ch), 1) . "\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', " host: " . $host . " poststring: " . $poststring . "\n\n", FILE_APPEND);

            $res = curl_exec($ch);
            // curl_close($ch);

            
            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($res), 1) . "\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export(__LINE__ . __FILE__.': ' . date("Y-m-d H:i:s") . ' == ' . curl_getinfo($ch, CURLINFO_HEADER_OUT), 1) . "\n\n", FILE_APPEND);
            file_put_contents('/tmp/romstal.log', "res_113:" . var_export($res,true) . "\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/alextesting.log', "result : " . $res . " host: " . $host . " poststring:" . $poststring ."\n\n", FILE_APPEND);
        } catch ( Exception $e) {
            mail('catalin.paraschiva@whiteimage.ro','eroare curlGetClientJson', var_export($e->getMessage(), 1) );
            file_put_contents('/tmp/romstal.log', "res_113:" . var_export($e->getMessage(), 1) . "\n\n", FILE_APPEND);

        }
        // if($list_id=='5748' || $list_id=='7063' || $list_id=='7042'){
        //     file_put_contents('/tmp/romstal.log', "aici:" . var_export($res,true) . "\n\n", FILE_APPEND);
        //     $a= 'OK';
        //     mail('catalin.paraschiva@whiteimage.ro', __LINE__.'json decode return' . __FILE__,json_encode($res));
        //     mail('catalin.paraschiva@whiteimage.ro', __LINE__.'json decode return' . __FILE__,$res);
        //     return json_decode($res);
        // }
        return json_decode($res);
    }

    public static function curlGetClientJsonCustom($url, $product_id = false, $attr = 'sku') {
        $delimiter = '?';
        if(stripos($url, '?') !== false) {
            $delimiter = '&';
        }

        $poststring = "$delimiter$attr=" . urlencode($product_id);
        //$poststring .= '&local_fields='.urldecode(serialize($client['local_fields']));
        //mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__. ' b-mall sync ', $url.$poststring);
        try {
            //$host = 'http://qanoriel.evozon.com/index.php/wiproducts?sku=NOR6937';
            $ch = curl_init($url.$poststring);
            // curl_setopt($ch, CURLOPT_POST, 0);
            // curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);
            // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            // curl_setopt($ch, CURLOPT_HEADER, 0);  // DO NOT RETURN HTTP HEADERS
            // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
            // curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET'
              ));
            $res = curl_exec($ch);
            if(stripos($url, 'donaonline') !== false){
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,$url.$poststring);
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,json_encode($res));
            }
            
        } catch ( Exception $e) {
            file_put_contents('/mnt/drive2/tmp/silviu/silviu.log', var_export('error curl json', 1)."\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/silviu.log', var_export($e->getMessage(), 1)."\n\n", FILE_APPEND);
        }
        //mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__. ' b-mall sync ', $res);
        return $res;
    }


    // bestkids
    public static function curlGetClientJsonBK($list_id, $product_id) {
        require (dirname(__FILE__) . '/../../classes/site_activity/wiSyncClientUrlsConfig.php');

        $client = $client_urls_config[$list_id];
        $client['return'] = true;
        $client['product_id'] = $product_id;
        file_put_contents('/mnt/drive2/tmp/silviu/alextesting.log', "product id: " . $product_id ."\n\n", FILE_APPEND);

        $host = $client['has_magento'] ? $client['url_magento'] : $client['url_general'];

        if($list_id=='3275' || $list_id == '4131'){
            $host .= 'WIGetProduct/';
            $wlm_method = "getProduct";
            $poststring = json_encode(array_merge($client['params']['login'], $client['params'][$wlm_method]));
            $poststring = sprintf($poststring,  $client['product_id']);

        }

        try {
            //$host = 'http://qanoriel.evozon.com/index.php/wiproducts?sku=NOR6937';
            $ch = curl_init($host);
            if($client['method'] == 'post') curl_setopt($ch, CURLOPT_POST, 1);
            else curl_setopt($ch, CURLOPT_POST, 0);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);  // DO NOT RETURN HTTP HEADERS
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
            curl_setopt($ch, CURLOPT_VERBOSE, true);

            if($list_id=='3275' || $list_id == '4131'){
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            }

            if ($list_id == '4600') {
                echo "4600";
                $username = 'whiteImage';
                $password = 'whitepwd0981';
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_HTTPHEADER,
                    array(
                        "Authorization: Basic " . base64_encode($username . ":" . $password)
                    ));
            }

            $res = curl_exec($ch);
           // file_put_contents('/mnt/drive2/tmp/silviu/alextesting.log', "resultttt : " . $res . " host: " . $host . " poststring:" . $poststring ."\n\n", FILE_APPEND);
        } catch ( Exception $e) {
            file_put_contents('/mnt/drive2/tmp/silviu/silviu.log', var_export('error curl json', 1)."\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/silviu.log', var_export($e->getMessage(), 1)."\n\n", FILE_APPEND);

        }
        if($list_id=='3275' || $list_id == '4131') {
            #mail('gabi.stan@whiteimage.ro', 'api json', $res);
        }
        file_put_contents('/mnt/drive2/tmp/temp.log', $res ."\n\n", FILE_APPEND);
        $res = json_decode($res);
        $response['image'] = $res->response->wi_wsbus_remote_item_image;
        $response['url'] = $res->response->wi_wsbus_remote_item_url;

        if($list_id=='3275' || $list_id == '4131') {
            #mail('gabi.stan@whiteimage.ro', 'api response', json_encode($response));
        }
        return $response;


    }

    public static function curlGetClientJsonRomstal($list_id, $product_id) {
        require (dirname(__FILE__) . '/../../classes/site_activity/wiSyncClientUrlsConfig.php');

        $client['method'] = 'getProduct';
        $client['item_id'] = $product_id;
        $host = 'https://www.romstal.ro/whiteImage/index';
        file_put_contents('/mnt/drive2/tmp/silviu/alexromstal.log', "product id: " . $product_id ."\n\n", FILE_APPEND);
        $poststring = 'method=getProduct&item_id='. $product_id;

        try {
            //$host = 'http://qanoriel.evozon.com/index.php/wiproducts?sku=NOR6937';
            $ch = curl_init($host);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $poststring);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);  // DO NOT RETURN HTTP HEADERS

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
            curl_setopt($ch, CURLOPT_VERBOSE, true);

            $username = 'whiteImage';
            $password = 'whitepwd0981';
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array(
                    "Authorization: Basic " . base64_encode($username . ":" . $password)
                ));

            $res = curl_exec($ch);
            // file_put_contents('/mnt/drive2/tmp/silviu/alextesting.log', "resultttt : " . $res . " host: " . $host . " poststring:" . $poststring ."\n\n", FILE_APPEND);
        } catch ( Exception $e) {
            file_put_contents('/mnt/drive2/tmp/silviu/silviu.log', var_export('error curl json', 1)."\n\n", FILE_APPEND);
            file_put_contents('/mnt/drive2/tmp/silviu/silviu.log', var_export($e->getMessage(), 1)."\n\n", FILE_APPEND);

        }

        file_put_contents('/mnt/drive2/tmp/temp.log', $res ."\n\n", FILE_APPEND);
        $res = json_decode($res);
        $response['image'] = $res->wi_wsbus_remote_item_image;
        $response['url'] = $res->wi_wsbus_remote_item_url;
        $response['title'] = $res->wi_wsbus_remote_item_title;
        $response['category'] = $res->wi_wsbus_remote_item_category;
        $response['price'] = $res->wi_wsbus_remote_item_price;

        return $response;


    }

    public static function getRemoteProductJson($id, $list_id) {

        $params = "method=getProduct&id=$id&list_id=" . $list_id;

        $start = microtime(true);
        $ch = curl_init('https://www.mrpich.com/index.php?route=module/whitesync/sync_sitemap');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }


}