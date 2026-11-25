#!/bin/sh
# Punto de entrada del contenedor SSRP.
#
# Si SSRP_DATA_DIR apunta a un volumen persistente (p. ej. /data en Railway),
# las carpetas donde la aplicación guarda archivos (files/ y FormsVac/) se
# enlazan al volumen para que no se pierdan en cada despliegue.
set -e

APP=/var/www/html

# Apache con mod_php necesita un único MPM (prefork). Si otro quedó habilitado,
# Apache no arranca ("AH00534: More than one MPM loaded").
for mpm in event worker; do
    rm -f "/etc/apache2/mods-enabled/mpm_${mpm}.load" "/etc/apache2/mods-enabled/mpm_${mpm}.conf"
done
if [ ! -e /etc/apache2/mods-enabled/mpm_prefork.load ]; then
    ln -s ../mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load
    ln -s ../mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
fi

if [ -n "$SSRP_DATA_DIR" ]; then
    mkdir -p "$SSRP_DATA_DIR"

    for d in files FormsVac images/tmp; do
        if [ ! -L "$APP/$d" ]; then
            mkdir -p "$SSRP_DATA_DIR/$d"
            # Primera vez: copiar el contenido de la imagen sin sobrescribir datos existentes
            if [ -d "$APP/$d" ]; then
                cp -an "$APP/$d/." "$SSRP_DATA_DIR/$d/" 2>/dev/null || true
                # El código dentro de files/ siempre se actualiza desde la imagen
                if [ "$d" = "files" ]; then
                    for c in classes languages templates index_icons; do
                        if [ -d "$APP/files/$c" ]; then
                            rm -rf "$SSRP_DATA_DIR/files/$c"
                            cp -a "$APP/files/$c" "$SSRP_DATA_DIR/files/$c"
                        fi
                    done
                    cp -a "$APP/files/"*.php "$SSRP_DATA_DIR/files/" 2>/dev/null || true
                fi
                rm -rf "$APP/$d"
            fi
            ln -s "$SSRP_DATA_DIR/$d" "$APP/$d"
        fi
    done

    chown -R www-data:www-data "$SSRP_DATA_DIR"
fi

exec docker-php-entrypoint "$@"
