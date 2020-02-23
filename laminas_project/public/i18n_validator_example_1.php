<?php
// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

use Laminas\I18n\Validator\PostCode;

$data = ['RG40 4HN', '12345', 'J4B 5E6'];
$list = [
    'UK'     => new PostCode(['locale' => 'en_GB']),
    'USA'    => new PostCode(['locale' => 'en_US']),
    'Canada' => new PostCode(['locale' => 'en_CA']),
];
$valid = [];

foreach ($list as $key => $validator) {
    foreach ($data as $postCode) {
        $valid[$key][$postCode] = ($validator->isValid($postCode)) ? 'Y' : 'N';
    }
}

$pattern = "| %10s | %10s | %10s |\n";
$output = str_repeat(' ', 11)
        . vsprintf($pattern, $data);
$output .= trim(str_repeat(' ---------- |', 4)) . "\n";
foreach ($valid as $key => $result) {
    $output .= sprintf("%10s ", $key);
    $output .= vsprintf($pattern, array_values($result));
}
echo $output;

// RESULT:
/*
           |   RG40 4HN |      12345 |    J4B 5E6 |
---------- | ---------- | ---------- | ---------- |
        UK |          Y |          N |          N |
       USA |          N |          Y |          N |
    Canada |          N |          N |          Y |

*/
