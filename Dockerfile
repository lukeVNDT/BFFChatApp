#Client App
FROM node:14.15.0 as vuejs

LABEL authors="Nimat Razmjo"

RUN mkdir -p /app/public

COPY package.json webpack.mix.js package-lock.json /app/
COPY resources/ /app/resources/

WORKDIR /app

RUN npm install && npm run prod

FROM richarvey/nginx-php-fpm:1.9.1

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG true
ENV DATABASE_URL postgres://ynkdn999:F18g3q3R6W3Pm94tvlNypec5DN6D8Se7@dpg-cfjg2e1mbjsn9efr5g4g-a/bffchatapp
ENV DB_CONNECTION pgsql
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]

