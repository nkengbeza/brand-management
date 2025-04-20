docker-compose down
docker-compose up -d --build

docker-compose exec app php artisan config:clear

docker-compose exec app php artisan migrate
