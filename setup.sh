composer install
cp .env.example .env
sudo chmod +x bin/console
bin/console regenerate-app-secret