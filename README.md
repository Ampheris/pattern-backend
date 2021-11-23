# SparkApi



## Table of content
* [Contributing](#get-started-with-developing)
* [Code quality](#code-quality)
* [Test Api](#postman)


## Get started with developing
* Clone repo
* Install requirements:
    ```text
    composer install
    ```
* Migrate database:
    * In .env set DB_CONNECTION=sqlite and remove the rest of the database envs.
    * Create a file database.sqlite and place it in the database folder.
    ```text
    php artisan migrate
    ```
* Run development server: php -S localhost:8080 -t public

## Code quality
Make sure you keep a good code standard when contributing

```text
make install
make test
```

## Use Postman to test Api
Import the files in the postman folder to your Postman workspace.
