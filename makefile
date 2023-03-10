bash:
	docker-compose exec backend bash

setup:
	make install
	make clear
	make migrate
	make storage
	make passport

install:
	docker-compose exec backend composer install

migrate:
	docker-compose exec backend php artisan migrate:fresh --seed

storage:
	docker-compose exec backend php artisan storage:link

clear:
	docker-compose exec backend php artisan config:cache
	docker-compose exec backend php artisan config:clear
	docker-compose exec backend php artisan config:clear

passport:
	docker-compose exec backend php artisan passport:keys --force
	docker-compose exec backend php artisan passport:client --personal

telescope:
	docker-compose exec backend php artisan telescope:publish