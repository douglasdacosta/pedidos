Clone o projeto <br>
<br>
git clone https://github.com/douglasdacosta/pedidos.git<br>
Dentro do diretório laradock<br>
<br>
$cd pedidos<br>
<br>
Adicione o Laradock<br>
git clone https://github.com/laradock/laradock.git<br>
$cd laradock<br>
$ cp .env.example .env<br>
Na .env altere a linha (Evita conflito com o do S.O.)<br>
WORKSPACE_SSH_PORT=9999<br>
NGINX_HOST_HTTP_PORT=8002<br>
NGINX_HOST_HTTPS_PORT=4433<br>
MYSQL_DATABASE=pedidos<br>
<br>
$sudo docker-compose up -d nginx mysql phpmyadmin<br>
<br>
$sudo docker-compose ps<br>
<br>
Acesso ao Banco de dados - phpmyadmin<br>
http://localhost:1010/<br>
Servidor: mysql<br>
User: root<br>
Senha: root<br>
<br>
Crie o banco de dados pedidos<br>
<br>
Adicionar no .ENV <br>
DB_CONNECTION=mysql <br>
DB_HOST=mysql <br>
DB_PORT=3306 <br>
DB_DATABASE=pedidos<br> 
DB_USERNAME=root <br>
DB_PASSWORD=root <br>
<br>
$sudo docker-compose exec --user=laradock workspace bash<br>
$php composer install<br>
$php artisan migrate<br>

Para logar no projeto utilize <br>
http://localhost:8002 <br>
Login: admin@admin.com <br>
senha: admin <br>



