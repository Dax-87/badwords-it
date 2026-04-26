# badwords-it

Italian profanity and spam filter for PHP.

Three-level detection engine:
1. **Regex** with word boundaries — isolated words
2. **Substring** — catches concatenations like `cazzomerda`
3. **Phrases** — compound expressions like `figlio di puttana`

Email filtering checks the local part and domain name independently (no word boundaries, since emails have no spaces).

---

## Requirements

- PHP 8.0+
- Composer

---

## Installation

```bash
composer require dax-87/badwords-it
```

---

## Usage

```php
use BadwordsIt\Filter;

$filter = new Filter();
```

### Check a text field

```php
$filter->hasProfanity('che cazzo');       // true
$filter->hasProfanity('Ciao, come stai'); // false
```

### Check an email address

```php
$filter->hasProfanityEmail('merda@test.com');        // true
$filter->hasProfanityEmail('mario.rossi@gmail.com'); // false
```

### Check for spam keywords

```php
$filter->hasSpam('buy bitcoin now');              // true
$filter->hasSpam('Buongiorno, vorrei un preventivo'); // false
```

### Check multiple fields at once

```php
$filter->checkFields(['Mario', 'Rossi', 'Messaggio pulito']); // false
$filter->checkFields(['Mario', 'cazzo', 'testo ok']);          // true
```

### Full inspection (profanity + spam in one call)

```php
$result = $filter->inspect(
    textFields: [$name, $surname, $message, $address],
    email: $email
);

if ($result['profanity']) {
    // reject: profanity detected
}
if ($result['spam']) {
    // reject: spam detected
}
```

### Typical contact form integration

```php
require 'vendor/autoload.php';

use BadwordsIt\Filter;

$filter = new Filter();

$name    = $_POST['name']    ?? '';
$surname = $_POST['surname'] ?? '';
$email   = $_POST['email']   ?? '';
$message = $_POST['message'] ?? '';

$result = $filter->inspect([$name, $surname, $message], $email);

if ($result['profanity'] || $result['spam']) {
    http_response_code(400);
    echo json_encode(['error' => 'Content not allowed.']);
    exit;
}

// proceed with form processing
```

---

## Custom word lists

You can pass your own data files to override the defaults:

```php
$filter = new Filter(
    profanityFile: '/path/to/my-profanity.php',
    spamFile:      '/path/to/my-spam.php'
);
```

Each file must return an array matching the structure of the default files in `data/`.

---

## Running tests

```bash
composer install
./vendor/bin/phpunit tests/
```

---

## License

MIT
