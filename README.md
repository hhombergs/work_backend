Flats backend (Work example)
============================

Before the installation please change the app/cinfig/parameters.yml file to your needs (i.e. database name, user and SMTP data).
If you use MySQL instead of Postgresql please change also the doctrine dbal driver to pdo_mysql or mysqli in the app/config/config.yml file. 
When you are using the Postgresql server you must install the pdo_pgsql extension for PHP.
After you have made the needed changes run make from the repro main dir.
After the make process is finished run php bin/console server:run to start the REST Backend service without the need for a HTTP server 
(i.e. apache or nginx)