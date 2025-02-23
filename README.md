--- Step 1 ----
composer install

--- Step 2 ----
cp .env.example .env

--- Step 3 ----
php artisan key:generate

--- Step 4 ----
php artisan migrate

--- Step 5 ----
php artisan db:seed

--- Step 6 ----
php artisan storage:link

--- Step 7 ----
php artisan optimize:c

--- Step 8 ----
npm install

--- Step 9 ----
npm run dev 

--- Step 10 ----
php artisan serve


# E-commerce
