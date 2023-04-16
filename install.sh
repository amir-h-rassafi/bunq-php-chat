sudo apt update
sudo apt install -y docker.io docker-compose npm
docker-compose -f env/docker-compose.yml build --no-cache  
docker-compose -f env/docker-compose.yml up -d
docker-compose -f env/docker-compose.yml exec worker sqlite3 database/chat.db ".read database/chat.sql"
docker-compose -f env/docker-compose.yml exec worker chown www-data:www-data -R database/ 
docker-compose -f env/docker-compose.yml exec worker composer install
cp readme.md app/readme.md
