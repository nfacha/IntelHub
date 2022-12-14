FROM ubuntu:22.04
ENV DEBIAN_FRONTEND=noninteractive
ENV NONINTERACTIVE=noninteractive
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN apt-get update \
  && apt-get -y install apt-utils \
  && apt-get -y upgrade \
  && apt-get -y install wget curl nano zip unzip git openssl sqlite3 build-essential software-properties-common cron supervisor gnupg tzdata

RUN echo "UTC" >> /etc/timezone \
  && dpkg-reconfigure -f noninteractive tzdata

RUN add-apt-repository ppa:ondrej/php \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - \
    && echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list \
    && apt-get update \
    && apt-get -y install nginx php8.1-fpm php8.1-cli php8.1-curl php8.1-mbstring \
        php8.1-mysql php8.1-gd php8.1-bcmath php8.1-readline \
        php8.1-zip php8.1-imap php8.1-xml php8.1-intl php8.1-soap \
        php8.1-memcache php8.1-memcached php8.1-yaml php8.1-pgsql php8.1-amqp supervisor nodejs yarn && mkdir -p /var/log/supervisor \
        && rm -rf /var/lib/apt/lists/*
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer
RUN ln -fs /usr/share/zoneinfo/UTC /etc/localtime
RUN composer self-update --2
#RUN rm -rf /var/lib/apt/lists/*
WORKDIR /var/www/intelhub
COPY . /var/www/intelhub/
COPY ./.env.sample /var/www/intelhub/.env
RUN composer install
RUN npm ci && yarn install && yarn encore production
RUN rm -rf /var/www/intelhub/.env

COPY service-config/supervisor/supervisord.conf /etc/supervisor/conf.d/
COPY service-config/nginx/nginx.conf /etc/nginx/nginx.conf
COPY service-config/nginx/mime.types /etc/nginx/mime.types
COPY service-config/nginx/fastcgi_params /etc/nginx/fastcgi_params
COPY service-config/nginx/sites /etc/nginx/conf.d
COPY --chown=www-data:www-data . /var/www/intelhub
RUN mkdir /run/php
CMD ["/usr/bin/supervisord"]
