#!/bin/bash
# setup script for PHP-CL JumpStart:Laminas: runs *inside* container
php /srv/jumpstart/phpcl_jumpstart_laminas/laminas_project/composer.phar install --working-dir=/srv/jumpstart/phpcl_jumpstart_laminas/laminas_project
mysql < /srv/jumpstart/phpcl_jumpstart_laminas/sample_data/restore.sql
mysql < /srv/jumpstart/phpcl_jumpstart_laminas/sample_data/jumpstart.sql
ln -s -v /srv/jumpstart/phpcl_jumpstart_laminas/laminas_project/public /srv/www/laminas
