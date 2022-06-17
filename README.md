# bus-booking

## requiremnets 
in order to run the project these requiremnts need to be installed on you machine 
```
docker
composer  // TODO : add  add composer image to docker composer file
```

## installation steps
- after cloning the repository run these commands on the root folder 

  ```
  docker-compose build
  ```
  ```
  docker-compose up -d
  ```

- change the directory to the src folder 
`cd src`
- install require packages using composer 
  ```
  composer install
  ```
- to build the database tables and presist seeding data into it run this command 
  ```
  docker-compose exec php  php /var/www/html/artisan migrate:fresh --seed
  ```
- run passport install command to generate keys that will be used for authentication
  ```
  docker-compose exec php  php /var/www/html/artisan passport:install
  ```
- to check that everything is working fine go to this url `localhost:8088/trips` to see the information of the trips and the available seats on each trip

  you should see something like this 
  
  ![image](https://user-images.githubusercontent.com/28245801/174397750-7f5b0939-95cc-4144-a987-06e8665562f5.png)





## Postman 
  you can use [this](https://www.getpostman.com/collections/fc6aeab4a5302159c583) postman collection to see the availables APIs
  
  ```bash
---------------------------------------------------------------------------------------------
| resource                  | description                                                   |
|---------------------------|---------------------------------------------------------------|
| `/api/register`           | to register new user                                          |
--------------------------------------------------------------------------------------------|
| `/api/login`              | login with registered user to get the token                   |
|                           |  that will be used in the upcoming requests                   |
--------------------------------------------------------------------------------------------|
| `/api/make-reservation`   | given the start_city_id and end_city_id and seat_id           |
|                           |  you can make a reservation                                   |
--------------------------------------------------------------------------------------------|
| `/api/available-seats`    | given the start_city_id and end_city_id                       |
|                           | you can see all available trips and the free seats            |
---------------------------------------------------------------------------------------------
```
