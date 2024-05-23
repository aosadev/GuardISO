
# GuardISO

GuardISO es una aplicación desarrollada utilizando el framework Symfony que facilita la gestión y el cumplimiento de la norma ISO 27001. Esta aplicación proporciona herramientas integradas para manejar la documentación, las auditorías internas, el control de riesgos y el registro de incidentes, todo desde una interfaz centralizada y fácil de usar.

## Características Principales

- **Gestión de Documentación**: Automatiza el manejo de toda la documentación requerida por la ISO 27001.
- **Auditorías Internas**: Planifica y registra los resultados de las auditorías internas.
- **Control de Riesgos**: Herramientas para identificar y gestionar riesgos asociados a la seguridad de la información.
- **Registro de Incidentes**: Módulo para registrar y seguir incidentes de seguridad.

## Requisitos del Sistema

- PHP 7.4 o superior.
- Servidor web Apache o Nginx.
- Base de datos compatible con Doctrine ORM (p.ej., MySQL, PostgreSQL, SQLite).
- Composer para la gestión de dependencias de PHP.

## Instalación

Sigue estos pasos para configurar el proyecto en tu entorno local:

1. **Clonar el repositorio**:
   Utiliza el siguiente comando para clonar el repositorio en tu máquina local:
   ```bash
   git clone https://github.com//aosadev/GuardISO.git
   ```

2. **Instalar dependencias**:
   Navega al directorio del proyecto y ejecuta el siguiente comando para instalar todas las dependencias necesarias:
   ```bash
   cd GuardISO
   composer install
   ```

3. **Configurar el archivo .env**:
   Asegúrate de configurar el archivo `.env` con tus datos de conexión a la base de datos y otros parámetros necesarios.

4. **Ejecutar migraciones**:
   Crea la estructura de la base de datos ejecutando las migraciones con este comando:
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

5. **Iniciar el servidor de desarrollo**:
   Puedes iniciar el servidor de desarrollo de Symfony con este comando para probar la aplicación:
   ```bash
   symfony server:start
   ```

## Uso

Proporciona instrucciones básicas sobre cómo usar la aplicación.

## Contribuir

Si deseas contribuir al proyecto, considera las siguientes pautas:
- Realiza un fork del repositorio.
- Crea una nueva rama para cada característica o mejora.
- Realiza tus cambios.
- Envía una pull request para su revisión.

## Licencia

Este proyecto está licenciado bajo la Licencia MIT - ver el archivo `LICENSE` para más detalles.

## Contacto

Asier Osa - aosa.dev@gmail.com
