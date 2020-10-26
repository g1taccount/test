FROM alpine:edge

RUN apk --update --no-cache add \
        php7 \
#        php7-bcmath \
        php7-dom \
        php7-ctype \
        php7-curl \
        php7-fpm \
#        php7-gd \
        php7-iconv \
#        php7-intl \
        php7-json \
        php7-mbstring \
#        php7-mcrypt \
#        php7-mysqli \
#        php7-opcache \
        php7-openssl \
        php7-pdo \
        php7-pdo_mysql \
#        php7-pdo_pgsql \
#        php7-pdo_sqlite \
        php7-phar \
#        php7-posix \
        php7-redis \
        php7-simplexml \
#        php7-soap \
        php7-tokenizer \
        php7-xdebug \
        php7-xml \
        php7-xmlwriter \
#        php7-zip \
#        php7-zlib \
    && rm -rf /var/cache/apk/*

#RUN echo "@testing http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories
#RUN apk --update --no-cache add \
#        php7-mongodb@testing \
#    && rm -rf /var/cache/apk/*

# For frontend :
# - nodejs
# - nodejs-npm
# For pdf generator:
# - wkhtmltopdf
# - ttf-freefont
RUN apk --update --no-cache add \
        nginx \
#        git \
        curl \
        nodejs \
        nodejs-npm \
        # for pdf generator
        wkhtmltopdf \
        nano \
#        openjdk7-jre \
        # for pdf generator
        ttf-freefont \
#        ghostscript \
    && rm -rf /var/cache/apk/*

#RUN apk --no-cache add ca-certificates wget
#RUN wget --quiet --output-document=/etc/apk/keys/sgerrand.rsa.pub https://alpine-pkgs.sgerrand.com/sgerrand.rsa.pub

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && mkdir -p /run/nginx

COPY ./php.ini /etc/php7/conf.d/php.ini
COPY ./init.sh /
COPY ./default.conf /etc/nginx/conf.d/default.conf
RUN chmod +x /init.sh

EXPOSE 80

ENTRYPOINT [ "/init.sh" ]