# Bunq Task -- create simple chat app with php/slim.

### NOTE! It is so simple, without any Auth, any Websocket, any Status management!


## How to install?

```
chmod +x install.sh
./install.sh
```

now you have it on http://localhost:8000


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
