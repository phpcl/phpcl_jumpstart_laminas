<?php
// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

use Laminas\Validator\Between;

$data      = ['andrew' => 16, 'doug' => 30, 'cal' => 65, 'flintstone' => 200];
$validator = new Between(['min' => 18, 'max' => 65, 'inclusive' => TRUE]);

foreach ($data as $name => $age) {
    echo "$name, you entered this for your age: $age\n";
    if ($validator->isValid($age)) {
        echo "You are welcome to continue filling out the policy application\n\n";
    } else {
        echo "Sorry! " . implode("\n", $validator->getMessages()) . "\n\n";
    }
}

// RESULT:
/*
andrew, you entered this for your age: 18
You are welcome to continue filling out the policy application

doug, you entered this for your age: 30
You are welcome to continue filling out the policy application

cal, you entered this for your age: 88
Sorry! The input is not between '18' and '65', inclusively

flintstone, you entered this for your age: 200
Sorry! The input is not between '18' and '65', inclusively
*/
