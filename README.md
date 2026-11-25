# SSRP — Sub-Sistema de Registro de Personal

Sistema de Recursos Humanos: ficha personal de funcionarios (planta/TGN y consultores),
altas, bajas, movilidad, afiliaciones, vacaciones, permisos y años de servicio (CAS).

Aplicación PHP heredada (2012–2018) migrada a **PHP 8.4**, preparada para desplegarse en
**Railway** con Docker y MySQL.

## Roles de usuario

| `user.permisos` | Rol | Pantalla al iniciar sesión |
|---|---|---|
| 0 | Administrador | Panel con todos los módulos |
| 1 | Funcionario de planta (TGN) | Ficha personal |
| 2 | Consultor | Ficha personal de consultor |
| 3 | Social | Panel social |
| 4 | Control | Panel de control |

## Despliegue en Railway

### 1. Servicios

1. Crear un proyecto en Railway.
2. Agregar un servicio **MySQL**.
3. Agregar un servicio desde este repositorio de GitHub. Railway detecta el `Dockerfile` de la raíz.
4. En **Settings** del servicio de la aplicación:
   - **Healthcheck Path**: `/login.php`
   - **Restart Policy**: *On Failure*, 5 reintentos
   - Si el builder no muestra *Dockerfile*, agregar la variable `RAILWAY_DOCKERFILE_PATH=Dockerfile`.

> No se usa `railway.json`: Railway dejó de aceptar *Config as Code* en servicios nuevos
> (desde el 28/08/2026) y lo retira por completo el 01/12/2026.

### 2. Variables de entorno del servicio de la aplicación

Referenciar las variables del servicio MySQL:

| Variable | Valor |
|---|---|
| `MYSQLHOST` | `${{MySQL.MYSQLHOST}}` |
| `MYSQLPORT` | `${{MySQL.MYSQLPORT}}` |
| `MYSQLUSER` | `${{MySQL.MYSQLUSER}}` |
| `MYSQLPASSWORD` | `${{MySQL.MYSQLPASSWORD}}` |
| `MYSQLDATABASE` | `${{MySQL.MYSQLDATABASE}}` |
| `SSRP_DATA_DIR` | `/data` |

Variables opcionales:

| Variable | Por defecto | Uso |
|---|---|---|
| `DB_CHARSET` | `utf8mb4` | Juego de caracteres de la conexión |
| `DB_SQL_MODE` | `NO_ENGINE_SUBSTITUTION` | Modo SQL compatible con el código heredado |
| `DB_ALIASES` | `registrorrhh,ssrp,ssrp-dev,ssrp-per` | Nombres de bases antiguas que se redirigen a la base principal |

### 3. Volumen persistente

Agregar un **volumen** al servicio de la aplicación montado en `/data`. Allí se guardan los
archivos que suben o generan los usuarios (si no, se pierden en cada despliegue):

- `files/` — documentos de cada funcionario
- `FormsVac/` — formularios de vacaciones en PDF
- `images/tmp/` — fotografías de los funcionarios

### 4. Base de datos

El volcado de la base **no está en este repositorio** (contiene datos personales). Importarlo
desde una computadora con el cliente `mysql`, usando la conexión pública del servicio MySQL
(pestaña *Connect* → *Public Network*):

```bash
mysql -h <host_publico> -P <puerto_publico> -u root -p railway < ssrp_railway.sql
```

### 5. Documentos existentes

Los documentos históricos (`files/`, `FormsVac/`, `images/tmp/`) tampoco están en el
repositorio. Para cargarlos, copiarlos al volumen (`/data/files`, `/data/FormsVac`,
`/data/images/tmp`), por ejemplo con `railway ssh` o un servicio temporal con el volumen montado.

## Desarrollo local (WAMP)

1. Copiar `.htaccess.example` como `.htaccess` y ajustar la ruta de `compat.php` y las
   credenciales de la base local.
2. Apache debe usar PHP 8.x como módulo (`mod_php`).

## Compatibilidad con PHP 8

`compat.php` se carga antes de cada página (`auto_prepend_file`) y provee:

- La extensión `mysql_*` (eliminada en PHP 7) implementada sobre `mysqli`.
- Funciones eliminadas: `each`, `create_function`, `ereg*`, `split`, `get_magic_quotes_*`.
- Configuración central de la base de datos por variables de entorno. Las credenciales
  escritas en archivos antiguos se ignoran.

## Seguridad: pendientes conocidos

- Las contraseñas de `user` se guardan en texto plano. Conviene migrarlas a `password_hash()`.
- Gran parte de las consultas SQL concatenan parámetros (riesgo de inyección SQL). El login y
  el reporte individual CAS ya usan consultas parametrizadas.
- Los documentos dentro de `files/` se sirven directamente por Apache; el explorador
  `files/index.php` exige sesión de administrador, pero un enlace directo a un archivo no.
