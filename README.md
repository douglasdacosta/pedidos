intalando ambiente docker

docker pull php:8.3.1-apache

docker pull php:7.2.34-apache

Depois de cloando entre no progeto e rode

Dentro do diretório

$cd laradock

$sudo docker-compose up -d nginx mysql phpmyadmin

$sudo docker-compose ps

Acesso ao Banco de dados - phpmyadmin
http://localhost:1010/
Servidor: mysql
User: root
Senha: root
$sudo docker-compose exec --user=laradock workspace bash


$php composer install

$php artisan migrate




Adicionar no .ENV 
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=pedidos
DB_USERNAME=root
DB_PASSWORD=root

Para logar no projeto utilize
http://localhost:8002
Login: eplax@eplax.com
senha: eplax



