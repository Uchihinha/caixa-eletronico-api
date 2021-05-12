FROM ambientum/php:7.4-nginx

USER root

COPY ./start.sh /usr/local/bin/start
RUN chmod u+x /usr/local/bin/start

RUN apk update && \
    apk add --no-cache strace php7-dev@php && \
	apk add --no-cache strace php7-pear@php && \
    apk add --no-cache strace php7-gmp@php && \
    apk add --no-cache strace autoconf && \
    apk add --no-cache strace openssl && \
    apk add --no-cache tzdata && \
    pecl channel-update pecl.php.net && \
    pear config-set php_ini /etc/php7/php.ini

ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

USER ambientum

WORKDIR /var/www/app


CMD ["/usr/local/bin/start"]
