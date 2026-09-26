<?php
header('Access-Control-Allow-Origin: *');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $request = $_GET;
        break;
    case 'POST':
        $request = $_POST;
        break;
    default:
        exit;
}
/*if ((int) $request['list_id'] == 5891){
    mail('catalin.paraschiva@whiteimage.ro',__FILE__.' linia '.__LINE__,json_encode($request));
}*/
//if ((int) $request['list_id'] == 3666 && ($request['method'] == 'save')) {
//    //file_put_contents('/tmp/sorin.log', var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
//    file_put_contents('/tmp/sorin.log', print_r($request, true), FILE_APPEND);
//    //file_put_contents('/tmp/sorin.log', print_r(__FILE__, true), FILE_APPEND);
//    //mail("sergio@whiteimage.ro" , "subj" , "sssss");
//}

require_once(dirname(__FILE__) . '/../classes/service/subscriber/WI_Subscriber_Service_Config.php');
require_once(dirname(__FILE__) . '/../classes/service/subscriber/WI_Subscriber_Service.php');
require_once(dirname(__FILE__) . '/../classes/service/subscriber/WI_Subscriber_Service_Validation.php');
require_once(dirname(__FILE__) . '/../classes/service/subscriber/WI_Subscriber_Service_Response.php');
require_once(dirname(__FILE__) . '/../includes/config.inc.php');
require_once(dirname(__FILE__) . '/../includes/smtp.php');
require_once(dirname(__FILE__) . '/../includes/smarty_includes.php');
require_once(dirname(__FILE__) . '/../classes/WI_PDO.class.php');
require_once(dirname(__FILE__) . '/../includes/functions.php');
require_once(APP_ROOT . 'classes/WI_FAST_ACTIONS.php');
require_once(dirname(__FILE__) . '/../includes/getIp/getIp.php');
require_once(dirname(__FILE__) . '/../classes/wlm_sms_campaign.php');
require_once(dirname(__FILE__) . '/../classes/mobile/mobileSubscribers.php');

// WhatsApp module autoload — needed for the trigger hooks inside
// WI_Subscriber_Service to resolve. No-op if the module is not deployed.
$wa_autoload = dirname(__FILE__) . '/../whatsapp/vendor/autoload.php';
if (file_exists($wa_autoload)) {
    require_once($wa_autoload);
}
unset($wa_autoload);

try {
    $request['fv']['email'] = isset($request['fv']['email']) ? strtolower($request['fv']['email']) : '';
    $request['email'] = isset($request['email']) ? strtolower($request['email']) : '';

    $ss = new WI_Subscriber_Service($request);
    $ss->setDbh(WI_PDO::getInstance());
    $ss->setListId((int) $request['list_id']);
    $ss->setMethod($request['method']);

    $user_id = $ss->validateRequest();
    $ss->setReturnDataType(!empty($request['return_data_type']) ? $request['return_data_type'] : WI_Subscriber_Service_Config::SERVICE_RETURN_DATA_TYPE_JSON);
    $has_callback = $ss->validateReturnDataTypeDependencies();

    if ($has_callback) {
        $ss->setCallback($request['return_callback']);
    }

    define('WLM_COMMON_LIST_ID', $ss->getListId());

    //mail("sergio@whiteimage.ro", "found", "email");
    
        // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__, json_encode($request));  

    switch ($ss->getMethod()) {
        case WI_Subscriber_Service_Config::SERVICE_METHOD_COUNT:
            $ss->processMethodCount();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_COUNT_UNSUBSCRIBERS:
            $ss->processMethodCountUnsubscribers();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_DIRECT_SAVE;
            $ss->processMethodDirectSave(); // metoda care salveaza direct in baza de date, insert/update
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_SELECT;
            $ss->processMethodSelect();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_SAVE;
            $ss->processMethodSave(); // metoda care foloseste cURL si url-ul subscribe_general.php
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_SELECT_ONE;
            $ss->processMethodSelectOne();

            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_UPDATE; // metoda de UPDATE
            $ss->processMethodUpdate();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_UNSUBSCRIBE;
            $ss->processMethodUnsubscribe();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_RESUBSCRIBE;
            $ss->processMethodResubscribe();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_MOBILE_SAVE;
            $ss->processMethodMobileSave();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_APPEND;
            $ss->processMethodAppend();
            break;
            // NETLINX BEGIN
        case WI_Subscriber_Service_Config::SERVICE_METHOD_ANONYMIZE;
            $ss->processMethodAnonymize($user_id);
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_TRIGGER_LINK;
            $ss->processMethodTriggerLink();
            break;
            // NETLINX END
	case WI_Subscriber_Service_Config::SERVICE_METHOD_CREATE_SEGMENT;
            $ss->processMethodCreateSegment();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_REPORT_BY_SEGMENT;
            $ss->processMethodReportBySegment();
            break;
        case WI_Subscriber_Service_Config::SERVICE_METHOD_REPORT_BY_LIST;
            $ss->processMethodReportByList();
            break;
    }
} catch (Exception $e) {
    $ss->logError($e);

    if ($e instanceof PDOException) {
        // $ss->sendServiceResponse(0, $e->getMessage());
        $ss->sendServiceResponse(0, 'Service error #1!');
    } else {
        $ss->sendServiceResponse(0, $e->getMessage());
    }
}
