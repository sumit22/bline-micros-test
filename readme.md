#Project setup and starting

```
# navigate to project folder and run this command

docker compose -f "docker-compose.yml" up -d --build

```
this will start the user service and kong in their respective containers


## Configure user-service in Kong
```
curl -i -X POST http://localhost:8001/services \
  --data "name=user-service" \
  --data "url=http://user-service:8080"

curl -i -X POST http://localhost:8001/services/user-service/routes \
  --data "paths[]=/user-service"


#Enable plugin for key based authentication
curl -i -X POST http://localhost:8001/services/user-service/plugins \
  --data "name=key-auth"

#create consumer
curl -i -X POST http://localhost:8001/consumers \
  --data "username=user-service-consumer"

#setup API KEY, you can pass your own custom static api key
curl -i -X POST http://localhost:8001/consumers/user-service-consumer/key-auth \
  --data "key=b63d5a16-c20d-41b5-94d8-3d66a6490c95"

  ```

  ## User Service APIs

pass the apiKey header to access the users/ apis

  ```
curl --location 'http://localhost:8000/user-service/users/' \
--header 'apiKey: b63d5a16-c20d-41b5-94d8-3d66a6490c95'


curl --location 'http://localhost:8000/user-service/users/1111' \
--header 'apiKey: b63d5a16-c20d-41b5-94d8-3d66a6490c95'

  ```



