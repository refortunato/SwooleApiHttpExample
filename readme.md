# Swoole Http Example

This application is a example using Swoole HTTP with PSRs 7, 11 for Http Requests, Responses and Controllers.

## How to execute - local

Run:

```sh
# For the first time
docker-compose up --build

# If it's already built
docker-compose up
```

And then enter in container console:
```sh
docker exec -it php_app_swoole_http bash
```

Inside container, run:
```sh
php /var/www/framework/start-swoole-http.php
```

## How to build image

Run:
```sh
docker build -t myaccount/my_app_name:1.0.0 -f ./docker-build/Dockerfile .
```

### Execute image locally

Run:
```sh
docker run  -p 80:9501 --name my_swoole_app myaccount/myapp_name:1.0.0
```

Stop imagem local:
```sh
docker stop my_swoole_app
```
