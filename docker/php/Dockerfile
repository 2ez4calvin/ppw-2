FROM ubuntu:22.04

LABEL maintainer="Web II"

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC
ENV SUPERVISOR_PHP_COMMAND="/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan serve --host=0.0.0.0 --port=80"

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && apt-get install -y \
    gnupg \
    curl \
    ca-certificates \
    zip \
    unzip \
    git \
    supervisor \
    && mkdir -p /etc/apt/keyrings \
    && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' \
       | gpg --dearmor \
       | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
    && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" \
       > /etc/apt/sources.list.d/ppa_ondrej_php.list \
    && apt-get update && apt-get install -y \
    php8.3-cli \
    php8.3-pgsql \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-opcache \
    php8.3-curl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

ENV NVM_DIR="/root/.nvm"

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.4/install.sh | bash \
    && . "$NVM_DIR/nvm.sh" \
    && nvm install 22 \
    && nvm use 22

# Instala o Composer
RUN curl -sLS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/bin/ --filename=composer

ENV COMPOSER_HOME=/tmp/composer

COPY /docker/php/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY /docker/php/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

WORKDIR /var/www/html

COPY /src/package.json package.json
RUN npm install \
        && npm run build

EXPOSE 80

ENTRYPOINT ["start-container"]