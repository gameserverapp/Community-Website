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
nvm install 6.17.1;

touch install-step-2.sh;

echo "
apt install composer zip unzip php-mbstring php-dom -y;

ssh-keygen -F github.com || ssh-keyscan github.com >> ~/.ssh/known_hosts

rm -rf /var/www/*;
git clone git@github.com:GameserverApp/Community-Website.git /var/www;

composer install -d /var/www;
npm --prefix /var/www install;

chown -R www-data:www-data /var/www

sed -i 's#/var/www/html#/var/www/public#g' /etc/nginx/sites-enabled/digitalocean

service nginx reload

php /var/www/artisan setup-community-website

php /var/www/artisan optimize" >> install-step-2.sh;

bash install-step-2.sh
