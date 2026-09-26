<?php

class WI_Anonymize_Service_Response
{
    public static function send($code, $message, $data = array())
    {
        $response = array(
            'code' => (int) $code,
            'message' => $message,
        );

        if (!empty($data)) {
            $response = array_merge($response, $data);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        exit;
    }

    public static function success($message, $data = array())
    {
        self::send(1, $message, $data);
    }

    public static function error($message, $code = 0)
    {
        self::send($code, $message);
    }
}
?>
