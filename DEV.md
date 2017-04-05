# Dev Readme

## Useful Commands

### For normal setup, follow the steps below:

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

create database
```
php bin/console doctrine:database:create
```

update database schema
```
php bin/console doctrine:schema:update --force
```

validate database schema
```
php bin/console doctrine:schema:validate
```

import database information by importing the clsp.sql file in the project root directory into the database, untick "enable foreign key checks"

update database.php in AppBundle directory so that the parameters match your database credentials and information

### Additional Commands

run the seeder
```
php bin/console doctrine:fixtures:load
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

# Generating keys for JWT

You MUST generate keys for authentication - and by extension this application - to work

The instructions below assume that you're one a Linux system. Modify the instructions appropriately if you're on a Windows or Mac system

```
mkdir var/jwt-keys
openssl genrsa -out var/jwt-keys/private.pem -aes256 4096
openssl rsa -pubout -in var/jwt-keys/private.pem -out var/jwt-keys/public.pem
```



