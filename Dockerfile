#
# PHP-CL JumpStart Doctrine
#

# Pull base image.
FROM asclinux/linuxforphp-8.2-ultimate:7.4-nts

RUN \
	rm -rf /srv/tempo/jumpstart && \
	git clone https://github.com/phpcl/phpcl_jumpstart_laminas.git /srv/tempo/jumpstart
RUN \
	echo "Restoring database ... " && \
	/etc/init.d/mysql start && \
	sleep 5 && \
	mysql -uroot -v -e "CREATE DATABASE IF NOT EXISTS jumpstart;" && \
	mysql -uroot -v -e "USE jumpstart;" && \
	mysql -uroot -v -e "CREATE USER IF NOT EXISTS 'test'@'localhost' IDENTIFIED BY 'password';" && \
	mysql -uroot -v -e "GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost';" && \
	mysql -uroot -v -e "FLUSH PRIVILEGES;" && \
	mysql -uroot -e "SOURCE /srv/tempo/jumpstart/sample_data/jumpstart.sql;" jumpstart
RUN \
	echo "Installing phpMyAdmin ..." && \
	lfphp-get phpmyadmin
RUN \
	echo "Updating existing Laminas project ..." && \
	cd /srv/tempo/jumpstart/laminas_project && \
	php composer.phar self-update && \
	php composer.phar install
RUN \
	echo "Configuring Apache ..." && \
	cp /srv/tempo/jumpstart/index.html /srv/www && \
	ln -s /srv/tempo/jumpstart/laminas_project/public /srv/www/demo && \
	ln -s /srv/tempo/jumpstart/my_project/public /srv/www/my && \
	/etc/init.d/httpd start
ENTRYPOINT ["/bin/lfphp"]
CMD ["--mysql", "--phpfpm", "--apache"]
