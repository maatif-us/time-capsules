# Time Capsules

## Backend
        1. composer i
        2. cp .env.example .env
        3. php artisan key:generate
        4. php artisan migrate

## Frontend setup
        1. npm i
        2. npm run dev/build

## Run the app

    php artisan serve

## Run the tests

    php artisan test 

## Using Docker
  ```
  1. docker build -t {container_name} .
  2. docker run -p 8000:8000 -p 8081:8081 {container_name}
  ```
