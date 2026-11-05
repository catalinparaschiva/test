<?php

use Whiteimage\Subscriber\Profile\Instance as ProfileInstance;
use Whiteimage\Subscriber\Profile\Configuration\Manager as ConfigurationManager;
require_once(__DIR__ . '/../../sales/SalesQuery.php');

//change URL function => googleAnalyticsSyncPcPopulate
require_once(dirname(__FILE__) . "/../../../includes/googleAnalytics.php");

/**
 * @param $url_array -> array
 * @param $type -> string
 * @return $url_array -> product with URL changed for tracking
 */
function changeProductReccURLtoTracking($type,$before_link, $after_link, $list_id,$cmpg_id,$url_array,$toFilter){

    $urls = array();
    $urls                = googleAnalyticsSyncPcPopulate($type, null, null, $list_id, $cmpg_id, $url_array, $toFilter);

    $urls_product_id_url = array();
    if(!empty($before_link) && !empty($after_link) ) {
        $urls_product_id_url = googleAnalyticsSyncPcPopulate($type, $before_link, $after_link, $list_id, $cmpg_id, $url_array, $toFilter);
    }

    if(!empty($urls)){
        for($i=0;$i<count($url_array);$i++){
            if($type == 'sync'){
                $url_array[$i+1]['product_url']               = $urls[$i];
                if(!empty($urls_product_id_url[$i])){
                    $url_array[$i+1]['remote_product_id_url'] = $urls_product_id_url[$i];
                }
            }else{
                $url_array[$i]['product_url']                 = $urls[$i];
            }
        }
    }
    return $url_array;
}

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.sync_cart_transactions.php
 * Type:     function
 * Name:     sync_cart_transactions
 * Purpose:  sync_cart_transactions a value to a template variable
 * -------------------------------------------------------------
 */

function smarty_function_sync_cart_transactions($params, Smarty_Internal_Template $template)
{
    global $argv;
    require_once(__DIR__ . '/../../../includes/config_db_2011-12-14_abcde.php');
    require_once(__DIR__ . '/../../wlmCommonManager.php');

    require_once(__DIR__ . "/../../../classes/site_activity/sync_from_remote.php");
    require_once(__DIR__ . "/../../../classes/site_activity/wiSyncClientUrlsConfig.php");
    //require_once(__DIR__ . "/../../../cron/site_activity/sync_client_urls.php");
    $log_path  = '/mnt/drive2/tmp/silviu/sync_cart_transactions_';
    //$log_path2 = '/mnt/drive2/tmp/silviu/sync_cart_transactions2_';
    if($_GET['list_id'] == 8111) {
         mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($params).json_encode($template).json_encode($_GET));
        file_put_contents($log_path.$_GET['list_id'].'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($params), 1) . "\n\n", FILE_APPEND);
        file_put_contents($log_path.$_GET['list_id'].'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' .json_encode($template), 1) . "\n\n", FILE_APPEND);
        file_put_contents($log_path.$_GET['list_id'].'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($_GET), 1) . "\n\n", FILE_APPEND);
    }
    $email = '';
    if(!empty($_GET['vc'])) {
        $parts = explode("##", base64_decode(trim($_GET['vc'])));

        if (is_array($parts) && count($parts) == 3) {
            $cmpg_id = formatID($parts[0]);
            $emailid = formatID($parts[1]);
            $email = trim($parts[2]);
        }
    }
    if(empty($cmpg_id)) $cmpg_id = $_GET['cmpg_id'];
    if(empty($emailid)) $emailid = isset($_GET['emailid']) ? $_GET['emailid'] : '';
    if(empty($emailid)) $emailid = $template->getTemplateVars('emailid');
    if(empty($email))   $email = isset($_GET['emails']) ? $_GET['emails'] : isset($_GET['email']) ? $_GET['emails'] : '' ;
    if(isset($_GET['list_id'])) $list_id = $_GET['list_id'];
    if(empty($email)) $email = $template->getTemplateVars('email');
/*    if ($template->getTemplateVars('cmpg_id') == '174672') {
        mail('gabi.stan@whiteimage.ro', 'yoy abandon', json_encode($list_id));
    }*/
    //if(!empty($template->getTemplateVars('rateit'))){
    //mail('sergio@whiteimage.ro', 'params', json_encode($params));
    //}

    if ($list_id == '6168') {
        // mail('gabi.stan@whiteimage.ro', 'MRPICH yoy abandon' . __LINE__, json_encode($_GET));
    }

    $is_recomandation = false; $tranordid = false;
    if ($list_id == '3907' /*|| $list_id == '4084'*/  ) {
        $is_recomandation = true;
        //mail('catalin.paraschiva@whiteimage.ro',__FILE__. ' b-mall sync ' . __LINE__, json_encode($_GET));
        //mail('catalin.paraschiva@whiteimage.ro',__FILE__. ' b-mall sync ' . __LINE__, json_encode($params));
    }
    //trebuie sa intram in conditiei in momentul in care este recomandare de tip 2 ( recomandare produse in functie de ultima comanda )
    if(isset($params['recommend'])) {
        $is_recomandation = true;
    }
    
    if(isset($_GET['tran_id']) || $is_recomandation) {
        if(!empty($_GET['tran_id'])) $tranordid = $_GET['tran_id'];
        $status = !empty($_GET['tr_status']) ? $_GET['tr_status'] : 'false';

        if(isset($_GET['server'])) {
            $dbh = dbConnect::getInstanceByServerId($_GET['server']);//getInstanceByListId($list_id);
        } else if (isset($list_id)) {
            $dbh = dbConnect::getInstanceByListId($list_id);
        }
        $cmpgSql = "SELECT a.list_id, b.listname, b.listemail, b.listemaildescr ,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_cmpg ELSE c.sm_cmpg END AS sm_cmpg,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_sus ELSE c.sm_sus END AS sm_sus,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_jos ELSE c.sm_jos END AS sm_jos,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_text_linkedin ELSE c.sm_text_linkedin END AS sm_linkedin,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_text_twitter ELSE c.sm_text_twitter END AS sm_twitter,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_text_facebook ELSE c.sm_text_facebook END AS sm_facebook,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_text_digg ELSE c.sm_text_digg END AS sm_digg,
                     CASE WHEN a.sm_cmpg = '1' THEN a.sm_text_myspace ELSE c.sm_text_myspace END AS sm_myspace,
                     d.trigger_action as trigger_action,
                     c.google_param as list_google_param,
                     a.google_param as cmpg_google_param,
                     a.subject
              FROM campaigns_ a
              INNER JOIN lists_ b ON a.list_id = b.list_id
              LEFT JOIN lists_settings_ c ON b.list_id = c.list_id
              LEFT JOIN segments_ d ON a.seg_id = d.seg_id
		      WHERE  a.cmpg_id = " . $cmpg_id . " AND a.list_id = b.list_id AND a.list_id = c.list_id";
        $sth = $dbh->prepare($cmpgSql);
        $sth->execute();
        $dbTrigger = $sth->fetch(PDO::FETCH_ASSOC);
        $list_id = $dbTrigger['list_id'];

        $json_urls = array(
                            3289 => 'https://www.b-mall.ro/whiteimage/wsbus.php?token=3ae32123eea9fe36c712&method=get_product',
                            3907 => 'https://www.b-mall.ro/whiteimage/wsbus.php?token=3ae32123eea9fe36c712&method=get_cart' /* http://www.b-mall.ro/getproduct.php?sku=BM6714173,BM7284769,BM9119272*/
        );
        if($_GET['list_id'] == 4255 ){
            // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, $tranordid);
        }
        $cmd_id = false;
        try {

            if ($tranordid) {
                //get last transaction for email
                $sql = "SELECT * FROM cart.transaction_" . $list_id .
                    " WHERE temp_order='" . $tranordid . "' OR remote_transaction_id = '$tranordid' AND status=false ORDER BY id DESC";
                if (
                    $list_id == '3275' ||
                    $list_id == '4131' ||
                    $list_id == '4600' ||
                    $list_id == '3979' ||
                    $list_id == '5203' ||
                    $list_id == '5205' ||
                    $list_id == '5215' ||
                    $list_id == '4084' ||
                    $list_id == '5216' ||
                    $list_id == '4166' ||
                    $list_id == '5406' ||
                    $list_id == '6168' ||
                    $list_id == '7090' ||
                    $list_id == '7130' ||
                    $list_id == '7063' ||
                    $list_id == '7896' ||
                    $list_id == '4255' ||
                    $list_id == '7952' ||
                    $list_id == '8111' ||
                    $list_id == '8235' ||
                    $list_id == '8452'  ||
                    $list_id == '8422' ||
                    $list_id == '8541' ||
                    $list_id == '8239' 
                ) {
                    $sql = "SELECT * FROM cart.transaction_" . $list_id .
                        " WHERE temp_order='" . $tranordid . "' OR remote_transaction_id = '$tranordid' ORDER BY id DESC";
                }
            } else {
                //get last transaction for email
                $sql = "SELECT * FROM cart.transaction_" . $list_id . " WHERE email='$email' ORDER BY id DESC LIMIT 1";
            }/**/

            /*old code
            if($tranordid) {
                //get last transaction for email
                $sql = "SELECT * FROM cart.transaction_" . $list_id .
                    " WHERE temp_order='" . $tranordid . "' OR remote_transaction_id = '$tranordid' AND status=false ORDER BY id DESC";
                if($list_id=='3275' || $list_id == '4131' || $list_id == '4600' || $list_id=='3979') {
                    $sql = "SELECT * FROM cart.transaction_" . $list_id .
                        " WHERE temp_order='" . $tranordid . "' OR remote_transaction_id = '$tranordid' ORDER BY id DESC";
                }
            } else {
                $config_list = SalesQuery::getConfigSalesListIdByListId($list_id, $dbh);
                $l_id = !empty($config_list) ? $config_list : $list_id;
                //get last transaction for email
                if( ( $l_id == '3979' || $l_id == '4131' || $l_id == '3275' || $l_id == '3966') && ( $cmpg_id=='130307' || $cmpg_id=='156123' || $cmpg_id=='156121' || $cmpg_id=='164321') ){
                    $sql = "SELECT * FROM cart.transaction_" . $l_id . " WHERE email='$email' ORDER BY id DESC";
                }else{
                    $sql = "SELECT * FROM cart.transaction_" . $l_id . " WHERE status=true AND email='$email' ORDER BY id DESC";
                }

            }*/

            $sth = $dbh->prepare($sql);
            $sth->execute();
            $dbTransaction = $sth->fetch(PDO::FETCH_ASSOC);

            // Some list transactions come with currency
            $currency = '';
            if ($list_id == '5203' || $list_id == '5205') { // MRPICH RO & MRPICH EN
                $currency = ! empty($dbTransaction['currency']) ? $dbTransaction['currency'] : '';
            }

            if($_GET['list_id'] == 4255 ){
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, ($sql));
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($dbTransaction));
            }

            if($dbTransaction && $is_recomandation) {
                $tranordid = !empty($dbTransaction['remote_transaction_id']) ? $dbTransaction['remote_transaction_id'] : $dbTransaction['temp_order'];
            }
            if($_GET['list_id'] == 8111) {
                //  mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($params).json_encode($template).json_encode($_GET));
                file_put_contents($log_path.$_GET['list_id'].'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($tranordid), 1) . "\n\n", FILE_APPEND);
            }
        } catch (Exception $e) {
            file_put_contents($log_path.$list_id.'.log', var_export($e->getMessage(), 1) . "\n\n", FILE_APPEND);
            file_put_contents($log_path.$list_id.'.log', var_export($sql, 1) . "\n\n", FILE_APPEND);
        }

        if(empty($emailid)) $emailid = $dbTransaction['emailid'];

        //select products by transaction
        $sql         = "SELECT * FROM cart.transaction_product_" . $list_id . " WHERE transaction_id = " . $dbTransaction['id'];
        $sql_aaaaaaa = "SELECT * FROM cart.transaction_product_" . $list_id . " WHERE transaction_id = " . $tranordid;
        if ($list_id == '5205') {
            // mail('gabi.stan@whiteimage.ro', 'MRPICH yoy abandon' . __LINE__, json_encode($sql));
        }
        //mail( 'sergio@whiteimage.ro', 'SQL', $sql_aaaaaaa );

        try {
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $dbProducts = $sth->fetchAll(PDO::FETCH_ASSOC);
        } catch ( Exception $e ) {
            $dbProducts = array();
        }

        if($_GET['list_id'] == 4255 ){
            //  mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($dbProducts));
        }
        $TVA = 19;
        $command = array();
        $command['products'] = $command['info'] = array();

        $product_ids = ''; $product_skus = ''; $array_pr_ids = array();
        foreach ($dbProducts as $product) {
            $sql = "SELECT * FROM cart.product_" . $list_id . " WHERE id=" . $product['product_id'];
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $dbProduct = $sth->fetch(PDO::FETCH_ASSOC);
            $product_ids .= $dbProduct['remote_product_id'].',';
            $product_skus .= $dbProduct['product_sku'].',';
            $array_pr_ids[$dbProduct['remote_product_id']] = $dbProduct['remote_product_id'];
        }

        $i = 1;
        $command['total'] = 0;
        if ($list_id == '5205') {
            // mail('gabi.stan@whiteimage.ro', 'MRPICH yoy abandon' . __LINE__, json_encode($dbProducts));
        }
        if ($list_id == '3907') {
            //mail('catalin.paraschiva@whiteimage.ro', 'id cos ' . __LINE__, $tranordid);
            $site_products = SyncFromRemote::curlGetClientJsonCustom($json_urls[$list_id], $tranordid, 'id');
            //mail('catalin.paraschiva@whiteimage.ro', 'siteProducts' . __LINE__, $site_products);
            $site_products = json_decode($site_products,true);

            foreach ($site_products as $products) {
                foreach ($products as $product) {
                    //mail('catalin.paraschiva@whiteimage.ro', 'siteProducts' . __LINE__, json_encode($product['wi_attributes']['wi_wsbus_attribute_price_reduction']));
                    $command['products'][$i]['remote_product_id'] = $product[$i]['wi_wsbus_remote_item_id'];


                    $command['products'][$i]['remote_product_id'] = $product['wi_wsbus_remote_item_id'];
                    $command['products'][$i]['category'] = $product['wi_wsbus_remote_item_category'];
                    $command['products'][$i]['title'] = htmlentities($product['wi_wsbus_remote_item_title'], 0, 'UTF-8');
                    $command['products'][$i]['sku'] = $product['wi_wsbus_remote_item_sku'];
                    $command['products'][$i]['quantity'] = $product['wi_attributes']['wi_wsbus_attribute_quantity'];
                    $command['products'][$i]['price'] = $product['wi_wsbus_remote_item_price'];
                    $command['products'][$i]['total'] = $product['wi_wsbus_remote_item_price'] * $product['wi_attributes']['wi_wsbus_attribute_quantity'];
                    $command['products'][$i]['old_price'] = $product['wi_wsbus_remote_item_oldprice'];
                    $command['products'][$i]['image'] = $product['wi_wsbus_remote_item_image'];
                    $command['products'][$i]['url'] = $product['wi_wsbus_remote_item_url'];
                    $command['products'][$i]['marime'] = $product['wi_attributes']['wi_wsbus_attribute_size'];
                    $command['products'][$i]['availability'] = $product['wi_attributes']['wi_wsbus_attribute_availability'];
                    $command['products'][$i]['discount'] = $product['wi_attributes']['wi_wsbus_attribute_price_reduction'];


                    $command['total'] += $command['products'][$i]['total'];
                    $i++;
                }
            }
            //mail('catalin.paraschiva@whiteimage.ro', 'siteProducts' . __LINE__, json_encode($command));

            $template->assign('command', $command);
        }else {
        if($_GET['list_id'] == 8111) {
                //  mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($params).json_encode($template).json_encode($_GET));
                file_put_contents($log_path.$_GET['list_id'].'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($dbProducts), 1) . "\n\n", FILE_APPEND);
            }
        foreach ($dbProducts as $product) {
            $sql = "SELECT * FROM cart.product_" . $list_id . " WHERE id=" . $product['product_id'];
            $sth = $dbh->prepare($sql);
            $sth->execute();
            $dbProduct = $sth->fetch(PDO::FETCH_ASSOC);

            if($_GET['list_id'] == 8111 ){
                //  mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($params).json_encode($template).json_encode($_GET));
                file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($product), 1) . "\n\n", FILE_APPEND);
                file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($dbProduct), 1) . "\n\n", FILE_APPEND);
            }

            if($_GET['list_id'] == 4255 ){
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($dbProduct));
                // $sales_list_id=$_GET['list_id'];
            }
            $command['products'][$i]['id'] = $dbProduct['id'];
            $command['products'][$i]['remote_product_id'] = $dbProduct['remote_product_id'];
            $command['products'][$i]['category'] = $dbProduct['product_category'];
            $command['products'][$i]['title'] = $dbProduct['product_name'];
            $command['products'][$i]['sku'] = $dbProduct['product_sku'];
            $command['products'][$i]['quantity'] = $product['quantity'];
            $command['products'][$i]['price'] = $product['average_price'];
            $command['products'][$i]['image'] = $product['image'];
            $command['total'] += $command['products'][$i]['price'];

            /*if(isset($json_urls) && isset($json_urls[$list_id])) {
                $site_products = SyncFromRemote::curlGetClientJsonCustom($json_urls[$list_id], $dbProduct['remote_product_id'], 'item_id');
                $site_products = json_decode($site_products);
                if ($list_id == '3907') {
                    //mail('catalin.paraschiva@whiteimage.ro',__FILE__. ' b-mall sync ' . __LINE__, json_encode($site_products));
                   }
                file_put_contents($log_path.$list_id.'.log', var_export($site_products, 1) . "\n\n", FILE_APPEND);


                if(count($site_products) == 1) {
                    $sku = '';
                    if(isset($site_products->sku)) {
                        $sku = $site_products->sku;
                    } else if ( isset($site_products->wi_wsbus_remote_item_sku) ) {
                        $sku = $site_products->wi_wsbus_remote_item_sku;
                    }

                    if($sku == $command['products'][$i]['sku']) {
                        if(isset($site_products->thumb)) {
                            $command['products'][ $i ]['image'] = $site_products->thumb;
                        } elseif(isset($site_products->wi_wsbus_remote_item_image)) {
                            $command['products'][ $i ]['image'] = $site_products->wi_wsbus_remote_item_image;
                        }
                    }
                } else {
                    foreach($site_products as $site_attr => $site_product) {
                        $sku = '';
                        if(isset($site_product->sku)) {
                            $sku = $site_product->sku;
                        } else if ( isset($site_product->wi_wsbus_remote_item_sku) ) {
                            $sku = $site_product->wi_wsbus_remote_item_sku;
                        } else if ( isset($site_products->$site_attr) && is_string($site_attr) && $site_attr == 'wi_wsbus_remote_item_sku') {
                            $sku = $site_products->$site_attr;
                        }

                        if($sku == $command['products'][$i]['sku']) {
                            if(isset($site_product->thumb)) {
                                $command['products'][ $i ]['image'] = $site_product->thumb;
                            } elseif(isset($site_product->wi_wsbus_remote_item_image)) {
                                $command['products'][ $i ]['image'] = $site_product->wi_wsbus_remote_item_image;
                            }
                        }
                    }
                }
                file_put_contents('/mnt/drive2/tmp/silviu/sync_cart_transactions_'.$list_id.'.log', var_export($command, 1) . "\n\n", FILE_APPEND);

            }*/

            //adaugat de alex Besleaga 09.06.2016 pentru bestkids --  pentru a lua imaginea si url din API lor
            /* variabila bk e folosita pentru a nu intra si in codul de mai jos
            am facut si o metoda custom de curlGetClientJsonBK pentru a returna imaginea si url real time
            */
            $bk = 0;
            if($list_id=='3275' || $list_id == '4131') {
                $sales_list_id = $list_id;

                $sqlCheckConfig = "SELECT * FROM cart.lists_config_sales WHERE sales_list_id=? order by id asc limit 1";
                $checkConfig = $dbh->prepare($sqlCheckConfig);
                $checkConfig->execute(array($list_id));
                $config_list = $checkConfig->fetch(PDO::FETCH_ASSOC);

                if($config_list) {
                    $sales_list_id = $config_list['list_id'];
                }

                $bkids_products = SyncFromRemote::curlGetClientJsonBK($sales_list_id, $dbProduct['remote_product_id']);
                $command['products'][$i]['image'] =  $bkids_products['image'];
                $command['products'][$i]['product_url'] = $bkids_products['url'];
                //file_put_contents('/mnt/drive2/tmp/silviu/alextesting.log', "Return : " . $bkids_products->response->wi_wsbus_remote_item_image .  "\n\n", FILE_APPEND);
                $bk=1;

            }
            // ----------------------------end adaugat de alex pt bestkids

            // romstal
            if($list_id=='4600'){
                $sales_list_id = $list_id;

                $sqlCheckConfig = "SELECT * FROM cart.lists_config_sales WHERE sales_list_id=? order by id asc limit 1";
                $checkConfig = $dbh->prepare($sqlCheckConfig);
                $checkConfig->execute(array($list_id));
                $config_list = $checkConfig->fetch(PDO::FETCH_ASSOC);

                if($config_list) {
                    $sales_list_id = $config_list['list_id'];
                }

                $romstal_products = SyncFromRemote::curlGetClientJsonRomstal($sales_list_id, $dbProduct['remote_product_id']);
                $command['products'][$i]['image'] =  $romstal_products['image'];
                $command['products'][$i]['product_url'] = $romstal_products['url'];
                $command['products'][$i]['title'] = $romstal_products['title'];
                $command['products'][$i]['category'] = $romstal_products['category'];
                $command['products'][$i]['price'] = $romstal_products['price'];

                $sqlQuantity = "SELECT a.quantity FROM cart.product_$sales_list_id p INNER JOIN cart.product_aggregated_$sales_list_id a ON p.id=a.product_id WHERE p.remote_product_id=".$dbProduct['remote_product_id'];
                $checkQuantity = $dbh->prepare($sqlQuantity);
                $checkQuantity->execute();
                $quantity = $checkQuantity->fetch(PDO::FETCH_ASSOC);

                if($quantity) {
                    $command['products'][$i]['quantity'] = $quantity['quantity'];
                }

//                mail('catalin.paraschiva@whiteimage.ro',__LINE__.__FILE__,json_encode($command['products']));

                $bk=1;
            }
            // end romstal

            // DpaP
            if($list_id=='3966'){

                $dpap_products_json= SyncFromRemote::curlGetClientJsonCustom('https://www.dpap.ro/get_products.php' , $dbProduct['product_sku'], 'sku');
                $dpap_products     = json_decode($dpap_products_json);

                $command['products'][$i]['image']      = $dpap_products[0]->{Imagine};
                $command['products'][$i]['pret_vechi'] = $dpap_products[0]->{'Pret vechi'};
                $command['products'][$i]['pret_nou']   = $dpap_products[0]->{'Pret nou'};
            }
            // end DpaP

            // DonaOnline
            if($list_id=='4255'){

                $dona_products_json= SyncFromRemote::curlGetClientJsonCustom('https://donaonline.ro/index.php?route=extension/module/whiteimage/getProduct' , $dbProduct['remote_product_id'], 'product_id');
                $dona_products     = json_decode($dona_products_json);

                $command['products'][$i]['image']      = $dona_products[0]->image;
                $command['products'][$i]['product_url'] = $dona_products[0]->product_url;
                $command['products'][$i]['price']      = $dona_products[0]->price;
                $command['products'][$i]['final_price']      = $dona_products[0]->final_price;
                $command['products'][$i]['special_price']      = $dona_products[0]->special_price;
                $command['products'][$i]['title'] = $dona_products[0]->name;

                if($_GET['list_id'] == 4255 ){
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, ($dona_products_json));
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($dona_products_json));
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($dona_products));
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($command));
                }
            }
            // end DonaOnline

            if ($list_id == '5205' || $list_id == '5203') {

                $pich_products_json= SyncFromRemote::getRemoteProductJson($dbProduct['remote_product_id'] , $list_id);

                $pich_products     = json_decode($pich_products_json);

                $command['products'][$i]['image']      = $pich_products->image;
                $command['products'][$i]['product_url'] = $pich_products->product_url;

                // mail('gabi.stan@whiteimage.ro', 'MRPICH yoy abandon', json_encode($command));

            }

            if($_GET['list_id'] == 7090 || $_GET['list_id'] == 7130  || $_GET['list_id'] == 7063   || $_GET['list_id'] == 7896 || $_GET['list_id'] == 7952 || $_GET['list_id'] == 8235 || $_GET['list_id'] == 8541 ){
                if($dbProduct['remote_product_id']!=''){
                    
                    $sqlCheckConfig = "SELECT * FROM cart.lists_config_sales WHERE sales_list_id=? order by id asc limit 1";
                    $checkConfig = $dbh->prepare($sqlCheckConfig);
                    $checkConfig->execute(array($list_id));
                    $config_list = $checkConfig->fetch(PDO::FETCH_ASSOC);

                    if($config_list) {
                        $sales_list_id = $config_list['list_id'];
                    }

                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($sales_list_id));
                    $magento2_remote_site_product = SyncFromRemote::curlGetClientJson($method = 'getProduct', $sales_list_id, $dbProduct['remote_product_id']);

                    // file_put_contents('/tmp/romstal.log', "fun sync card transaction brico1:" . var_export($magento2_remote_site_product,true) . "\n\n", FILE_APPEND);
                    if($_GET['list_id'] == 8235){
                        // file_put_contents('/tmp/romstal.log', "fun sync card transaction brico:" . var_export($magento2_remote_site_product,true) . "\n\n", FILE_APPEND);
                  
                        // file_put_contents('/tmp/romstal.log', "array keys brico:" . var_export(array_keys($magento2_remote_site_product),true) . "\n\n", FILE_APPEND);
                    }
                    $magento2_remote_site_product[0]->name = superentities($magento2_remote_site_product[0]->name);
                    $command['products'][$i]['image']      = $magento2_remote_site_product[0]->image;
                    $command['products'][$i]['product_url'] = $magento2_remote_site_product[0]->product_url;
                    $command['products'][$i]['price']      = $magento2_remote_site_product[0]->price;
                    $command['products'][$i]['final_price']      = $magento2_remote_site_product[0]->final_price;
                    $command['products'][$i]['special_price']      = $magento2_remote_site_product[0]->special_price;
                    $command['products'][$i]['title'] = $magento2_remote_site_product[0]->name;
                    
                    if($_GET['list_id'] == 7063){
                        $command['products'][$i]['autor'] = $magento2_remote_site_product[0]->attributes->autor;
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($magento2_remote_site_product[0]));
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($magento2_remote_site_product));
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($command));
                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($dbProduct));
                    }
                    
                    if($_GET['list_id'] == 8111){
                        //  mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($params).json_encode($template).json_encode($_GET));
                        // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($magento2_remote_site_product[0]), 1) . "\n\n", FILE_APPEND);
                    }
                }

            }

            if($_GET['list_id'] == 8111 ){
                if($dbProduct['remote_product_id']!=''){
                    
                    $sqlCheckConfig = "SELECT * FROM cart.lists_config_sales WHERE sales_list_id=? order by id asc limit 1";
                    $checkConfig = $dbh->prepare($sqlCheckConfig);
                    $checkConfig->execute(array($list_id));
                    $config_list = $checkConfig->fetch(PDO::FETCH_ASSOC);

                    if($config_list) {
                        $sales_list_id = $config_list['list_id'];
                    }

                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($sales_list_id));
                    $shopify_remote_site_product = SyncFromRemote::curlGetClientJson($method = 'getProduct', $sales_list_id, $dbProduct['remote_product_id']);

                    file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($shopify_remote_site_product), 1) . "\n\n", FILE_APPEND);
                    // if($_GET['list_id'] == 7063){
                    //     file_put_contents('/tmp/romstal.log', "fun sync card transaction brico:" . var_export($shopify_remote_site_product,true) . "\n\n", FILE_APPEND);
                  
                    //     file_put_contents('/tmp/romstal.log', "array keys brico:" . var_export(array_keys($shopify_remote_site_product),true) . "\n\n", FILE_APPEND);
                    // }
                     $shopify_remote_site_product =  json_encode($shopify_remote_site_product);
                    $shopify_remote_site_product = json_decode($shopify_remote_site_product,true);
                if(isset($shopify_remote_site_product['product'])) {
                    $command['products'][$i]['image']      = $shopify_remote_site_product['product']['featuredImage']['url'];
                    $command['products'][$i]['product_url'] = $shopify_remote_site_product['product']['onlineStoreUrl'];
                    $command['products'][$i]['price']      = $shopify_remote_site_product['product']['priceRangeV2']['maxVariantPrice']['amount'];
                    $command['products'][$i]['final_price']      = $shopify_remote_site_product['product']['priceRangeV2']['maxVariantPrice']['amount'];
                    $command['products'][$i]['special_price']      = $shopify_remote_site_product['product']['priceRangeV2']['maxVariantPrice']['amount'];
                    $command['products'][$i]['title'] = $shopify_remote_site_product['product']['title'];
                }
                    
                    
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($dbProduct), 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $shopify_remote_site_product->product->featuredImage->url, 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($shopify_remote_site_product->product->featuredImage), 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($shopify_remote_site_product->product), 1) . "\n\n", FILE_APPEND);

                    if($_GET['list_id'] == 8111){
                        //  mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($params).json_encode($template).json_encode($_GET));
                        file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($command), 1) . "\n\n", FILE_APPEND);
                    }
                }
                $bk==1;
            }

            if($_GET['list_id'] == 8452 || $_GET['list_id'] == 8422){
                if($dbProduct['remote_product_id']!=''){
                    
                    $sqlCheckConfig = "SELECT * FROM cart.lists_config_sales WHERE sales_list_id=? order by id asc limit 1";
                    $checkConfig = $dbh->prepare($sqlCheckConfig);
                    $checkConfig->execute(array($list_id));
                    $config_list = $checkConfig->fetch(PDO::FETCH_ASSOC);

                    if($config_list) {
                        $sales_list_id = $config_list['list_id'];
                    }

                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($sales_list_id));
                    $merchantPro_remote_site_product = SyncFromRemote::curlGetClientJson($method = 'getProduct', $sales_list_id, $dbProduct['remote_product_id']);

                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($merchantPro_remote_site_product), 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($i), 1) . "\n\n", FILE_APPEND);
                    // if($_GET['list_id'] == 7063){
                    //     file_put_contents('/tmp/romstal.log', "fun sync card transaction brico:" . var_export($merchantPro_remote_site_product,true) . "\n\n", FILE_APPEND);
                  
                    //     file_put_contents('/tmp/romstal.log', "array keys brico:" . var_export(array_keys($merchantPro_remote_site_product),true) . "\n\n", FILE_APPEND);
                    // }
                    $merchantPro_remote_site_product =  json_encode($merchantPro_remote_site_product);
                    $merchantPro_remote_site_product = json_decode($merchantPro_remote_site_product,true);
                    
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . ($merchantPro_remote_site_product['url']), 1) . "\n\n", FILE_APPEND);
                
                    $command['products'][$i]['image']      = $merchantPro_remote_site_product['image_url'];
                    $command['products'][$i]['product_url'] = $merchantPro_remote_site_product['url'];
                    $command['products'][$i]['price']      = $merchantPro_remote_site_product['price'];
                    $command['products'][$i]['final_price']      = $merchantPro_remote_site_product['price_net'];
                    $command['products'][$i]['special_price']      = $merchantPro_remote_site_product['price_net'];
                    $command['products'][$i]['title'] = $merchantPro_remote_site_product['name'];
                                    
                    
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $merchantPro_remote_site_product['url'], 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $merchantPro_remote_site_product['image_url'], 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $merchantPro_remote_site_product['price'], 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $merchantPro_remote_site_product['price_net'], 1) . "\n\n", FILE_APPEND);
                    // file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $merchantPro_remote_site_product['name'], 1) . "\n\n", FILE_APPEND);
    
                    // if($_GET['list_id'] == 8452){
                    //     //  mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($params).json_encode($template).json_encode($_GET));
                        file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($command), 1) . "\n\n", FILE_APPEND);
                    // }
                }
                $bk==1;
            }
            if($list_id == 8239){
                if($dbProduct['remote_product_id']!=''){
                    
                    $sqlCheckConfig = "SELECT * FROM cart.lists_config_sales WHERE sales_list_id=? order by id asc limit 1";
                    $checkConfig = $dbh->prepare($sqlCheckConfig);
                    $checkConfig->execute(array($list_id));
                    $config_list = $checkConfig->fetch(PDO::FETCH_ASSOC);

                    if($config_list) {
                        $sales_list_id = $config_list['list_id'];
                    }

                    // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($sales_list_id));
                    $remote_site_product = SyncFromRemote::curlGetClientJson($method = 'getProduct', $sales_list_id, $dbProduct['remote_product_id']);
                    
                    //  file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($remote_site_product), 1) . "\n\n", FILE_APPEND);
                    if($remote_site_product->product) {
                        $command['products'][$i]['image']      = $remote_site_product->product->image;
                        $command['products'][$i]['product_url'] = $remote_site_product->product->product_url;
                        $command['products'][$i]['price']      = $remote_site_product->product->old_price;
                        $command['products'][$i]['final_price']      = $remote_site_product->product->price;
                        $command['products'][$i]['special_price']      = $remote_site_product->product->price;
                        $command['products'][$i]['title'] = $remote_site_product->product->name;
                        $command['products'][$i]['discount'] = $remote_site_product->product->discount;
                    }
                    //  file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . json_encode($command), 1) . "\n\n", FILE_APPEND);
                }
                $bk==1;
            }

            if($i == 1 && empty($json_urls[$list_id]) && $bk==0) {
                try {
                    $sales_list_id = $list_id;

                    $sqlCheckConfig = "SELECT * FROM cart.lists_config_sales WHERE sales_list_id=? order by id asc limit 1";
                    $checkConfig = $dbh->prepare($sqlCheckConfig);
                    $checkConfig->execute(array($list_id));
                    $config_list = $checkConfig->fetch(PDO::FETCH_ASSOC);

                    if($config_list) {
                        $sales_list_id = $config_list['list_id'];
                    }
                    if ($list_id == '5216') {
                        $product_ids =  substr($product_ids, 0, -1);
                    }
                    if($list_id!=5406 && $list_id!=7090 && $list_id!=7130 && $list_id!=7063 && $list_id!=7896 && $list_id!=7952 && $list_id!=8235 && $list_id!=8452 && $list_id!=8443 && $list_id!=8415 && $list_id!=8422 && $list_id!=8541 && $list_id!=8239)
                    {
                        $remote_site_product = SyncFromRemote::curlGetClientJson($method = 'getProduct', $sales_list_id, $product_ids);
                    }
                    
                    if ($remote_site_product && $list_id!=5406 && $list_id!=7090 && $list_id!=7130 && $list_id!=7063 && $list_id!=7896 && $list_id!=7952 && $list_id!=8235 && $list_id!=8452 && $list_id!=8443 && $list_id!=8415 && $list_id!=8422 && $list_id!=8541 && $list_id!=8239) {
                        $t = $i; 
                        if(isset($remote_site_product->products)) {
                            $remote_site_product = $remote_site_product->products;
                        }

                        foreach($remote_site_product as $rsp) {

                            $client = array(); $store_id = 0; $product_url = '#';
                            try {
                                require (dirname(__FILE__) . '/../../../classes/site_activity/wiSyncClientUrlsConfig.php');
                                $client = $client_urls_config[$sales_list_id];
                            } catch ( Exception $e) {
                                file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $e->getMessage(), 1) . "\n\n", FILE_APPEND);
                            }

                            if (isset($rsp->store_ids) && !empty($rsp->store_ids)) {
                                $store_id = $rsp->store_ids[0];
                            }

                            if(!empty($client)) {
                                if (isset($rsp->product_url)) {
                                    $product_url = $rsp->product_url;
                                    if (isset($client) && isset($client['stores']) && isset($client['stores'][$store_id])) {
                                        $product_url = str_replace($rsp->base_url, $rsp->base_url . $client['stores'][$store_id], $rsp->product_url);
                                    }
                                } else {
                                    $product_url = $rsp->url_path;
                                    if (isset($client) && isset($client['stores'])) {
                                        $product_url = str_replace($rsp->base_url, $rsp->base_url . $client['stores'][$store_id], $rsp->url_path);
                                    }
                                }

                                #$command['products'][$t]['image'] = (strpos($rsp->image, 'http://') !== false) ? $rsp->image : 'http://' . $rsp->image;
                                $command['products'][$t]['image'] = $rsp->image;
                                $command['products'][$t]['product_url'] = $product_url;
                                $command['products'][$t]['special_price'] = $rsp->special_price;
                                $command['products'][$t]['price'] = $rsp->price;
                                // if($_GET['list_id'] == 7896 ){
                                //     mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($command));
                                //     mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($rsp));
                                // }
                                $t++;
                                if ((int)$rsp->price <= 0) {                                    
                                    unset($command['products'][$t - 1]);
                                }
                            }
                        }
                    }else{

                        //Implementare pentru Melkior. Se extrage imaginea produsului si url-ul din baza noastra de date sincronizata.
                        //A fost facuta aceasta implementare deoarece nu a functionat cazul standard cu sincronizare in timp real

                        if ($list_id==5406) {
                            $t=$i;
                            //mail('catalin.paraschiva@whiteimage.ro', 'test ' . __LINE__, 'test');
                            $rmt_ids = explode(',', $product_ids);
                            foreach ($rmt_ids as $rmt_id) {
                                $sql_prod = "SELECT attr_name, attr_value from site_activity.list_url_attribute_$sales_list_id
                                              WHERE url_id IN (SELECT url_id
                                                  FROM site_activity.list_url_attribute_$sales_list_id
                                                  WHERE attr_name = 'remote_id' AND attr_value = '$rmt_id' ORDER BY updated_at DESC LIMIT 1)";
                                $st = $dbh->prepare($sql_prod);
                                $st->execute();
                                $dbprod = $st->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($dbprod as $v){
                                    if ($v['attr_name']=='image') {
                                        $command['products'][$t]['image'] = $v['attr_value'];
                                    }
                                    if ($v['attr_name']=='product_url') {
                                        $command['products'][$t]['product_url'] = $v['attr_value'];
                                    }
                                }
                                $t++;
                            }
                        }
                    }

                } catch (Exception $e) {
                    file_put_contents($log_path.$list_id.'.log', var_export(__LINE__ . __FILE__. ': ' . date("Y-m-d H:i:s") . ' == ' . $e->getMessage(), 1) . "\n\n", FILE_APPEND);
                }
            }

            // if((int)$command['products'][$i]['final_price'] <= 0) {
            //     unset($command['products'][$i]);
            // }
            $i++;
        }
        // if ($list_id == '5205') {
        //     // mail('gabi.stan@whiteimage.ro', 'MRPICH yoy abandon' . __LINE__, json_encode($command));
        // }
        //test sergio products url
        //mail('sergio@whiteimage.ro', 'produsele de tracking', json_encode($command));
        //end test sergio

        //select products by transaction
        $sqlSubs = "SELECT * FROM public.subscribers_" . $list_id .
            " WHERE emailid='" . $emailid . "'";
        $sthSubs = $dbh->prepare($sqlSubs);

        try {
            $sthSubs->execute();
            $dbDgrs = $sthSubs->fetch(PDO::FETCH_ASSOC);
            if (!empty($dbDgrs)) {
                $fullname = '';
                if (isset($dbDgrs['dgr_firstname_']) && !empty($dbDgrs['dgr_firstname_'])) {
                    $fullname .= $dbDgrs['dgr_firstname_'];
                }
                if (isset($dbDgrs['dgr_lastname_']) && !empty($dbDgrs['dgr_lastname_'])) {
                    $fullname .= ' ' . $dbDgrs['dgr_lastname_'];
                }
            }
        } catch (Exception $e) {}

        /**
         * RECOMMANDATIONS
         */
        $config_list = SalesQuery::getConfigSalesListIdByListId($list_id, $dbh);
        $config_sales_list_id = !empty($config_list) ? $config_list : $list_id;

        $primary_list_id = $list_id;
        if(!$config_list) {
            $primary_list_id = SalesQuery::getConfigListIdBySalesListId($list_id, $dbh);
        }


        file_put_contents($log_path.$config_sales_list_id.'.log', var_export($params, 1)."\n\n", FILE_APPEND);
        file_put_contents($log_path.$config_sales_list_id.'.log', var_export($primary_list_id, 1)."\n\n", FILE_APPEND);

        if(isset($params['recommend'])) {
            $recommandation_type = $params['recommend'];

            $sqlU = "SELECT u.user_id
                    FROM users_ u
                    INNER JOIN lists_ l ON l.user_id = u.user_id
                    WHERE l.list_id = ? LIMIT 1";

            try {
                $sthU = $dbh->prepare($sqlU);
                $sthU->execute(array($list_id));
                $aResult = $sthU->fetch(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                file_put_contents($log_path.$config_sales_list_id.'.log', var_export($e->getMessage(), 1)."\n\n", FILE_APPEND);
                exit;
            }

            try {
                $profile = new ProfileInstance(array('user_id' => $aResult['user_id'], 'list_id' => $primary_list_id));
                $profile_to_sales_products_map = ConfigurationManager::getVariableValueByPriority(array('profile' => $profile, 'variable' => 'sales_products_attributes'));
            } catch ( Exception $e) {
                $profile_to_sales_products_map = array();
            }

            $nr_days_back = isset($params['nr_days_back']) ? $params['nr_days_back'] : 30;
            $sales_params = array(
                'limit' => isset($params['limit']) ? $params['limit'] : 2,
                'list_id' => $primary_list_id,
                'sales_list_id' => $config_sales_list_id,
                'email' => $email,
                'profile_to_sales_products_map' => $profile_to_sales_products_map,
                'nr_days_back' => $nr_days_back,
                'array_pr_ids' => $array_pr_ids,
                'emailid' => $emailid
            );

            // if($list_id == '4131' && $cmpg_id == '156123'){
            //     mail("sergio@whiteimage.ro","sales params", json_encode($sales_params));
            // }

            switch ($recommandation_type) {
                case '1': //recomandari produse in functie de cosul finalizat
                default:
                    $recommandations = SalesQuery::getSalesRecommandations($sales_params, $dbh);
                    if($list_id=='3275' || $list_id == '4131'){
                        //mail('gabi.stan@whiteimage.ro', 'json abandon', json_encode($command));
                       //mail('sergio@whiteimage.ro', 'json abandon', json_encode($command));
                    }
                    $command['recomandations'] = array_values($recommandations);
                    break;
                case '2': //recomandari produse ( ce au cumparat altii ) in functie de cele din cosul de cumparaturi
                    $sales_params['products'] = $command['products'];
                    $rec_by_type = salesQuery::getRecommandationsByType($dbh, $sales_params);
                    if (count($rec_by_type) > 0) $command['recommandations_by_type'] = array_values($rec_by_type);
                    break;
                case '1_2':
                    $command['recomandations'] = SalesQuery::getSalesRecommandations($sales_params, $dbh);
                    $sales_params['products'] = $command['products'];
                    $rec_by_type = salesQuery::getRecommandationsByType($dbh, $sales_params);
                    if (count($rec_by_type) > 0) $command['recommandations_by_type'] = array_values($rec_by_type);
                    break;
                case '3': //recomandari browse abandon
                    $sales_params['nr_days_back'] = 14;
                    $rec_by_type = salesQuery::getRecommandationsBrowseAbandon($dbh, $sales_params);
                    if (count($rec_by_type) > 0) $command['recommandations_by_type'] = array_values($rec_by_type);
                    break;
                case '4': //recomandari noutati Skinseen
                    $rec_by_type = salesQuery::getRecommandationsNewsSkinseen($dbh, $sales_params);
                    if (count($rec_by_type) > 0) $command['recommandations_by_type'] = array_values($rec_by_type);
                    break;
            }
        }
        /**
         * END RECOMMANDATIONS
         */

    //    if($list_id == 8235){
        // mail('catalin.paraschiva@whiteimage.ro', 'json abandon', json_encode($command));
        // file_put_contents($log_path.$config_sales_list_id.'.log', var_export($command, 1)."\n\n", FILE_APPEND);
    //    }

        //bestKIDS add tracking -> adauga o opinie
        /**
         * before si after trebuie setati ca paramentri la sync_cart
         */

        // track cart products URL
        // teste
        //if( !empty($command['products']) && ( $list_id == '3979' || $list_id == '4131' || $list_id == '3275' ) && ( $cmpg_id == '130307' || $cmpg_id == '156123' || $cmpg_id == '156121' || $cmpg_id == '156220' ) ){
        
        // file_put_contents($log_path.$config_sales_list_id.'.log', __LINE__. var_export($command, 1)."\n\n", FILE_APPEND);
        if( !empty($command['products']) ){
            //verify tracking for product rating
            if(!empty($params['before']) && !empty($params['after']) ){
                $before_link = $params['before'];
                $after_link  = $params['after'];
                $command['products']            = changeProductReccURLtoTracking('sync', $before_link, $after_link, $list_id, $cmpg_id, $command['products'], "emailid");
            }else{
                $command['products']            = changeProductReccURLtoTracking('sync', null, null, $list_id, $cmpg_id, $command['products'], "emailid");
            }
        }
        // file_put_contents($log_path.$config_sales_list_id.'.log', __LINE__. var_export($command, 1)."\n\n", FILE_APPEND);
        if ($list_id == '5205') {
            // mail('gabi.stan@whiteimage.ro', 'MRPICH yoy abandon' . __LINE__, json_encode($command));
        }
        // track product recomandations
        if( !empty($command['recomandations']) ){
            $command['recomandations']          = changeProductReccURLtoTracking('recc', null, null, $list_id, $cmpg_id, $command['recomandations'], "emailid");
        }
        // track product recommandations_by_type
        if( !empty($command['recommandations_by_type']) ){
            $command['recommandations_by_type'] = changeProductReccURLtoTracking('recc', null, null, $list_id, $cmpg_id, $command['recommandations_by_type'], "emailid");
        }

        $parameters            = array();
        $parameters['list_id'] = $list_id;
        $parameters['cmpg_id'] = $cmpg_id;
        $parameters['email_id']= $emailid;
        $parameters['email']   = $email;
        $parameters['command'] = $command;
        $parameters['fullname']= isset($fullname) ? $fullname : '';
        $parameters['tva']     = $TVA;
        $parameters['cmd_id']  = $cmd_id;
        $parameters['ts']      = date('Y-m-d H:i:s');
        $parameters['nr_produse']=$i-1;

        //test sergio products url
//        if($cmpg_id == "164321"){
//            mail('sergio@whiteimage.ro', 'produsele de tracking if', json_encode(
//                                                                                array(
//                                                                                    "rec_type" => $recommandation_type,
//                                                                                    "params" => $parameters
//                                                                                )
//                                                                            )
//            );
//        }
//        mail('sergio@whiteimage.ro', 'produsele de tracking if', json_encode(
//                                                                                array(
//                                                                                    "rec_type" => $recommandation_type,
//                                                                                    "params" => $parameters
//                                                                                )
//                                                                            )
//        );
        //mail('sergio@whiteimage.ro', 'params',  json_encode($parameters));
//        if(!empty($recommandations)){
//            mail('sergio@whiteimage.ro', 'abandon',  json_encode($recommandations));
//        }
        //end test sergio

        $template->assign('tranordid', $tranordid);
        }
    }else {

        $parameters = !empty($argv[8]) ? $argv[8] : '';
        // if ($list_id == '3907'|| $list_id == '4084'|| $list_id == '7090') {
        //     mail('catalin.paraschiva@whiteimage.ro','parameters '.__LINE__.' ###### '.__FILE__,json_encode($parameters));
        // }
        $parameters = unserialize(base64_decode($parameters));
        $tranordid = $parameters['tran_id'];

        //mail('sergio@whiteimage.ro', 'produsele de tracking else', json_encode($parameters));

        $template->assign('tranordid', $tranordid);
    }


    //mail('sergio@whiteimage.ro', 'Params', json_encode($parameters));
    //mail('catalin.paraschiva@whiteimage.ro','parameters '.__LINE__.' ###### '.__FILE__,json_encode($parameters));
    file_put_contents($log_path.$config_sales_list_id.'.log', var_export('reminder parameters:', 1)."\n\n", FILE_APPEND);
    file_put_contents($log_path.$config_sales_list_id.'.log', var_export($parameters, 1)."\n\n", FILE_APPEND);

    if(!empty($parameters)) {
        if (! empty($command['products'])) {
            if ($command['total'] != 0) $template->assign('total', $command['total']);
            $template->assign('currency', $currency);
        }


        foreach ($parameters as $key => $param) {
            $template->assign($key, $param);
        }
    }
    if ($list_id == '5216') {
        //mail('gabi.stan@whiteimage.ro', 'MRPICH yoy abandon' . __LINE__, json_encode($parameters) . " " . $email);
    }

    // if ($list_id == '3907'|| $list_id == '4084'|| $list_id == '7090') {
    //     mail('catalin.paraschiva@whiteimage.ro','parameters '.__LINE__.' ###### '.__FILE__,json_encode($parameters));
    //     mail('catalin.paraschiva@whiteimage.ro','parameters '.__LINE__.' ###### '.__FILE__,json_encode($command));
    // }
}

function superentities( $str ){
    // get rid of existing entities else double-escape
    $str = html_entity_decode(stripslashes($str),ENT_QUOTES,'UTF-8');
    $ar = preg_split('/(?<!^)(?!$)/u', $str );  // return array of every multi-byte character
    foreach ($ar as $c){
        $o = ord($c);
        if ( (strlen($c) > 1) || /* multi-byte [unicode] */
            ($o <32 || $o > 126) || /* <- control / latin weirdos -> */
            ($o >33 && $o < 40) ||/* quotes + ambersand */
            ($o >59 && $o < 63) /* html */
        ) {
            // convert to numeric entity
            $c = mb_encode_numericentity($c,array (0x0, 0xffff, 0, 0xffff), 'UTF-8');
        }
        $str2 .= $c;
    }
    return $str2;
}
?>