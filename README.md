[![CI](https://github.com/djonasm/lea-record-shop/actions/workflows/backend-tests.yml/badge.svg?branch=main)](https://github.com/djonasm/lea-record-shop/actions/workflows/backend-tests.yml)
# About Lea Record Shop
Example of the REST API of a small ecommerce, where it is possible to manage users, products (disks) and orders. With a system that ensures that no more stock is sold than the product has, even in the case of many simultaneous orders.

## Technologies
### Lumen Framework 
Is a PHP micro-framework for creating APIs and microservices. It was used because it was incredibly fast and simple to use.

### MySQL
Database Service is a fully managed database service. It allowed the project to use transaction to ensure that orders and stock are updated together.

### Docker
Takes away repetitive, mundane configuration tasks and is used throughout the development lifecycle for fast, easy and portable application development.

### Github Actions
Automate your workflow from idea to production. It is running all the tests in the project whenever a commit or merge occurs.
 
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
The test that guarantees the stock, for this we will run the test in parallel, which performs thousands of simultaneous requests to generate an order, where the amount of stock is validated and decremented with each order.

```docker-compose run --rm php vendor/bin/paratest --processes 50 --repeat 100 --testsuite="acceptance"```

## API Documentation
#### Generating Documentation
```docker-compose exec php php artisan scribe:generate```

Should now be able to visit the documentation on: http://localhost/docs

You should see something similar to this:
![LeaRecordAPIDocs](https://user-images.githubusercontent.com/1079090/151680362-e7150922-2c91-4b6d-af32-e1dedd608601.png)

## Deploy 
To deploy the application, the AWS Elastic Beanstalk service can be used it is necessary to configure a cache server (Redis) and database (MySQL).

### Elastic Beanstalk

AWS Elastic Beanstalk is an easy-to-use service for deploying and scaling web applications and services. AWS Elastic Beanstalk is an easy-to-use service for deploying and scaling web applications and services

[Deploying a Laravel application to Elastic Beanstalk](https://docs.aws.amazon.com/elasticbeanstalk/latest/dg/php-laravel-tutorial.html#php-laravel-tutorial-database)

### Amazon RDS
The existing setup with docker is for development only, so it is necessary to configure a database to ensure the application works property.

### Amazon ElastiCache
it is necessary to configure a cache server, because currently the stock reservation is being made using file or memory, and if there were several servers the stock reservation would not work. The link above already includes the configuration with the database.

[Setting up a Redis Cluster for scalability and high availability](https://aws.amazon.com/getting-started/hands-on/setting-up-a-redis-cluster-with-amazon-elasticache/)
