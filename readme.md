# Phones Validator

After clonning the repository, enter in the project folder and follow the steps bellow

## Building docker image:

`docker build -t phone_validator .`

## Starting a container

`docker run --name validator -it -d -p 8080:80 -v {path_to_project}:/phone_validator phone_validator`

## Installing dependencies

`docker exec -it validator composer install`

## Running tests

`docker exec -it validator vendor/bin/phpunit tests`

After all, it's possible to access the 127.0.0.1:8080 to see the interface