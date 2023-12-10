# Useful Code

A place where I store code I find useful. 

# PHP

### [PHP Function for Executing Prepared Statements with Named Parameters](https://github.com/User00092/useful_code/blob/fcd7951a74ec97ea6b61cc7c1fbf4a408aebfb58/php/named_param_executor.php)

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
