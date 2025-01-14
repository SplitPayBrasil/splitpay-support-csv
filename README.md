# Splitpay Support CSV

## Overview
Splitpay Support CSV is a PHP library designed to assist in handling CSV files. With this component, you can easily perform conversions such as "Array to CSV" or "JSON to CSV" with a structured and flexible API.

## Installation
To install the library, use Composer:

```bash
composer require splitpay/support-csv
```

## Usage
To use the library, you need to import the following classes:

- `Parser`
- `Layout`
- `Column`

Below is an example of how to use Splitpay Support CSV:

```php
<?php

require 'vendor/autoload.php';

use Splitpay\Support\Csv\Parser;
use Splitpay\Support\Csv\Layout;
use Splitpay\Support\Csv\Column;

// Creating columns
$userName = new Column(name: 'userName', type: 'string', alias: 'user', filters: ['trim', 'strtolower', 'ucwords']);
$email = new Column(name: 'email', type: 'string');
$password = new Column('password');

// Creating the layout
$layout = new Layout([$userName, $email, $password]);

// Creating the parser
$parser = new Parser($layout);

// Converting array to CSV
$csv = $parser->parseFromArray([
  [
    'userName' => 'Esdras Schonevald',
    'email' => 'esdras@splitpaybrasil.com.br',
    'password' => '!ChangeMe@123!'
  ],
  [
    'userName' => 'Joao Ricardo',
    'email' => 'joaoricardo@splitpaybrasil.com.br',
    'password' => '!ChangeMe@123!'
  ],
  [
    'userName' => 'Yago Tomaz',
    'email' => 'yago@splitpaybrasil.com.br',
    'password' => '!ChangeMe@123!'
  ]
]);

echo $csv;
```

## Features
- Convert arrays or JSON to CSV with customizable layouts.
- Define column properties such as name, type, alias, and filters.
- Supports filters for data transformation, e.g., `trim`, `strtolower`, and `ucwords`.

## Contributing
Contributions are welcome! Feel free to open issues or submit pull requests on the [GitHub repository](#).

## License
This project is licensed under the MIT License. See the LICENSE file for more details.
