FROM php:8.2
WORKDIR /code
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql
COPY . .
RUN composer install
RUN composer dump-autoload
RUN php artisan key:generate
RUN php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
RUN php artisan migrate
RUN php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"

CMD php artisan serve --host=0.0.0.0 --port=8181
EXPOSE 8181
