sail=./vendor/bin/sail
$sail composer install
$sail artisan custom:migrate
$sail artisan db:seed
$sail artisan passport:install
