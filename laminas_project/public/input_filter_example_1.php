<?php
// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

use Laminas\Filter\{StringTrim, StripTags};
use Laminas\Validator\{StringLength, };
use Laminas\I18n\Validator\Alnum;
use Laminas\InputFilter\Factory;

$goodData = [
    'full_name'   => 'Andrew Caya ',
    'postal_code' => ' J4B 5E6'
];
$badData = [
    'full_name'   => 'Fred <script>alert("Hacked");</script>',
    'postal_code' => '01234567890123456789'
];

$factory = new Factory();
$inputFilter = $factory->createInputFilter([
    'full_name' => [
        'name'       => 'full_name',
        'required'   => true,
        'validators' => [
            ['name' => Alpha::class, 'options' => [ 'allowWhiteSpace' => TRUE ]],
        ],
        'filters' => [
            ['name' => StripTags::class],
            ['name' => StringTrim::class],
        ],
    ],
    'postal_code' => [
        'name'       => 'postal_code',
        'required'   => true,
        'validators' => [
            ['name' => Alnum::class, 'options' => ['allowWhiteSpace' => TRUE]],
            ['name' => StringLength::class, 'options' => ['max' => 10]],
        ],
        'filters' => [
            ['name' => StripTags::class],
            ['name' => StringTrim::class],
        ],
    ],
]);

echo "\n\n**************************************";
echo "\nGood Data";
echo "\n**************************************\n";
var_dump($goodData);
echo "\n";
$inputFilter->setData($goodData);
echo ($inputFilter->isValid()) ? 'VALID' : 'INVALID';
echo "\n";
var_dump($inputFilter->getValues());


echo "\n\n**************************************";
echo "\nBad Data";
echo "\n**************************************\n";
$inputFilter->setData($badData);
echo ($inputFilter->isValid()) ? 'VALID' : 'INVALID';
echo "\n";
var_dump($inputFilter->getMessages());
echo "\n";


/** RESULT:
**************************************
Good Data
**************************************
array(2) {
  ["full_name"]=>
  string(12) "Andrew Caya "
  ["postal_code"]=>
  string(8) " J4B 5E6"
}

VALID
array(2) {
  ["full_name"]=>
  string(11) "Andrew Caya"
  ["postal_code"]=>
  string(7) "J4B 5E6"
}


**************************************
Bad Data
**************************************
INVALID
array(2) {
  ["full_name"]=>
  array(1) {
    ["notAlpha"]=>
    string(44) "The input contains non alphabetic characters"
  }
  ["postal_code"]=>
  array(1) {
    ["stringLengthTooLong"]=>
    string(41) "The input is more than 10 characters long"
  }
}

*/
