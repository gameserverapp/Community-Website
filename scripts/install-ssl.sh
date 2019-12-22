certbot --nginx --agree-tos --redirect -d %%DOMAIN%% --register-unsafely-without-email

sed -i 's#try_files $uri $uri/ =404#try_files $uri $uri/ /index.php?$query_string#g' /etc/nginx/sites-enabled/digitalocean

service nginx reload