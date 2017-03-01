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

drop the database
```
php bin/console doctrine:database:drop --force
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

# Setting Up MySQL to use UTF-8

### Instructions
add the following lines to your ```my.cnf``` or ```my.ini``` file. Check your version of MySQL's documenation for the actual file.
```ini
[mysqld]
collation-server     = utf8_unicode_ci
character-set-server = utf8           
```




More information in the "Setting up the Database to be UTF8" section of the Symfony doctrine documentation

http://symfony.com/doc/current/doctrine.html

