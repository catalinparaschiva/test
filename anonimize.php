<?php

if (stripos($_SERVER['PHP_SELF'], "anonymize.php") !== false) {
    header("Location: ../../index.php");
    exit;
}

if (defined('LISTID')) {
    
    $user_id = $_USER_INFO['user_id'];
    $whoami  = !empty($_SESSION['USER_INFO']['whoami']) ? $_SESSION['USER_INFO']['whoami'] : 0;        
    
    if (isset($_REQ_['search_x'])) {
        
        if (empty($_REQ_['email'])) {
            
            $msg_error = 'Please specify email address!';
            
        } elseif (!empty($_REQ_['notify']) && empty($_REQ_['notify_email'])) {
            
            $msg_error = 'Please specify email address for anonymization result!';
                    
        } else {
            
            $email = strtolower(trim($_REQ_['email']));
            
            $exists = 0; 
            
            if ($_REQ_['list_id'] > 0) {
                
                $list_id = preg_replace("/[^0-9]/", "", $_REQ_['list_id']);                

                if (!empty($_REQ_['notify'])) {
                    $notify_email = strtolower(trim($_REQ_['notify_email']));
                    exec('/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym.php user_' . $user_id . ' list_id_' . $list_id . ' ' . escapeshellarg($email) . ' ' . escapeshellarg($whoami) . ' ' . escapeshellarg($notify_email) . ' > /dev/null &');
                } else {
                    exec('/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym.php user_' . $user_id . ' list_id_' . $list_id . ' ' . escapeshellarg($email) . ' ' . escapeshellarg($whoami) . ' 2>&1 &', $output, $return_val);
                    $exists = (int)$output[0];
                }
                
            } else {
                
                if (!empty($_REQ_['notify'])) {
                    $notify_email = strtolower(trim($_REQ_['notify_email']));
                    exec('/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym_account.php user_' . $user_id . ' ' . escapeshellarg($email) . ' ' . escapeshellarg($whoami) . ' ' . escapeshellarg($notify_email) . ' > /dev/null &');
                } else {
                    exec('/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym_account.php user_' . $user_id . ' ' . escapeshellarg($email) . ' ' . escapeshellarg($whoami) . ' 2>&1 &', $output, $return_val);
                    $exists = (int)$output[0];
                }
            }
            
            if (empty($_REQ_['notify']) && !$exists) {
                $msg_error = 'Email address does not exists!';
            }
        }
    }
    
    $smarty->assign(array(
                            "my_lists"      => $my_lists,
                            "msg_error"     => !empty($msg_error) ? $msg_error : '',
                            "msg_success"   => $exists,
                        ));
    $center_file  = "../listsnew/templates/anonymize.tpl";
    
} else {
    
    $center_file = "redirect.tpl";
    $smarty->assign(array(
                            "redirect_url"	=> "index.php",
                            "message"		=> "no list selected",
                        ));
}

?>

