echo "Updating your OS"
apt -y update
apt -y upgrade
apt-get -y install php7.0
apt-get -y install php7.0-xml
apt-get -y install php-mcrypt php-gd
apt-get -y install php-mbstring
apt-get -y install php-gettext
apt-get -y install git composer
apt-get -y install apache2
apt-get -y install libapache2-mod-php7.0
curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
apt-get -y install nodejs
apt-get -y install npm
apt-get -y install supervisor
apt-get -y install mysql-server
apt-get -y install php7.0-mysql
apt-get -y install phpmyadmin
apt-get -y install redis-server
apt-get -y install php-redis
apt-get -y install php7.0-ldap
phpenmod mcrypt
phpenmod mbstring
a2enmod rewrite
systemctl restart redis-server.service
systemctl enable redis-server.service
echo "Creating a directory->/var/www/html/Quiztool"
mkdir /var/www
mkdir /var/www/html
mkdir /var/www/html/Quiztool
echo "Cloning the Quiztool's current version."
cd /var/www/html/Quiztool
git clone https://gitlabe1.ext.net.nokia.com/zavetz/Quiz-tool.git
echo "Starting Laravel installation with composer"
cd /var/www/html/Quiztool/Quiz-tool/quizgame
composer install
chown www-data: -R /var/www/html/Quiztool/
echo "<VirtualHost *:80>
ServerName 0.0.0.0
DocumentRoot "/var/www/html/Quiztool/Quiz-tool/quizgame/public"
<Directory "/var/www/html/Quiztool/Quiz-tool/quizgame/public">
Options FollowSymLinks
AllowOverride All
Require all granted
allow from all
</Directory>
</VirtualHost>
" >> /etc/apache2/sites-available/Quiztool.conf
a2ensite Quiztool.conf
service apache2 restart
cd /var/www/html/Quiztool/Quiz-tool/quizgame
composer require predis/predis
npm install express ioredis socket.io --save

echo "[program:socket]
command=node /var/www/html/Quiztool/Quiz-tool/quizgame/socket.js
autostart=true
autorestart=true
stderr_logfile=/var/log/socket.err.log
stdout_logfile=/var/log/socket.out.log

" >> /etc/supervisor/conf.d/socket.conf
echo "[program:redis]
command=redis-server --port 3001
autostart=true
autorestart=true
stderr_logfile=/var/log/redis.err.log
stdout_logfile=/var/log/redis.out.log

" >> /etc/supervisor/conf.d/redis.conf

supervisorctl reread
supervisorctl update
service supervisor restart
mysql -u root -p -e "create database quiztool"
cd /var/www/html/Quiztool/Quiz-tool/quizgame
mv /var/www/html/Quiztool/Quiz-tool/quizgame/.env.example /var/www/html/Quiztool/Quiz-tool/quizgame/.env
php artisan key:generate
php artisan migrate
php artisan db:seed
echo "Include /etc/phpmyadmin/apache.conf" >> /etc/apache2/apache2.conf
echo "Seemingly we're done here."
