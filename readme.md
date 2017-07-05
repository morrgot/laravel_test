## Get Started

Предполагается, что запускаемся за Linux машине, на которой имеются:
* Имеется PHP >= 5.5.9
* БД MySQL
* Есть сервер Nginx

### Инструкция

1. Зайти в директорию проекта.
```bash
cd /path/to/laravel_test
```
2. Скачиваем все необходимые пакеты composer-ом
```bash
php composer.phar install
```
3. В Mysql создаем базу "laravel_test" (CREATE DATABASE laravel_test;). В конфигурации БД используется "стандартный" пользователь root с пустым паролем, так что если надо - не забываем это подправить в `laravel_test/config/database.php`
4. Запускаем миграции и сиды
```bash
php artisan migrate:refresh --seed
```
5. Nginx конфиг лежит в корне - `laravel_test/laravel.conf`. Его необходимо добавить к остальным конфигам.
```bash
sudo ln -s /var/www/laravel_test/laravel.conf /etc/nginx/sites-enabled/laravel.conf
# Либо просто скопировать
sudo сз /var/www/laravel_test/laravel.conf /etc/nginx/sites-enabled/laravel.conf
```
6. В nginx конфиге правим переменную `$root`, в которой указываем путь к директории с входным скриптом
```
set $root /var/www/laravel_test; # Меняем на свой /path/to/laravel_test
root $root;
```
7. Перезапускаем nginx.
```bash
sudo nginx -t
sudo nginx -s reload
```
 А, ну и не забываем в прописать себе в хостах c IP вашей виртуальной машины! У меня так:
 ```
 10.10.20.16 laravel_test.dev api.laravel_test.dev
 ```
8. Готово! Можно заходить на `http://laravel_test.dev`.


