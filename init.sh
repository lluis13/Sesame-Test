#!/bin/bash

sleep 10

echo "Drop scheme 'app' if exist..."
php bin/console doctrine:database:drop --force

echo "Creating scheme 'app'..."
# Luego creamos el esquema de nuevo
php bin/console doctrine:database:create

echo "Droping all tables..."
php bin/console doctrine:schema:drop --force


echo "Executing Symfony migration..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Initialized."
