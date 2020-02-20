<?php
// Composer autoloading
include __DIR__ . '/../vendor/autoload.php';

use Laminas\Filter\{FilterChain, StringTrim, StripTags, UpperCaseWords};

$raw_data = '   This text contains trailing linefeeds and whitespace' . "\n"
          . 'and 123456789 non-alnum data: "@#$%^!!!"  ' . "\n"
          . 'and a bad HTML <p>paragraph</p><b>bold</b>'
          . '<script>bad.javascript("BAD")</script>';

$chain = new FilterChain();
$chain->attach(new StringTrim())
      ->attach(new StripTags(['allowedTags' => ['p','b']]))
      ->attach(new UpperCaseWords());

echo "\n\n**************************************";
echo "\nStringTrim + StripTags + UpperCaseWords";
echo "\n**************************************\n";
var_dump($chain->filter($raw_data));

/** RESULT:
string(145) "This Text Contains Trailing Linefeeds And Whitespace
And 123456789 Non-alnum Data: "@#$%^!!!"
And A Bad Html Paragraphboldbad.javascript("bad")"
*/
