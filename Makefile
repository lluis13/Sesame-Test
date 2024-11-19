docker-compose-build-up:
	docker-compose build
	docker-compose up -d

run-tests:
	docker-compose exec php vendor/bin/phpunit --testdox
