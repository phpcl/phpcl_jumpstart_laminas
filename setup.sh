#!/bin/bash
# setup script for PHP-CL JumpStart:Laminas
docker pull asclinux/linuxforphp-8.2-ultimate:7.4-nts
docker volume create jumpstart_laminas
docker volume ls
docker volume inspect jumpstart_laminas
docker run -dit --restart=always --name jumpstart_laminas -v ${PWD}/:/srv/www -p 8181:80 -p 10443:443 -p 2222:22 --mount source=jumpstart_laminas,target=/srv/jumpstart asclinux/linuxforphp-8.2-ultimate:7.4-nts lfphp
docker container ls
docker exec jumpstart_laminas /bin/bash -c "rm -rf /srv/jumpstart/phpcl_jumpstart_laminas/*"
docker exec jumpstart_laminas /bin/bash -c "rm -rf /srv/jumpstart/phpcl_jumpstart_laminas/.*"
docker exec jumpstart_laminas /bin/bash -c "rmdir /srv/jumpstart/phpcl_jumpstart_laminas"
docker exec jumpstart_laminas /bin/bash -c "git clone https://github.com/phpcl/phpcl_jumpstart_laminas /srv/jumpstart/phpcl_jumpstart_laminas"
docker exec jumpstart_laminas /bin/bash -c "chmod +x /srv/jumpstart/phpcl_jumpstart_laminas/init.sh"
docker exec jumpstart_laminas /bin/bash -c "/srv/jumpstart/phpcl_jumpstart_laminas/init.sh"
echo "Access container web site from your browser using this URL: http://localhost:8181/laminas"
echo "Or run a shell using:"
echo "docker exec -it jumpstart_laminas /bin/bash"
