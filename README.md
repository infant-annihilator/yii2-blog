Базовый блог на yii2 basic с автоформированием тегов

![image](https://user-images.githubusercontent.com/59831069/132142149-a4f88161-c147-4b58-8a5a-6c184c51776c.png)


УСТАНОВКА
------------
Выполните команду 
git clone https://github.com/infant-annihilator/yii2-blog.git

Склонировав репозиторий себе на компьютер, пропишите cookieValidationKey В `config/web.php`.
Им может быть любая строка, содержащая английские буквы и цифры.

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

### База Данных

Настройте под себя `config/db.php`, например (прежде убедитесь, что вы уже создали бд 
с указанными учётными данными и названием):

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=blog',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
];
```

Установите миграции в БД

   ```
   tests/bin/yii migrate
   ```

### Установите зависимости через Composer 

    ```
    composer install  
    ```

ЗАПУСК
------------
Запустите сервер (к примеру, openserver)
При разработке использовались php 7.4 и MariaDB 10.3
Если всё сделано верно, то приложение будет доступно по адресу

~~~
http://blog/
~~~
