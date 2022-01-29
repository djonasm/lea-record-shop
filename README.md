[![CI](https://github.com/djonasm/lea-record-shop/actions/workflows/backend-tests.yml/badge.svg?branch=main)](https://github.com/djonasm/lea-record-shop/actions/workflows/backend-tests.yml)
# About Lea Record Shop
Example of the REST API of a small ecommerce, where it is possible to manage users, products (disks) and orders. With a system that ensures that no more stock is sold than the product has, even in the case of many simultaneous orders.

## 

## Setup

#### Install Docker
Before you start, you must have docker and docker compose installed
- [Install Docker](https://docs.docker.com/engine/install/)
- [Install Docker Compose](https://docs.docker.com/compose/install/)

#### Start Containers
```docker-compose up -d```

#### Run Setup Script
```docker-compose run --rm php composer setup```

## Tests

### Running Unit and Integration Tests
```docker-compose run --rm php vendor/bin/phpunit --testsuite="unit,integration"```

### Running Stock Test
The test that guarantees the stock, for that we will run in parallel making thousands of simultaneous requests.

```docker-compose run --rm php vendor/bin/paratest --processes 50 --repeat 100 --testsuite="acceptance"```

## Documentation
#### Generating Documentation
```docker-compose exec php php artisan scribe:generate```

Should now be able to visit the documentation on: http://localhost/docs

You should see something similar to this.
