# Fusión de `registro` en `ssrp`

## Objetivo
Unir en `ssrp` las funcionalidades de `B:\wamp64\www\rrhh.roa\registro` (rama 2014–2018: ficha personal,
alta/baja, movilidad, afiliación, login Bootstrap) con las de `ssrp` (vacaciones, CAS, documentos).
Menú de admin con ambas secciones; al iniciar sesión, cada usuario va a su pantalla según su rol, y los
usuarios normales pueden llenar la ficha personal.

## Hallazgos
- Ambas carpetas son ramas de la misma aplicación. Enrutamiento de `index.php` casi idéntico
  (registro agrega `FichaPersonalP`; ssrp agrega `RepFormVacP`).
- 62 archivos difieren contra el respaldo original de ssrp; se toma la versión más reciente por fecha.
- Roles (`user.permisos`): 0 admin, 1 planta/TGN (`FullRegister`), 2 consultor (`FullRegisterc`), 3 social, 4 control.
- Recursos solo en registro que se usan: `gebo/`, `plugins/`, `jui/`, `Styles/`, `dist_files/`,
  `data/bootstrap335`, `data/js/jquery-2.1.3.min.js`, archivos CodeCharge (`Common.php`, `Template.php`, ...).
- No usados (no se copian): `rpo/` (otra copia de la app, 98 MB), `admin017/`, `gallery/`, `TESTPHP/`,
  `FormsVac1/`, archivos `* - copia*`, `*_old*`, `*OLD*`, configs alternativas.
- `libs/` idéntico en ambas.

## Decisiones
- Se conservan de ssrp: `LoginSystem.class.php` (consultas preparadas), `config*.php` (entorno), `compat.php`.
- Fusión manual: `index.php`, `adminNavigation.php`, `login.php`.
- Datos (`files/`, `FormsVac/`) de registro: copia sin sobrescribir.

## TDD
Desactivado. Verificación: lint PHP 8.4 + pruebas HTTP por rol.

## Tareas
- [x] F1 Copiar archivos más nuevos de registro (36) y nuevos (129); 47 copias/_old omitidas
- [x] F2 Migración PHP 8 sobre lo copiado + lint limpio
- [x] F3 `index.php` (ruta FichaPersonalP + bienvenida) y `adminNavigation.php` (unión de menús)
- [x] F4 `login.php` de registro con redirección por rol (1→FullRegister, 2→FullRegisterc, resto→index)
- [x] F5 Pruebas GET: admin 27 enlaces OK; rol 1 y rol 2 cargan todas las secciones de la ficha
- [x] F6 Arreglos CodeCharge PHP 8: `/e` en preg_replace, CCSEvents/values como array, join invertido,
      constantes sin comillas (lista revisada), componente inexistente `$evaluacion_planes`
- [x] F7 Conexiones con credenciales fijas → configuración central (`ssrp_mysqli_connect`, db_connect.php)
- [x] F8 Volcado `E:\Sistema de RRHH\registrorrhhdump.sql` importado a `registrorrhh_dump`; 38 tablas nuevas
      (catálogos) agregadas a `rrhh`
- [ ] F9 PENDIENTE (requiere confirmación): reemplazar en `rrhh` las tablas comunes donde el volcado es más
      reciente (id máximo mayor): personal, ficha, contratos, usuarios. Respaldo: `rrhh-backup-pre-fusion-20261125.sql`
- [ ] F10 Guardado de formularios no probado (no se envió POST para no modificar datos reales)

## Pendientes de seguridad
- `FormsVac/r1.php` = Adminer 3.6.3 (copiado desde registro). Excluido en `.dockerignore`; falta borrarlo.

## Respaldo
Antes de F1: `b:/wamp64/www/rrhh.roa/ssrp-backup-pre-fusion-20261125.tar.gz`.

## Siguiente paso
F1
