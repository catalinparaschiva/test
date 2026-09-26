<?php

class WI_Anonymize_Service
{
    private $request;
    private $dbh;
    private $method;
    private $email;
    private $list_id;
    private $user_id;
    private $notify_email;

    public function __construct($request)
    {
        $this->request = $request;
        $this->email = null;
        $this->list_id = null;
        $this->user_id = null;
        $this->method = null;
        $this->notify_email = isset($request['notify_email']) ? trim($request['notify_email']) : null;
    }

    public function setDbh($dbh)
    {
        $this->dbh = $dbh;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setEmail($email)
    {
        $this->email = strtolower(trim($email));
    }

    public function setListId($list_id)
    {
        $this->list_id = (int) $list_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = (int) $user_id;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getListId()
    {
        return $this->list_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function processAnonymization()
    {
        if ($this->method === WI_Anonymize_Service_Config::METHOD_ACCOUNT) {
            return $this->anonymizeAccount();
        } elseif ($this->method === WI_Anonymize_Service_Config::METHOD_LIST) {
            return $this->anonymizeList();
        }

        throw new Exception('Invalid anonymization method');
    }

    private function anonymizeAccount()
    {
        $output = array();
        $return_val = 0;

        $cmd = WI_Anonymize_Service_Config::ANONYM_ACCOUNT_SCRIPT .
               ' user_' . $this->user_id .
               ' ' . escapeshellarg($this->email) .
               ' 0 ' . escapeshellarg($this->notify_email) .
               ' 2>&1 &';

        exec($cmd, $output, $return_val);

        return $this->processAnonymizationResult($output, $return_val);
    }

    private function anonymizeList()
    {
        $output = array();
        $return_val = 0;

        $cmd = WI_Anonymize_Service_Config::ANONYM_LIST_SCRIPT .
               ' user_' . $this->user_id .
               ' list_id_' . $this->list_id .
               ' ' . escapeshellarg($this->email) .
               ' 0 ' . escapeshellarg($this->notify_email) .
               ' 2>&1 &';

        exec($cmd, $output, $return_val);

        return $this->processAnonymizationResult($output, $return_val);
    }

    private function processAnonymizationResult($output, $return_val)
    {
        if (!empty($output[0])) {
            return array(
                'code' => 1,
                'message' => 'User ' . $this->email . ' anonymized successfully',
                'method' => $this->method,
                'email' => $this->email,
            );
        }

        throw new Exception('Anonymization failed: email not found or access denied');
    }

    public function logOperation($status, $message)
    {
        $log_dir = dirname(__FILE__) . '/../logs/anonymize_service';

        if (!is_dir($log_dir)) {
            @mkdir($log_dir, 0755, true);
        }

        $log_file = $log_dir . '/' . date('Y-m-d') . '.log';
        $log_message = date('Y-m-d H:i:s') . ' | Status: ' . $status . ' | Email: ' . $this->email . ' | Method: ' . $this->method . ' | User: ' . $this->user_id . ' | Message: ' . $message . "\n";

        file_put_contents($log_file, $log_message, FILE_APPEND);
    }
}
?>
