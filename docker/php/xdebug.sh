#!/usr/bin/env bash

if [ "$#" -ne 1 ]; then
    SCRIPT_PATH=`basename "$0"`
    echo "Usage: $SCRIPT_PATH enable|disable"
    exit 1;
fi

if [ "$1" == "enable" ]; then

    U_ID=${UID} docker exec -i -u 0 ${SERVICE_ID} bash -c \
        '[ -f /usr/local/etc/php/disabled/docker-php-ext-xdebug.ini ] && cd /usr/local/etc/php/ && mv disabled/docker-php-ext-xdebug.ini conf.d/ && kill -USR2 1 || echo "Xdebug already enabled"'
else
    U_ID=${UID} docker exec -i -u 0 ${SERVICE_ID} bash -c \
        '[ -f /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ] && cd /usr/local/etc/php/ && mkdir -p disabled/ && mv conf.d/docker-php-ext-xdebug.ini disabled/ && kill -USR2 1 || echo "Xdebug already disabled"'
fi

U_ID=${UID} docker exec -i -u 0  ${SERVICE_ID} bash -c '$(php -m | grep -q Xdebug) && echo "Status: Xdebug ENABLED" || echo "Status: Xdebug DISABLED"'
