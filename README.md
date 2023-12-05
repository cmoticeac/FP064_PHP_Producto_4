## FP064 PHPDevelopers Producto 3

1. Haz el build del docker: docker-compose build
2. Corre la composición de docker: docker-compose up -d
3. Instala las dependencias con docker: bin/composer install
4. Accede a tu navegador http://localhost/


NOTA:
Al descargar en local el producto 3, copiar y renombrar archivo /src/.env.example a .env
El archivo “.env” en Laravel es utilizado para almacenar variables de entorno específicas del proyecto, por ejemplo las credenciales de la base de datos.
Las credenciales y datos de conexión deben coincidir con los que hemos definido en el “docker-compose.yml”. 
Al modificar datos del archivo, se recomienda ejecutar “php artisan config:cache” en nuestra consola dentro del directorio del proyecto para poder recargar la configuración de la aplicación ("docker-compose exec web bash")

Cuando clonas el proyecto y lo configuras tu entorno local, debes copiar .env.example a .env y ejecutar "php artisan key:generate". Este comando generará automáticamente una nueva clave APP_KEY y la insertará en tu archivo .env.
