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
    'apiFile' => __DIR__ . '\..\iot.json'//path to json file with api endpoints and emails for notifications
]

```

Example of the required file , example iot.json

```JSON

{
  "endpoints": [
    "https:endpoint",
    ...multiple endpoinst can be added
  ],
  "subscribers": [
    "email@gmail.com",
    ...multiple subscribers can be added
  ],
  "sender": "sender email here"
}

```

#### 3. Available commands for cron

```PHP

/** load data from endpoints in json file or module parameter endpoints */
iot24/load

/** sends notification to all emails in json file or module parameter subscribers */
notification/send

```

#### 4. Web page endpoints

```PHP 

/** shows all donwloaded data from table `iot24` */
/** also shows graph of data from given channels */
iot24/index

/** allows update given data */
iot24/update

/** load data from endpoints in json file or module parameter endpoints */
iot24/load

```

loading from api

graphs