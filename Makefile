init:
	docker-compose up --build -d
	docker exec -it test-app composer install
	docker exec -it test-app chmod -R 777 var
	sleep 5
	docker exec -it test-app php bin/console doctrine:database:create -q
	docker exec -it test-app php bin/console doctrine:schema:create -q
	docker exec -it test-app php bin/console parse -q
	echo "Open 127.0.0.1:8886"