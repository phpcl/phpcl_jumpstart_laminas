# Source Code for PHP-CL Laminas JumpStart Course

## Docker / Compose
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
* Install `docker-compose`
  * https://docs.docker.com/compose/install/

## Repo
* The preferred approach is to `fork` the repo into your own github account:
  * Open your browser to `https://github.com/phpcl/phpcl_jumpstart_laminas/`
  * On the top right click `Fork`
  * Choose your own account
* Alternative you can clone the PHP-CL repo, but you won't have the rights to push changes
* Clone this repository into some directory (which we call here `/path/to/repo`)
```
git clone https://github.com/<YOUR_ACCOUNT>/phpcl_jumpstart_laminas /path/to/repo
```
* Build the image on your host computer
```
cd /path/to/repo
docker-compose build
```
* Bring the container online.  The `-d` flag makes it run in background.
```
docker-compose up -d
```
* Open a shell to the container
```
docker exec -it <container_ID> /bin/bash
// or
docker exec -it phpcl_jumpstart_laminas /bin/bash
```
  * The repository gets cloned inside the container into this directory: `/srv/tempo/jumpstart`
  * The `/path/to/repo` directory on your host computer is mapped inside the container as: `/srv/tempo/home`
* Access Laminas demo web site from your browser
  * You can use `localhost` like this:
```
http://localhost:8181/laminas
```
  * Or you can use the IP address of the container like this:
```
http://172.16.1.99/laminas
```
* Database access
  * From the main web page click on the `phpMyAdmin` link
  * Username: `test`
  * Password: `password`
  * Database Name: `jumpstart`
* When you're done, exit the shell and stop the container as follows:
```
docker-compose down
```

## Making Changes Using a Forked Repo
* From outside the Docker container, use your favorite text editor, add or modify the file
* Push the changes to your forked version of the repo:
```
git add *
git commit -m 'Some Message'
git push
```
* Return to the Docker container and pull the change
```
docker exec -it phpcl_jumpstart_laminas /bin/bash
cd /srv/tempo/jumpstart
git stash
git pull
```

## Making Changes Using Copy
* From outside the Docker container, use your favorite text editor, add or modify the file
* Return to the Docker container and copy the changed file into the directory structure mapped to the web
```
cp /srv/tempo/home/path/to/modified/file /srv/tempo/jumpstart/path/to/modified/file
```
