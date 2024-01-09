apt update -y;

apt install curl -y;

sh -c 'echo \"deb https://packages.sury.org/php/ $(lsb_release -sc) main\" > /etc/apt/sources.list.d/php.list'
wget -qO - https://packages.sury.org/php/apt.gpg | sudo apt-key add -

apt update -y

apt install zip git unzip python redis-server nginx build-essential -y;

apt install php7.2-common php7.2-cli php7.2-mysql php7.2-fpm php7.2-mbstring php7.2-xml php7.2-curl php7.2-gd php7.2-zip php7.2-bcmath php7.2-gmp mcrypt php7.2-mbstring -y;

wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet

mv composer.phar /usr/local/bin/composer

mkdir -p /var/www/public/js
touch /var/www/public/js/app.js

composer install --no-interaction --no-dev --prefer-dist -d /var/www;

php /var/www/artisan key:generate

mkdir /etc/nginx/params

echo '
client_max_body_size 100m;
index  index.php index.html index.htm;

location / {
    try_files $uri $uri/ /index.php?$args;
}

location ~* ^.+\.(ogg|ogv|svg|svgz|eot|otf|woff|mp4|ttf|rss|atom|jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|doc|xls|exe|ppt|tar|mid|midi|wav|bmp|rtf)$ {
    access_log off; log_not_found off; expires max;
}

location ~ [^/]\.php(/|$) {

    fastcgi_split_path_info ^(.+?\.php)(/.*)$;

    if (!-f $document_root$fastcgi_script_name) {
            return 404;
    }

    fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;

    fastcgi_index index.php;

    include fastcgi_params;

    fastcgi_param SCRIPT_FILENAME  $realpath_root$fastcgi_script_name;
    fastcgi_param DOCUMENT_ROOT $realpath_root;

    fastcgi_param APP_ENV local;

    fastcgi_param fastcgi_buffer_size 128k;
    fastcgi_param fastcgi_busy_buffers_size 256k;
    fastcgi_param fastcgi_temp_file_write_size 256k;
    fastcgi_param fastcgi_read_timeout 300;
}' > /etc/nginx/params/default-laravel

echo 'server {
        server_name my.testdomain.com;
        root /var/www/public;
        listen 443 ssl;

        ssl_certificate /etc/ssl/certs/selfsigned.crt;
        ssl_certificate_key /etc/ssl/certs/selfsigned.crt;

        access_log /var/log/access.log;
        error_log  /var/log/error.log;

        include params/default-laravel;
}' > /etc/nginx/sites-enabled/default

service nginx restart

rm -rf install.sh
rm -rf install-step-2.sh
