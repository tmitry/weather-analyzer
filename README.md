# Weather Analyzer

## About

Analyze weather based on open services.


## 1. Installation ##

``` bash
$ composer install
```
Configure database in ".env"
``` bash
$ php bin/console doctrine:database:create
```
``` bash
$ php bin/console doctrine:migrations:migrate
```

## 2. Usage ##

``` bash
$ symfony server:start
```
``` bash
http://127.0.0.1:8000/temperature/
```


