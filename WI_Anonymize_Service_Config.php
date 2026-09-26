<?php

class WI_Anonymize_Service_Config
{
    const METHOD_ACCOUNT = 'account';
    const METHOD_LIST = 'list';

    const VALID_METHODS = [
        self::METHOD_ACCOUNT,
        self::METHOD_LIST,
    ];

    const ANONYM_ACCOUNT_SCRIPT = '/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym_account.php';
    const ANONYM_LIST_SCRIPT = '/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym.php';

    const RESPONSE_TYPE_JSON = 'json';
}
?>
