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
curl 'http://localhost:8000/user/add?username={USER_NAME}'
```

### LIST USERS
```
curl 'http://localhost:8000/user/list?count={COUNT}'
```

### SEND MESSAGE
```
curl --location 'http://localhost:8000/user/{USER_ID_1}/send/{USER_ID_2}' \
--header 'Content-Type: application/json' \
--data '{
    "text" : {TEXT}"
}'
```

### GET CHATS
```
curl 'http://localhost:8000/user/{USER_ID}/chats'
```

### GET CHAT MESSAGES

```
curl 'http://localhost:8000/chat/{USER_ID}'
```
