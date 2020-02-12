<?php
// based upon article by Daniel Opitz (https://odan.github.io/2017/08/16/create-a-php-phar-file.html)
// location of directory containing code to be included in phar file
$path = __DIR__ . '/LaminasTools/';

// The php.ini setting phar.readonly must be set to 0
$pharFile = 'laminas-tools.phar';

// clean up
if (file_exists($pharFile)) {
    unlink($pharFile);
}
if (file_exists($pharFile . '.gz')) {
    unlink($pharFile . '.gz');
}

// create phar
$p = new Phar($pharFile);

// creating our library using whole directory
$p->buildFromDirectory($path);

// pointing main file which requires all classes
$p->setDefaultStub('index.php', '/index.php');

// plus - compressing it into gzip
$p->compress(Phar::GZ);

// clean up
if (file_exists($pharFile . '.gz')) {
    unlink($pharFile . '.gz');
}

echo "$pharFile successfully created\n";
echo "Usage: php $pharFile\n";

