curl 'http://localhost:8000/user/add?username=user1'
curl 'http://localhost:8000/user/add?username=user2'

curl --location 'http://localhost:8000/user/1/send/2' \
--header 'Content-Type: application/json' \
--data '{
    "text" : "Hi user 2"
}'

curl --location 'http://localhost:8000/user/2/send/1' \
--header 'Content-Type: application/json' \
--data '{
    "text" : "Hi user 1"
}'

curl 'http://localhost:8000/chat/1'

