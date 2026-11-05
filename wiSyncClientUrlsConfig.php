<?php

/**
 * config list, url pentru json, limit de produse cerute
 * !ATENTIE
 * list_id trebuie sa fie cel al listei principale ( NU SALES_LIST_ID, in cazul in care este setat )
 */
$client_urls_config = array(
    //Exemplu magento
    3666 => array( //nu sterge, lista de test SILVIU
        'has_magento' => true,
        //'has_prestashop' => true,
        //'url_magento' => 'http://89.234.7.96/index.php/white/wlm/syncSitemapToWlmService', //se completeaza cu null daca clientul nu are magento integrat
        'url_magento'  => 'http://89.36.26.207:88/index.php/white/wlm/syncSitemapToWlmService',
        'url_general'  => null, // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81
        'method'       => 'post',
        'filters'      => 'basic',
        'limit'        => 10,
        'store_id'     => 1,
//        'local_fields' => array(
//            'wi_wsbus_remote_item_id'              => 'id',
//            'wi_wsbus_remote_item_url'             => 'url',
//            'wi_wsbus_remote_item_image'           => 'image',
//            'wi_wsbus_remote_item_sku'             => 'sku',
//            'wi_wsbus_remote_item_category'        => 'category',
//            'wi_wsbus_remote_item_category_id'     => 'category_id',
//            'wi_wsbus_remote_item_category_parent' => 'category_parent',
//            'wi_wsbus_remote_item_category_url'    => 'category_url',
//            'wi_wsbus_remote_item_title'           => 'title',
//            'wi_wsbus_remote_item_price'           => 'price',
//            'wi_wsbus_remote_item_oldprice'        => 'oldprice',
//            'wi_wsbus_remote_item_default_url'     => 'default_url',
//        ),
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
            'wi_mag_category_id'     => 'category_id',
            'wi_mag_category_parent' => 'category_parent',
            'wi_mag_category_url'    => 'category_url',
            //'wi_mag_color'           => 'color',
            //'wi_mag_new_attr'        => 'new_attr',
            //'wi_mag_new_attr2'       => 'new_attr2',
            //'wi_mag_new_morena'      => 'morena'
            //'wi_mag_reducere'        => 'discount',
            //'wi_mag_base_url'        => 'base_url',
            //'wi_mag_store'           => 'store_ids',
        ),
        'check_ip'    => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
    /* orig
    3666 => array( //nu sterge, lista de test SILVIU
        'has_magento' => false,
        'has_prestashop' => true,
        //'url_magento' => 'http://89.234.7.96/index.php/white/wlm/syncSitemapToWlmService', //se completeaza cu null daca clientul nu are magento integrat
        'url_magento' => null,
        'url_general' => 'http://silviupresta.7w.ro:81/modules/whiteplatform/cron-white.php', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 10,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina' => 'product_url',
            'wi_mag_link_imagine' => 'image',
            'wi_mag_sku' => 'sku',
            'wi_mag_categorie' => 'category',
            'wi_mag_nume_produs' => 'name',
            'wi_mag_pret_nou' => 'price',
            'wi_mag_pret_vechi' => 'special_price',
            //'wi_mag_reducere' => 'discount',
            //'wi_mag_base_url' => 'base_url',
            //'wi_mag_store' => 'store_ids',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),*/
    3865 => array(
        'has_magento' => true,
        'url_magento' => 'http://stagenoriel.evozon.com/index.php/white/wlm/syncSitemapToWlmService', //se completeaza cu null daca clientul nu are magento integrat
        'url_general' => null, // se completeaza cu null daca clientul are magento integrat
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 25,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product' => 'product_url',
            'wi_mag_link_imagine' => 'image',
            'wi_mag_sku' => 'sku',
            'wi_mag_categorie' => 'category',
            'wi_mag_nume_produs' => 'name',
            'wi_mag_pret_nou' => 'price',
            'wi_mag_pret_special' => 'special_price',
            'wi_mag_base_url' => 'base_url',
            'wi_mag_store' => 'store_ids',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true,
        'stores' => array(1 => '', 2 => 'bebe/')
    ),
    2009 => array(
        'has_magento' => true,
        'url_magento' => 'http://www.noriel.ro/index.php/white/wlm/syncSitemapToWlmService', //se completeaza cu null daca clientul nu are magento integrat
        'url_general' => null, // se completeaza cu null daca clientul are magento integrat
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 25,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product' => 'product_url',
            'wi_mag_link_imagine' => 'image',
            'wi_mag_sku' => 'sku',
            'wi_mag_categorie' => 'category',
            'wi_mag_nume_produs' => 'name',
            'wi_mag_pret_nou' => 'price',
            'wi_mag_pret_special' => 'special_price',
            'wi_mag_base_url' => 'base_url',
            'wi_mag_store' => 'store_ids',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true,
        'stores' => array(1 => '', 2 => 'bebe/')
    ),
    3029 => array(
        'has_magento' => true,
        'url_magento' => 'https://www.dpap.ro/index.php/white/wlm/syncSitemapToWlmService', //se completeaza cu null daca clientul nu are magento integrat
        'url_general' => null, // se completeaza cu null daca clientul are magento integrat
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 25,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product' => 'product_url',
            'wi_mag_sku' => 'sku',
            'wi_mag_categorie' => 'category',
            'wi_mag_nume_produs' => 'name',
            'wi_mag_pret_nou' => 'price',
            'wi_mag_pret_special' => 'special_price',
            'wi_mag_base_url' => 'base_url',
            'wi_mag_url_path' => 'url_path',
            'wi_mag_discontinued' => 'discontinued',
            'wi_mag_disabled' => 'disabled'
        ),
        'wi_attributes' => array(
            'wi_wsbus_discontinued' => 'discontinued',
            'wi_wsbus_disabled' => 'disabled'
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
    3289 => array(
        'has_magento' => false,
        'url_magento' => null, //se completeaza cu null daca clientul nu are magento integrat
        'url_general' => 'https://www.b-mall.ro/whiteimage/wsbus.php', // se completeaza cu null daca clientul are magento integrat
        'token' => '3ae32123eea9fe36c712',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 100, //limita maxima
        'local_fields' => array(
            'wi_wsbus_remote_item_id' => 'id',
            'wi_wsbus_remote_item_url' => 'product_url',
            'wi_wsbus_remote_item_image' => 'image',
            'wi_wsbus_remote_item_sku' => 'sku',
            'wi_wsbus_remote_item_category' => 'category',
            'wi_wsbus_remote_item_title' => 'name',
            'wi_wsbus_remote_item_price' => 'special_price',
            'wi_wsbus_remote_item_oldprice' => 'price',
            'wi_wsbus_remote_item_default_url' => 'default_product_url',
        ),
        'wi_attributes' => array(
            'wi_wsbus_attribute_age' => 'age',
            'wi_wsbus_attribute_gender' => 'gender',
            'wi_wsbus_attribute_brand' => 'brand'
        )
    ),
    3275 => array(
        'has_magento' => false,
        'url_magento' => null, //se completeaza cu null daca clientul nu are magento integrat
        'url_general' => 'http://5.2.199.111:5680/WebAPI_Basic/products/', // se completeaza cu null daca clientul are magento integrat
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 100, //limita maxima
        'local_fields' => array(
            'wi_wsbus_remote_item_id' => 'id',
            'wi_wsbus_remote_item_url' => 'product_url',
            'wi_wsbus_remote_item_image' => 'image',
            'wi_wsbus_remote_item_sku' => 'sku',
            'wi_wsbus_remote_item_category' => 'category',
            'wi_wsbus_remote_item_title' => 'name',
            'wi_wsbus_remote_item_price' => 'price',
            'wi_wsbus_remote_item_special_price' => 'special_price',
            /*'wi_wsbus_remote_item_default_url' => 'default_product_url',*/
        )/*,
        'wi_attributes' => array(
            'wi_wsbus_attribute_age' => 'age',
            'wi_wsbus_attribute_gender' => 'gender',
            'wi_wsbus_attribute_brand' => 'brand'
        )*/,
        'methods' => array(
            'count' => 'WIProductsCount',
            'get' => 'WIGetProductsPaging',
            'getProduct' => 'WIGetProduct'
        ),
        'params' => array(
            'login' => array(
                'user_name' => 'WhiteImage',
                'password' => 'W6yh5Tg'
            ),
            'getProduct' => array(
                'request_data' => array(
                    'item_id' => '%s'
                )
            ),

            'count' => array(),
            'get' => array(
                "request_data" => array(
                    "limit" => '50',
                    "page" => '%d'

                )
            )
        )
    ),
//    4042 => array(
//        'has_magento' => true,
//        'url_magento' => 'http://www.otter.ro/index.php/white/wlm/syncSitemapToWlmService', //se completeaza cu null daca clientul nu are magento integrat
//        'url_general' => null, // se completeaza cu null daca clientul are magento integrat
//        'method' => 'post',
//        'filters' => 'basic',
//        'limit' => 20,
//        'local_fields' => array(
//            'wi_mag_remote_product_id' => 'id',
//            'wi_mag_link_product' => 'product_url',
//            'wi_mag_link_imagine' => 'image',
//            'wi_mag_sku' => 'sku',
//            'wi_mag_categorie' => 'category',
//            'wi_mag_nume_produs' => 'name',
//            'wi_mag_pret_nou' => 'price',
//            'wi_mag_pret_special' => 'special_price',
//            'wi_mag_base_url' => 'base_url',
//            'wi_mag_store' => 'store_ids',
//        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true
//    ),
    4042 => array( // otter
        'has_magento'  => true,
        'url_magento'  => 'http://www.otter.ro/whitesyncnew/sync/syncSitemapToWlmService?', //se completeaza cu null daca clientul nu are magento integrat
        'url_general'  => null, // se completeaza cu null daca clientul are magento integrat
        'method'       => 'post',
        'filters'      => 'basic',
        'limit'        => 20,
        'store_id'     => 2,
        'list_id'      => 4042,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product'      => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_special'      => 'special_price',
            'wi_mag_base_url'          => 'base_url',
            'wi_mag_store'             => 'store_ids',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
    5070 => array( // salamander
        'has_magento'  => true,
        'url_magento'  => 'https://www.salamandershop.ro/whitesyncnew/sync/syncSitemapToWlmService?', //se completeaza cu null daca clientul nu are magento integrat
        'url_general'  => null, // se completeaza cu null daca clientul are magento integrat
        'method'       => 'post',
        'filters'      => 'basic',
        'limit'        => 20,
        'store_id'     => 1,
        'list_id'      => 5070,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product'      => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_special'      => 'special_price',
            'wi_mag_base_url'          => 'base_url',
            'wi_mag_store'             => 'store_ids',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
    5216 => array( // salamander
        'has_magento'  => true,
        'url_magento'  => 'https://www.salamandershop.ro/index.php/whitesyncnew/sync/syncSitemapToWlmService?', //se completeaza cu null daca clientul nu are magento integrat
        'url_general'  => null, // se completeaza cu null daca clientul are magento integrat
        'method'       => 'post',
        'filters'      => 'basic',
        'limit'        => 20,
        'store_id'     => 1,
        'list_id'      => 5216,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product'      => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_special'      => 'special_price',
            'wi_mag_base_url'          => 'base_url',
            'wi_mag_store'             => 'store_ids',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
    4067 => array( // ALDO
        'has_magento'  => true,
        'url_magento'  => 'https://www.aldoshoes.com.ro/index.php/whitesyncnew/sync/syncSitemapToWlmService?', //se completeaza cu null daca clientul nu are magento integrat
        'url_general'  => null, // se completeaza cu null daca clientul are magento integrat
        'method'       => 'post',
        'filters'      => 'basic',
        'limit'        => 20,
        'store_id'     => 1,
        'list_id'      => 4067,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product'      => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_special'      => 'special_price',
            'wi_mag_base_url'          => 'base_url',
            'wi_mag_store'             => 'store_ids',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
    4609 => array( // Tezyo
        'has_magento'  => true,
        'url_magento'  => 'https://www.tezyo.ro/index.php/whitesyncnew/sync/syncSitemapToWlmService?', //se completeaza cu null daca clientul nu are magento integrat
        'url_general'  => null, // se completeaza cu null daca clientul are magento integrat
        'method'       => 'post',
        'filters'      => 'basic',
        'limit'        => 20,
        'store_id'     => 3,
        'list_id'      => 4609,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_product'      => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_special'      => 'special_price',
            'wi_mag_base_url'          => 'base_url',
            'wi_mag_store'             => 'store_ids',
            'wi_qty'                   => 'qty',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
//    4067 => array(
//        'has_magento' => true,
//        'url_magento' => 'http://www.aldoshoes.com.ro/index.php/white/wlm/syncSitemapToWlmService', //se completeaza cu null daca clientul nu are magento integrat
//        'url_general' => null, // se completeaza cu null daca clientul are magento integrat
//        'method' => 'post',
//        'filters' => 'basic',
//        'limit' => 20,
//        'local_fields' => array(
//            'wi_mag_remote_product_id' => 'id',
//            'wi_mag_link_product' => 'product_url',
//            'wi_mag_link_imagine' => 'image',
//            'wi_mag_sku' => 'sku',
//            'wi_mag_categorie' => 'category',
//            'wi_mag_nume_produs' => 'name',
//            'wi_mag_pret_nou' => 'price',
//            'wi_mag_pret_special' => 'special_price',
//            'wi_mag_base_url' => 'base_url',
//            'wi_mag_store' => 'store_ids',
//        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true
//    ),
    382 => array( //dona
        'has_magento' => false,
        'has_prestashop' => true,
        'url_magento' => null,
        'url_general' => 'http://www.donaonline.ro/modules/whiteplatform/cron-white.php', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 20,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina' => 'product_url',
            'wi_mag_link_imagine' => 'image',
            'wi_mag_sku' => 'sku',
            'wi_mag_categorie' => 'category',
            'wi_mag_nume_produs' => 'name',
            'wi_mag_pret_nou' => 'price',
            'wi_mag_pret_vechi' => 'special_price',
            //'wi_mag_reducere' => 'discount',
            //'wi_mag_base_url' => 'base_url',
            //'wi_mag_store' => 'store_ids',
        )
    ),
    4659 => array( //dona
        'has_magento' => false,
        'has_prestashop' => true,
        'url_magento' => null,
        'url_general' => 'http://www.dentstore.ro/modules/whiteplatform/cron-white2.php', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 20,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina' => 'product_url',
            'wi_mag_link_imagine' => 'image',
            'wi_mag_sku' => 'sku',
            'wi_mag_categorie' => 'category',
            'wi_mag_nume_produs' => 'name',
            'wi_mag_pret_nou' => 'price',
            'wi_mag_pret_vechi' => 'special_price',
            //'wi_mag_reducere' => 'discount',
            //'wi_mag_base_url' => 'base_url',
            //'wi_mag_store' => 'store_ids',
        )
    ),
    5041 => array( // TESTS, only works if called by .EU, see the url_general for details
        'has_magento' => false,
        'has_prestashop' => false,
        'url_magento' => null,
        'multi_language' => true,
        'url_general' => 'http://whiteimage.net/clients/wlm/SCRIPTS/sync_site_map.php?method=get',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 40,
        'local_fields' => array(
            'wi_wsbus_remote_product_id' => 'id',
            'wi_wsbus_link_pagina' => 'product_url',
            'wi_wsbus_link_imagine' => 'image',
            'wi_wsbus_sku' => 'sku',
            'wi_wsbus_categorie' => 'category',
            'wi_wsbus_catid' => 'category_id',
            'wi_wsbus_nume_produs' => 'name',
            'wi_wsbus_pret_nou' => 'price',
            'wi_wsbus_pret_special' => 'special_price',
        ),
    ),
    5205 => array( // MRPICH EN
        'has_magento' => false,
        'has_prestashop' => false,
        'url_magento' => null,
        'multi_language' => true,
        'url_general' => 'https://www.mrpich.com/index.php?route=module/whitesync/sync_sitemap',
        'method' => 'post',
        'list_id' => 5202,
        'filters' => 'basic',
        'limit' => 40,
        'local_fields' => array(
            'wi_wsbus_remote_product_id' => 'id',
            'wi_wsbus_link_pagina' => 'product_url',
            'wi_wsbus_link_imagine' => 'image',
            'wi_wsbus_sku' => 'sku',
            'wi_wsbus_categorie' => 'category',
            'wi_wsbus_catid' => 'category_id',
            'wi_wsbus_nume_produs' => 'name',
            'wi_wsbus_pret_nou' => 'price',
            'wi_wsbus_pret_special' => 'special_price',
        ),
    ),
    5203 => array( // MRPICH RO
        'has_magento' => false,
        'has_prestashop' => false,
        'url_magento' => null,
        'multi_language' => true,
        'url_general' => 'https://www.mrpich.com/index.php?route=module/whitesync/sync_sitemap',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 40,
        'list_id' => 5201,
        'local_fields' => array(
            'wi_wsbus_remote_product_id' => 'id',
            'wi_wsbus_link_pagina' => 'product_url',
            'wi_wsbus_link_imagine' => 'image',
            'wi_wsbus_sku' => 'sku',
            'wi_wsbus_categorie' => 'category',
            'wi_wsbus_catid' => 'category_id',
            'wi_wsbus_nume_produs' => 'name',
            'wi_wsbus_pret_nou' => 'price',
            'wi_wsbus_pret_special' => 'special_price',
        ),

    ),
    5202 => array( // MRPICH EN
        'has_magento' => false,
        'has_prestashop' => false,
        'url_magento' => null,
        'multi_language' => true,
        'url_general' => 'https://www.mrpich.com/index.php?route=module/whitesync/sync_sitemap',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 40,
        'local_fields' => array(
            'wi_wsbus_remote_product_id' => 'id',
            'wi_wsbus_link_pagina' => 'product_url',
            'wi_wsbus_link_imagine' => 'image',
            'wi_wsbus_sku' => 'sku',
            'wi_wsbus_categorie' => 'category',
            'wi_wsbus_nume_produs' => 'name',
            'wi_wsbus_pret_nou' => 'price',
            'wi_wsbus_pret_special' => 'special_price',
        )
    ),
    5201 => array( // MRPICH RO
        'has_magento' => false,
        'has_prestashop' => false,
        'url_magento' => null,
        'multi_language' => true,
        'url_general' => 'https://www.mrpich.com/index.php?route=module/whitesync/sync_sitemap',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 40,
        'local_fields' => array(
            'wi_wsbus_remote_product_id' => 'id',
            'wi_wsbus_link_pagina' => 'product_url',
            'wi_wsbus_link_imagine' => 'image',
            'wi_wsbus_sku' => 'sku',
            'wi_wsbus_categorie' => 'category',
            'wi_wsbus_catid' => 'category_id',
            'wi_wsbus_nume_produs' => 'name',
            'wi_wsbus_pret_nou' => 'price',
            'wi_wsbus_pret_special' => 'special_price',
        ),

    ),
    5212 => array( //
        'has_magento' => true,
        'has_prestashop' => false,
        'url_magento' => 'http://89.36.26.207:88/whitesyncnew/sync/syncSitemapToWlmService?', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 5212,
        'limit' => 10,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),
    4118 => array( // Melkior.ro
        'has_magento' => false,
        'has_prestashop' => true,
        'url_magento' => null,
        'token' => 'eXOLpDfBJIyLeeMy96Jy',
        'url_general' => 'http://www.melkior.ro/modules/whiteplatform/cron-white.php',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 20,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
            'wi_mag_rating'            => 'rating',
            'wi_mag_top_review'        => 'top_review'
        )
    ),


    5442 => array( // Zazaboutique
        'has_magento' => true,
        'has_prestashop' => false,
        'url_magento' => 'https://www.zazaboutique.ro/whitesyncnew/sync/syncSitemapToWlmService?', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 5442,
        'limit' => 10,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),

    
    4773 => array( // Mattca
        'has_magento' => true,
        'has_prestashop' => false,
        'url_magento' => 'https://www.mattca.ro/whitesyncnew/sync/syncSitemapToWlmService?', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 4773,
        'limit' => 10,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),

    
    5473 => array( // Nicoro
        'has_magento' => true,
        'has_prestashop' => false,
        'url_magento' => 'https://www.nicoro.ro/whitesyncnew/sync/syncSitemapToWlmService?', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 5473,
        'limit' => 10,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),

    5544 => array( // MAGENTO TEST
        'has_magento' => true,
        'has_prestashop' => false,
        'url_magento' => 'http://magento.whiteimage.biz/whitesyncnew/sync/syncSitemapToWlmService?', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 5544,
        'limit' => 10,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
        'check_ip' => '212.100.229.24|85.204.225.228',
        'check_ip_force' => true
    ),

    5440 => array( // Zorile Store
        'has_magento' => false,
        'has_prestashop' => false,
        'url_magento' => null,
        'multi_language' => true,
        'url_general' => '...........',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 40,
        'local_fields' => array(
            'wi_wsbus_remote_product_id' => 'id',
            'wi_wsbus_link_pagina' => 'product_url',
            'wi_wsbus_link_imagine' => 'image',
            'wi_wsbus_sku' => 'sku',
            'wi_wsbus_categorie' => 'category',
            'wi_wsbus_catid' => 'category_id',
            'wi_wsbus_nume_produs' => 'name',
            'wi_wsbus_pret_nou' => 'price',
            'wi_wsbus_pret_special' => 'special_price',
        ),
    ),
    3760 => array( // FASHIONUP
        'has_magento' => false,
        'has_prestashop' => false,
        'url_magento' => null,
        'multi_language' => true,
        'url_general' => 'https://www.fashionup.ro/libs/whiteimage/whiteimage_sync_sitemap.php?',
        'method' => 'post',
        'filters' => 'basic',
        'limit' => 100,
        'local_fields' => array(
            'wi_wsbus_remote_product_id' => 'id',
            'wi_wsbus_link_pagina' => 'product_url',
            'wi_wsbus_link_imagine' => 'image',
            'wi_wsbus_sku' => 'sku',
            'wi_wsbus_categorie' => 'category',
            'wi_wsbus_catid' => 'category_id',
            'wi_wsbus_nume_produs' => 'name',
            'wi_wsbus_pret' => 'price',
            'wi_wsbus_color' => 'color',
            'wi_wsbus_brand' => 'brand',
        )

    ),

    1955 => array( //FLANCO
        'has_magento' => true,
        'has_prestashop' => false,
        'url_magento' => 'https://www.flanco.ro/whitesyncnew/sync/syncSitemapToWlmService?', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 368,
        'list_id'  => 1955,
        'limit' => 50,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true
    ),

    6481 => array( //CONTAKT
        'has_magento' => true,
        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
        'has_prestashop' => false,
        'url_magento' => 'https://www.contakt.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'acces_token'=>'n1eetujxj95e9sj4od3s2pxjpamd9b48',
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 6481,
        'limit' => 100,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true
        'methods' => array(
            'count' => 'count',
            'get' => 'products',
            'getProduct' => 'product'
        ),
        'params' => array(
            'product' => array(
                'request_data' => array(
                    'item_id' => '%s'
                )
            ),

            'count' => array(),
            'get' => array(
                "request_data" => array(
                    "limit" => '50',
                    "page" => '%d'

                )
            )
        )
    ),

    6471 => array( //TEST INCOGNITO
        'has_magento' => true,
        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
        'has_prestashop' => false,
        'url_magento' => 'http://wi.inco.tech/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'acces_token'=>'t7b9mw7026hhak0j2b9fyrvrcv3dmkcq',
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 6471,
        'limit' => 1,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true

        'methods' => array(
            'count' => 'count',
            'get' => 'products',
            'getProduct' => 'product'
        ),
        'params' => array(
            'product' => array(
                'request_data' => array(
                    'item_id' => '%s'
                )
            ),

            'count' => array(),
            'get' => array(
                "request_data" => array(
                    "limit" => '50',
                    "page" => '%d'

                )
            )
        )
    ),

    7042 => array( //LITERA
        'has_magento' => true,
        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
        'has_prestashop' => false,
        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_magento' => 'https://www.litera.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'acces_token'=>'hfv533ncjuthnhq72r1rmv9iearerskx',
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 7042,
        'limit' => 1,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
        
        'wi_attributes' => array(
            'wi_mag_attribute_autori' => 'autori',
        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true

        'methods' => array(
            'count' => 'count',
            'get' => 'products',
            'getProduct' => 'product'
        ),
        'params' => array(
            'product' => array(
                'request_data' => array(
                    'item_id' => '%s'
                )
            ),

            'count' => array(),
            'get' => array(
                "request_data" => array(
                    "limit" => '50',
                    "page" => '%d'

                )
            )
        )
    ),

    7129 => array( //BRANDGSM
        'has_magento' => true,
        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
        'has_prestashop' => false,
        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_magento' => 'https://www.brandgsm.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'acces_token'=>'6bddm8floqbxmzj2x2gyt3xpo61gisn6',
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 7129,
        'limit' => 1,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true

        'methods' => array(
            'count' => 'count',
            'get' => 'products',
            'getProduct' => 'product'
        ),
        'params' => array(
            'product' => array(
                'request_data' => array(
                    'item_id' => '%s'
                )
            ),

            'count' => array(),
            'get' => array(
                "request_data" => array(
                    "limit" => '50',
                    "page" => '%d'

                )
            )
        )
    ),

    5748 => array( //BRICODEPOT
        'has_magento' => true,
        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
        'has_prestashop' => false,
        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        'url_magento' => 'https://www.bricodepot.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
        // 'acces_token'=>'k5hsv2qcwz4rui9vjteofnwbp4kiqciu',
        'acces_token'=>'3bp0y8nmh6aj6qfyh15k1ydl8cjswrug',
        'url_general' => null,
        'method' => 'post',
        'filters' => 'basic',
        'store_id' => 1,
        'list_id'  => 5748,
        'limit' => 1,
        'local_fields' => array(
            'wi_mag_remote_product_id' => 'id',
            'wi_mag_link_pagina'       => 'product_url',
            'wi_mag_link_imagine'      => 'image',
            'wi_mag_sku'               => 'sku',
            'wi_mag_categorie'         => 'category',
            'wi_mag_categorie_id'      => 'category_id',
            'wi_mag_nume_produs'       => 'name',
            'wi_mag_pret_nou'          => 'price',
            'wi_mag_pret_vechi'        => 'special_price',
        ),
        
        'wi_attributes' => array(
            'wi_mag_attribute_autori' => 'autori',
        ),
//        'check_ip' => '212.100.229.24|85.204.225.228',
//        'check_ip_force' => true

        'methods' => array(
            'count' => 'count',
            'get' => 'products',
            'getProduct' => 'product'
        ),
        'params' => array(
            'product' => array(
                'request_data' => array(
                    'item_id' => '%s'
                )
            ),

            'count' => array(),
            'get' => array(
                "request_data" => array(
                    "limit" => '50',
                    "page" => '%d'

                )
            )
        )
                ),

        7602 => array( // optiblu
            'has_magento' => false,
            'has_prestashop' => false,
            'url_magento' => null,
            'multi_language' => true,
            'url_general' => '...........',
            'method' => 'post',
            'filters' => 'basic',
            'limit' => 40,
            'local_fields' => array(
                'wi_wsbus_remote_product_id' => 'id',
                'wi_wsbus_link_pagina' => 'product_url',
                'wi_wsbus_link_imagine' => 'image',
                'wi_wsbus_sku' => 'sku',
                'wi_wsbus_categorie' => 'category',
                'wi_wsbus_catid' => 'category_id',
                'wi_wsbus_nume_produs' => 'name',
                'wi_wsbus_pret_nou' => 'price',
                'wi_wsbus_pret_special' => 'special_price',
            ),
        ),

        7603 => array( // optiplaza
            'has_magento' => false,
            'has_prestashop' => false,
            'url_magento' => null,
            'multi_language' => true,
            'url_general' => '...........',
            'method' => 'post',
            'filters' => 'basic',
            'limit' => 40,
            'local_fields' => array(
                'wi_wsbus_remote_product_id' => 'id',
                'wi_wsbus_link_pagina' => 'product_url',
                'wi_wsbus_link_imagine' => 'image',
                'wi_wsbus_sku' => 'sku',
                'wi_wsbus_categorie' => 'category',
                'wi_wsbus_catid' => 'category_id',
                'wi_wsbus_nume_produs' => 'name',
                'wi_wsbus_pret_nou' => 'price',
                'wi_wsbus_pret_special' => 'special_price',
            ),
        ),

        7813 => array( // geomag
            'has_magento' => false,
            'has_prestashop' => false,
            'url_magento' => null,
            'multi_language' => true,
            'url_general' => '...........',
            'method' => 'post',
            'filters' => 'basic',
            'limit' => 40,
            'local_fields' => array(
                'wi_wsbus_remote_product_id' => 'id',
                'wi_wsbus_link_pagina' => 'product_url',
                'wi_wsbus_link_imagine' => 'image',
                'wi_wsbus_sku' => 'sku',
                'wi_wsbus_categorie' => 'category',
                'wi_wsbus_catid' => 'category_id',
                'wi_wsbus_nume_produs' => 'name',
                'wi_wsbus_pret_nou' => 'price',
                'wi_wsbus_pret_special' => 'special_price',
            ),
        ),

        5083 => array( //CORINT
            'has_magento' => true,
            'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
            'has_prestashop' => false,
            // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
            'url_magento' => 'https://edituracorint.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
            // 'acces_token'=>'k5hsv2qcwz4rui9vjteofnwbp4kiqciu',
            'acces_token'=>'mtw7w9ohde6grvavvvthty39velmo7r7',
            'url_general' => null,
            'method' => 'post',
            'filters' => 'basic',
            'store_id' => 1,
            'list_id'  => 5083,
            'limit' => 1,
            'local_fields' => array(
                'wi_mag_remote_product_id' => 'id',
                'wi_mag_link_pagina'       => 'product_url',
                'wi_mag_link_imagine'      => 'image',
                'wi_mag_sku'               => 'sku',
                'wi_mag_categorie'         => 'category',
                'wi_mag_categorie_id'      => 'category_id',
                'wi_mag_nume_produs'       => 'name',
                'wi_mag_pret_nou'          => 'price',
                'wi_mag_pret_vechi'        => 'special_price',
            ),
            
            'wi_attributes' => array(
                'wi_mag_attribute_autori' => 'autori',
            ),
    //        'check_ip' => '212.100.229.24|85.204.225.228',
    //        'check_ip_force' => true
    
            'methods' => array(
                'count' => 'count',
                'get' => 'products',
                'getProduct' => 'product'
            ),
            'params' => array(
                'product' => array(
                    'request_data' => array(
                        'item_id' => '%s'
                    )
                ),
    
                'count' => array(),
                'get' => array(
                    "request_data" => array(
                        "limit" => '50',
                        "page" => '%d'
    
                    )
                )
            )
                    ),
                    7895 => array( //NITELASHOP
                        'has_magento' => true,
                        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_magento' => 'https://nitelashop.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        // 'acces_token'=>'k5hsv2qcwz4rui9vjteofnwbp4kiqciu',
                        'acces_token'=>'errwnxhrzu9r5edzp54baof5bxiemzxo',
                        'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 7895,
                        'limit' => 1,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'product_url',
                            'wi_mag_link_imagine'      => 'image',
                            'wi_mag_sku'               => 'sku',
                            'wi_mag_categorie'         => 'category',
                            'wi_mag_categorie_id'      => 'category_id',
                            'wi_mag_nume_produs'       => 'name',
                            'wi_mag_pret_nou'          => 'price',
                            'wi_mag_pret_vechi'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'item_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),
                    7928 => array( //HAUZEN
                        'has_magento' => true,
                        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_magento' => 'https://hauzen.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        // 'acces_token'=>'k5hsv2qcwz4rui9vjteofnwbp4kiqciu',
                        'acces_token'=>'7ajted24gcqwoahsztar10kbnolu904i',
                        'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 7928,
                        'limit' => 1,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'product_url',
                            'wi_mag_link_imagine'      => 'image',
                            'wi_mag_sku'               => 'sku',
                            'wi_mag_categorie'         => 'category',
                            'wi_mag_categorie_id'      => 'category_id',
                            'wi_mag_nume_produs'       => 'name',
                            'wi_mag_pret_nou'          => 'price',
                            'wi_mag_pret_vechi'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'item_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),

                    5775 => array( //DONAONLINE
                        'has_magento' => false,
                        'has_magento_2' => false, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_magento' => 'https://donaonline.ro/index.php?route=extension/module/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 5775,
                        'limit' => 1,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'product_url',
                            'wi_mag_link_imagine'      => 'image',
                            'wi_mag_sku'               => 'sku',
                            'wi_mag_categorie'         => 'category',
                            'wi_mag_categorie_id'      => 'category_id',
                            'wi_mag_nume_produs'       => 'name',
                            'wi_mag_pret_nou'          => 'price',
                            'wi_mag_pret_vechi'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'getProduct&product_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "products" => ''
                
                                )
                            )
                        )
                                ),

                    8104 => array( //SKINSEEN
                          'has_magento' => false,
                        'has_magento_2' => false, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        'has_shopify' => true,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_general' => 'https://skinseen.whiteimage.eu/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'acces_token'=>'123456789',
                        'shop' => 'skinseen1.myshopify.com',
                        // 'url_general' => null,
                        'method' => 'post',
                        'method_split' => [
                            'get' => 'get',
                            'count' => 'get',
                            'getCats' => 'get',
                            'getProduct' => 'post'
                        ],
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 8104,
                        'sales_list_id'  => 8111,
                        'limit' => 100,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'product_url',
                            'wi_mag_link_imagine'      => 'image',
                            'wi_mag_sku'               => 'sku',
                            'wi_mag_categorie'         => 'category',
                            'wi_mag_categorie_id'      => 'category_id',
                            'wi_mag_nume_produs'       => 'name',
                            'wi_mag_pret_nou'          => 'price',
                            'wi_mag_pret_vechi'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'product_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),

                    8111 => array( //SKINSEEN //mermeleala facuta sa incerc pc_populate type 12 pentru lista de vanzari
                          'has_magento' => false,
                        'has_magento_2' => false, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        'has_shopify' => true,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_general' => 'https://skinseen.whiteimage.eu/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'acces_token'=>'123456789',
                        'shop' => 'skinseen1.myshopify.com',
                        // 'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 8111,
                        'sales_list_id'  => 8111,
                        'limit' => 1,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'product_url',
                            'wi_mag_link_imagine'      => 'image',
                            'wi_mag_sku'               => 'sku',
                            'wi_mag_categorie'         => 'category',
                            'wi_mag_categorie_id'      => 'category_id',
                            'wi_mag_nume_produs'       => 'name',
                            'wi_mag_pret_nou'          => 'price',
                            'wi_mag_pret_vechi'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'product_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),

                    8234 => array( //Pepetti
                        'has_magento' => true,
                        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_magento' => 'https://www.papetti.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        // 'acces_token'=>'k5hsv2qcwz4rui9vjteofnwbp4kiqciu',
                        'acces_token'=>'idd06i8j6bmomn9stmh5qkxrwa90tgtf',
                        'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 8234,
                        'limit' => 1,
                        'local_fields' => array(
                            'id' => 'id',
                            'link'       => 'product_url',
                            'image_link'      => 'image',
                            'id'               => 'sku',
                            'product_type'         => 'category',
                            'title'       => 'name',
                            'price'          => 'price',
                            'price'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'item_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),
                                
                    8404 => array( //hippo
                        'has_magento' => true,
                        'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_magento' => 'https://hippoland.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'acces_token'=>'5yepo1tyi8yd1ey4bdfawagzm9yfrit8',
                        'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 8404,
                        'limit' => 1,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'link',
                            'wi_mag_link_imagine'      => 'image_link',
                            'wi_mag_sku'               => 'id',
                            'wi_mag_categorie'         => 'product_type',
                            'wi_mag_nume_produs'       => 'title',
                            'wi_mag_pret_nou'          => 'price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'item_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),
                                
                    8443 => array( //MKD MEDICALE
                          'has_magento' => false,
                        'has_magento_2' => false, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        'has_shopify' => false,
                        'has_merchantpro' => true,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_general' => 'https://whiteimage.mangusta.pro/api/v1/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'acces_token'=>'d16319343ba5b31aae5f20577d7d0adae1b6c3af0a2723bd4a2a17da3a5c9784',
                        'store' => 'www.mkd-medicale.ro',
                        // 'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 8443,
                        'sales_list_id'  => 8452,
                        'limit' => 1,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'product_url',
                            'wi_mag_link_imagine'      => 'image',
                            'wi_mag_sku'               => 'sku',
                            'wi_mag_categorie'         => 'category',
                            'wi_mag_categorie_id'      => 'category_id',
                            'wi_mag_nume_produs'       => 'name',
                            'wi_mag_pret_nou'          => 'price',
                            'wi_mag_pret_vechi'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'product_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),
                                
                    8415 => array( //PILOT BOOKS
                          'has_magento' => false,
                        'has_magento_2' => false, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                        'has_prestashop' => false,
                        'has_shopify' => false,
                        'has_merchantpro' => true,
                        // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'url_general' => 'https://whiteimage.mangusta.pro/api/v1/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                        'acces_token'=>'d16319343ba5b31aae5f20577d7d0adae1b6c3af0a2723bd4a2a17da3a5c9784',
                        'store' => 'www.pilotbooks.ro',
                        // 'url_general' => null,
                        'method' => 'post',
                        'filters' => 'basic',
                        'store_id' => 1,
                        'list_id'  => 8415,
                        'sales_list_id'  => 8422,
                        'limit' => 1,
                        'local_fields' => array(
                            'wi_mag_remote_product_id' => 'id',
                            'wi_mag_link_pagina'       => 'product_url',
                            'wi_mag_link_imagine'      => 'image',
                            'wi_mag_sku'               => 'sku',
                            'wi_mag_categorie'         => 'category',
                            'wi_mag_categorie_id'      => 'category_id',
                            'wi_mag_nume_produs'       => 'name',
                            'wi_mag_pret_nou'          => 'price',
                            'wi_mag_pret_vechi'        => 'special_price',
                        ),
                        
                        // 'wi_attributes' => array(
                        //     'wi_mag_attribute_autori' => 'autori',
                        // ),
                //        'check_ip' => '212.100.229.24|85.204.225.228',
                //        'check_ip_force' => true
                
                        'methods' => array(
                            'count' => 'count',
                            'get' => 'products',
                            'getProduct' => 'product'
                        ),
                        'params' => array(
                            'product' => array(
                                'request_data' => array(
                                    'product_id' => '%s'
                                )
                            ),
                
                            'count' => array(),
                            'get' => array(
                                "request_data" => array(
                                    "limit" => '50',
                                    "page" => '%d'
                
                                )
                            )
                        )
                                ),

            8303 => array( //EDITURA PARALELA 45
                'has_magento' => true,
                'has_magento_2' => true, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                'has_prestashop' => false,
                // 'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                'url_magento' => 'https://www.edituraparalela45.ro/rest/V1/whiteimage/', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                'acces_token'=>'yingys1f7vkxpp2xmacim9mdkivvvgqk',
                'url_general' => null,
                'method' => 'post',
                'filters' => 'basic',
                'store_id' => 1,
                'list_id'  => 8303,
                'limit' => 1,
                'local_fields' => array(
                    'wi_mag_remote_product_id' => 'id',
                    'wi_mag_link_pagina'       => 'product_url',
                    'wi_mag_link_imagine'      => 'image',
                    'wi_mag_sku'               => 'sku',
                    'wi_mag_categorie'         => 'category',
                    'wi_mag_categorie_id'      => 'category_id',
                    'wi_mag_nume_produs'       => 'name',
                    'wi_mag_pret_nou'          => 'price',
                    'wi_mag_pret_vechi'        => 'special_price',
                ),
                
                'wi_attributes' => array(
                    'wi_mag_attribute_autori' => 'autori',
                ),
        //        'check_ip' => '212.100.229.24|85.204.225.228',
        //        'check_ip_force' => true

                'methods' => array(
                    'count' => 'count',
                    'get' => 'products',
                    'getProduct' => 'product'
                ),
                'params' => array(
                    'product' => array(
                        'request_data' => array(
                            'item_id' => '%s'
                        )
                    ),

                    'count' => array(),
                    'get' => array(
                        "request_data" => array(
                            "limit" => '50',
                            "page" => '%d'

                        )
                    )
                )
            ),

            8240 => array( //Mobila abc
                'has_magento' => false,
                'has_magento_2' => false, // se completeaza doar pentru site-urile cu MAGENTO 2 cu plugin de le noi
                'has_prestashop' => false,
                'url_magento' => '', // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                'url_general' => "https://mobilaabc.ro/index.php?route=extension%2Fmodule%2Fwhiteimage_sitemap_sync", // se completeaza cu null daca clientul are magento integrat 89.36.26.207:81,
                'acces_token'=>'1ec8289ff50fff6480e49145098d1ef4',
                'method' => 'post',
                'filters' => 'basic',
                'store_id' => 1,
                'list_id'  => 8240,
                'limit' => 1,
                'local_fields' => array(
                    'wi_mag_remote_product_id' => 'id',
                    'wi_mag_link_pagina'       => 'product_url',
                    'wi_mag_link_imagine'      => 'image',
                    'wi_mag_sku'               => 'sku',
                    'wi_mag_categorie'         => 'category',
                    'wi_mag_categorie_id'      => 'category_id',
                    'wi_mag_nume_produs'       => 'name',
                    'wi_mag_pret_nou'          => 'price',
                    'wi_mag_pret_vechi'        => 'special_price',
                ),
                
                'wi_attributes' => array(
                    'wi_mag_attribute_autori' => 'autori',
                ),
        //        'check_ip' => '212.100.229.24|85.204.225.228',
        //        'check_ip_force' => true

                'methods' => array(
                    'count' => 'count',
                    'get' => 'get',
                    'getProduct' => 'getProduct'
                ),
                'params' => array(
                    'product' => array(
                        'request_data' => array(
                            'item_id' => '%s'
                        )
                    ),
                    'count' => array(),
                    'get' => array(
                        "request_data" => array(
                            "limit" => '50',
                            "page" => '%d'

                        )
                    )
                )
            ),
);

$default_methods = array(
    'count' => 'count',
    'get' => 'get',
    'getProduct' => 'getProduct'
);

//'id', 'url_path', 'image', 'sku', 'category', 'name', 'price', 'base_url', 'product_url', 'special_price'
//http://qanoriel.evozon.com/index.php/white/wlm/syncSitemapToWlmService?method=get&check_ip_force=1&limit=50&page=1&filters=basic&local_fields=a:9:{s:17:"wi_pc_link_pagina";s:8:"url_path";s:18:"wi_pc_link_imagine";s:5:"image";s:11:"wi_pc_brand";s:9:"thumbnail";s:15:"wi_pc_categorie";s:8:"category";s:17:"wi_pc_nume_produs";s:4:"name";s:14:"wi_pc_pret_nou";s:5:"price";s:16:"wi_pc_pret_vechi";s:9:"old_price";s:14:"wi_pc_reducere";s:8:"discount";s:15:"wi_pc_descriere";s:11:"description";}