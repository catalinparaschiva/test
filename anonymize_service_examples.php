<?php
/**
 * Anonymize Service - Client Examples
 *
 * This file demonstrates how to consume the anonymize_service.php API
 */

class AnonymizeServiceClient
{
    private $endpoint;
    private $service_key;

    public function __construct($endpoint, $service_key)
    {
        $this->endpoint = rtrim($endpoint, '/') . '/anonymize_service.php';
        $this->service_key = $service_key;
    }

    /**
     * Anonymize entire user account
     */
    public function anonymizeAccount($email, $notify_email = null)
    {
        return $this->call('account', $email, null, $notify_email);
    }

    /**
     * Anonymize user in specific list
     */
    public function anonymizeList($email, $list_id, $notify_email = null)
    {
        return $this->call('list', $email, $list_id, $notify_email);
    }

    /**
     * Generic API call method
     */
    private function call($method, $email, $list_id = null, $notify_email = null)
    {
        $params = array(
            'service_key' => $this->service_key,
            'method' => $method,
            'email' => $email,
        );

        if ($list_id !== null) {
            $params['list_id'] = $list_id;
        }

        if ($notify_email !== null) {
            $params['notify_email'] = $notify_email;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);
        $result['http_code'] = $http_code;

        return $result;
    }
}

/**
 * USAGE EXAMPLES
 */

// Example 1: Anonymize entire account
echo "Example 1: Anonymize entire account\n";
echo "====================================\n";

$client = new AnonymizeServiceClient(
    'http://yourdomain.com',
    'YOUR_API_KEY_HERE'
);

$result = $client->anonymizeAccount('user@example.com', 'admin@example.com');

echo "Status: " . ($result['code'] == 1 ? 'SUCCESS' : 'ERROR') . "\n";
echo "Message: " . $result['message'] . "\n";
echo "Method: " . $result['method'] . "\n";
echo "Email: " . $result['email'] . "\n\n";


// Example 2: Anonymize user in specific list
echo "Example 2: Anonymize user in specific list\n";
echo "==========================================\n";

$result = $client->anonymizeList('subscriber@example.com', 1234, 'admin@example.com');

echo "Status: " . ($result['code'] == 1 ? 'SUCCESS' : 'ERROR') . "\n";
echo "Message: " . $result['message'] . "\n";
echo "Method: " . $result['method'] . "\n";
echo "Email: " . $result['email'] . "\n\n";


// Example 3: Error handling
echo "Example 3: Error handling\n";
echo "========================\n";

$result = $client->anonymizeList('invalid-email', 1234);

if ($result['code'] != 1) {
    echo "Error Code: " . $result['code'] . "\n";
    echo "Error Message: " . $result['message'] . "\n";
} else {
    echo "Anonymization successful\n";
}

echo "\n\n";

/**
 * RAW CURL EXAMPLES
 */

echo "Raw cURL Examples:\n";
echo "=================\n\n";

echo "1. Anonymize entire account:\n";
echo "curl -X POST http://yourdomain.com/anonymize_service.php \\\n";
echo "  -d \"service_key=YOUR_API_KEY\" \\\n";
echo "  -d \"method=account\" \\\n";
echo "  -d \"email=user@example.com\" \\\n";
echo "  -d \"notify_email=admin@example.com\"\n\n";

echo "2. Anonymize specific list:\n";
echo "curl -X POST http://yourdomain.com/anonymize_service.php \\\n";
echo "  -d \"service_key=YOUR_API_KEY\" \\\n";
echo "  -d \"method=list\" \\\n";
echo "  -d \"email=user@example.com\" \\\n";
echo "  -d \"list_id=1234\" \\\n";
echo "  -d \"notify_email=admin@example.com\"\n\n";

echo "3. Anonymize without notification:\n";
echo "curl -X POST http://yourdomain.com/anonymize_service.php \\\n";
echo "  -d \"service_key=YOUR_API_KEY\" \\\n";
echo "  -d \"method=account\" \\\n";
echo "  -d \"email=user@example.com\"\n";

?>
