<?php

use Whiteimage\Entity\Subscriber as SubscriberEntity;

class WI_Subscriber_Service
{
    private $request;
    private $list_id;
    private $emailid;
    private $email;
    private $phone_number;
    private $method;
    private $dbh;
    private $return_data_type;
    private $callback;


    public function __construct($request)
    {
        $this->request = $this->fara_diacritice($request);
        if ($_SERVER['REMOTE_ADDR'] == '81.181.193.130') {
            // mail('gabi.stan@whiteimage.ro', 'TELCOR', json_encode($request));
        }
        file_put_contents(dirname(__FILE__) . "/../../../logs/service/subscriber_service/" . intval($request['list_id']) . ".log", date('Y-m-d G:i:s') . " [WI_Subscriber_Service::__construct]: " . print_r($this->request, true), FILE_APPEND);

        // ----------------------------------------------------task NN de logat informatiile intr-un fisier csv -> de facut functie separata in viitor pentru ca nu este deloc ok sa punem codul aici ( alex b) ///// seriously?!!!!!!!
        //VPC

        //versiunea veche
        /*if(intval($request['list_id'])==4784){
            //add  newline
            //build row
            if(!file_exists("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv")){
                file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv","EMAIL_ID,EMAIL_CODE,EMAIL_ADDRESS,REGISTRATION_NUMBER,FIRST_NAME,LAST_NAME,DATE OF ACTIVATION,CNP,PACKAGE,PACKAGE PRICE,ACCOUNT NUMBER,BENEFICIARY INFO,BEN NAME 1,BEN SURNAME 1,BEN CNP1,BEN PERCENT 1,BEN NAME 2,BEN SURNAME 2,BEN CNP2,BEN PERCENT 2,BEN NAME 3,BEN SURNAME 3,BEN CNP3,BEN PERCENT 3,CONTRACT_NUMBER,Line"."\n" , FILE_APPEND);
            }

            $vpc = $request['fv']['id'] . "," . "VPC" . "," .$request['fv']['email']. "," . $request['fv']['registration_number'] . "," . $request['fv']['firstname'] . "," . $request['fv']['lastname'] . "," . $request['fv']['date_of_activation'] . "," .
                $request['fv']['cnp'] . "," . $request['fv']['package'] . "," . $request['fv']['package_price'] . "," . $request['fv']['account_number'] . "," . $request['fv']['beneficiary_info'] . "," . $request['fv']['ben_name1'] . "," . $request['fv']['ben_surname1'] . "," . $request['fv']['ben_cnp1'] . "," . $request['fv']['ben_percent1'] . "," . $request['fv']['ben_name2'] . "," . $request['fv']['ben_surname2'] . "," . $request['fv']['ben_cnp2'] . "," . $request['fv']['ben_percent2'] . "," . $request['fv']['ben_name3'] . "," . $request['fv']['ben_surname3'] . "," . $request['fv']['ben_cnp3'] . "," . $request['fv']['ben_percent3'] . "," . $request['fv']['contract_number'] . "," . $request['fv']['line'];
            $vpc_utf16=iconv("UTF-8","UTF-16",$vpc);
            //write in file row
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv", $vpc_utf16, FILE_APPEND);
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv", "\n", FILE_APPEND);
        }*/

        if (intval($request['list_id']) == 4784) {
            //add  newline
            //build row
            if (!file_exists("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv")) {
                file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv", "EMAIL_ID,EMAIL_CODE,EMAIL_ADDRESS,REGISTRATION_NUMBER,FIRST_NAME,DATE OF ACTIVATION,PACKAGE,PACKAGE PRICE,ACCOUNT NUMBER,BENEFICIARY INFO,BEN NAME 1,BEN SURNAME 1,BEN PERCENT 1,BEN NAME 2,BEN SURNAME 2,BEN PERCENT 2,BEN NAME 3,BEN SURNAME 3,BEN PERCENT 3,DOCUMENT_NAME,DOCUMENT_CONTENT,SUM_INSURED_A,SUM_INSURED_I" . "\n", FILE_APPEND);
            }

            $vpc = $request['fv']['id'] . "," . "VPC" . "," . $request['fv']['email'] . "," . $request['fv']['registration_number'] . "," . $request['fv']['firstname'] . "," . $request['fv']['date_of_activation'] . "," . $request['fv']['package'] . "," . $request['fv']['package_price'] . "," . $request['fv']['account_number'] . "," . $request['fv']['beneficiary_info'] . "," . $request['fv']['ben_name1'] . "," . $request['fv']['ben_surname1'] . "," . $request['fv']['ben_percent1'] . "," . $request['fv']['ben_name2'] . "," . $request['fv']['ben_surname2'] . "," . $request['fv']['ben_percent2'] . "," . $request['fv']['ben_name3'] . "," . $request['fv']['ben_surname3'] . "," . $request['fv']['ben_percent3'] . "," . $request['fv']['document_name'] . "," . $request['fv']['document_content'] . "," . $request['fv']['sum_insured_a'] . "," . $request['fv']['sum_insured_i'];
            $vpc_utf16 = iconv("UTF-8", "UTF-16", $vpc);
            //write in file row
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv", $vpc_utf16, FILE_APPEND);
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpc_files/TEST_VPC_" . date('Ymd') . ".csv", "\n", FILE_APPEND);
        }

        //VPO
        if (intval($request['list_id']) == 4786) {
            if (!file_exists("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpo_files/TEST_VPO_" . date('Ymd') . ".csv")) {
                file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpo_files/TEST_VPO_" . date('Ymd') . ".csv", "EMAIL_ID,EMAIL_CODE,EMAIL_ADDRESS,REGISTRATION_NUMBER,FIRST_NAME,LAST_NAME,PACKAGE" . "\n", FILE_APPEND);
            }
            $vpo = $request['fv']['id'] . "," . "VPO" . "," . $request['fv']['email'] . "," . $request['fv']['registration_number'] . "," . $request['fv']['firstname'] . "," . $request['fv']['lastname'] . "," . $request['fv']['package'];
            $vpo_utf16 = iconv("UTF-8", "UTF-16", $vpo);
            //write in file row
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpo_files/TEST_VPO_" . date('Ymd') . ".csv", $vpo_utf16, FILE_APPEND);
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpo_files/TEST_VPO_" . date('Ymd') . ".csv", "\n", FILE_APPEND);
        }

        //VPM
        if (intval($request['list_id']) == 4785) {
            if (!file_exists("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpm_files/TEST_VPM_" . date('Ymd') . ".csv")) {
                file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpm_files/TEST_VPM_" . date('Ymd') . ".csv", "EMAIL_ID,EMAIL_CODE,EMAIL_ADDRESS,REGISTRATION_NUMBER,FIRST_NAME,LAST_NAME,PACKAGE,CNP,CONTRACT_NUMBER,BEN NAME 1,BEN SURNAME 1,BEN CNP1,BEN PERCENT 1,BEN NAME 2,BEN SURNAME 2,BEN CNP2,BEN PERCENT 2,BEN NAME 3,BEN SURNAME 3,BEN CNP3,BEN PERCENT 3,DATE OF ACTIVATION" . "\n", FILE_APPEND);
            }
            $vpm = $request['fv']['id'] . "," . "VPM" . "," . $request['fv']['email'] . "," . $request['fv']['registration_number'] . "," . $request['fv']['firstname'] . "," . $request['fv']['lastname'] . "," . $request['fv']['package'] . "," . $request['fv']['cnp'] . "," .
                $request['fv']['contract_number'] . ","  . $request['fv']['ben_name1'] . "," . $request['fv']['ben_surname1'] . "," . $request['fv']['ben_cnp1'] . "," . $request['fv']['ben_percent1'] . "," . $request['fv']['ben_name2'] . "," . $request['fv']['ben_surname2'] . "," . $request['fv']['ben_cnp2'] . "," . $request['fv']['ben_percent2'] . "," . $request['fv']['ben_name3'] . "," . $request['fv']['ben_surname3'] . "," . $request['fv']['ben_cnp3'] . "," . $request['fv']['ben_percent3'] . "," . $request['fv']['date_of_activation'];
            $vpm_utf16 = iconv("UTF-8", "UTF-16", $vpm);
            //write in file row
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpm_files/TEST_VPM_" . date('Ymd') . ".csv", $vpm_utf16, FILE_APPEND);
            file_put_contents("/var/www/html/clients/wlm/cron/special_procedures/ing/trimiteri_contractuale/service/vpm_files/TEST_VPM_" . date('Ymd') . ".csv", "\n", FILE_APPEND);
        }
        // ----------------------------------------------END TASK NN---------------
        //mail("sergio@whiteimage.ro", "found", "email");
    }


    public function setReturnDataType($return_data_type)
    {
        $this->return_data_type = $return_data_type;
    }


    public function validateRequest()
    {
        $ssv = new WI_Subscriber_Service_Validation($this->request);

        $ssv->validateListId();

        $ssv->validateServiceKey();
        $sql = "SELECT a.user_id 
                FROM   users_ a
                       INNER JOIN lists_ b ON a.user_id = b.user_id
                WHERE  a.synkkey = ? AND b.list_id = ?";
        $sth = $this->dbh->prepare($sql);
        $sth->execute(array($this->request['service_key'], $this->list_id));
        $user_id = $sth->fetchColumn();
        if (empty($user_id)) {
            throw (new Exception('Required parameter [service_key] mismatch!'));
        }

        $ssv->validateMethod();

        return $user_id;
    }


    public function validateReturnDataTypeDependencies()
    {
        $ssv = new WI_Subscriber_Service_Validation($this->request);

        $ssv->validateReturnDataTypeDependencies($this->return_data_type);

        return $ssv->has_callback;
    }


    public function setRequest($request)
    {
        $this->request = $request;
    }


    public function setListId($list_id)
    {
        $this->list_id = $list_id;
    }


    public function setMethod($method)
    {
        $this->method = $method;
    }


    public function setCallback($callback)
    {
        $this->callback = strip_tags($callback);
    }


    public function sendServiceResponse($code, $message, array $extra_response_attr = array())
    {
        $obj = new stdClass();
        $obj->code = $code;
        $obj->message = $message;

        foreach ($extra_response_attr as $key => $val) {
            $obj->$key = $val;
        }

        WI_Subscriber_Service_Response::send($obj, $this->return_data_type, $this->callback);
    }


    public function logError($e)
    {
        $file_partname = !empty($this->list_id) ? $this->list_id : 'general';

        file_put_contents(dirname(__FILE__) . "/../../../logs/service/subscriber_service/" . $file_partname . ".log", date('Y-m-d H:i:s') . "\n emailid: " . $this->emailid . "\nFile: " . __FILE__ . " \n Line: " . __LINE__ .  " \n SQL Error message: " . $e->getMessage() .  " \n SQL Error line: " . $e->getLine() . " \n SQL Trace: \n\n  " . print_r($e->getTrace(), true) . "\n\n", FILE_APPEND);
    }


    public function setDbh($dbh)
    {
        $this->dbh = $dbh;
    }


    public function getListId()
    {
        return $this->list_id;
    }


    public function getMethod()
    {

        return $this->method;
    }

    public function getRequest()
    {
        return $this->request;
    }


    public function processMethodCount()
    {
        $prepared = $this->prepareWhereSql();

        $sql = "SELECT count(*) as cnt FROM subscribers_" . $this->list_id . " WHERE" . $prepared->where_sql;

        $sth = $this->dbh->prepare($sql);

        foreach ($prepared->arr_for_bind as $key => $value) {
            $sth->bindValue($key, $value, PDO::PARAM_STR);
        }

        $sth->execute();

        $this->sendServiceResponse(1, 'Number of subscribers', array('count' => $sth->fetchColumn()));
    }

    public function processMethodCountUnsubscribers()
    {
        $prepared = $this->prepareWhereSql();

        $sql = "SELECT count(*) as cnt FROM unsubscribe.subscribers_" . $this->list_id . " WHERE" . $prepared->where_sql;

        $sth = $this->dbh->prepare($sql);

        foreach ($prepared->arr_for_bind as $key => $value) {
            $sth->bindValue($key, $value, PDO::PARAM_STR);
        }

        $sth->execute();

        $this->sendServiceResponse(1, 'Number of unsubscribers', array('count' => $sth->fetchColumn()));
    }


    public function validateMethodSelectDependencies()
    {
        $ssv = new WI_Subscriber_Service_Validation($this->request);

        $ssv->validateMethodSelectDependencies();
    }


    public function processMethodSelect()
    { // TODO de creat clasa separata
        
        $this->validateMethodSelectDependencies();

        $lfs = $this->getDbExistingListFields();

        /***** validate and create selected_fields ***/
        $request_return_fields = !empty($this->request['return_fields']) ? $this->request['return_fields'] : 'email';


        if ($request_return_fields == 'all') {
            $prepared_fields_for_sql_arr = $this->getPreparedFieldsForSqlFormat(array('fields' => $lfs, 'lfs' => $lfs, 'with_sql_alias' => true));
        } else {
            $request_return_fields = explode('|', $request_return_fields);
            $prepared_fields_for_sql_arr = $this->getPreparedFieldsForSqlFormat(array('fields' => $request_return_fields, 'lfs' => $lfs, 'with_sql_alias' => true));
        }

        $selected_fields_sql = implode(',', $prepared_fields_for_sql_arr);
        /*** validate selected_fields *****/
        
        $prepared = $this->prepareWhereSql();

        $sql = "SELECT " . $selected_fields_sql .  ", emailid, subscribe_status FROM subscribers_" . $this->list_id . " WHERE" . $prepared->where_sql . " ORDER BY emailid DESC OFFSET :offset LIMIT :limit";

        $sth = $this->dbh->prepare($sql);

        foreach ($prepared->arr_for_bind as $key => $value) {
            $sth->bindValue($key, $value, PDO::PARAM_STR);
        }

        $sth->bindValue(':offset', $this->request['offset'], PDO::PARAM_INT);
        $sth->bindValue(':limit', $this->request['limit'], PDO::PARAM_INT);

        $sth->execute();

        $subscribers = $sth->fetchAll(PDO::FETCH_OBJ);

        if (($this->request['limit'] == 1) && isset($subscribers[0])) {
            $this->sendServiceResponse(1, 'Number of subscribers', array('count' => count($subscribers), 'subscriber' => $subscribers[0]));
        } else {
            $this->sendServiceResponse(1, 'Number of subscribers', array('count' => count($subscribers), 'subscribers' => $subscribers));
        }
    }


    public function processMethodSelectOne()
    {
        $this->request['offset'] = 0;
        $this->request['limit'] = 1;

        $this->processMethodSelect();
    }


    public function validateMethodDirectSaveDependencies()
    {
        $ssv = new WI_Subscriber_Service_Validation($this->request);

        $ssv->validateMethodDirectSaveDependencies();
    }


    public function processMethodDirectSave()
    {
        $arr = $this->doSave();

        $this->sendServiceResponse($arr[0], $arr[1]);
    }

    public function doSave()
    {
        $this->validateMethodDirectSaveDependencies();

        $lfs = $this->getDbExistingListFields();

        $request_fields_values = $this->fara_diacritice($this->request['fv']);

        foreach ($request_fields_values as $key => $value) {
            if (($key != 'email') && !in_array($key, $lfs)) {
                // unset($request_fields_values[$key]);
                $forbidden_columns = array("dgr_emailid_", "dgr_email_", "dgr_subscribe_status_", "dgr_unsubscribe_status_", "dgr_mail_type_", "dgr_soft_bounce_back_", "dgr_hard_bounce_back_", "dgr_join_date_", "dgr_unsubscribe_date_", "dgr_optin_date_", "dgr_optout_date_", "dgr_stampip_", "dgr_remoteid_", "dgr_newsletter_", "dgr_stamptime_", "dgr_validcode_", "dgr_flag_invite_", "dgr_invite_date_", "dgr_stampipconfirm_", "dgr_trigger_unsub_obt1_", "dgr_trigger_unsub_obt2_", "dgr_trigger_unsub_obt3_", "dgr_trigger_unsub_obt4_", "dgr_auto_unsubscribe_", "dgr_status_sync_", "dgr_r_", "dgr_f_", "dgr_m_", "dgr_sm_details_");

                if (!in_array("dgr_" . $key . "_", $forbidden_columns)) {
                    try {
                        $this->dbh->query("BEGIN");

                        $sql = "INSERT INTO lists_fields_(list_id, fieldname, fieldtitle, fieldtype, formfieldtype, fieldmandatory, capitalizat) VALUES('" . $this->list_id . "', '" . formatSTR(strtolower(trim($key))) . "', '" . formatSTR(trim($key)) . "', 'character varying(255)', 'text', '0', '0')";
                        $insert = $this->dbh->prepare($sql);
                        $insert->execute();

                        $table = 'subscribers_' . $this->list_id;
                        $column = "dgr_" . strtolower(trim($key)) . "_";
                        $schemas = array('public', 'subscribers', 'bounce', 'unsubscribe', 'survey');
                        foreach ($schemas as $schema) {
                            if (wlmUtils::tableExists($schema, $table) && !wlmUtils::columnExists($schema, $table, $column)) {
                                $query = "ALTER TABLE " . $schema . '.' . $table . " ADD COLUMN " . $column . " varchar(255)";
                                $alter = $this->dbh->prepare($query);
                                $alter->execute();
                            }
                        }

                        $this->dbh->query("COMMIT");
                    } catch (Exception $e) {
                        $this->dbh->query("ROLLBACK");
                        // throw $e;
                        throw (new Exception('Subscriber not saved!'));
                    }
                }
            }
        }

        // if (count($request_fields_values) == 1) { throw(new Exception('Subscriber insert: all fields (other then email) are empty!')); }

        $prepared_fields_for_sql_arr = $this->getPreparedFieldsForSqlFormat(array('fields' => $request_fields_values, 'lfs' => $lfs));

        $email = $request_fields_values['email'];

        $has_unique_violation = false;

        $test = "SELECT email from subscribers_" . $this->list_id . " where email='" . $email . "'";
        $sth2 = $this->dbh->prepare($test);
        $sth2->execute();
        $db_email = $sth2->fetchColumn();

        if ($db_email != $email) {
            try {
                $sql = "INSERT INTO subscribers_" . $this->list_id . " (" . implode(",", array_keys($prepared_fields_for_sql_arr)) . ",join_date,optin_date,subscribe_status) VALUES (" . implode(', ', array_pad(array(), count($prepared_fields_for_sql_arr), '?')) . ",CURRENT_DATE,CURRENT_DATE,'confirmed') RETURNING emailid";

                $sth = $this->dbh->prepare($sql);

                $sth->execute(array_values($prepared_fields_for_sql_arr));
                $this->emailid = $sth->fetchColumn();

                if ($sth->rowCount() == 1) {
                    if ($this->list_id == '6041') {

                        exec("php /var/www/html/clients/wlm/utile/clients/toyota/insert_or_update_into_biz.php " . $this->list_id . " " . $this->emailid . " > /dev/null 2>&1 &");
                    }
                    if ($this->list_id == '6214') {

                        exec("php /var/www/html/clients/wlm/utile/clients/toyota/insert_or_update_into_biz.php " . $this->list_id . " " . $this->emailid . " > /dev/null 2>&1 &");
                    }
                    if ($this->list_id == '6003'|| $this->list_id == '8505') {
                        sleep(5);
                        exec("php /var/www/html/clients/wlm/utile/clients/toyota/insert_or_update_into_biz.php " . $this->list_id . " " . $this->emailid . " > /dev/null 2>&1 &");
                    }
                    //implementare pentru a trimite datele in timp real si catre TOYOTA-VALORIS-wizz
                    if (in_array($this->list_id, ['5988','5989','5997','5998','6002','6113','6266','6480','6506','6726','6727','6787','7204','6890','6824','6825','6786'])) {
                        // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                        $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : '';
                        exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                    }                    
                    
                    if (in_array($this->list_id, ['7334','7335','7418'])) {
                        // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                        $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                        exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris_test.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                    }
                    if (in_array($this->list_id, ['7334','7335', '7341','7355'])) {
                        // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                        $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                        exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                    }
                    if (in_array($this->list_id, ['6003','6041'])) {
                        // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                        $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                        exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz_live.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                    }
                    //SFARSIT implementare
                    return array(1, 'Subscriber [' . $email . '], emailid [' . $this->emailid . '] added!');
                }
            } catch (Exception $e) {

                if ($e->getCode() == 23505) {
                    $has_unique_violation = true;
                } else {
                    throw (new Exception($e->getMessage()));
                }
            }
        } else {
            $has_unique_violation = true;
        }

        $ls = $this->getDbListSettings('on_duplicate_error');

        $on_duplicate_trigger_error = intval($ls->on_duplicate_error) == 1 ? true : false;

        if ($this->list_id != 4042) {
            if ($has_unique_violation && $on_duplicate_trigger_error) {
                return array(2, 'Subscriber [' . $email . '], emailid [' . $this->emailid . '] duplicated!');
            }
        }

        if ($has_unique_violation) {

            unset($prepared_fields_for_sql_arr['email']);

            foreach ($prepared_fields_for_sql_arr as $key => $value) {
                if ($value == '') {
                    unset($prepared_fields_for_sql_arr[$key]);
                    continue;
                }
                $prepared_fields_for_sql_update_arr[] = $key . ' = ?';
            }

            if (count($prepared_fields_for_sql_arr) == 0) {
                throw (new Exception('Subscriber update: all fields are empty!'));
            }

            $sql = "UPDATE subscribers_" . $this->list_id . " SET " . implode(', ', $prepared_fields_for_sql_update_arr) . " WHERE email = ? RETURNING emailid";

            $sth = $this->dbh->prepare($sql);

            $sth->execute(array_merge(array_values($prepared_fields_for_sql_arr), array($email)));
            $this->emailid = $sth->fetchColumn();
            if ($sth->rowCount() == 1) {
                if ($this->list_id == '6041' || $this->list_id == '6214' || $this->list_id == '6003' || $this->list_id == '8505') {
                    exec("php /var/www/html/clients/wlm/utile/clients/toyota/insert_or_update_into_biz.php " . $this->list_id . " " . $this->emailid . " > /dev/null 2>&1");
                }
                return array(1, 'Subscriber [' . $email . '], emailid [' . $this->emailid . '] updated!');
            }
        }

        throw (new Exception('Subscriber not saved!'));
    }

    public function doUpdate()
    {
        $this->validateMethodDirectSaveDependencies();

        $lfs = $this->getDbExistingListFields();

        $request_fields_values = $this->fara_diacritice($this->request['fv']);
        $update_by = $this->request['update_by'];

        foreach ($request_fields_values as $key => $value) {
            if (($key != 'email') && !in_array($key, $lfs)) {
                // unset($request_fields_values[$key]);
                $forbidden_columns = array("dgr_emailid_", "dgr_email_", "dgr_subscribe_status_", "dgr_unsubscribe_status_", "dgr_mail_type_", "dgr_soft_bounce_back_", "dgr_hard_bounce_back_", "dgr_join_date_", "dgr_unsubscribe_date_", "dgr_optin_date_", "dgr_optout_date_", "dgr_stampip_", "dgr_remoteid_", "dgr_newsletter_", "dgr_stamptime_", "dgr_validcode_", "dgr_flag_invite_", "dgr_invite_date_", "dgr_stampipconfirm_", "dgr_trigger_unsub_obt1_", "dgr_trigger_unsub_obt2_", "dgr_trigger_unsub_obt3_", "dgr_trigger_unsub_obt4_", "dgr_auto_unsubscribe_", "dgr_status_sync_", "dgr_r_", "dgr_f_", "dgr_m_", "dgr_sm_details_");

                if (!in_array("dgr_" . $key . "_", $forbidden_columns)) {
                    try {
                        $this->dbh->query("BEGIN");

                        $sql = "INSERT INTO lists_fields_(list_id, fieldname, fieldtitle, fieldtype, formfieldtype, fieldmandatory, capitalizat) VALUES('" . $this->list_id . "', '" . formatSTR(strtolower(trim($key))) . "', '" . formatSTR(trim($key)) . "', 'character varying(255)', 'text', '0', '0')";
                        $insert = $this->dbh->prepare($sql);
                        $insert->execute();

                        $table = 'subscribers_' . $this->list_id;
                        $column = "dgr_" . strtolower(trim($key)) . "_";
                        $schemas = array('public', 'subscribers', 'bounce', 'unsubscribe', 'survey');
                        foreach ($schemas as $schema) {
                            if (wlmUtils::tableExists($schema, $table) && !wlmUtils::columnExists($schema, $table, $column)) {
                                $query = "ALTER TABLE " . $schema . '.' . $table . " ADD COLUMN " . $column . " varchar(255)";
                                $alter = $this->dbh->prepare($query);
                                $alter->execute();
                            }
                        }

                        $this->dbh->query("COMMIT");
                    } catch (Exception $e) {
                        $this->dbh->query("ROLLBACK");
                        // throw $e;
                        throw (new Exception('Subscriber not saved!'));
                    }
                }
            }
        }

        if (count($request_fields_values) == 1) {
            throw (new Exception('Subscriber update: all fields (other then email) are empty!'));
        }

        $prepared_fields_for_sql_arr = $this->getPreparedFieldsForSqlFormat(array('fields' => $request_fields_values, 'lfs' => $lfs));

        $subscriber_id = $this->request[$update_by];

        unset($prepared_fields_for_sql_arr['email']);

        foreach ($prepared_fields_for_sql_arr as $key => $value) {
            if ($value == '') {
                unset($prepared_fields_for_sql_arr[$key]);
                continue;
            }
            $prepared_fields_for_sql_update_arr[] = $key . ' = ?';
        }

        if (count($prepared_fields_for_sql_arr) == 0) {
            throw (new Exception('Subscriber update: all fields are empty!'));
        }

        $up_log = __DIR__ . '/../../../tmp/gabi/subscriber_service.log';

        try {

            // NETLINX BEGIN
            // history(1, $this->list_id, $this->request['emailid'], '', 'update api');
            // NETLINX END

            $sql = "UPDATE subscribers_" . $this->list_id . " SET " . implode(', ', $prepared_fields_for_sql_update_arr) . " WHERE " . preg_replace('/[^a-z0-9\_]+/is', '', $update_by) . " = ? returning emailid";
            file_put_contents($up_log, '[INFO]' . "SQL: $sql", FILE_APPEND);
            $sth = $this->dbh->prepare($sql);

            $sth->execute(array_merge(array_values($prepared_fields_for_sql_arr), array($subscriber_id)));
            file_put_contents($up_log, "\r\n" . '[INFO]' . "VALUES: ".json_encode(array_merge(array_values($prepared_fields_for_sql_arr), array($subscriber_id))), FILE_APPEND);
            //file_put_contents($up_log, '[INFO]' . "Binding: array_merge(array_values($prepared_fields_for_sql_arr), array($subscriber_id))", FILE_APPEND);

            if ($sth->rowCount() == 1) {
                $this->emailid = $sth->fetchColumn(0);

                // Check if triggers are available
                $query = $this->dbh->prepare("SELECT cmpg_id, filter
                  FROM   campaigns_
                  INNER JOIN segments_ ON campaigns_.seg_id = segments_.seg_id
                  WHERE
                        campaigns_.list_id = $this->list_id AND
                        segments_.list_id = $this->list_id AND
                        segments_.trigger_action = 'instantup' AND
                        segments_.status = 'active'");
                $query->execute();

                while ($row = $query->fetchColumn()) {

                    if ($this->triggerIsAllowed($this->list_id, $row, $this->emailid)) {

                        file_put_contents($up_log, "\r\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\r\n", FILE_APPEND);
                        file_put_contents($up_log, "Trigger allowed for emailid {$this->emailid} on campaign $row and list {$this->list_id}", FILE_APPEND);

                        exec("php /var/www/html/clients/wlm/cron/sendtrigger.php " . escapeshellarg($this->list_id) . " " . escapeshellarg($row) . " " . escapeshellarg($this->email) . " '' '' '' " . ($this->emailid ? $this->emailid : '') . " 2>&1 >> /var/www/html/clients/wlm//logs/sendtrigger.log");
                    } else {
                        file_put_contents($up_log, "\r\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\r\n", FILE_APPEND);
                        file_put_contents($up_log, "Trigger not allowed for campaign $row on list {$this->list_id}", FILE_APPEND);
                    }
                }

                // WhatsApp trigger hook — segment-driven, fires once per
                // event regardless of how many email campaigns matched.
                // No-op if WA module isn't deployed.
                if (class_exists('\\WhiteImage\\WhatsApp\\Service\\WhatsAppTriggerService')) {
                    \WhiteImage\WhatsApp\Service\WhatsAppTriggerService::fireOnSubscriberEvent(
                        (int) $this->list_id,
                        (int) $this->emailid,
                        ['instantup']
                    );
                }
            }
        } catch (Exception $e) {
            file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            file_put_contents($up_log, '[SQL ERROR] for list ' . $this->list_id . 'Update error: ' . $e->getMessage(), FILE_APPEND);
            throw (new Exception('Update error: ' . $e->getMessage()));
        }

        if ($sth->rowCount() == 1) {
            if ($this->list_id == '6041' || $this->list_id == '6214' || $this->list_id == '6003'|| $this->list_id == '8505') {
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/insert_or_update_into_biz.php " . $this->list_id . " " . $this->emailid . " > /dev/null 2>&1 &");
            }
            //implementare pentru a trimite datele in timp real si catre TOYOTA-VALORIS-wizz
            if (in_array($this->list_id, ['5988','5989','5997','5998','6002','6113','6266','6480','6506','6726','6727','6787','7204','6890','6824','6825','6786'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : '';
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }
            if (in_array($this->list_id, ['7334','7335','7418'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris_test.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }
            if (in_array($this->list_id, ['7334','7335','7341','7355'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }if (in_array($this->list_id, ['6003','6041'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz_live.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }
            //SFARSIT implementare
            return array(1, 'Subscriber ' . $update_by . ' [' . $subscriber_id . '], emailid [' . $this->emailid . '] updated!');
        }

        file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
        file_put_contents($up_log, '[UNKOWN ERROR]' . "Update error: {$this->emailid} on campaign $row and list {$this->list_id}", FILE_APPEND);
        throw (new Exception('Subscriber not saved!'));
    }

    public function doAppend()
    {
        $this->validateMethodDirectSaveDependencies();

        $lfs = $this->getDbExistingListFields();

        $request_fields_values = $this->fara_diacritice($this->request['fv']);

        $update_by = $this->request['update_by'];
        $separator = isset($this->request['separator']) ? $this->dbh->quote($this->request['separator']) : "'|'";
        $appendColumn = isset($this->request['appendcolumn']) ? 'dgr_'.$this->request['appendcolumn'] . "_": null;

        if (!($appendColumn)) {
            throw (new Exception('Subscriber update: specify parameter appendcolumn !'));
        }

        foreach ($request_fields_values as $key => $value) {
            if (($key != 'email') && !in_array($key, $lfs)) {
                unset($request_fields_values[$key]);
            }
        }

        if (count($request_fields_values) == 1) {
            throw (new Exception('Subscriber update: all fields (other then email) are empty!'));
        }

        $prepared_fields_for_sql_arr = $this->getPreparedFieldsForSqlFormat(array('fields' => $request_fields_values, 'lfs' => $lfs));
        $subscriber_id = $this->request[$update_by];

        unset($prepared_fields_for_sql_arr['email']);



        foreach ($prepared_fields_for_sql_arr as $key => $value) {
            if ($value == '') {
                unset($prepared_fields_for_sql_arr[$key]);
                continue;
            }
            if( $key == $appendColumn ) {
                $prepared_fields_for_sql_update_arr[] = $key . ' = COALESCE(' . $key . ", '') || " . $separator . ' || ?';
                continue;
            }
            $prepared_fields_for_sql_update_arr[] = $key . ' = ?';
            
        }
        if (count($prepared_fields_for_sql_arr) == 0) {
            throw (new Exception('Subscriber update: all fields are empty!'));
        }

        $up_log = __DIR__ . '/../../../tmp/gabi/subscriber_service.log';

        try {

            // NETLINX BEGIN
            // history(1, $this->list_id, $this->request['emailid'], '', 'update api');
            // NETLINX END

            $sql = "UPDATE subscribers_" . $this->list_id . " SET " . implode(', ', $prepared_fields_for_sql_update_arr) . " WHERE " . preg_replace('/[^a-z0-9\_]+/is', '', $update_by) . " = ? returning emailid";
            file_put_contents($up_log, '[INFO]' . "SQL: $sql", FILE_APPEND);
            $sth = $this->dbh->prepare($sql);

            $sth->execute(array_merge(array_values($prepared_fields_for_sql_arr), array($subscriber_id)));
            file_put_contents($up_log, "\r\n" . '[INFO]' . "VALUES: ".json_encode(array_merge(array_values($prepared_fields_for_sql_arr), array($subscriber_id))), FILE_APPEND);
            //file_put_contents($up_log, '[INFO]' . "Binding: array_merge(array_values($prepared_fields_for_sql_arr), array($subscriber_id))", FILE_APPEND);

            if ($sth->rowCount() == 1) {
                $this->emailid = $sth->fetchColumn(0);

                // Check if triggers are available
                $query = $this->dbh->prepare("SELECT cmpg_id, filter
                  FROM   campaigns_
                  INNER JOIN segments_ ON campaigns_.seg_id = segments_.seg_id
                  WHERE
                        campaigns_.list_id = $this->list_id AND
                        segments_.list_id = $this->list_id AND
                        segments_.trigger_action = 'instantup' AND
                        segments_.status = 'active'");
                $query->execute();

                while ($row = $query->fetchColumn()) {

                    if ($this->triggerIsAllowed($this->list_id, $row, $this->emailid)) {

                        file_put_contents($up_log, "\r\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\r\n", FILE_APPEND);
                        file_put_contents($up_log, "Trigger allowed for emailid {$this->emailid} on campaign $row and list {$this->list_id}", FILE_APPEND);

                        exec("php /var/www/html/clients/wlm/cron/sendtrigger.php " . escapeshellarg($this->list_id) . " " . escapeshellarg($row) . " " . escapeshellarg($this->email) . " '' '' '' " . ($this->emailid ? $this->emailid : '') . " 2>&1 >> /var/www/html/clients/wlm//logs/sendtrigger.log");
                    } else {
                        file_put_contents($up_log, "\r\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\r\n", FILE_APPEND);
                        file_put_contents($up_log, "Trigger not allowed for campaign $row on list {$this->list_id}", FILE_APPEND);
                    }
                }

                // WhatsApp trigger hook — segment-driven, fires once per
                // event regardless of how many email campaigns matched.
                // No-op if WA module isn't deployed.
                if (class_exists('\\WhiteImage\\WhatsApp\\Service\\WhatsAppTriggerService')) {
                    \WhiteImage\WhatsApp\Service\WhatsAppTriggerService::fireOnSubscriberEvent(
                        (int) $this->list_id,
                        (int) $this->emailid,
                        ['instantup']
                    );
                }
            }
        } catch (Exception $e) {
            file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            file_put_contents($up_log, '[SQL ERROR] for list ' . $this->list_id . 'Update error: ' . $e->getMessage(), FILE_APPEND);
            throw (new Exception('Update error: ' . $e->getMessage()));
        }

        if ($sth->rowCount() == 1) {
            if ($this->list_id == '6041' || $this->list_id == '6214' || $this->list_id == '6003'|| $this->list_id == '8505') {
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/insert_or_update_into_biz.php " . $this->list_id . " " . $this->emailid . " > /dev/null 2>&1 &");
            }
            //implementare pentru a trimite datele in timp real si catre TOYOTA-VALORIS-wizz
            if (in_array($this->list_id, ['5988','5989','5997','5998','6002','6113','6266','6480','6506','6726','6727','6787','7204','6890','6824','6825','6786'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : '';
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }
            if (in_array($this->list_id, ['7334','7335','7418'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris_test.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }
            if (in_array($this->list_id, ['7334','7335','7341','7355'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }if (in_array($this->list_id, ['6003','6041'])) {
                // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz_live.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
            }
            //SFARSIT implementare
            return array(1, 'Subscriber ' . $update_by . ' [' . $subscriber_id . '], emailid [' . $this->emailid . '] updated and appended!');
        }

        file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
        file_put_contents($up_log, '[UNKOWN ERROR]' . "Update error: {$this->emailid} on campaign $row and list {$this->list_id}", FILE_APPEND);
        throw (new Exception('Subscriber not saved!'));
    }


    private function getDbExistingListFields()
    {
        $sql  = "SELECT * FROM lists_fields_ WHERE list_id = ? ORDER BY lsfid ASC";

        $sth = $this->dbh->prepare($sql);


        $sth->execute(array($this->list_id));

        $lfs_tmp = $sth->fetchAll(PDO::FETCH_OBJ);


        //$lfs = array('email');
        $lfs = array('email', 'join_date', 'subscribe_status'); // added join_date 26.04.2018
        $lfs = array_merge($lfs, $this->getSystemFields());

        foreach ($lfs_tmp as $val) {
            $lfs[] = $val->fieldname;
        }

        return $lfs;
    }


    private function getPreparedFieldsForSqlFormat($param)
    {

        $fields = $param['fields'];
        $lfs = $param['lfs'];
        $with_sql_alias = isset($param['with_sql_alias']) ? $param['with_sql_alias'] : false;

        $prepared_fields = array();

        switch ($this->method) {
            case 'select':
            case 'select_one':
                foreach ($fields as $key => $field) {
                    if (!in_array($field, $lfs)) {
                        unset($fields[$key]);
                    } else {
                        if ($field == 'email' || $field == 'join_date' || in_array($field, $this->getSystemFields())) { // modificat 26.04.2018
                            $prepared_fields[$key] = $field;
                        } else {
                            $prepared_fields[$key] = 'dgr_' . $field . '_';

                            if ($with_sql_alias) {
                                $prepared_fields[$key] .= ' as ' . $field;
                            }
                        }
                    }
                }

                break;
            case 'direct_save':
            case 'mobile_save':
            case 'save':
            case 'update':
            case 'append':

                foreach ($fields as $field_name => $field_value) {
                    if (!in_array($field_name, $lfs)) {
                        unset($fields[$field_name]);
                    } else {
                        if ($field_name == 'email' || $field_name == 'subscribe_status' || $field_name == 'join_date') { // modificat 30.01.2019
                            $prepared_fields[$field_name] = $field_value;
                        } else {
                            $prepared_fields['dgr_' . $field_name . '_'] = $field_value;
                        }
                    }
                }
                break;
        }

        return $prepared_fields;
    }


    private function getDbListSettings($return_fields = 'on_duplicate_error')
    {
        $sql  = "SELECT " . $return_fields . ", lists_.listemaildescr FROM lists_settings_, lists_
            WHERE lists_settings_.list_id = ? AND
	        lists_settings_.list_id = lists_.list_id LIMIT 1";

        $sth = $this->dbh->prepare($sql);

        $sth->execute(array($this->list_id));

        return $sth->fetch(PDO::FETCH_OBJ);
    }


    public function    processMethodSave()
    {
        $this->validateMethodDirectSaveDependencies();

        $email = $this->request['fv']['email'];

        if (isset($this->request['dont_validate_email'])) {
            $this->request['fv']['email'] = time() . mt_rand(1, 9999999) . '@noemail.ro';
        }

        if (!isset($this->request['save_type'])) {
            $this->request['save_type'] = 1;
        }

        if ((int)$this->list_id == 1655) {

            //file_put_contents('/tmp/sorin.log', json_encode($this->subscribe()), FILE_APPEND);

            $subscribe_response = json_decode($this->subscribe());
            if ($subscribe_response->code == 1) {
                $this->sendServiceResponse(1, 'Subscriber [' . $email . '] saved!', array('emailid' => !empty($subscribe_response->emailid) ? $subscribe_response->emailid : null));
            }

            if ($subscribe_response->code == -1 && (strpos($subscribe_response->message, 'duplicate') !== false)) {
                $this->sendServiceResponse(2, 'Subscriber [' . $email . '] duplicated!');
            }
        } else {

            //            if ($this->list_id == '3666') {
            //
            //                $subscribe_response = $this->subscribe();
            //                //file_put_contents('/tmp/sorin.log', var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            //                file_put_contents('/tmp/sorin.log', $subscribe_response, FILE_APPEND);
            //                //file_put_contents('/tmp/sorin.log', print_r(__FILE__, true), FILE_APPEND);
            //                //mail("sergio@whiteimage.ro" , "subj" , "sssss");
            //            }

            switch ((int)$this->request['save_type']) {
                case 1:
                default: // se apeleaza subscriber_general.php (insert/update in baza de date + send trigger + email-uri de confirmare daca e cazul)
                    $subscribe_response = json_decode($this->subscribe());
                    if ($subscribe_response->code == 1) {
                        if ($this->list_id == '6041' || $this->list_id == '6214' || $this->list_id == '6003' || $this->list_id == '8505') {
                            $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : '';
                            exec("php /var/www/html/clients/wlm/utile/clients/toyota/insert_or_update_into_biz.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                        }
                        //implementare pentru a trimite datele in timp real si catre TOYOTA-VALORIS-WIZZ
                        if (in_array($this->list_id, ['5988','5989','5997','5998','6002','6113','6266','6480','6506','6726','6727','6787','7204','6890','6824','6825','6786','5810','5990'])) {
                            $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : '';
                            exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                        }
                        if (in_array($this->list_id, ['7334','7335','7418'])) {
                            // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                            $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                            exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris_test.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                        }
                        if (in_array($this->list_id, ['7334','7335','7341','7355'])) {
                            // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                            $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                            exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                        }
                        if (in_array($this->list_id, ['6003','6041'])) {
                            // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                            $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                            exec("php /var/www/html/clients/wlm/utile/clients/toyota/sync_wizz_live.php " . $this->list_id . " " . $email_id . " > /dev/null 2>&1 &");
                        }
                        //SFARSIT implementare
                        // Implementare Distrigaz
                        if (in_array($this->list_id, ['7808'])) {
                            // mail('catalin.paraschiva@whiteimage.ro', __LINE__.__FILE__,"php /var/www/html/clients/wlm/utile/clients/toyota/sync_toyota_valoris.php ".$this->list_id." ". $email_id. " > /dev/null 2>&1");
                            $email_id = !empty($subscribe_response->emailid) ? $subscribe_response->emailid : $this->emailid;
                            exec("php /var/www/html/clients/wlm/utile/clients/distrigaz/cron/distrigazAddMessage.php server_2 " . $this->list_id . " " . $email_id . " ".$email. " ".$this->request['fv']['message_id'] . " ".$this->request['fv']['api_callback'] . " > /dev/null 2>&1 &");
                        }
                        // sfarsit Distrigaz
                        $this->sendServiceResponse(1, 'Subscriber [' . $email . '] saved!', array('emailid' => !empty($subscribe_response->emailid) ? $subscribe_response->emailid : null));
                    }

                    if ($subscribe_response->code == -1 && (strpos($subscribe_response->message, 'duplicate') !== false)) {
                        $this->sendServiceResponse(2, 'Subscriber [' . $email . '] duplicated!');
                    } elseif ($subscribe_response->code == -1) {
                    }
                    break;
                case 2: // se face insert/update in baza de date + send trigger
                    $arr = $this->doSave();
                    $this->processMethodSendTrigger();
                    $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));
                    break;
                case 3: // se face insert/update in baza de date
                    $arr = $this->doSave();
                    $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));
                    break;
            }
        }

        //        if( $this->list_id == '1655') {
        //
        //        }

        //        switch ((int)$this->request['save_type']) {
        //            case 1:
        //            default: // se apeleaza subscriber_general.php (insert/update in baza de date + send trigger + email-uri de confirmare daca e cazul)
        //                $subscribe_response = json_decode($this->subscribe());
        //                if ($subscribe_response->code == 1) {
        //                    $this->sendServiceResponse(1, 'Subscriber [' . $email . '] saved!', array('emailid' => !empty($subscribe_response->emailid) ? $subscribe_response->emailid : null));
        //                }
        //
        //                if ($subscribe_response->code == -1 && (strpos($subscribe_response->message, 'duplicate') !== false)) {
        //                    $this->sendServiceResponse(2, 'Subscriber [' . $email . '] duplicated!');
        //                }
        //                break;
        //            case 2: // se face insert/update in baza de date + send trigger
        //                $arr = $this->doSave();
        //                $this->processMethodSendTrigger();
        //                $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));
        //                break;
        //            case 3: // se face insert/update in baza de date
        //                $arr = $this->doSave();
        //                $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));
        //                break;
        //        }

        throw (new Exception('Subscriber not saved!'));
    }

    public function processMethodUpdate()
    {
        $this->validateMethodDirectSaveDependencies();

        if (isset($this->request['dont_validate_email'])) {
            $this->request['fv']['email'] = time() . mt_rand(1, 9999999) . '@noemail.ro';
        }


        // se face insert/update in baza de date
        $arr = $this->doUpdate();
        $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));

        throw (new Exception('Subscriber not saved!'));
    }
    
    public function processMethodAppend()
    {
        $this->validateMethodDirectSaveDependencies();

        if (isset($this->request['dont_validate_email'])) {
            $this->request['fv']['email'] = time() . mt_rand(1, 9999999) . '@noemail.ro';
        }


        // se face insert/update in baza de date
        $arr = $this->doAppend();
        $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));

        throw (new Exception('Subscriber not saved!'));
    }

    public function processMethodUnsubscribe()
    {
        // We're not checking for any [fv] fields here, no need, just emailid
        if (
            !isset($this->request['emailid'])
            || $this->request['emailid'] == ''
            || !is_numeric($this->request['emailid'])
        ) {
            throw (new Exception('Missing/wrong fields'));
        } else {
            $this->emailid = $this->request['emailid'];
        }

        $arr = $this->doUnsubscribe();
        // First two parameters are  the code and message returned by doUnsubscribe()
        $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));

        throw (new Exception('Subscriber not saved!')); // if query didn't return results
    }

    public function doUnsubscribe()
    {

        // NETLINX BEGIN
        // history(1, $this->list_id, $this->emailid, '', 'unsubscribe api');
        // NETLINX END

        $up_log = __DIR__ . '/../../../tmp/gabi/subscriber_service.log';
        try {
            $sql = "UPDATE subscribers_" . $this->list_id .
                " SET subscribe_status = 'no',
                unsubscribe_status = 'confirmed',
                unsubscribe_date = '" . date('Y-m-d') . "'
                WHERE  emailid = ? AND unsubscribe_status = 'no'";
            $query = $this->dbh->prepare($sql);
            $query->execute(array($this->emailid));

            // NETLINX BEGIN
            trigger_unsub($this->list_id, $this->emailid);
            // NETLINX END

        } catch (Exception $e) {

            file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            file_put_contents($up_log, '[SQL ERROR] for list ' . $this->list_id . 'Unsubscribe error: ' . $e->getMessage(), FILE_APPEND);

            return array(1, 'Subscriber emailid [' . $this->emailid . '] could not be unsubscribed!');
        }

        if ($query->rowCount() == 1) {
            return array(1, 'Subscriber emailid [' . $this->emailid . '] unsubscribed!');
        } else {
            file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            file_put_contents($up_log, '[ERROR]' . 'emailid not correct or already subscribed', FILE_APPEND);
            throw (new Exception('Subscriber not saved!'));
        }
    }

    public function processMethodResubscribe()
    {
        // We're not checking for any [fv] fields here, no need, just emailid
        if (
            !isset($this->request['emailid'])
            || $this->request['emailid'] == ''
            || !is_numeric($this->request['emailid'])
        ) {
            throw (new Exception('Missing/wrong fields'));
        } else {
            $this->emailid = $this->request['emailid'];
        }

        $arr = $this->doResubscribe();
        // First two parameters are  the code and message returned by doUnsubscribe()
        $this->sendServiceResponse($arr[0], $arr[1], array('emailid' => !empty($this->emailid) ? $this->emailid : null));

        throw (new Exception('Could not resubscribe!')); // if query didn't return results
    }

    public function processMethodMobileSave()
    {
        global $smarty;
        // Check if we have a phone number!
        if (
            !isset($this->request['fv']['telefon'])
            || $this->request['fv']['telefon'] == ''
            || !is_numeric($this->request['fv']['telefon'])
        ) {
            throw (new Exception('Missing/wrong fields')); // Cut the bullshit!
        }

        $this->phone_number = $this->request['fv']['telefon'];

        $response = $this->doMobileSave();
        $this->sendServiceResponse($response[0], $response[1], $response[2]); // Code and message are returned

        throw (new Exception('Could not save mobile subscriber!'));
    }

    public function doMobileSave()
    {
        global $smarty;
        require_once(APP_ROOT . 'classes/Subscribers.class.php');
        require_once(APP_ROOT . 'classes/mobile/mobileListSettings.php');
        require_once(APP_ROOT . 'classes/wlm_sms_campaign.php');

        $smsIsEnabled = mobileListSettings::smsIsEnabled($this->list_id);

        if (!$smsIsEnabled) return array(0, 'SMS is not enabled');

        /*$sql = "INSERT INTO public.subscribers_" . $this->list_id . " (dgr_telefon_, subscribe_status) VALUES( '" . $this->phone_number. "', 'confirmed') ";
        $statementHandler = $this->dbh->prepare($sql);
        $statementHandler->execute();
        $affectedRows = $statementHandler->rowCount();

        if ($affectedRows != 1) {
            throw(new Exception('Could not save mobile subscriber!'));
        }*/

        $lfs = $this->getDbExistingListFields();

        $request_fields_values = $this->fara_diacritice($this->request['fv']);
        foreach ($request_fields_values as $key => $value) {
            if (($key != 'email') && !in_array($key, $lfs)) {
                // unset($request_fields_values[$key]);
                $forbidden_columns = array("dgr_emailid_", "dgr_email_", "dgr_subscribe_status_", "dgr_unsubscribe_status_", "dgr_mail_type_", "dgr_soft_bounce_back_", "dgr_hard_bounce_back_", "dgr_join_date_", "dgr_unsubscribe_date_", "dgr_optin_date_", "dgr_optout_date_", "dgr_stampip_", "dgr_remoteid_", "dgr_newsletter_", "dgr_stamptime_", "dgr_validcode_", "dgr_flag_invite_", "dgr_invite_date_", "dgr_stampipconfirm_", "dgr_trigger_unsub_obt1_", "dgr_trigger_unsub_obt2_", "dgr_trigger_unsub_obt3_", "dgr_trigger_unsub_obt4_", "dgr_auto_unsubscribe_", "dgr_status_sync_", "dgr_r_", "dgr_f_", "dgr_m_", "dgr_sm_details_");

                if (!in_array("dgr_" . $key . "_", $forbidden_columns)) {
                    try {
                        $this->dbh->query("BEGIN");

                        $sql = "INSERT INTO lists_fields_(list_id, fieldname, fieldtitle, fieldtype, formfieldtype, fieldmandatory, capitalizat) VALUES('" . $this->list_id . "', '" . formatSTR(strtolower(trim($key))) . "', '" . formatSTR(trim($key)) . "', 'character varying(255)', 'text', '0', '0')";
                        $insert = $this->dbh->prepare($sql);
                        $insert->execute();

                        $table = 'subscribers_' . $this->list_id;
                        $column = "dgr_" . strtolower(trim($key)) . "_";
                        $schemas = array('public', 'subscribers', 'bounce', 'unsubscribe', 'survey');
                        foreach ($schemas as $schema) {
                            if (wlmUtils::tableExists($schema, $table) && !wlmUtils::columnExists($schema, $table, $column)) {
                                $query = "ALTER TABLE " . $schema . '.' . $table . " ADD COLUMN " . $column . " varchar(255)";
                                $alter = $this->dbh->prepare($query);
                                $alter->execute();
                            }
                        }

                        $this->dbh->query("COMMIT");
                    } catch (Exception $e) {
                        $this->dbh->query("ROLLBACK");
                        // throw $e;
                        throw (new Exception('Subscriber not saved!'));
                    }
                }
            }
        }

        $prepared_fields_for_sql_arr = $this->getPreparedFieldsForSqlFormat(array('fields' => $request_fields_values, 'lfs' => $lfs));


        //        $email = $request_fields_values['email'];
        //
        //        $has_unique_violation = false;
        //
        //        $test = "SELECT email FROM subscribers_" . $this->list_id . " WHERE email='" . $email . "'";
        //        $sth2 = $this->dbh->prepare($test);
        //        $sth2->execute();
        //        $db_email = $sth2->fetchColumn();
        //
        //        if ($db_email != $email) {
        try {
            $sql = "INSERT INTO subscribers_" . $this->list_id . " (" . implode(",", array_keys($prepared_fields_for_sql_arr)) . ",join_date,optin_date,subscribe_status) VALUES (" . implode(', ', array_pad(array(), count($prepared_fields_for_sql_arr), '?')) . ",CURRENT_DATE,CURRENT_DATE,'confirmed') RETURNING emailid";

            $sth = $this->dbh->prepare($sql);

            $sth->execute(array_values($prepared_fields_for_sql_arr));
            $this->emailid = $sth->fetchColumn();

            if ($sth->rowCount() != 1) {
                return array(1, 'Subscriber not added!');
            }
        } catch (Exception $e) {

            if ($e->getCode() == 23505) {
                $has_unique_violation = true;
            } else {
                throw (new Exception($e->getMessage()));
            }
        }
        //        } else {
        //            $has_unique_violation = true;
        //        }


        $emailid = $this->dbh->lastInsertId('subscribers_' . $this->list_id . '_emailid_seq');
        $mobileSubscriber = new mobileSubscriber($this->list_id);
        $mobileSubscriber->setSubscriberId($emailid);
        $mobileSubscriber->setSmsPhoneNumber($this->phone_number);
        $result = $mobileSubscriber->save();

        $code = ($result) ? '1' : '0';
        $message = ($code == 1) ? 'Mobile subscriber saved' : 'Mobile subscriber not saved';
        $response = array($code, $message, array("email_id" => $emailid));  // later return

        // If we can't save to mobile. then delete from public.subscribers as well
        if ($code == 0) {
            $deleteSql = "DELETE FROM public.subscribers_$this->list_id WHERE emailid = $emailid";
            $delSth = $this->dbh->prepare($deleteSql);
            $delSth->execute();

            return $response;
        }

        //        mail('catalin.paraschiva@whiteimage.ro', 'Mobile sub added for list ' . $this->list_id, 'Mobile ' . $this->phone_number . ' added.',__LINE__.' file: '.__FILE__);

        // @todo add the mobile and email save in a transaction
        $cmpgIdSql = "SELECT cmpg_id
                  FROM   campaigns_
                  INNER JOIN segments_ ON campaigns_.seg_id = segments_.seg_id
                  WHERE
                        campaigns_.list_id = $this->list_id AND
                        segments_.list_id = $this->list_id AND
                        segments_.trigger_action = 'instant' AND
                        segments_.status = 'active'";

        $cmpgSth = $this->dbh->prepare($cmpgIdSql);
        $cmpgSth->execute();

        while ($cmpgId = $cmpgSth->fetchColumn()) {

            //            mail('catalin.paraschiva@whiteimage.ro','query ran '.__LINE__.' file: '.__FILE__, $cmpgIdSql);

            if ($this->mobileTriggerIsAllowed($this->list_id, $cmpgId, $emailid)) {
                //                mail('catalin.paraschiva@whiteimage.ro', 'mobileTriggerIsAllowed '.__LINE__.' file: '.__FILE__, 'asdasd');


                $user_data = $mobileSubscriber->fetchBySmsPhoneNumber($this->phone_number);
                if ($user_data) {
                    foreach ($user_data as $k => $v) {
                        $smarty->assign(preg_replace('/^dgr_|_$|^mwis_/is', '', trim($k)), $v);
                    }
                }
                $fields  = $this->getListFields();
                $fields2 = array();

                foreach ($fields as $key => $value) {
                    $fields2[$key] = $key . " AS " . $value;
                }

                //                mail('catalin.paraschiva@whiteimage.ro', 'mobileTriggerIsAllowed '.__LINE__.' file: '.__FILE__, json_encode($fields2));


                //adaugat Laur 17.02.2022 - trimiteri de sms-uri
                $fieldsSth = $this->dbh->prepare(
                    "SELECT " . mobileSubscriber::getSmsFieldsString() . ", emailid, email, join_date, optin_date, mail_type, " . implode(", ", $fields2) . "
                FROM   subscribers_" . $this->list_id . "
                LEFT JOIN mobile.subscriber_" . $this->list_id . " ms ON subscribers_" . $this->list_id . ".emailid = ms.subscriber_id
                WHERE  subscribe_status = 'confirmed'  and emailid = '" . $emailid . "'		         
                ORDER  BY emailid"
                );

                $fieldsSth->execute();
                $userData =  $fieldsSth->fetch(PDO::FETCH_ASSOC);
                @array_walk($userData, function (&$item, $key) use ($smarty) {
                    $smarty->assign($key, $item);
                });


                wlm_sms_campaign::sendMessageByCmpgId($cmpgId, $userData);

		$rslt = $this->dbh->prepare(
                                "SELECT id as id
                                 FROM  trigger.triggers_actions_
                                 WHERE list_id = $this->list_id AND cmpg_id = $cmpgId AND data = current_date");
                $rslt->execute();
                $row = $rslt->fetch(PDO::FETCH_ASSOC);
                if (!empty($row)) {
                    $trg_id = $row['id'];
                } else {
                    $rslt = $this->dbh->prepare("INSERT INTO trigger.triggers_actions_(list_id, cmpg_id, data) VALUES($this->list_id, $cmpgId, current_date) RETURNING id");
                    $rslt->execute();
                    $row = $rslt->fetch(PDO::FETCH_ASSOC);
                    $trg_id = $row['id'];
                }
                
                $sql = "INSERT INTO trigger.triggers_subscribers_(trg_id, emailid) VALUES($trg_id, $emailid)";
		$rslt = $this->dbh->prepare($sql);
                $rslt->execute();
                
                wlm_sms_campaign::updateSentStatistics($cmpgId);
                
                $sql = "UPDATE campaigns_ SET
                                                sent_counter  = sent_counter + 1
		        WHERE list_id = " . $this->list_id . " AND cmpg_id = " . $cmpgId;
                $rslt = $this->dbh->prepare($sql);
                $rslt->execute();
                
                //exec("php /var/www/html/clients/wlm/cron/sendtrigger.php " . escapeshellarg($this->list_id) . " " . escapeshellarg($cmpgId) . " " . escapeshellarg($userData['email']) . " '' '' '' " . ($emailid ? $emailid : '') . "  > /dev/null 2>&1 &");
                
            } else {
                // mail('catalin.paraschiva@whiteimage.ro', 'mobileTriggerIsAllowed NOOT '.__LINE__.' file: '.__FILE__, 'NOOT');
            }
        }

        // WhatsApp trigger hook — segment-driven, fires once per event.
        // No-op if WA module isn't deployed.
        if (class_exists('\\WhiteImage\\WhatsApp\\Service\\WhatsAppTriggerService')) {
            \WhiteImage\WhatsApp\Service\WhatsAppTriggerService::fireOnSubscriberEvent(
                (int) $this->list_id,
                (int) $emailid,
                ['instant']
            );
        }

        return $response;
    }

    public function fara_diacritice($str)
    {
        // mail("laurentiu@whiteimage.ro",__LINE__,$str);
        $clean = str_replace(array("ă", "Ă", "î", "Î", "â", "Â", "ş", "Ş", "ţ", "Ţ", "conține"), array("&#259;", "&#258;", "&#238;", "&#206;", "&#226;", "&#194;", "&#351;", "&#350;", "&#355;", "&#354;", "con&#355;ine"), $str);
        return $clean;
    }
    public function doResubscribe()
    {

        global $smarty;
        global $cfg;
        global $shortlink_list_ids;

        $up_log = '/mnt/drive2/tmp/gabi/subscriber_service.log';

        // Check if we are to send confirmation messages
        $list_settings = $this->getDbListSettings('listemaildescr, listemail, subscription_type');

        if ($list_settings->subscription_type == "double") {
            $sub_status = "'requested'";
            $unsub_status = '';
            $validcode = md5(uniqid(rand(), true));
        } else { // if we have single optin we confirm right away
            $sub_status = "'confirmed'";
            $unsub_status = "unsubscribe_status = 'no', ";
            $validcode = "''";
        }

        // NETLINX BEGIN
        // history(1, $this->list_id, $this->emailid, '', 'resubscribe api ' . $list_settings->subscription_type);
        // NETLINX END

        try {
            $sql0 = "UPDATE unsubscribe.subscribers_" . $this->list_id .
                " SET subscribe_status = $sub_status,
                validcode = '$validcode',"
                . $unsub_status . "  
                join_date = '" . date('Y-m-d') . "'
                WHERE  emailid = ? AND unsubscribe_status = 'confirmed'";
            $query0 = $this->dbh->prepare($sql0);
            $query0->execute(array($this->emailid));

            if(in_array($this->list_id,[7467,7473,7474,7475,7487,7488,1235])){
                $tableName = "subscribers_" . $this->list_id;
                $query = sprintf("SELECT * FROM %s limit 1", $tableName);
                
                $result = $this->dbh->prepare($query);
                $result->execute();
                $row = $result->fetch(PDO::FETCH_ASSOC);
               
                if ($row) {
                    $columns = array_keys($row);
                    $sql = (sprintf("INSERT INTO subscribers_%d SELECT %s FROM unsubscribe.subscribers_%d WHERE emailid = %d  RETURNING email", $this->list_id, implode(",", $columns), $this->list_id, $this->emailid));
                    $query = $this->dbh->prepare($sql);
                    $query->execute();
                }
            }else{
            $sql = "INSERT INTO subscribers_" . $this->list_id .
                " SELECT * from unsubscribe.subscribers_" . $this->list_id . " 
             WHERE  emailid = ?  RETURNING email";
             $query = $this->dbh->prepare($sql);
             $query->execute(array($this->emailid));
            } 
            $result = $query->fetch(PDO::FETCH_BOTH);

            $this->email = $result['email'];

            if ($this->email) {
                $sql0 = "DELETE FROM unsubscribe.subscribers_" . $this->list_id .
                    " WHERE  emailid = ? AND subscribe_status = 'confirmed'";
                $query0 = $this->dbh->prepare($sql0);
                $query0->execute(array($this->emailid));
            } else {
                return array(1, 'Subscriber emailid [' . $this->emailid . '] could not be resubscribed! ERROR 001: Maybe already subscribed');
            }
        } catch (Exception $e) {

            file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            file_put_contents($up_log, '[SQL ERROR] for list ' . $this->list_id . ' Resubscribe error: ' . $e->getMessage(), FILE_APPEND);

            return array(1, 'Subscriber emailid [' . $this->emailid . '] could not be resubscribed!');
        }

        if ($query->rowCount() == 1) {

            // Get the demographics' values to populate our message
            $fields  = $this->getListFields();
            $fields['remoteid'] = 'remoteid';
            $fields2 = array();

            foreach ($fields as $key => $value) {
                $fields2[$key] = $key . " AS " . $value;
            }

            $linkuri = array();
            $query = $this->dbh->prepare("SELECT emailid,email, " . implode(", ", $fields2) . " FROM subscribers_" . $this->list_id . " WHERE email = '" . $this->email . "' ORDER BY emailid DESC LIMIT 1");

            $query->execute();

            if ($rS = $query->fetch(PDO::FETCH_BOTH)) {
                $eid = $rS['emailid'];

                foreach ($fields as $key => $value) {
                    $smarty->assign($value, $rS[$value]);
                    $linkuri["[[" . $value . "]]"] = $rS[$value];
                }
                $linkuri["[[utm1_email]]"] = $rS['email'];
            }

            // Following code has been taken from subscribe_general and modified to work with this service
            if ($list_settings->subscription_type == "double") {

                file_put_contents($up_log, date('d-m-Y H:i:s') . "\tline " . __LINE__ . " :: $this->list_id :: Double optin\n", FILE_APPEND);

                // Populate email content
                $subject = $this->displayEmailMsg($this->list_id, "request_msg_subject",  array_merge($linkuri, array("[[listname]]" => $list_settings->listemaildescr)));
                $message = $this->displayEmailMsg($this->list_id, "request_msg_body", array_merge($linkuri, array(
                    "[[firstname]]"                => formatSTR(trim($linkuri["[[firstname]]"])),
                    "[[listname]]"                 => $list_settings->listemaildescr,
                    "[[openreadcheck]]" => "<img src=\"" . $cfg['_PathToApp_'] . "trks.php?R=2&vc=" . urlencode(base64_encode($this->email . "##" . $this->list_id . "##sub")) . "\" width=\"2\" height=\"2\">",
                    "[[confirmunsubscribelistlink]]" => $cfg['_PathToApp_'] . "unsubscribe.php?vc=" . urlencode(base64_encode($this->list_id . "##0" . "##" . $this->emailid . "##" . $this->email)), //ok
                    "[[confirmsubscribelistlink]]" => $cfg['_PathToApp_'] . "subscribe.php?vc=" . urlencode(base64_encode($this->list_id . "##" . $this->email . "##" . $validcode)) . (!empty($update) ? '&update=1' : '')
                )));

                // We deal with short subscriber links, for a small number of customers (check includes/config.inc.php)
                if (in_array($this->list_id, $shortlink_list_ids)) {
                    require_once(APP_ROOT . 'classes/ShortLink.php');
                    $entity_unique_code = ShortLink::create($cfg['_PathToApp_'] . "subscribe.php?vc=" . urlencode(base64_encode($this->list_id . "##" . $this->email . "##" . $validcode)) . "&server=" . wlmCommon::getServerId() . '&update=1');

                    $message = $this->displayEmailMsg($this->list_id, "request_msg_body", array_merge($linkuri, array(
                        "[[firstname]]"                => formatSTR(trim($_POST['firstname'])),
                        "[[listname]]"                 => $list_settings->listemaildescr,
                        "[[openreadcheck]]" => "<img src=\"" . $cfg['_PathToApp_'] . "trks.php?R=2&vc=" . urlencode(base64_encode($this->email . "##" . $this->list_id . "##sub")) . "&server=" . wlmCommon::getServerId() . "\" width=\"2\" height=\"2\">",
                        "[[confirmunsubscribelistlink]]" => $cfg['_PathToApp_'] . "unsubscribe.php?vc=" . urlencode(base64_encode($this->list_id . "##0" . "##" . $this->emailid . "##" . $this->email)) . "&server=" . wlmCommon::getServerId(), //ok
                        "[[confirmsubscribelistlink]]" => $entity_unique_code ? 'http://7w.ro/cs' . ((wlmCommon::getServerId() > 0) ? wlmCommon::getServerId() : '') . '/' . $entity_unique_code : $cfg['_PathToApp_'] . "subscribe.php?vc=" . urlencode(base64_encode($this->list_id . "##" . $this->email . "##" . $validcode)) . "&server=" . wlmCommon::getServerId() . (!empty($update) ? '&update=1' : '')
                    )));
                }

                if ($subject) {
                    // mail("laurentiu@whiteimage.ro",__FILE__."::".__LINE__."::".$this->list_id."::".$this->email,$list_settings->listemaildescr . " ---- " .$list_settings->listemail);
                    $from = $list_settings->listemaildescr ? $list_settings->listemaildescr . ' <' . $list_settings->listemail . '>' : '';
                    mail_pmta2($this->email, $subject, $message, $from);

                    file_put_contents($up_log, date('d-m-Y H:i:s') . "\tline " . __LINE__ . " :: $this->list_id :: {$this->email} : Mail sent to PMTA\n", FILE_APPEND);
                }
            }

            if ($list_settings->subscription_type == "single") {

                file_put_contents($up_log, date('d-m-Y H:i:s') . "\tline " . __LINE__ . " :: $this->list_id :: Single optin\n", FILE_APPEND);

                // Populate email content
                $subject = $this->displayEmailMsg($this->list_id, "confirm_msg_subject",  array_merge($linkuri, array("[[listname]]" => $list_settings->listemaildescr)));
                $message = $this->displayEmailMsg($this->list_id, "confirm_msg_body", array_merge($linkuri, array(
                    "[[firstname]]"                => formatSTR(trim($linkuri["[[firstname]]"])),
                    "[[listname]]"                 => $list_settings->listemaildescr,
                    "[[openreadcheck]]" => "<img src=\"" . $cfg['_PathToApp_'] . "trks.php?R=2&vc=" . urlencode(base64_encode($this->email . "##" . $this->list_id . "##sub")) . "\" width=\"2\" height=\"2\">",
                    "[[confirmunsubscribelistlink]]" => $cfg['_PathToApp_'] . "unsubscribe.php?vc=" . urlencode(base64_encode($this->list_id . "##0" . "##" . $this->emailid . "##" . $this->email)), //ok
                    "[[confirmsubscribelistlink]]" => $cfg['_PathToApp_'] . "subscribe.php?vc=" . urlencode(base64_encode($this->list_id . "##" . $this->email . "##" . $validcode)) . (!empty($update) ? '&update=1' : '')
                )));

                if ($subject) {
                    $from = $list_settings->listemaildescr ? $list_settings->listemaildescr . ' <' . $list_settings->listemail . '>' : '';
                    mail_pmta2($this->email, $subject, $message, $from);

                    file_put_contents($up_log, date('d-m-Y H:i:s') . "\tline " . __LINE__ . " :: $this->list_id :: {$this->email} : Mail sent to PMTA\n", FILE_APPEND);
                }
            }
            // Check if triggers are available
            $query = $this->dbh->prepare("SELECT cmpg_id, filter
                  FROM   campaigns_
                  INNER JOIN segments_ ON campaigns_.seg_id = segments_.seg_id
                  WHERE
                        campaigns_.list_id = $this->list_id AND
                        segments_.list_id = $this->list_id AND
                        segments_.trigger_action = 'instantup' AND
                        segments_.status = 'active'");
            $query->execute();

            while ($row = $query->fetchColumn()) {

                if ($this->triggerIsAllowed($this->list_id, $row, $this->emailid)) {

                    file_put_contents($up_log, "\r\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\r\n", FILE_APPEND);
                    file_put_contents($up_log, "Trigger allowed for emailid {$this->emailid} on campaign $row and list {$this->list_id}" . "\r\n", FILE_APPEND);

                    exec("php /var/www/html/clients/wlm/cron/sendtrigger.php " . escapeshellarg($this->list_id) . " " . escapeshellarg($row) . " " . escapeshellarg($this->email) . " '' '' '' " . ($this->emailid ? $this->emailid : '') . " >/dev/null 2>&1 &");
                } else {
                    file_put_contents($up_log, "\r\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\r\n", FILE_APPEND);
                    file_put_contents($up_log, "Trigger not allowed for campaign $row on list {$this->list_id}" . "\r\n", FILE_APPEND);
                }
            }

            // WhatsApp trigger hook — segment-driven, fires once per event.
            // No-op if WA module isn't deployed.
            if (class_exists('\\WhiteImage\\WhatsApp\\Service\\WhatsAppTriggerService')) {
                \WhiteImage\WhatsApp\Service\WhatsAppTriggerService::fireOnSubscriberEvent(
                    (int) $this->list_id,
                    (int) $this->emailid,
                    ['instantup']
                );
            }

            return array(1, 'Subscriber emailid [' . $this->emailid . '] resubscribed!');
        } else {
            file_put_contents($up_log, var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            file_put_contents($up_log, '[ERROR]' . 'emailid not correct or already subscribed', FILE_APPEND);
            throw (new Exception('Subscriber not saved!'));
        }
    }

    public function processMethodSendTrigger()
    {
        $params = array(
            'dbh'     => $this->dbh,
            'list_id' => $this->list_id,
            'emailid' => $this->emailid
        );
        $subscriber = new SubscriberEntity($params);

        $subscriber->sendTrigger();
    }

    private function subscribe()
    {
        $lfs = $this->getDbExistingListFields();

        $request_fields_values = $this->fara_diacritice($this->request['fv']);

        foreach ($request_fields_values as $key => $value) {
            if (($key != 'email') && !in_array($key, $lfs)) {
                // unset($request_fields_values[$key]);
                $forbidden_columns = array("dgr_emailid_", "dgr_email_", "dgr_subscribe_status_", "dgr_unsubscribe_status_", "dgr_mail_type_", "dgr_soft_bounce_back_", "dgr_hard_bounce_back_", "dgr_join_date_", "dgr_unsubscribe_date_", "dgr_optin_date_", "dgr_optout_date_", "dgr_stampip_", "dgr_remoteid_", "dgr_newsletter_", "dgr_stamptime_", "dgr_validcode_", "dgr_flag_invite_", "dgr_invite_date_", "dgr_stampipconfirm_", "dgr_trigger_unsub_obt1_", "dgr_trigger_unsub_obt2_", "dgr_trigger_unsub_obt3_", "dgr_trigger_unsub_obt4_", "dgr_auto_unsubscribe_", "dgr_status_sync_", "dgr_r_", "dgr_f_", "dgr_m_", "dgr_sm_details_");

                if (!in_array("dgr_" . $key . "_", $forbidden_columns)) {
                    try {
                        $this->dbh->query("BEGIN");

                        $sql = "INSERT INTO lists_fields_(list_id, fieldname, fieldtitle, fieldtype, formfieldtype, fieldmandatory, capitalizat) VALUES('" . $this->list_id . "', '" . formatSTR(strtolower(trim($key))) . "', '" . formatSTR(trim($key)) . "', 'character varying(255)', 'text', '0', '0')";
                        $insert = $this->dbh->prepare($sql);
                        $insert->execute();

                        $table = 'subscribers_' . $this->list_id;
                        $column = "dgr_" . strtolower(trim($key)) . "_";
                        $schemas = array('public', 'subscribers', 'bounce', 'unsubscribe', 'survey');
                        foreach ($schemas as $schema) {
                            if (wlmUtils::tableExists($schema, $table) && !wlmUtils::columnExists($schema, $table, $column)) {
                                $query = "ALTER TABLE " . $schema . '.' . $table . " ADD COLUMN " . $column . " varchar(255)";
                                $alter = $this->dbh->prepare($query);
                                $alter->execute();
                            }
                        }

                        $this->dbh->query("COMMIT");
                    } catch (Exception $e) {
                        $this->dbh->query("ROLLBACK");
                        // throw $e;
                        throw (new Exception('Subscriber not saved!'));
                    }
                }
            }
        }

        $email = $request_fields_values['email'];

        unset($request_fields_values['email']);

        // IQOS - Grapefruit API call for Capacel :)
        if ($this->list_id == '5009') {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://pmi.gd.ro/iqoscolours/checkStock/rFfZfNJhWyVATfpcsmFYVOxsoPI5VkVK');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);

            curl_close($ch);

            $response = json_decode($response, true);
            if (array_key_exists('stock', $response)) {
                if ($response['stock'] == 0) {
                    $request_fields_values['stoc'] = 'epuizat';
                } else {
                    $request_fields_values['stoc'] = $response['stock'];
                }
            }
        }

        $post_fields = array(
            'lst' => $this->list_id, // numarul listei pentru care se realizeaza sincronizarea
            'email' => $email, // adresa de email a userului (pe baza adresei de email se fac introduse se face update si unsubscribe)
            'stampip' => $_SERVER['REMOTE_ADDR'], // adresa de IP de la care s-a inregistrat userul
        );

        if ($this->list_id == '3666') {

            //file_put_contents('/tmp/sorin.log', var_export("\n\n" . date('Y-m-d G:i:s') . " - Line: " . __LINE__ . "\n", true), FILE_APPEND);
            file_put_contents('/tmp/sorin.log', json_encode($post_fields), FILE_APPEND);
            //file_put_contents('/tmp/sorin.log', print_r(__FILE__, true), FILE_APPEND);
            //mail("sergio@whiteimage.ro" , "subj" , "sssss");
        }

        if ($this->list_id == '4786' || $this->list_id == '5934') {
            $request_fields_values['expeditor_email_cc'] = 'bancassuranceVP@nn.ro';
        }
        
        if ($this->list_id == '6770' || $this->list_id == '6703' || $this->list_id == '6298') {
            $hostSubscriberService = 'https://wlm.whiteimage.eu/clients/wlm/subscribe_general.php';
        }else{
            $hostSubscriberService = 'https://wlm.whiteimage.eu/clients/wlm/subscribe_general.php';
        }

        $post_fields_str = http_build_query(array_merge($post_fields, $request_fields_values));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $hostSubscriberService);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields_str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        //file_put_contents("/mnt/drive2/tmp/silviu/alextesting1.log", $response . "\n\n", FILE_APPEND);

        curl_close($ch);

        return $response;
    }


    function __destruct()
    {
        //unset($this);
    }

    private function getSystemFields()
    {
        if (isset($this->request['return_system_fields'])) {
            return array('join_date', 'emailid');
        }

        return array();
    }


    private function prepareWhereSql()
    {
        // this condition has been removed on request
        // $where_sql = " (subscribe_status = 'confirmed')";
        $arr_for_bind = array();
        $where_sql = '';
        $obj = new stdClass();

        if (!empty($this->request['search'])) {
            foreach ($this->request['search'] as $val) {
                list($search_field_name, $search_field_value, $search_field_operator) = explode('|', $val);

                if (!in_array($search_field_name, array('email', 'emailid', 'remoteid', 'join_date', 'subscribe_status')) && !in_array($search_field_name, $this->getSystemFields())) {
                    $search_field_name_ready_for_sql = 'dgr_' . $search_field_name . '_';
                } else {
                    $search_field_name_ready_for_sql = $search_field_name;
                }

                switch ($search_field_operator) {
                    case 1:
                        $where_operator = " = ";
                        break;
                    case 2:
                        $where_operator = " < ";
                        break;
                    case 3:
                        $where_operator = " > ";
                        break;
                    case 4:
                        $where_operator = " <> ";
                        break;
                    case 5:
                        $where_operator = " ILIKE ";
                        break;
                    case 6:
                        $where_operator = " IS NULL";
                        break;
                    case 7:
                        $where_operator = " IS NOT NULL";
                        break;
                    default:
                        $where_operator = " = ";
                }



                if ($search_field_operator == 5) {
                    $search_bind_value =  "%" . $search_field_value . "%";
                } elseif ($search_field_operator == 6 || $search_field_operator == 7) {
                    $search_bind_value = '';
                } else {
                    $search_bind_value =  $search_field_value;
                }
                if ($search_field_name_ready_for_sql != "emailid" && $search_field_name_ready_for_sql != "join_date") {
                    if ($where_sql != '') {
                        $where_sql .= ' AND ';
                        if ($search_field_operator == 6 || $search_field_operator == 7) {
                            $where_sql .= '((' . $search_field_name_ready_for_sql . $where_operator . ') OR (' . $search_field_name_ready_for_sql . "='')) ";
                        } else {
                            $where_sql .= '(lower(' . $search_field_name_ready_for_sql . ') ' . $where_operator . "lower(:" . $search_field_name . '))';
                            $arr_for_bind[':' . $search_field_name] = $search_bind_value;
                        }
                    } else {
                        if ($search_field_operator == 6 || $search_field_operator == 7) {
                            $where_sql .= '((' . $search_field_name_ready_for_sql . $where_operator . ') OR (' . $search_field_name_ready_for_sql . "='')) ";
                        } else {
                            $where_sql .= '(lower(' . $search_field_name_ready_for_sql . ') ' . $where_operator . "lower(:" . $search_field_name . '))';
                            $arr_for_bind[':' . $search_field_name] = $search_bind_value;
                        }
                    }
                } else {
                    if ($where_sql != '') {
                        $where_sql .= ' AND ';
                        if ($search_field_operator == 6 || $search_field_operator == 7) {
                            $where_sql .= '((' . $search_field_name_ready_for_sql . $where_operator . ') OR (' . $search_field_name_ready_for_sql . "='')) ";
                        } else {
                            $where_sql .= '((' . $search_field_name_ready_for_sql . ') ' . $where_operator . "(:" . $search_field_name . '))';
                            $arr_for_bind[':' . $search_field_name] = $search_bind_value;
                        }
                    } else {
                        if ($search_field_operator == 6 || $search_field_operator == 7) {
                            $where_sql .= '((' . $search_field_name_ready_for_sql . $where_operator . ') OR (' . $search_field_name_ready_for_sql . "='')) ";
                        } else {
                            $where_sql .= '((' . $search_field_name_ready_for_sql . ') ' . $where_operator . "(:" . $search_field_name . '))';
                            $arr_for_bind[':' . $search_field_name] = $search_bind_value;
                        }
                    }
                }
            }
        }

        $obj->arr_for_bind = $arr_for_bind;

        if (empty($where_sql)) {
            $where_sql = " true ";
        }

        $obj->where_sql = $where_sql;

        return $obj;
    }


    private function triggerIsAllowed($listId, $cmpgId, $emailid)
    {

        $sql = "SELECT segments_.has_fast_actions, filter
              FROM campaigns_
              INNER JOIN segments_ ON campaigns_.seg_id = segments_.seg_id
              WHERE  campaigns_.list_id = " . intval($listId) . " AND segments_.list_id = " . intval($listId) . "
                    AND campaigns_.cmpg_id = " . intval($cmpgId) . " AND segments_.trigger_action = 'instantup' AND segments_.status = 'active' LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->execute();

        if ($query->rowCount() == 1) {

            $data = $query->fetchAll();
            $has_fast_actions = $data[0]["has_fast_actions"];
            $filter = $data[0]["filter"];

            $target = WI_FAST_ACTIONS::getSqlFromString(
                ($has_fast_actions == 't') ? true : false,
                (int)$listId
            );
            $alias = ($has_fast_actions == 't') ? 'wis.' : '';

            $sqlTest = "SELECT * FROM " . $target . " WHERE " . $alias . "emailid = '" . intval($emailid) . "' AND " . $filter . ' LIMIT 1';

            $query = $this->dbh->prepare($sqlTest);
            $query->execute();

            return ($query->rowCount() > 0)  ? true : false;
        }

        return false;
    }

    private function mobileTriggerIsAllowed($listId, $cmpgId, $emailid)
    {

        $sql = "SELECT segments_.has_fast_actions, filter
              FROM campaigns_
              INNER JOIN segments_ ON campaigns_.seg_id = segments_.seg_id
              INNER JOIN mobile.campaigns mc USING(cmpg_id)
              WHERE  campaigns_.list_id = " . intval($listId) . " AND segments_.list_id = " . intval($listId) . "
                    AND campaigns_.cmpg_id = " . intval($cmpgId) . "
                    AND segments_.trigger_action = 'instant'
                    AND segments_.status = 'active'
                    AND mc.send_sms_type = " . wlm_sms_campaign::SEND_SMS_ONLY .
            " LIMIT 1";
        $query = $this->dbh->prepare($sql);
        $query->execute();

        if ($query->rowCount() == 1) {

            $data = $query->fetchAll();
            $has_fast_actions = $data[0]["has_fast_actions"];
            $filter = $data[0]["filter"];

            $target = WI_FAST_ACTIONS::getSqlFromString(
                ($has_fast_actions == 't') ? true : false,
                (int)$listId
            );
            $alias = ($has_fast_actions == 't') ? 'wis.' : '';

            $sqlTest = "SELECT * FROM " . $target . " WHERE " . $alias . "emailid = '" . intval($emailid) . "' AND " . $filter . ' LIMIT 1';

            $query = $this->dbh->prepare($sqlTest);
            $query->execute();

            return ($query->rowCount() > 0)  ? true : false;
        }

        return false;
    }

    public function displayEmailMsg($list_id, $action, $replace = array())
    {
        global $smarty;

        $query = $this->dbh->prepare("SELECT " . $action . " AS msg FROM lists_messages_ WHERE list_id = '" . $this->list_id . "'");
        $query->execute();

        if (!($rS = $query->fetchObject())) return "";

        $msg = $rS->msg;

        if (is_array($replace)) {
            foreach ($replace as $pattern => $v) {
                $msg = str_replace($pattern, $v, $msg);
            }
        }

        $msg = $smarty->fetch("eval:" . $msg);

        return $msg;
    }

    public function getListFields()
    {
        // Get all the demographics \(-_-)/
        $query = $this->dbh->prepare("SELECT fieldname FROM lists_fields_ WHERE list_id = '" . $this->list_id . "' ORDER BY fieldpos");
        $query->execute();

        while ($rS = $query->fetch(PDO::FETCH_BOTH)) {
            if (!preg_match('/^[s]([0-9]+)[q]([0-9]+)$/', $rS['fieldname']))
                $fields["dgr_" . $rS['fieldname'] . "_"] = $rS['fieldname'];
        }

        return $fields;
    }

    public function processMethodAnonymize($user_id)
    {

        $arr = $this->doAnonymize($user_id);
        $this->sendServiceResponse($arr[0], $arr[1]);

        throw (new Exception('Subscriber not anonymized!'));
    }

    public function doAnonymize($user_id)
    {

        $up_log = __DIR__ . '/../../tmp/gabi/subscriber_service.log';

        if (empty($user_id)) {
            file_put_contents($up_log, 'Subscriber ' . $this->request['fv']['email'] . '] not anonymized: service_key mismatch!', FILE_APPEND);
            throw (new Exception('Subscriber not anonymized: service_key mismatch!'));
        }

        if (empty($this->request['type'])) {
            throw (new Exception('Subscriber anonymize: type is empty, type must be list_only or entire_account!'));
        }
        if (!in_array($this->request['type'], array('list_only', 'entire_account'))) {
            throw (new Exception('Subscriber anonymize: type mismatch, type must be list_only or entire_account!'));
        }
        if (empty($this->request['fv']['email'])) {
            throw (new Exception('Subscriber anonymize: email is empty!'));
        }

        if ($this->request['type'] == 'entire_account') {
            exec('/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym_account.php user_' . $user_id . ' ' . escapeshellarg($this->request['fv']['email']) . ' 0 ' . escapeshellarg($this->request['fv']['notify_email']) . ' 2>&1 &', $output, $return_val);
        } else {
            exec('/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym.php user_' . $user_id . ' list_id_' . $this->list_id . ' ' . escapeshellarg($this->request['fv']['email']) . ' 0 ' . escapeshellarg($this->request['fv']['notify_email']) . ' 2>&1 &', $output, $return_val);
        }

        if (!empty($output[0])) {
            return array(1, 'Subscriber ' . $this->request['fv']['email'] . ' anonimized!');
        }

        file_put_contents($up_log, 'Subscriber ' . $this->request['fv']['email'] . '] not anonymized: email address error!', FILE_APPEND);
        throw (new Exception('Subscriber not anonymized: email address error!'));
    }

    public function processMethodTriggerLink()
    {

        $request_fields_values = $this->fara_diacritice($this->request['fv']);
        if (empty($request_fields_values['cmpg_id'])) {
            throw (new Exception('Invalid campaign!'));
        }
        if (empty($request_fields_values['type_shortlink']) || !in_array($request_fields_values['type_shortlink'], ['shortlink1', 'shortlink2', 'shortunsubscribelink'])) {
            throw (new Exception('Invalid shortlink type!'));
        }

        $ms = mobileSubscriber::getInstance($this->list_id);

        $wsc = wlm_sms_campaign::fetchByCmpgId($request_fields_values['cmpg_id']);
        $ls = $wsc->getListSettings();

        $search_cond = !empty($request_fields_values['search_cond']) ? $request_fields_values['search_cond'] : '1=1';

        $sql   = "SELECT a.emailid, a.email, a.dgr_firstname_ AS firstname, a.dgr_lastname_ AS lastname, 
                         b.code, %s AS phone_number
                  FROM   subscribers_%d a
                         LEFT JOIN mobile.subscriber_%d ms ON a.emailid = ms.subscriber_id
                         LEFT JOIN mobile.url_users b ON a.emailid = b.emailid AND 
                                                         b.list_id = %d AND b.cmpg_id = %d AND
                                                         b.var_url = '%s'
                  WHERE  %s";
        $sql   = sprintf(
            $sql,
            !empty($ls['phone_dgr_name']) ? 'dgr_' . $ls['phone_dgr_name'] . '_' : 'ms.sms_phone_number',
            $this->list_id,
            $this->list_id,
            $this->list_id,
            $request_fields_values['cmpg_id'],
            $request_fields_values['type_shortlink'],
            $search_cond
        );
        $query = $this->dbh->prepare($sql);
        $query->execute();

        $users = [];
        while ($rS = $query->fetch(PDO::FETCH_BOTH)) {
            if (!empty($rS['code'])) {
                $code = $rS['code'];
            } else {
                $code = $ms->generateCode($this->list_id, $request_fields_values['cmpg_id'], $rS, $request_fields_values['type_shortlink']);
            }
            $users[] = [
                'email'     => $rS['email'],
                'phone'     => $rS['phone_number'],
                'firstname' => $rS['firstname'],
                'lastname'  => $rS['lastname'],
                'shortlink' => $wsc->getUrlTracking() . '/' . $code
            ];
        }

        $this->sendServiceResponse(1, 'Number of subscribers', array('count' => count($users), 'subscribers' => $users));
    }

    public function processMethodCreateSegment() {
	$request_fields_values = $this->fara_diacritice($this->request['fv']);
	if (empty($request_fields_values['segname'])) {
            throw (new Exception('Invalid segment name!'));
        }
	if (empty($request_fields_values['id_conventie'])) {
            throw (new Exception('Invalid id_conventie!'));
        }
	if (empty($request_fields_values['tip'])) {
            throw (new Exception('Invalid tip!'));
        }
	if (empty($request_fields_values['tara'])) {
            throw (new Exception('Invalid tara!'));
        }	
	if (empty($request_fields_values['id_specializari'])) {
            throw (new Exception('Invalid id_specializari!'));
        }
	$filter = "(mail_type = ''html'') AND (subscribe_status = ''confirmed'') AND (dgr_tip_ = ''%s'') AND (dgr_id_conventie_ = ''%s'') AND (LOWER(dgr_tara_) = ''%s'') AND (string_to_array(dgr_id_specializari_, '','')::int[] && ARRAY[%s])";
	$filter = sprintf($filter, $request_fields_values['tip'], $request_fields_values['id_conventie'], $request_fields_values['tara'], $request_fields_values['id_specializari']);
	$definition = sprintf("SELECT * FROM subscribers_%d WHERE %s", $this->list_id, $filter);
	$sql = "INSERT INTO segments_(list_id, segname, filter, definition) VALUES(%d, '%s', '%s', '%s') RETURNING seg_id, segname";
	$sql = sprintf($sql, $this->list_id, $request_fields_values['segname'], $filter, $definition);
	$query = $this->dbh->prepare($sql);
        $query->execute();
	if ($rS = $query->fetch(PDO::FETCH_BOTH)) {
            $this->sendServiceResponse(1, 'Segment created', array('id' => $rS['seg_id'], 'segname' => $rS['segname']));
	} else {
            throw (new Exception('Error created segment!'));
	}
    }
    
    public function processMethodReportBySegment() {
        $request_fields_values = $this->fara_diacritice($this->request['fv']);
        if (empty($request_fields_values['seg_id'])) {
            throw (new Exception('Invalid segment id!'));
        }
        $cmpgs = [];
        $data = [];
        if (!empty($this->request['report_type'])) {
            $sql = "SELECT cmpg_id FROM campaigns_ WHERE list_id = %d AND seg_id = %d";
            $sql = sprintf($sql, $this->list_id, $request_fields_values['seg_id']);
            $query = $this->dbh->prepare($sql);
            $query->execute();
            while ($rS = $query->fetch(PDO::FETCH_BOTH)) {
                $cmpgs[] = $rS['cmpg_id'];
            }
            $offset = isset($this->request['offset']) ? (int)$this->request['offset'] : 0;
            $limit  = !empty($this->request['limit']) ? (int)$this->request['limit'] : 500;
            switch ($this->request['report_type']) {
                case 'open':
                    $sql = "SELECT json_agg(DISTINCT email) AS emails
                            FROM (
                                SELECT email FROM readstatus_ WHERE list_id = %d AND %s ORDER BY email OFFSET %d LIMIT %d
                            )";
                    $sql = sprintf($sql, $this->list_id, count($cmpgs) > 1 ? "cmpg_id IN (" . implode(',', $cmpgs) . ")" : "cmpg_id = {$cmpgs[0]}", $offset, $limit);
                break;
                case 'unopen':
                    $sql = "SELECT json_agg(DISTINCT email) AS emails
                            FROM (
                                SELECT email
                                FROM   sendcampaigns.sendcampaigns_%d 
                                WHERE  list_id = %d AND %s AND email NOT IN (SELECT DISTINCT email FROM readstatus_ WHERE list_id = %d AND %s)
                                ORDER  BY email
                                OFFSET %d LIMIT %d
                            )";
                    $sql = sprintf($sql, $this->list_id, 
                                         $this->list_id, count($cmpgs) > 1 ? "cmpg_id IN (" . implode(',', $cmpgs) . ")" : "cmpg_id = {$cmpgs[0]}",
                                         $this->list_id, count($cmpgs) > 1 ? "cmpg_id IN (" . implode(',', $cmpgs) . ")" : "cmpg_id = {$cmpgs[0]}", 
                                         $offset, $limit);
                break;
                case 'unsub':
		    $sql = "SELECT json_agg(t.*) AS emails
                            FROM (
                                SELECT x.email, u.unsub_date 
                                FROM   unsubscribers_ u
                                       INNER JOIN (SELECT emailid, email FROM subscribers_%d UNION SELECT emailid, email FROM unsubscribe.subscribers_%d) x ON u.emailid = x.emailid
                                WHERE %s AND u.report_as_spam = 0
                                ORDER BY x.email OFFSET %d LIMIT %d
                            ) t";
                    $sql = sprintf($sql, $this->list_id, $this->list_id, count($cmpgs) > 1 ? "cmpg_id IN (" . implode(',', $cmpgs) . ")" : "cmpg_id = {$cmpgs[0]}", $offset, $limit);
		break;
		case 'bounce':
                    $sql = "SELECT json_agg(x.*) AS bounces
                            FROM (
                                SELECT email, 
				       CASE 
					   WHEN a > 0 THEN 'a'
					   WHEN a1 > 0 THEN 'a1'
					   WHEN a2 > 0 THEN 'a2'
					   WHEN b > 0 THEN 'b'
					   WHEN b1 > 0 THEN 'b1'
					   WHEN b2 > 0 THEN 'b2'
					   WHEN c > 0 THEN 'c'
					   WHEN d > 0 THEN 'd'
					   WHEN e > 0 THEN 'e'
					   WHEN f > 0 THEN 'f'
					   ELSE 'none' 	
                                        END AS type,
                                        info,
                                        bounce_date AS date
                                FROM   bounce_backs_ 
                                WHERE  %s
                            ) x";
                    $sql = sprintf($sql, count($cmpgs) > 1 ? "cmpg_id IN (" . implode(',', $cmpgs) . ")" : "cmpg_id = {$cmpgs[0]}");
                break;
            }
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);                                   
            echo json_encode($data);
        } else {                                    
            $sql = "SELECT cmpg_id, cmpgname, description, send_schedule,
                           sent_counter, opened_counter, ct_counter, uc_counter, tc_counter, bounce_counter, unsub_counter
                    FROM   campaigns_                       
                    WHERE  list_id = %d AND seg_id = %d";
            $sql = sprintf($sql, $this->list_id, $request_fields_values['seg_id']);
            $query = $this->dbh->prepare($sql);
            $query->execute();
            while ($rS = $query->fetch(PDO::FETCH_BOTH)) {
                $cmpgs[] = [
                                'id'                => $rS['cmpg_id'],
                                'cmpgname'          => $rS['cmpgname'],
                                'link'		    => "https://wlm.whiteimage.eu/clients/wlm/campaigns/includes/preview.php?list_id={$this->list_id}&cmpg_id={$rS['cmpg_id']}",
                                'description'       => $rS['description'],
                                'send_date'         => $rS['send_schedule'],
                                'sent_counter'      => $rS['sent_counter'],
                                'opened_counter'    => $rS['opened_counter'],
                                'ct_counter'        => $rS['ct_counter'],
                                'uc_counter'        => $rS['uc_counter'],
                                'tc_counter'        => $rS['tc_counter'],
                                'bounce_counter'    => $rS['bounce_counter'],
                                'unsub_counter'     => $rS['unsub_counter'],
                           ];
            }        
            echo json_encode($cmpgs);
        }
    }

    public function processMethodReportByList() {
        $request_fields_values = $this->fara_diacritice($this->request['fv']);        
        $cmpgs = [];
        $data = [];
        if (!empty($this->request['report_type'])) {            
            $offset = isset($this->request['offset']) ? (int)$this->request['offset'] : 0;
            $limit  = !empty($this->request['limit']) ? (int)$this->request['limit'] : 500;
            switch ($this->request['report_type']) {                
                case 'unsub':
		    $sql = "SELECT json_agg(t.*) AS emails
                            FROM (
                                  SELECT * FROM (
                                	SELECT email, unsubscribe_date AS unsub_date FROM subscribers_%d WHERE unsubscribe_status = 'confirmed'
                                	UNION 
                                	SELECT email, unsubscribe_date AS unsub_date FROM unsubscribe.subscribers_%d 
                                  ) x
                                  ORDER BY email OFFSET %d LIMIT %d                              
                            ) t";
                    $sql = sprintf($sql, $this->list_id, $this->list_id, $offset, $limit);
		break;
		case 'bounce':
                    $sql = "SELECT json_agg(x.*) AS bounces
                            FROM (
                                SELECT email, 
				       CASE 
					   WHEN a > 0 THEN 'a'
					   WHEN a1 > 0 THEN 'a1'
					   WHEN a2 > 0 THEN 'a2'
					   WHEN b > 0 THEN 'b'
					   WHEN b1 > 0 THEN 'b1'
					   WHEN b2 > 0 THEN 'b2'
					   WHEN c > 0 THEN 'c'
					   WHEN d > 0 THEN 'd'
					   WHEN e > 0 THEN 'e'
					   WHEN f > 0 THEN 'f'
					   ELSE 'none' 	
                                        END AS type,
                                        info,
                                        bounce_date AS date
                                FROM   bounce_backs_ b
                                       INNER JOIN campaigns_ c ON b.cmpg_id = c.cmpg_id AND c.list_id = %d
                                ORDER BY email OFFSET %d LIMIT %d
                            ) x";
                    $sql = sprintf($sql, $this->list_id, $offset, $limit);
                break;
            }
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $data = $query->fetch(PDO::FETCH_ASSOC);                                   
            echo json_encode($data);
        }
    }


}
