<?php

class WI_Anonymize_Service_Validation
{
    private $request;
    private $dbh;

    public function __construct($request, $dbh = null)
    {
        $this->request = $request;
        $this->dbh = $dbh;
    }

    public function setDbh($dbh)
    {
        $this->dbh = $dbh;
    }

    public function validateServiceKey()
    {
        if (empty($this->request['service_key'])) {
            throw new Exception('Missing required parameter: service_key');
        }

        if (!is_string($this->request['service_key']) || strlen($this->request['service_key']) < 5) {
            throw new Exception('Invalid service_key format');
        }
    }

    public function validateMethod()
    {
        if (empty($this->request['method'])) {
            throw new Exception('Missing required parameter: method');
        }

        if (!in_array($this->request['method'], WI_Anonymize_Service_Config::VALID_METHODS)) {
            throw new Exception('Invalid method. Allowed values: ' . implode(', ', WI_Anonymize_Service_Config::VALID_METHODS));
        }
    }

    public function validateEmail()
    {
        if (empty($this->request['email'])) {
            throw new Exception('Missing required parameter: email');
        }

        $email = strtolower(trim($this->request['email']));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format');
        }

        return $email;
    }

    public function validateListId($method)
    {
        if ($method === WI_Anonymize_Service_Config::METHOD_LIST) {
            if (empty($this->request['list_id'])) {
                throw new Exception('Missing required parameter for method "list": list_id');
            }

            $list_id = (int) $this->request['list_id'];

            if ($list_id <= 0) {
                throw new Exception('Invalid list_id: must be a positive integer');
            }

            return $list_id;
        }

        return null;
    }

    public function validateServiceKeyAndGetUserId($list_id = null)
    {
        if (!$this->dbh) {
            throw new Exception('Database connection not available');
        }

        if ($list_id === null) {
            $sql = "SELECT DISTINCT a.user_id FROM users_ a
                    WHERE a.synkkey = ?
                    LIMIT 1";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array($this->request['service_key']));
        } else {
            $sql = "SELECT a.user_id
                    FROM users_ a
                    INNER JOIN lists_ b ON a.user_id = b.user_id
                    WHERE a.synkkey = ? AND b.list_id = ?";
            $sth = $this->dbh->prepare($sql);
            $sth->execute(array($this->request['service_key'], $list_id));
        }

        $user_id = $sth->fetchColumn();

        if (empty($user_id)) {
            throw new Exception('Invalid service_key or unauthorized access');
        }

        return $user_id;
    }
}
?>
