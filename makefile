sh:
	docker-compose exec backend sh

setup:
	make clear
	make migrate
	make storage
	make passport

migrate:
	docker-compose exec backend php artisan migrate --seed

storage:
	docker-compose exec backend php artisan storage:link

clear:
	docker-compose exec backend php artisan config:cache
	docker-compose exec backend php artisan config:clear
	docker-compose exec backend php artisan config:clear

passport:
	docker-compose exec backend php artisan passport:keys --force
	docker-compose exec backend php artisan passport:client --personal