<?php
// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

use Laminas\Form\Element;
use Laminas\Form\Factory;

$factory = new Factory();
$form    = $factory->createForm([
    'elements' => [
        [
            'spec' => [
                'name' => 'username',
                'options' => ['label' => 'Username'],
                'type'  => 'Text',
                'attributes' => [
                    'size' => '10',
                    'placeholder' => 'Enter Username',
                ],
            ],
        ],
        [
            'spec' => [
                'name' => 'password',
                'options' => ['label' => 'Password'],
                'type'  => 'Password',
                'attributes' => ['size' => '20'],
            ],
        ],
        [
            'spec' => [
                'name' => 'submit',
                'type'  => 'Submit',
                'attributes' => ['value' => 'Login'],
            ],
        ],
    ],
]);


// RESULT:
/*
*/
