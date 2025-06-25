<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instalacja aplikacji

1. Sklonuj repozytorium i zainstaluj zależności:

```bash
git clone https://github.com/prosp3ro/php_todo_app_filament
cd php_todo_app_filament
composer install
npm install
```

2. Skonfiguruj plik .env:

```bash
cp .env.example .env
php artisan key:generate
```

3. Uruchom projekt

Bez dockera:

```bash
php artisan migrate
php artisan serve
npm run dev
```

Z użyciem laravel sail:
Najpierw w pliku `.env` ustaw odpowiednie porty (FORWARD).

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
npm run dev
```

4. Wystartuj kolejkę:

```bash
php artisan queue:work
# albo
sail artisan queue:work
```
