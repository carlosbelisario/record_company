## Instalación

Clonar el repositiorio en la carpeta destinada normalmente /var/www/html en servidores linux con apache, utilizando 
    `git clone https://github.com/carlosbelisario/record_company.git`

una vez clonado el repositorio instalar las dependencias mediante el comando
    `composer install` 

realizar una copia del archivo .env.example y renombrarlo a .env, editar en este archivo los parametros de conexion

 DB_HOST=tuhost (en entorno local nomralmente localhost)
 DB_DATABASE=record_company #recomendado
 DB_USERNAME=tuusuariodb
 DB_PASSWORD=passworddb

ingresar a un cliente para mysql (phpmyadmin, mysql-workbench, navicat, etc.) y crear la base de datos llamada record_company (o el nombre configurado en tu archivo .env)


abrir una consola ubicarse en la raiz del proyecto y correr los siguiente comandos

 `php artisan migrate:install`
 `php artisan migrate`

en maquina local ingresar en la url

http://localhost/record_company/

de no tener el mod_rewrite de apache activado debera ingresar en 

http://localhost/record_company/public

y estara la aplicación funcionando