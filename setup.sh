composer install
cp .env.example .env
sudo chmod +x bin/console
bin/console regenerate-app-secret
sudo chown -R www-data:www-data /var/www/symfony.alexishenry.eu/var