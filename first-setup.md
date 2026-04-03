Install node lts 24.14.1 (npm)

cp .env.example .env

install composer
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"

install laravel
composer global require laravel/installer

composer install
npm install