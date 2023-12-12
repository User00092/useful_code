# Useful Code

A place where I store code I find useful. 

#### Links may not be up-to-date, please check the proper paths before utilizing.

# PHP

### [PHP Function for Executing Prepared Statements with Named Parameters](https://github.com/User00092/useful_code/blob/a5a3cc33fe98247d822f5086898ec97f33083603/php/named_param_executor.php)

```php
executeWithNamedParameters();
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `conn` | `mysqli` | **Required**. a mysqli connection instance |
| `sql` | `string` | **Required**. the sql statement |
| `namedValues` | `array` | **Required**. an array of key values |

##### Example:
```php
$conn = new \mysqli('servername', 'username', 'password', 'database');
$accountQuery = executeWithNamedParameters($conn, "SELECT * FROM table WHERE email = :email", [
    ":email" => "name@company.com"
]);
```



### [PHP AES-256 Encryption and Decryption Class](https://github.com/User00092/useful_code/blob/fed3b7b2d40730dd69252948bf7653188dd67458/php/AES256.php)

```php
new AES256();
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `key` | `string` | **Required**. the key to be used for encryption and decryption |

##### Example:
```php
// Example key (32 bytes)
$key = 'abcdefghijklmnopqrstuvwxys012345';

// Create an instance of the AES256 class
$aes256 = new AES256($key);

// Example plaintext
$plaintext = 'This is a secret message.';

// Encrypt with random nonce
$encryptedData = $aes256->encrypt($plaintext);

if ($encryptedData !== null) {
    echo "Encrypted Data: $encryptedData\n";

    // Decrypt the data
    $decryptedData = $aes256->decrypt($encryptedData);

    if ($decryptedData !== null) {
        echo "Decrypted Data: $decryptedData\n";
    } else {
        echo "Decryption failed.\n";
    }
} else {
    echo "Encryption failed.\n";
}

// Encrypt with specified nonce
$customNonce = base64_encode(random_bytes(AES256::AES256_NONCE_SIZE));
$encryptedDataWithIV = $aes256->encryptWithIV($plaintext, $customNonce);

if ($encryptedDataWithIV !== null) {
    echo "\nEncrypted Data with Custom Nonce: $encryptedDataWithIV\n";

    // Decrypt the data
    $decryptedDataWithIV = $aes256->decrypt($encryptedDataWithIV);

    if ($decryptedDataWithIV !== null) {
        echo "Decrypted Data with Custom Nonce: $decryptedDataWithIV\n";
    } else {
        echo "Decryption failed.\n";
    }
} else {
    echo "Encryption failed.\n";
}
```



### [PHP CSRF Protection Class](https://github.com/User00092/useful_code/blob/ca1ec6b006064df24efc6dce710b4835b2b655a1/php/CSRFProtection.php)

```php
new CSRFProtection();
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `config` | `array` | specify data used in the CSRF class |

##### Example:
```php
$config = [
    'session_key' => 'custom_csrf_token', // Optional: Customize session key
    'token_name' => '_custom_csrf',       // Optional: Customize token name
    'expiration' => 600,                  // Optional: Customize token expiration time (in seconds)
];

$csrfProtection = new CSRFProtection($config);

// Generate and retrieve CSRF token
$token = $csrfProtection->generateToken();
echo "Generated Token: $token\n";

// Get the current CSRF token
$currentToken = $csrfProtection->getToken();
echo "Current Token: $currentToken\n";

// Validate a submitted token
$submittedToken = $_POST['custom_csrf_token'] ?? '';
if ($csrfProtection->validateToken($submittedToken)) {
    echo "Token is valid.\n";
} else {
    echo "Token is invalid or expired.\n";
}

// Get the CSRF token as a hidden input field for a form
$formTokenField = $csrfProtection->getTokenField();
echo "Form Token Field: $formTokenField\n";

// Get the CSRF token as a meta tag for use in HTML headers
$metaTokenTag = $csrfProtection->getTokenMeta();
echo "Meta Token Tag: $metaTokenTag\n";

```


