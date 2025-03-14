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

Se incluye un Makefile para facilitar la inicialización del entorno. Desde la raíz del proyecto, ejecuta:
```bash
docker-compose build
docker-compose up -d
```
Esto levantará:
- **php:** Un contenedor PHP (basado en PHP 8.1 CLI) con Doctrine y Composer instalados. Se ejecuta el servidor embebido en el puerto **8000**.
- **mysql:** Un contenedor MySQL 8.0. El contenedor escucha en el puerto 3306 internamente, pero se mapea al puerto **3307** en el host para evitar conflictos con instalaciones locales.

### 3. Acceder a la Aplicación

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

### 4. Ejecutar las Pruebas Automatizadas

Desde la raíz del proyecto, ejecuta:
```bash
vendor/bin/phpunit --testdox tests
```
Esto correrá todas las pruebas unitarias e integración ubicadas en el directorio `tests`.

### 5. Detener el Entorno Docker

Para detener los contenedores, ejecuta:
```bash
make down
```

## Notas de Configuración

- **MySQL:**  
  En este proyecto, MySQL se configura para usarse en el puerto **3307** del host. Esta configuración se define de forma consistente en los siguientes archivos:
  - **config/doctrine.php:** Se establece el parámetro `'port' => 3307` en la conexión a la base de datos.
  - **bin/doctrine:** También se utiliza el puerto 3307 para la conexión (definido en el array de parámetros de conexión).
  - **docker-compose.yml:** El contenedor MySQL escucha en el puerto 3306 internamente, pero se mapea al puerto **3307** en el host para evitar conflictos con instalaciones locales.
  
  Si en tu entorno utilizas MySQL en el puerto por defecto (3306), deberás ajustar estos archivos en consecuencia.

- **Arquitectura y Diseño:**  
  El proyecto está estructurado siguiendo principios de DDD y Clean Architecture. Se utilizan Value Objects para encapsular datos sensibles y se implementan repositorios mediante interfaces. La lógica de negocio (por ejemplo, el registro de usuario) se encuentra desacoplada en casos de uso y controladores.

- **Pruebas Automatizadas:**  
  Se han implementado pruebas unitarias e integración usando PHPUnit para validar la funcionalidad de las entidades, Value Objects, casos de uso y la integración de Doctrine con MySQL.

## Estructura del Proyecto

- **src/**: Código fuente de la aplicación (entidades, repositorios, casos de uso, etc.)
- **tests/**: Pruebas unitarias e integración.
- **config/**: Configuración de Doctrine (por ejemplo, `doctrine.php`).
- **docker/**: Dockerfile para el servicio PHP.
- **docker-compose.yml**: Configuración de Docker Compose para los servicios PHP y MySQL.
- **Makefile**: Comandos para construir, levantar y detener el entorno Docker.
- **README.md**: Este archivo, que explica cómo ejecutar el proyecto.

## Entrega

1. Sube tu código a un repositorio público en GitHub.
2. Incluye este archivo README.md con las instrucciones de ejecución.
3. Comparte el enlace del repositorio con los evaluadores.
