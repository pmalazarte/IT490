# IT490
OpenWeatherMap Weather API
__________________________________________________________________________________________________________________________________________
Setup Apache

sudo apt-get install apache2

sudo apt-get install php7.0 libapache2-mod-php7.0

sudo vim /etc/php/7.0/cli/apache2/php.ini +877

extension = amqp.so

sudo vim /etc/php/7.0/cli/php.ini +877

extension = amqp.so

cd /etc/php/7.0/cli/conf.d

sudo ln -s /etc/php/mods-available/amqp.ini

________________________________________________________________________________________________________________________________________
mysql

sudo mysql - u root - p

CREATE USER 'IT490User'@'localhost' IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON *.* TO 'IT490User'@'localhost' WITH GRANT OPTION;

quit

________________________________________________________________________________________________________________________________________

rabbitmq

testRabbitMQ.ini

[testServer]

BROKER_HOST = 127.0.0.1

BROKER_PORT = 5672

USER = admin

PASSWORD = admin

VHOST = VHost490

EXCHANGE = Exchange490

QUEUE = Queue490
