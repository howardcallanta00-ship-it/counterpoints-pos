FROM php:8.3-apache
RUN apt-get update && apt-get install -y --no-install-recommends libfreetype6-dev libjpeg62-turbo-dev libpng-dev libicu-dev libzip-dev default-mysql-client \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd intl mysqli opcache zip \
 && a2enmod rewrite headers remoteip \
 && rm -rf /var/lib/apt/lists/*
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && printf '%s\n' 'ServerName localhost' 'RemoteIPHeader X-Forwarded-For' > /etc/apache2/conf-available/counterpoint.conf \
 && a2enconf counterpoint
WORKDIR /var/www/html
COPY . .
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader \
 && composer clear-cache
RUN mkdir -p writable/cache writable/logs writable/session public/uploads/avatars \
 && chown -R www-data:www-data writable public/uploads/avatars \
 && find writable public/uploads/avatars -type d -exec chmod 775 {} \;
COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint
EXPOSE 8080
ENTRYPOINT ["entrypoint"]
CMD ["apache2-foreground"]
