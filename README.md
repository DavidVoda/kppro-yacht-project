
# KPPRO-yacht-project

University project based on Symfony 6 (PHP).
Database: postgres

## How to run

1. execute following commands (see `./bin/yacht` for more details)
```shell
./bin/yacht composer install # to install php dependencies.
./bin/yacht up # to build and run docker containers via docker-compose.
./bin/yacht reinit # to shut down containers, run them again, clear cache, empty database and run database migrations and fixtures.
```
2. open [http://localhost]()

### Run tests
With running containers (`./bin/yacht up`) run `./bin/yacht test`

## Logins

 - **standard user**: user@gmail.com | Heslo123
 - **admin**: admin@gmail.com | Heslo123 

## Use cases

 - Register
 - Login

### User use cases
 - Yacht list
 - Yacht detail
 - Book yacht
 - Review yacht
 - View *My reservations*

### Admin use cases
 - Add new yacht
 - Delete review
 - Delete reservation
 - View all reservations

## Entities

 - Yacht
 - Reservation
 - Review
 - User
