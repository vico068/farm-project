#PASO A PASSO DE IMPLANTAÇÃO



create db

cp .env.example .env

config .env

composer install

php artisan key:generate

php artisan storage:link

php artisan migrate

php artisan db:seed

