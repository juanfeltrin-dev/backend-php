#!/bin/bash

XDEBUG_FILE="/etc/php.d/15-xdebug.ini"

if [ $PHP_XDEBUG == 'true' ]; then
    IP=$(hostname -i | awk -F. '{print $1"."$2"."$3".1"}')
    echo "zend_extension=xdebug.so

xdebug.idekey = DOCKER
xdebug.remote_autostart = 1
xdebug.default_enable = 1
xdebug.remote_enable = 1
xdebug.remote_autostart = 1
xdebug.remote_connect_back = 1
xdebug.profiler_enable = 1
xdebug.remote_port = 9000
xdebug.remote_host = ${IP}" > ${XDEBUG_FILE}

else 
    echo "; disable on startup"> ${XDEBUG_FILE}
fi

/usr/sbin/sshd
php-fpm --nodaemonize &
nginx -g "daemon off;"