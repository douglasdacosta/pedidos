intalando ambiente docker<br>
docker pull php:8.3.1-apache<br>
docker pull php:7.2.34-apache<br>
<br>
Depois de cloando entre no progeto e rode<br>
<br>
Dentro do diretório<br>
<br>
$cd laradock<br>
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

Para logar no projeto utilize 
http://localhost:8002 
Login: eplax@eplax.com 
senha: eplax 



