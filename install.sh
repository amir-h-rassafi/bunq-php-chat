sudo apt update
sudo apt install -y docker.io docker-compose
docker-compose -f env/docker-compose build --no-cache  
docker-compose -f env/docker-compose.yml up -d
docker-compose -f env/docker-compose.yml run worker sqlite3 database/chat.db ".read database/chat.sql"