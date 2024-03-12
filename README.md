
Entre no progeto e rode<br>
<br>
Dentro do diretório laradock<br>
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

Para logar no projeto utilize <br>
http://localhost:8002 <br>
Login: admin@admin.com <br>
senha: admin <br>



