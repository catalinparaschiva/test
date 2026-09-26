<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $request = $_GET;
        break;
    case 'POST':
        $request = $_POST;
        break;
    default:
        WI_Anonymize_Service_Response::error('Method not allowed', -1);
}

require_once(dirname(__FILE__) . '/WI_Anonymize_Service_Config.php');
require_once(dirname(__FILE__) . '/WI_Anonymize_Service.php');
require_once(dirname(__FILE__) . '/WI_Anonymize_Service_Validation.php');
require_once(dirname(__FILE__) . '/WI_Anonymize_Service_Response.php');

require_once(dirname(__FILE__) . '/../includes/config.inc.php');
require_once(dirname(__FILE__) . '/../classes/WI_PDO.class.php');

try {
    $validation = new WI_Anonymize_Service_Validation($request);

    // Validate required parameters
    $validation->validateServiceKey();
    $validation->validateMethod();
    $method = $request['method'];

    // Validate email
    $email = $validation->validateEmail();

    // Validate list_id if method is 'list'
    $list_id = $validation->validateListId($method);

    // Get database connection
    $dbh = WI_PDO::getInstance();
    $validation->setDbh($dbh);

    // Validate service key and get user_id
    $user_id = $validation->validateServiceKeyAndGetUserId($list_id);

    // Create service instance
    $anonymize_service = new WI_Anonymize_Service($request);
    $anonymize_service->setDbh($dbh);
    $anonymize_service->setMethod($method);
    $anonymize_service->setEmail($email);
    $anonymize_service->setUserId($user_id);

    if ($method === WI_Anonymize_Service_Config::METHOD_LIST) {
        $anonymize_service->setListId($list_id);
    }

    // Process anonymization
    $result = $anonymize_service->processAnonymization();

    // Log successful operation
    $anonymize_service->logOperation('SUCCESS', 'Anonymization completed');

    // Send response
    WI_Anonymize_Service_Response::success(
        $result['message'],
        array(
            'method' => $result['method'],
            'email' => $result['email'],
        )
    );

} catch (Exception $e) {
    // Log error
    if (isset($anonymize_service)) {
        $anonymize_service->logOperation('ERROR', $e->getMessage());
    }

    // Send error response
    WI_Anonymize_Service_Response::error($e->getMessage(), -1);
}
?>
