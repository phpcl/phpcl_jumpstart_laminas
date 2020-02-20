<?php
// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

use Laminas\Filter\PregReplace;

$options = [
    'pattern' => '/\d{2,4}-\d{2,4}-\d{2,4}-(\d{2,4})/',
    'replacement' => 'xxxx-xxxx-xxxx-$1'
];
$raw_data = 'Sensitive credit card data: 1111-2222-3333-4444';

echo "\n\n***********************************";
echo "\nOriginal: ";
echo "\n***********************************\n";
echo $raw_data;

echo "\n\n***********************************";
echo "\nPregReplace: ";
echo "\n***********************************\n";
echo (new PregReplace($options))->filter($raw_data);

// RESULT:
/*
Sensitive credit card data: xxxx-xxxx-xxxx-4444
*/
