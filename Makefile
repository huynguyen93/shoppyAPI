make docker-build:
	docker-compose build --no-cache

docker-up:
	docker-compose up -d --build; \
	docker-compose ps

docker-stop:
	docker-compose stop

ssh-php:
	docker exec -it php7.1  sh -c "cd /usr/local/apache2/htdocs/shoppy && /bin/bash"

ssh-apache:
	docker exec -it apache2 bash

app-install:
	docker exec -it php7.1 sh -c "cd /usr/local/apache2/htdocs/shoppy && \
	composer install && \
	bin/console doctrine:database:create --if-not-exists && \
	bin/console doctrine:schema:update --force && \
	rm -rf var/* && \
	exit" \

make app-data-reset:
	docker exec -it php7.1  sh -c "cd /usr/local/apache2/htdocs/shoppy && bin/console hautelook:fixtures:load --no-interaction"




