#Install the needed libs and create the database for the backend
install:
	composer install
	composer update
	php bin/console doctrine:database:create --if-not-exists
	php bin/console doctrine:schema:update --force
	cat dump.sql|xargs -0 php bin/console doctrine:query:sql

