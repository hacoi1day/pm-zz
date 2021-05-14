# create databases
CREATE DATABASE IF NOT EXISTS `pm`;
CREATE DATABASE IF NOT EXISTS `pm_test`;

# create root user and grant rights
CREATE USER 'root'@'localhost' IDENTIFIED BY '123456aa';
GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';
