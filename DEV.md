# Dev Readme

### Useful Commands
To install all dependencies:

```
composer install 
```

run built in PHP 7.1 development web server
```
php bin/console server:run
```

create databse
```
php bin/console doctrine:database:create
```

run the seeder
```
php bin/console doctrine:fixtures:load
```


validate database schema
```
php bin/console doctrine:schema:validate
```

update database schema
```
php bin/console doctrine:schema:update --force
```

clear all caches
```
php bin/console cache:clear
```

regenerate Entity getters and stters
```
php bin/console doctrine:generate:entities AppBundle
```

create an entity
```
php bin/console doctrine:generate:entity
```

create new controller
```
php app/console generate:controller
```
