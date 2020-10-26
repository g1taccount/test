#!/usr/bin/env sh

php-fpm7 -F &
nginx -g 'daemon off;' &
tail -f /dev/null