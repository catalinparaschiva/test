<?php

class WI_Subscriber_Service_Response
{
    public $code;
    public $message;
    public $timestamp;

    public static function send($obj, $return_data_type, $callback) {
        switch ($return_data_type) {
            case WI_Subscriber_Service_Config::SERVICE_RETURN_DATA_TYPE_JSONP:
                echo strip_tags($callback) . '(' . json_encode($obj) . ')';
                break;
            case WI_Subscriber_Service_Config::SERVICE_RETURN_DATA_TYPE_APPLICATION_JSON:
                header('Content-Type: application/json');
                echo json_encode($obj);
                break;
            default:
                echo json_encode($obj);
        }
        exit;
    }


    function __destruct() {
        //unset($this);
    }
}