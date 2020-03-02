CREATE DATABASE `jumpstart`;
USE `jumpstart`;
CREATE USER 'test'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON `jumpstart`.`events` TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON `jumpstart`.`hotels` TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON `jumpstart`.`signup` TO 'test'@'localhost';
GRANT ALL PRIVILEGES ON `jumpstart`.`users` TO 'test'@'localhost';
FLUSH PRIVILEGES;