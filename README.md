rename .env.example to .env

create a database with this command:
CREATE DATABASE mydatabase CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;


change app_url and database name in .env

run composer install

run php artisan key:generate

run php artisan storage:link

import database from data.sql file in database/data.sql(as it contains admin credentials. DONOT RUN PHP ARTISAN MIGRATE)

login with the following details for admin: on http://url/admin/login

User email: superadmin@admin.com(Donot login with this)
User Password: password

User email: admin@admin.com(login with this)
User Password: password12345

for common user register and login on http://url/login
