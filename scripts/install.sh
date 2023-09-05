if [ -f /swapfile ]; then
 echo "Swap file already exists."
else
 sudo fallocate -l 1G /swapfile
  sudo chmod 600 /swapfile
  sudo mkswap /swapfile
  sudo swapon /swapfile
  echo "/swapfile none swap sw 0 0" >> /etc/fstab
  echo "vm.swappiness=30" >> /etc/sysctl.conf
  echo "vm.vfs_cache_pressure=50" >> /etc/sysctl.conf
  echo "Swap created and added to /etc/fstab for boot up."
fi

apt update -y;

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.1/install.sh | bash;

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion

nvm install 14.19.0;

echo 'export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm' >> ~/.bash_profile

touch install-step-2.sh;

echo "
source ~/.bash_profile
source ~/.bashrc

hash -r nvm


sh -c 'echo \"deb https://packages.sury.org/php/ $(lsb_release -sc) main\" > /etc/apt/sources.list.d/php.list'
wget -qO - https://packages.sury.org/php/apt.gpg | sudo apt-key add -

apt update -y

apt install zip git unzip python redis-server build-essential -y;

apt install php7.2-common php7.2-cli php7.2-mysql php7.2-fpm php7.2-mbstring php7.2-xml php7.2-curl php7.2-gd php7.2-zip php7.2-bcmath php7.2-gmp mcrypt php7.2-mbstring -y;

apt install -y debian-keyring debian-archive-keyring apt-transport-https
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/gpg.key' | sudo gpg --dearmor -o /usr/share/keyrings/caddy-stable-archive-keyring.gpg
curl -1sLf 'https://dl.cloudsmith.io/public/caddy/stable/debian.deb.txt' | sudo tee /etc/apt/sources.list.d/caddy-stable.list
apt update -y
apt install caddy -y

wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet

mv composer.phar /usr/local/bin/composer

rm -rf /var/www/*;
git clone https://github.com/GameserverApp/Community-Website.git /var/www;

mkdir -p /var/www/public/js
touch /var/www/public/js/app.js

composer install --no-interaction --no-dev --prefer-dist -d /var/www;

npm --prefix /var/www ci;
npm --prefix /var/www run production;

chown -R www-data:www-data /var/www

php /var/www/artisan setup-community-website

php /var/www/artisan optimize
" >> install-step-2.sh;

sudo bash install-step-2.sh

sudo bash /var/www/install-caddy.sh

systemctl reload caddy

rm -rf install.sh
rm -rf install-step-2.sh
