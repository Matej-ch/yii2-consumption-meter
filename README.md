IOT controller panel extension
====================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist matejch/yii2-iot24-meter "^1.0"
```

or add

```
"matejch/yii2-iot24-meter": "^1.0"
```

to the require section of your `composer.json` file.

Setup
-----

#### 1. First migrate table

```PHP
./yii migrate --migrationPath=@vendor/matejch/yii2-iot24-meter/src/migrations
```

#### 2. Add to modules in your web.php

```php 
'iot' => [
    'class' => \matejch\iot24meter\Iot24::class,
    'apiFile' => //path to json file with api endpoints and emails for notifications
]

```

#### 3. Available commands for cron

```PHP

iot24/load

notification/send

```

#### 4. Web page endpoints

```PHP 

iot24/index

iot24/update

iot24/load

```

loading from api

graphs