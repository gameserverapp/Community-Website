echo "
%%DOMAIN%% {
    root * /var/www/public

    log
    encode gzip

    php_fastcgi unix//run/php/php7.2-fpm.sock

    file_server
}
" > /etc/caddy/Caddyfile