# backend

## Get started with developing
* Download repo
* Install requirements: composer install
* Migrate database:
    * In .env set DB_CONNECTION=sqlite and remove the rest of the database envs.
    * Place your database.sqlite in the database folder.
    * php artisan migrate
* Run development server: php -S localhost:8000 -t public


## Use Postman to test Api
Import the files in the postman folder to your Postman workspace.
