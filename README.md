# Lea Record Shop

## Setup

#### Install Docker
Before you start, you must have docker and docker compose installed
- [Install Docker](https://docs.docker.com/engine/install/)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

#### Start Containers
```docker-compose up -d```

#### Run Setup Script
```docker-compose run --rm php composer setup```

#### Generate API documentation
```docker-compose exec php php artisan scribe:generate```

[Documentation URL](http://localhost/docs)