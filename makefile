sh:
	docker-compose exec -T backend sh

setup:
	make install
	make clear
	make migrate
	make storage
	make passport

install:
	docker-compose exec -T backend composer install

migrate:
	docker-compose exec -T backend php artisan migrate:fresh --seed

storage:
	docker-compose exec -T backend php artisan storage:link

clear:
	docker-compose exec -T backend php artisan config:cache
	docker-compose exec -T backend php artisan config:clear
	docker-compose exec -T backend php artisan config:clear

passport:
	docker-compose exec -T backend php artisan passport:keys --force
	docker-compose exec -T backend php artisan passport:client --personal

telescope:
	docker-compose exec -T backend php artisan telescope:publish