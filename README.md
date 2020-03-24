<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Пример чата на laravel

Все в данном проекте делалось в ознакомительных целях.

## Настройка проекта
- `composer install`
- настроить `.env` файл
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan db:seed` - можно просто зарегистрировать нескольких пользователей по ссылке `/register`

Установка клиентской части
- `yarn install && yarn dev`
- установить laravel-echo-server `yarn global add laravel-echo-server`
- `laravel-echo-server init` или скопировать `laravel-echo-server.example.json` без `example`

## Запуск проекта
Я использую `homestead` по этому инструкция будет содержать список действий для него.
После установки зависивостей и настройки `.env` файла нужно запустить очереди и `laravel-echo-server`.
Очереди работают с помощью redis.
- в файле `.env` APP_URL должен быть равен "authHost" в файле `laravel-echo-server.json` и ссылке в строке браузера
- настраиваем redis в `.env` , драйвера вещателя и очередей `BROADCAST_DRIVER=redis` `QUEUE_CONNECTION=redis`
- подключаемя к `vagrant ssh` и в папке проекта (например:`code/laravel_chat_example` ) запускаем `laravel-echo-server` и `queue`
- в одном подключении запускаем эхо сервер `laravel-echo-server start`
- во втором подключении щапускаем очереди `php artisan queue:work`

