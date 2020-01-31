# phpcl_jumpstart_laminas
Source Code for PHP-CL Laminas JumpStart Course

## VM
* Install `docker`
  * CentOS: https://docs.docker.com/install/linux/docker-ce/centos/#install-docker-ce
  * Debian: https://docs.docker.com/install/linux/docker-ce/debian/
  * Fedora: https://docs.docker.com/install/linux/docker-ce/fedora/
  * Ubuntu: https://docs.docker.com/install/linux/docker-ce/ubuntu/
  * Windows: https://docs.docker.com/docker-for-windows/install/
  * Mac: https://docs.docker.com/docker-for-mac/install/
* Pull the latest `Linux for PHP` image
  * See: https://hub.docker.com/r/asclinux/linuxforphp-8.2-ultimate/tags/
  * Example:
```
docker pull asclinux/linuxforphp-8.2-ultimate:7.4-nts
```
* Make a note of the image and tag (hereafter referred to as `IMAGE` and `TAG`)
* Create a volume `jumpstart_laminas`
```
docker volume create jumpstart_laminas
```
* Identify the location
```
docker volume ls
docker volume inspect jumpstart_laminas
```
* Run PHP for Linux image and mount the volume.  Replace `IMAGE` and `TAG` with the values recorded above.
```
docker run -dit --restart=always --name jumpstart_laminas -v ${PWD}/:/srv/www -p 8181:80 -p 10443:443 -p 2222:22 --mount source=jumpstart_laminas,target=/srv/jumpstart IMAGE:TAG lfphp
```
* Get container ID
```
docker container ls
```
* Open a shell to the container
```
docker exec -it <container_ID> /bin/bash
// or
docker exec -it phpcl_jumpstart_laminas /bin/bash
```
* Restore files from repo for course
```
cd /srv/jumpstart
git clone https://github.com/phpcl/phpcl_jumpstart_laminas
```
* Restore database and assign privileges
```
# mysql
MariaDB [(none)]>
CREATE DATABASE `jumpstart`;
USE `jumpstart`;
CREATE USER 'test'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON `jumpstart`.`events` TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON `jumpstart`.`hotels` TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON `jumpstart`.`signup` TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON `jumpstart`.`users` TO 'test'@'localhost';
FLUSH PRIVILEGES;
SOURCE /srv/jumpstart/phpcl_jumpstart_laminas/sample_data/jumpstart.sql;
exit
```
* Connect repo to container web server
```
ln -s /srv/jumpstart/phpcl_jumpstart_laminas /srv/www/jumpstart
```
* Access container web site from your browser
```
http://localhost:8181/jumpstart
```
