docker-compose-build-up:
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install

run-tests:
	docker-compose exec php vendor/bin/phpunit --testdox
