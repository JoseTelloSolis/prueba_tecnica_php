up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

restart: down up

ps:
	docker-compose ps

logs:
	docker-compose logs -f
