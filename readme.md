## Bunq Task
Create simple chat app with php.

### It is so simple, without any Auth, any Websocket, any Status management!


## How to run?

```
docker-compose up -d
```


## API

### ADD USER
```
curl http://localhost:8000/users/add?username={USER_NAME}
```
### LIST USERS
```
curl http://localhost:8000/users/list?count={COUNT}
```
