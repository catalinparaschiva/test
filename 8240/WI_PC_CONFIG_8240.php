<?php

namespace campaigns\product_content;

require_once(dirname(__FILE__) . "/../../WI_PC_CONFIG_COMMON.php");

class WI_PC_CONFIG extends WI_PC_CONFIG_COMMON
{
    static $list_id    = '8240'; //lista back in stock
    static $sales_list = '8239'; // the list you need to send to the API

    // If present and true we need to use built-in functions such as sitemap
    static $has_plugin = false;

    static $platform = '';
    
    static $magento_2 = false;
    static $shopify = false; 
    static $merchantpro = false; 

    // The data we need to send to the api_remote_urls
    static $fetch_by = 'remote_product_id'; // as is named in our database table cart.product_{$list_id}

    // Use this parameter to call the API
    static $call_by = 'product_id'; // as defined in the API

    static $api_remote_urls = array(
        1 => 'https://mobilaabc.ro/index.php?route=extension/module/whiteimage_sitemap_sync',
        18 => 'https://mobilaabc.ro/index.php?route=extension/module/whiteimage_sitemap_sync'
    );

    static $shop = '';
    static $acces_token="1ec8289ff50fff6480e49145098d1ef4";

    /** campurile json-ului intors de api-ul folosit pentru recomandari;
     * pot fi diferite fata de campurile remote din interfata web, unde se face asocierea manuala (Local and remote fields) */
    /*static $api_remote_fields = array(

    );*/
    /* campurile json-ului intors de api-ul folosit pentru recomandari;
     * pot fi diferite fata de campurile remote din interfata web, unde se face asocierea manuala (Local and remote fields) **/

//    static $local_fields = array(
//        'wi_pc_link_pagina' => 'Link page',
//        'wi_pc_link_imagine' => 'Link image',
//        'wi_pc_brand' => 'Brand',
//        'wi_pc_nume_produs' => 'Product name',
//        'wi_pc_price' => 'Price',
//        'wi_pc_special_price' => 'Special Price',
//        'wi_pc_discount_percent' => 'Discount Percent',
//        'wi_pc_category' => 'Category',
//        'wi_pc_rating' => 'Rating'
//    );

    // static $local_fields = array(
    //     'wi_pc_link_pagina' => 'Link pagina', // 0
    //     'wi_pc_link_imagine' => 'Link imagine', // 1
    //     'wi_pc_brand' => 'Brand', // 2
    //     'wi_pc_categorie' => 'Categorie', // 3
    //     'wi_pc_nume_produs' => 'Nume produs', // 4
    //     'wi_pc_pret_nou' => 'Pret nou', // 5
    //     'wi_pc_pret_vechi' => 'Pret vechi', // 6
    //     'wi_pc_reducere' => 'Procent reducere', // 7
    //     'wi_pc_caracteristici' => 'Caracteristici', // 8
    //     'wi_pc_descriere' => 'Descriere', // 9
    //     'wi_pc_rating' => 'Rating', // 10
    //     'wi_pc_top_review' => 'Top review', // 11
    //     'wi_pc_pret_special' => 'Pret cu reducere' // 12
    // );

    static $local_fields = array(
        'wi_pc_link_pagina' => 'Link pagina',
        'wi_pc_link_imagine' => 'Link imagine',
        'wi_pc_categorie' => 'Categorie',
        'wi_pc_nume_produs' => 'Nume produs',
        'wi_pc_pret' => 'Pret',
        'wi_pc_pret_special' => 'Pret special',
        'wi_pc_pret_final' => 'Pret final'  
    );


    static $remote_json_fields = array(
//        1 => array(
//            'url_pagina' => 'Link page',
//            'url_imagine' => 'Link image',
//            'brand' => 'Brand',
//            'nume_produs' => 'Product name',
//            'pret_nou' => 'Price',
//            'pret_vechi' => 'Special Price',
//            'procent_reducere' => 'Discount Percent',
//            'categorie' => 'Category',
//            'rating' => 'Rating'
//        ),
        1 => array(
            'product_url' => 'Link page',
            'image' => 'Link image',
            'name' => 'Product name',
            'price' => 'Price',
            'final_price' => 'Final Price',
            'special_price' => 'Special Price',
            'category' => 'Category'
        ),
        18 => array(
            'product_url',
            'image',
            'category',
            'name',
            'price',
            'final_price',
            'special_price'
        ),
        19 => array(
            'product_url',
            'image',
            'category',
            'name',
            'price',
            'final_price',
            'special_price'
        ),
        12 => array(
            'product_url',
            'image',
            'category',
            'name',
            'price',
            'final_price',
            'special_price'
        )
    );
// [[{"id":"36166","product_url":"https:\/\/www.litera.ro\/supersimplu-chimie-ghid-practic-de-studiu-pentru-scoala-si-acasa-cediv122","sku":"CEDIV122","category_id":"1|2|10476|22392|24463|24467","category":"Event list|Ziua cartilor pentru copii|Carti pentru copii 9 -12 ani|Atlase si enciclopedii","name":"Supersimplu. Chimie. Ghid practic de studiu pentru scoala si acasa","final_price":49.95,"special_price":49.95,"price":99.9,"image":"https:\/\/cdn.litera.ro\/media\/catalog\/product\/s\/u\/supersimplu_chimie.jpg","review_summary":"76","qty":49,"attributes":{"autori":"DK","msrp_display_actual_price_type":"Use config","price_type":false,"price":"99.900000","reducere":null,"special_price":"49.950000"}}]

    /** campurile json-ului intors de api-ul folosit pentru recomandari;
     * pot fi diferite fata de campurile remote din interfata web, unde se face asocierea manuala (Local and remote fields) */
    /*static $api_remote_fields = array(
        'image' => 'Imagine',
    );*/
    /* campurile json-ului intors de api-ul folosit pentru recomandari;
     * pot fi diferite fata de campurile remote din interfata web, unde se face asocierea manuala (Local and remote fields) **/

    
    static function getFocusProduct($params) {

        global $dbh;

        $list_id  = $params['list_id'];
        $email_id = $params['email_id'];

        $result = false;

        try {
            $dbh = \dbConnect::getInstanceByListId($params['list_id']);

            // $sql = "SELECT email_id, vp.url as focus_url, vp.img as focus_img, vp.category_id as focus_category_id, count(product_id) as total_vizite 
            //         FROM site_activity.visited_links_{$list_id} v JOIN site_activity.visited_products_{$list_id} vp USING(url_id)
            //         WHERE  v.visit_date >= CURRENT_DATE - interval '24 hour' 
            //             AND v.email_id = '{$email_id}'
            //         GROUP BY email_id, vp.url, vp.img, vp.category_id
            //         HAVING count(product_id) >= 2
            //         ORDER BY total_vizite DESC LIMIT 1";


            $sql = "SELECT url as focus_url, img as focus_img, category_id as focus_category_id 
                    FROM site_activity.visited_products_{$list_id} 
                    WHERE url_id IN
                        (SELECT vp.url_id
                        FROM site_activity.visited_links_{$list_id} v JOIN site_activity.visited_products_{$list_id} vp USING(url_id)
                        WHERE v.visit_date >= (CURRENT_DATE - interval '24 hour') 
                            AND v.email_id = {$email_id}
                        ORDER BY page_views DESC LIMIT 1)
                    LIMIT 1";

// mail('catalin.paraschiva@whiteimage.ro',__LINE__. ' *** '.__FILE__,$sql);
            $sth = $dbh->prepare($sql);
            $sth->execute();

            $result = $sth->fetchAll();
        } catch(Exception $e) {
            mail('dev@whiteimage.ro',__LINE__.' ###### '.__FILE__, json_encode($e->getMessage) );
        }

        return ($result) ? $result : false;
    }

    static function getSalesFocusProduct($params) {

        global $dbh;

        $list_id  = $params['list_id'];
        $sales_list_id = $params['sales_list_id'];
        $email_id = $params['email_id'];

        $result = false;

        try {
            $dbh = \dbConnect::getInstanceByListId($list_id);
            $sql = "SELECT sp.remote_product_id, sp.category_id
             FROM cart.product_" . $sales_list_id . " sp
             INNER JOIN subscribers_" . $list_id . " spa ON (sp.remote_product_id = spa.dgr_product_id_)
             WHERE emailid = $email_id";

// mail('catalin.paraschiva@whiteimage.ro',__LINE__. ' *** '.__FILE__,$sql);
            $sth = $dbh->prepare($sql);
            $sth->execute();

            $result = $sth->fetchAll();
        } catch(Exception $e) {
            mail('dev@whiteimage.ro',__LINE__.' ###### '.__FILE__, json_encode($e->getMessage) );
        }

        return ($result) ? $result : false;
    }
}