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

set up database schema
```
php bin/console server:run
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
