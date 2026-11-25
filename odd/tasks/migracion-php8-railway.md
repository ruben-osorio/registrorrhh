# Migración PHP 8.4 + despliegue en Railway

## Objetivo
Que SSRP (PHP 5, 2012) corra en PHP 8.3/8.4 (WAMP local `http://rrhh.roa/`) y en Railway (Docker + MySQL).

## Problema
- Etiquetas cortas `<?` se sirven como texto (index.php no redirige a login.php).
- `mysql_*`, `each()`, `create_function()`, `ereg*`, `get_magic_quotes_*` eliminados.
- Constructores estilo PHP 4, claves de array sin comillas, offsets `{}`.
- Credenciales de BD fijas en código; sin configuración de despliegue.

## Alcance
- Capa de compatibilidad (`compat.php`) cargada con `auto_prepend_file`.
- Correcciones mecánicas en todos los `.php` (etiquetas, claves, constructores, sintaxis).
- Configuración por variables de entorno (Railway `MYSQL*`).
- Dockerfile (php:8.4-apache) para Railway.
- Fuera de alcance: hash de contraseñas, reescritura de SQL en todas las páginas.

## Respaldo
`b:/wamp64/www/rrhh.roa/ssrp-backup-pre-php8-20261125.tar.gz` (sin srp1.rar ni FormsVac).

## TDD
Desactivado (sin configuración de proyecto ni runner). Verificación: `php -l` con PHP 8.4 en todos los archivos + prueba HTTP de login local.

## Tareas
- [x] T1 Capa de compatibilidad `compat.php` + `.htaccess` local (WAMP usa mod_php: `.user.ini` no aplica)
- [x] T2 Reemplazo de etiquetas cortas `<?` por `<?php` (1166 en 172 archivos)
- [x] T3 Corrección por tokenizer: 2844 claves sin comillas, 122 offsets `{}`, 36 constructores PHP 4
- [x] T4 Lint PHP 8.4 limpio en todos los archivos (excepto `NOTES/BUSQUEDA AVANZADA.php`, fragmento no ejecutable)
- [x] T5 Configuración por variables de entorno + login con consulta preparada
- [x] T6 Dockerfile + configuración Railway (`railway.json`, `docker/`, `.dockerignore`, `.gitignore`)
- [x] T7 Prueba local: `/` redirige a login, login funciona

## Verificación / evidencia
- `php -l` (8.4.15) sobre todos los `.php`: sin errores salvo NOTES.
- `curl http://rrhh.roa/` → 302 a `login.php`; login válido → 302 a `index.php` (200).
- Inyección `' OR '1'='1` → `login.php?msg=2` (rechazada).
- Recorrido de 19 enlaces del menú admin + vacaciones/, generador/, files/: sin errores fatales.
- Compat con variables tipo Railway (CLI): conexión, alias `registrorrhh`→`rrhh`, `sql_mode`, `each`, `eregi`, `split`, `create_function` OK.
- Pendiente: build Docker no probado (Docker no instalado en esta máquina).
- Problema de datos (no de código): faltan tablas `contrato`, `baja`, `char_per` en la base local `rrhh` → nóminas fallan.

## Notas
- Fuera de alcance: hash de contraseñas (texto plano), SQL sin preparar en el resto de páginas.
- No es repositorio git: no hubo commits por tarea.

## Siguiente paso
Inicializar git, subir a GitHub, crear servicio MySQL + app en Railway, importar `rrhh`.
