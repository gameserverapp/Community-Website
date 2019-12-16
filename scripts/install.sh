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

echo "github.com ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAQEAq2A7hRGmdnm9tUDbO9IDSwBK6TbQa+PXYPCPy6rbTrTtw7PHkccKrpp0yVhp5HdEIcKr6pLlVDBfOLX9QUsyCOV0wzfjIJNlGEYsdlLJizHhbn2mUjvSAHQqZETYP81eFzLQNnPHt4EVVUh7VfDESU84KezmD5QlWpXLmvU31/yMf+Se8xhHTvKSCZIFImWwoG6mbUoWf9nzpIoaSjB+weqqUUmpaaasXVal72J+UX2B+2RPW3RcT0eOzQgqlJL3RKrTJvdsjE3JEAvGq3lGHSZXy28G3skua2SmVi/w4yCE6gbODqnTWlg7+wC604ydGXA8VJiS5ap43JXiUFFAaQ==" >> ~/.ssh/known_hosts

curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.35.1/install.sh | bash;

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"  # This loads nvm bash_completion
nvm install 6.17.1;

echo "export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm" >> ~/.bash_profile


touch install-step-2.sh;

echo "
source ~/.bash_profile
source ~/.bashrc

hash -r nvm

apt install composer zip unzip php-mbstring php-dom -y;

rm -rf /var/www/*;
git clone git@github.com:GameserverApp/Community-Website.git /var/www;

composer install -d /var/www;
npm --prefix /var/www install;

chown -R www-data:www-data /var/www

sed -i 's#/var/www/html#/var/www/public#g' /etc/nginx/sites-enabled/digitalocean

service nginx reload

php /var/www/artisan setup-community-website

php /var/www/artisan optimize" >> install-step-2.sh;

sudo bash install-step-2.sh
