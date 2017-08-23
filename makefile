#Install the needed libs and create the database for the backend
install:
	composer install
	php bin/console doctrine:database:create --if-not-exists
	php bin/console doctrine:schema:update --force

