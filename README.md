# Prueba Técnica PHP

Este proyecto es una aplicación PHP que cumple con la siguiente prueba técnica:
- Uso de Value Objects, repositorios con interfaces y diseño basado en DDD y Clean Architecture.
- Persistencia de datos en MySQL utilizando Doctrine.
- Pruebas unitarias e integración con PHPUnit.
- Despliegue del entorno con Docker.

## Requisitos

- Docker y Docker Compose instalados.
- Docker Desktop debe estar abierto antes de ejecutar cualquier comando.
- Git (opcional, para clonar el repositorio).

## Instrucciones de Ejecución

### 1. Clonar el Repositorio
```bash
git clone <URL_DEL_REPOSITORIO>
cd <nombre_del_proyecto>
```

### 2. Construir y Levantar los Contenedores Docker

Desde la raíz del proyecto, ejecuta:
```bash
docker-compose build
docker-compose up -d
```
Esto levantará:
- **php:** Un contenedor PHP (basado en PHP 8.1 CLI) con Doctrine y Composer instalados. Se ejecuta el servidor embebido en el puerto **8000**.
- **mysql:** Un contenedor MySQL 8.0. El contenedor escucha en el puerto 3306 internamente, pero se mapea al puerto **3307** en el host para evitar conflictos con instalaciones locales.

### 3. Crear la Base de Datos y Esquema

Una vez que los contenedores están corriendo, ejecuta:
```bash
docker exec -it php_app php bin/doctrine orm:schema-tool:update --force
```
Esto creará las tablas necesarias en la base de datos según las entidades definidas en el código.

### 4. Acceder a la Aplicación

- Abre tu navegador y navega a:  
  [http://localhost:8000](http://localhost:8000)
  
- Para probar el endpoint de registro, envía una petición **POST** a:
```
http://localhost:8000/register
```
con el siguiente JSON en el body:
```json
{
    "name": "Juan Pérez",
    "email": "juan@example.com",
    "password": "StrongPass@123"
}
```

### 5. Ejecutar las Pruebas Automatizadas

Desde la raíz del proyecto, ejecuta:
```bash
vendor/bin/phpunit --testdox tests
```
Esto correrá todas las pruebas unitarias e integración ubicadas en el directorio `tests`.

### 6. Detener el Entorno Docker

Para detener los contenedores, ejecuta:
```bash
docker-compose down
```

## Notas de Configuración

### Configuración de la Base de Datos

Para asegurar que la conexión a MySQL funcione correctamente, verifica que los siguientes archivos tengan los valores adecuados según tu entorno:

1. **config/doctrine.php**:
   - Modificar el puerto, nombre de la base de datos, usuario y contraseña en la configuración de la conexión.
   ```php
   return [
       'dbname' => 'nombre_base_datos',
       'user' => 'usuario_mysql',
       'password' => 'password_mysql',
       'host' => 'mysql_db',
       'driver' => 'pdo_mysql',
       'port' => 3307,
   ];
   ```

2. **bin/doctrine**:
   - Asegurar que los valores coincidan con `config/doctrine.php`.

3. **docker-compose.yml**:
   - Revisar y modificar la configuración de MySQL según sea necesario.
   ```yaml
   services:
     mysql:
       image: mysql:8.0
       environment:
         MYSQL_DATABASE: nombre_base_datos
         MYSQL_USER: usuario_mysql
         MYSQL_PASSWORD: password_mysql
         MYSQL_ROOT_PASSWORD: root_password
       ports:
         - "3307:3306"
   ```

### Verificación del Estado de los Contenedores

Para verificar que los contenedores están corriendo correctamente, usa:
```bash
docker ps
```

Si hay errores, revisa los logs con:
```bash
docker logs php_app
docker logs mysql_db
```

Si necesitas acceder a MySQL dentro del contenedor, ejecuta:
```bash
docker exec -it mysql_db mysql -u root -p
```

## Estructura del Proyecto

- **src/**: Código fuente de la aplicación (entidades, repositorios, casos de uso, etc.)
- **tests/**: Pruebas unitarias e integración.
- **config/**: Configuración de Doctrine (por ejemplo, `doctrine.php`).
- **docker/**: Dockerfile para el servicio PHP.
- **docker-compose.yml**: Configuración de Docker Compose para los servicios PHP y MySQL.
- **README.md**: Este archivo, que explica cómo ejecutar el proyecto.

## Entrega

1. Sube tu código a un repositorio público en GitHub.
2. Incluye este archivo README.md con las instrucciones de ejecución.
3. Comparte el enlace del repositorio con los evaluadores.
