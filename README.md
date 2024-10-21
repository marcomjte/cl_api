# Contact List API

Servicio API REST para la gestión de datos de contactos.

## Configuración

Tener previa instalación de "composer" en su versión 2.6.6

Ejecutar `composer install` para realizar la instalación de los paquetes necesarios.

Configurar las variables de entorno para la conexión a la base de datos, configurar el archivo .env las siguietes lineas por la configuración de tu computadora

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=cl_platform

DB_USERNAME=root

DB_PASSWORD=

Ejecutar `php artisan migrate` para poder crear las tablas necesarias en la base de datos.

Ejecutar `php artisan db:seed --class=PersonSeeder` para poder crear los registros ficticios en la base de datos.

## Iniciar proyecto

Ejecutar `php artisan serve` para poder iniciar el proyecto de manera local.

## NOTAS

Es importante iniciar el proyecto CL_API en la dirección http://127.0.0.1:8000 para el consumo de los servicios.

## License

Laravel es un framework de código abierto con licencia de [MIT license](https://opensource.org/licenses/MIT).