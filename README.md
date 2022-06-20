# bus-booking

## requiremnets 
in order to run the project these requiremnts need to be installed on you machine 
```
docker
docker-compose
```

## installation steps
- after cloning the repository run this command on the root folder 


  ```
  docker-compose up -d --build
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

- you can first use the register API to register new user
  this API will return access token to be used by other requests to as and authoirzation header ( Postman will do this automiatically )

- you can go to `localhost:8088/trips` to check the available trips and seats 
- after booking a reservation you can see that the seat status has changed to booked like this 

  ![image](https://user-images.githubusercontent.com/28245801/174405613-806f004d-c4f4-48d7-b14b-0396257d9b25.png)

