sh:
	docker-compose exec php sh

setup:
	make clear
	make migrate
	make passport

migrate:
	docker-compose exec php php artisan migrate --seed

clear:
	docker-compose exec php php artisan config:cache
	docker-compose exec php php artisan config:clear
	docker-compose exec php php artisan config:clear

passport:
	docker-compose exec php php artisan passport:keys --force
	docker-compose exec php php artisan passport:client --personal