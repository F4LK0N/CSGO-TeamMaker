# CSGO Empire - Challenge

## DEVELOPMENT
Local:
```bash
docker compose build
docker compose up -d
docker compose exec -it app /bin/bash
```
Container:
```bash
composer create-project --prefer-dist laravel/laravel .
php artisan key:generate
```

## BUILD
Local:
```bash
docker compose build
docker compose exec app php artisan migrate
```

## RUN
Local:
```bash
docker compose up -d
docker compose exec app php artisan serve --host=0.0.0.0 --port=3000
```

## ACCESS
```bash
http://localhost:3000
```

## TEST
```bash
docker compose exec app composer test
```



player name unique
random player when 2 skills equal
