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
sudo cp /var/www/laravel_test/laravel.conf /etc/nginx/sites-enabled/laravel.conf
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

## REST API
`http://api.laravel_test.dev` - апи хост.

АПИ возвращает JSON объекты. 
В случае успеха возвращается статус 200 и допольнительная информация. 

В случае любой ошибки возвращается JSON объект с соответствующим статусом:
```
{"error": "Product 13 not found", "code": 400}
```

### Endpoints:
1. **Создать продукт**:
```
POST http://api.laravel_test.dev/product
```
В POST передаем название и цену:
- **name** - string;
- **price** - integer.

*Success*:
```
{"id": 321}
```
Id созданного продукта.
2. **Купить продукт**
```
PUT http://api.laravel_test.dev/product/{product_id}/buy
```
- *{product_id}* - integer

*Success*:
```
{"id": 321}
```
Id купленного продукта.
3. **Создать ваучер**
```
POST http://api.laravel_test.dev/voucher
```
В POST передаем название и цену:
- **start_date** - string, дата в формате "Y-m-d";
- **end_date** - string, дата в формате "Y-m-d";
- **discount** - integer. Может принимать значения - [10, 15, 20, 25].

*Success*:
```
{"id": 321}
```
Id созданного ваучера.
4. **Привязать ваучер к продукту**
```
POST http://api.laravel_test.dev/voucher/{voucher_id}/product/{product_id}
```
- *{voucher_id}* - integer
- *{product_id}* - integer

*Success*:
Пустой ответ со статусом 200.
5. **Отвязать ваучер от продукта**
```
DELETE http://api.laravel_test.dev/voucher/{voucher_id}/product/{product_id}
```
- *{voucher_id}* - integer
- *{product_id}* - integer

*Success*:
Пустой ответ со статусом 200.