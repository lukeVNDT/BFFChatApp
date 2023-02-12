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
ENV DATABASE_URL postgres://ynkdn999:4S9oyuYVAnLs9BRvr6FpWBpMr6u4fCY1@dpg-cfk4i11mbjsn9eapaogg-a/bffchatapp_37ni
ENV DB_CONNECTION pgsql
ENV LOG_CHANNEL stderr
ENV BROADCAST_DRIVER pusher
ENV CACHE_DRIVER file
ENV QUEUE_CONNECTION sync
ENV SESSION_DRIVER file
ENV SESSION_LIFETIME 120

ENV REDIS_HOST 127.0.0.1
ENV REDIS_PASSWORD null
ENV REDIS_PORT 6379

ENV PUSHER_APP_ID 1370399
ENV PUSHER_APP_KEY c8e0d71f42cd8a71b2b8
ENV PUSHER_APP_SECRET 5df639a468bdf271ccc1
ENV PUSHER_APP_CLUSTER ap1

ENV CLOUDINARY_URL cloudinary://243757468891546:XDVFcHE3QAJqodzWTQNQWugj11w@dtiazqxyd

ENV MIX_PUSHER_APP_KEY c8e0d71f42cd8a71b2b8
ENV MIX_PUSHER_APP_CLUSTER ap1

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]

