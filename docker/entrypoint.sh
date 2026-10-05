#!/bin/sh
set -eu
: "${PORT:=8080}"
sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
mkdir -p "${AVATAR_UPLOAD_PATH:-/var/www/html/public/uploads/avatars}" /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session
chown -R www-data:www-data "${AVATAR_UPLOAD_PATH:-/var/www/html/public/uploads/avatars}" /var/www/html/writable
exec "$@"
