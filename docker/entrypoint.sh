#!/bin/sh
set -eu
: "${PORT:=8080}"
sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
mkdir -p "${AVATAR_UPLOAD_PATH:-/var/www/html/public/uploads/avatars}" /var/www/html/writable/cache /var/www/html/writable/logs /var/www/html/writable/session
chown -R www-data:www-data "${AVATAR_UPLOAD_PATH:-/var/www/html/public/uploads/avatars}" /var/www/html/writable
if [ "${RUN_MIGRATIONS_ON_START:-false}" = "true" ]; then
  echo "Running database migrations..."
  php -d display_errors=1 -d display_startup_errors=1 -d error_reporting=-1 spark migrate --all
fi
if [ -n "${SEED_ADMIN_PASSWORD:-}" ]; then
  echo "Ensuring the initial administrator exists..."
  php -d display_errors=1 -d display_startup_errors=1 -d error_reporting=-1 spark app:bootstrap-admin
fi
exec "$@"
