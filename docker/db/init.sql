create database if not exists moneys;

use moneys;

CREATE USER 'user'@localhost IDENTIFIED BY 'user';
GRANT ALL PRIVILEGES ON 'moneys'.* TO 'user'@localhost;
FLUSH PRIVILEGES;