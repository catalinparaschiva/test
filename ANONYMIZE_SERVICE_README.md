# Anonymize Service - API Documentation

## Overview
The Anonymize Service is a dedicated webservice that handles user anonymization with two methods:
- **account**: Anonymize entire user account across all lists
- **list**: Anonymize user data in a specific list only

## Endpoint
```
POST/GET /anonymize_service.php
```

## Authentication
All requests require a valid `service_key` parameter that must be verified against the system's user database.

## Required Parameters

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `service_key` | string | Yes | API key for authentication |
| `method` | string | Yes | Anonymization scope: `account` or `list` |
| `email` | string | Yes | Email address to anonymize |
| `list_id` | integer | Conditional | Required when method=`list` |
| `notify_email` | string | No | Email to notify when anonymization is complete |

## Usage Examples

### 1. Anonymize Entire Account
Anonymize all data for a user across all lists.

**Request:**
```
POST /anonymize_service.php
Content-Type: application/x-www-form-urlencoded

service_key=your_api_key&method=account&email=user@example.com&notify_email=admin@example.com
```

**cURL Example:**
```bash
curl -X POST http://yourdomain.com/anonymize_service.php \
  -d "service_key=YOUR_API_KEY" \
  -d "method=account" \
  -d "email=user@example.com" \
  -d "notify_email=admin@example.com"
```

**Response (Success):**
```json
{
  "code": 1,
  "message": "User user@example.com anonymized successfully",
  "method": "account",
  "email": "user@example.com"
}
```

### 2. Anonymize User in Specific List
Anonymize user data only in a specific mailing list.

**Request:**
```
POST /anonymize_service.php
Content-Type: application/x-www-form-urlencoded

service_key=your_api_key&method=list&email=user@example.com&list_id=1234&notify_email=admin@example.com
```

**cURL Example:**
```bash
curl -X POST http://yourdomain.com/anonymize_service.php \
  -d "service_key=YOUR_API_KEY" \
  -d "method=list" \
  -d "email=user@example.com" \
  -d "list_id=1234" \
  -d "notify_email=admin@example.com"
```

**Response (Success):**
```json
{
  "code": 1,
  "message": "User user@example.com anonymized successfully",
  "method": "list",
  "email": "user@example.com"
}
```

## Error Responses

### Missing Required Parameter
```json
{
  "code": -1,
  "message": "Missing required parameter: service_key"
}
```

### Invalid Method
```json
{
  "code": -1,
  "message": "Invalid method. Allowed values: account, list"
}
```

### Invalid Email Format
```json
{
  "code": -1,
  "message": "Invalid email format"
}
```

### Missing List ID (for list method)
```json
{
  "code": -1,
  "message": "Missing required parameter for method \"list\": list_id"
}
```

### Invalid Service Key
```json
{
  "code": -1,
  "message": "Invalid service_key or unauthorized access"
}
```

### Anonymization Failed
```json
{
  "code": -1,
  "message": "Anonymization failed: email not found or access denied"
}
```

## Response Codes

| Code | Meaning |
|------|---------|
| 1 | Success - Anonymization completed |
| -1 | Error - Check message for details |

## Validation Rules

### service_key
- Required
- Minimum 5 characters
- Must exist in users_ table with matching list_id (if provided)

### method
- Required
- Must be exactly: `account` or `list`

### email
- Required
- Must be a valid email format
- Converted to lowercase for processing

### list_id
- Optional, but required when method=`list`
- Must be a positive integer
- Must be accessible by the user (service_key)

### notify_email
- Optional
- If provided, notification email will be sent when anonymization completes

## Internal Process

The service executes the following scripts asynchronously:

### For method=account
```bash
/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym_account.php user_[USER_ID] [EMAIL] 0 [NOTIFY_EMAIL]
```

### For method=list
```bash
/usr/bin/php -q /var/www/html/clients/wlm/processes/anonym.php user_[USER_ID] list_id_[LIST_ID] [EMAIL] 0 [NOTIFY_EMAIL]
```

## Logging

All operations are logged to:
```
/logs/anonymize_service/YYYY-MM-DD.log
```

Log entries include:
- Timestamp
- Operation status (SUCCESS/ERROR)
- Email address
- Method used
- User ID
- Error message (if applicable)

## Security Considerations

1. **API Key Security**: Treat `service_key` as confidential
2. **HTTPS**: Always use HTTPS in production
3. **Rate Limiting**: Consider implementing rate limiting
4. **Audit Logging**: All anonymizations are logged for compliance
5. **GDPR Compliance**: This service supports GDPR right-to-be-forgotten requests

## Notes

- Anonymization is executed asynchronously in the background
- Email notifications are sent asynchronously if notify_email is provided
- The service validates service_key against both users_ and lists_ tables
- Email addresses are normalized to lowercase for consistent processing
