#Install the needed libs and create the database for the backend
install:
	composer install
	composer update
	./fixture

