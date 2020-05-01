# php-yandex-taxi-api

PHP library for [Yandex.Taxi API](https://fleet.taxi.yandex.ru/api/docs/concepts/index.html)

## Installation

You can use [Composer](https://getcomposer.org)

```bash
composer require ipinchuk/php-yandex-taxi-api
```

or download from [GitHub](https://github.com/i-pinchuk/php-yandex-taxi-api)

## Usage
 
```php
require __DIR__ . '/vendor/autoload.php';

$clientId = 'YOUR_CLIENT_ID';
$apiKey = 'YOUR_API_KEY';
$parkId = 'YOUR_PARK_ID';

$client = new IPinchuk\YandexTaxi\Client($clientId, $apiKey, $parkId);
```

### Cars
#### Gets a list of cars
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/Cars/v1_parks_cars_list_post.html) 
```php
$cars = $client->api('cars')->all();
```


### Driver Profiles
#### Gets a list of driver profiles
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/DriverProfiles/v1_parks_driver-profiles_list_post.html) 
```php
$cars = $client->api('drivers')->all();
```

####  Change association with driver profile and car
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/DriverProfiles/v1_parks_driver-profiles_car-bindings_put.html) 
```php
$profile_id = "SOME_DRIVER_PROFILE_ID";
$car_id = "SOME_CAR_ID";

$cars = $client->api('drivers')->bindVehicle($profile_id, $car_id);
```

####  Removes driver profile association with vehicle
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/DriverProfiles/v1_parks_driver-profiles_car-bindings_delete.html) 
```php
$profile_id = "SOME_DRIVER_PROFILE_ID";
$car_id = "SOME_CAR_ID";

$cars = $client->api('drivers')->unbindVehicle($profile_id, $car_id);
```

### Driver work rules
#### Gets a list of working rules.
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/DriverWorkRules/v1_parks_driver-work-rules_get.html) 
```php
$cars = $client->api('rules')->all();
```

### Orders
#### Gets a list of orders.
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/Orders/v1_parks_orders_list_post.html) 
```php
$cars = $client->api('orders')->all();
```

### Transactions
#### Gets a list of transactions.
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/Transactions/v2_parks_transactions_list_post.html) 
```php
$cars = $client->api('transactions')->all();
```

#### Gets a list of transaction categories.
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/Transactions/v2_parks_transactions_categories_list_post.html) 
```php
$cars = $client->api('transactions')->categories();
```

#### Gets a list of transactions for specified driver
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/Transactions/v2_parks_driver-profiles_transactions_list_post.html) 
```php
$driver_id = 'SOME_DRIVER_ID';

$cars = $client->api('transactions')->driverTransactions($driver_id);
```

#### Gets a list of transactions for the orders
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/Transactions/v2_parks_orders_transactions_list_post.html) 
```php
$order_ids = ['ORDER_ID_1', 'ORDER_ID_2', 'ORDER_ID_3'];

$cars = $client->api('transactions')->orderTransactions($order_ids);
```

#### Create a new driver transaction
[View API method documentation](https://fleet.taxi.yandex.ru/api/docs/reference/Transactions/v2_parks_driver-profiles_transactions_post.html) 
```php
$driver_id = 'SOME_DRIVER_ID';
$amount = '-10'; // You can increase or decrease driver balance
$cad_id = 'SOME_TRANSACTION_CATEGORY_ID';
$description = 'SOME_TRANSACTION_DESCRIPTION';

$cars = $client->api('transactions')->createTransaction($driver_id, $amount, $cad_id, $description);
```
or
```php

$driver_id = 'SOME_DRIVER_ID';
$amount = '10';
$cad_id = 'SOME_TRANSACTION_CATEGORY_ID';
$description = 'SOME_TRANSACTION_DESCRIPTION';

// For increase balance.
$cars = $client->api('transactions')->increaseBalance($driver_id, $amount, $cad_id, $description);
// For decrease balance
$cars = $client->api('transactions')->decreaseBalance($driver_id, $amount, $cad_id, $description);
```

### Add proxy server

```php
$client->setProxy('YOR_PROXY_IP');
```

## Code Quality

You need to configure API Key, Client ID and Park ID information in ClientTest.php and run the PHPUnit tests with [PHPUnit](https://phpunit.de)
```bash
phpunit tests/
```

## License

> MIT License
>  
>  Copyright (c) 2020 Igor Pinchuk
>  
>  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:
>  
>  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.
>  
>  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.