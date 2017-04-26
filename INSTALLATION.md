# Requirements (backend)
CLSP runs onthe LAMP stack. Below are some recommended configurations. Note that other versions of PHP/MySQL/Apache may work, but were not tested.

Our backend is in Symfony 3.2, and our frontend is in Angular 4. If you have problems using this guide, please consult the following pages.

### Outside Resources

- [Symfony 3.2 Installation](http://symfony.com/doc/3.2/setup.html)
- [Symfony 3.2 Requirements](http://symfony.com/doc/3.2/reference/requirements.html)
- [Angular 4 Installation](https://github.com/angular/angular-cli#installation)
- [Angular 4 Requirements](https://github.com/angular/angular)

We used [Syfmony 3.2 Standard Edition](https://github.com/symfony/symfony-standard) and [Angular CLI 1.0.0](https://github.com/angular/angular-cli) to create our projects initially. 

If you want to see if your version of PHP is correctly configured for Symfony 3.2, you can run ```php bin/symfony_requirements``` from the root of the clsp backend directory ```clsp```

### Minimum System Requirements

We didn't test this thoroughly. There's no guarantee this configuration will work

- Apache 2.4 
    - ```.htaccess``` files must be enabled. We use Apache's ```mod_rewrite``` to process URLs, without which the backend API will not function properly. 
- PHP 5.6
    - ```post_max_size = 64M``` and ```upload_max_filesize = 64M``` - These option constrains file upload size over ```POST```. Increase them so you can upload larger media files. I'd recommend increasing it to at least ```64M```.
    - ```default_charset = "UTF-8"``` - Make sure that PHP uses ```UTF-8``` so that non ```ASCII``` characters display correctly.
    - ```always_populate_raw_post_data = -1``` - For some reason, without this option PHP will throw an error and screw up JSON parsing on the front end.
    - ```extension=php_openssl.dll``` - OpenSSL extension must be installed and enabled
    - ```extension=php_pdo_mysql.dll``` - PDO MySQL driver must be installed and enabled
- MySQL 5.6
    - You must edit/add the following lines to the relavent section of your ```my.cnf``` or ```my.ini``` (MySQL configuration file) to ensure that non ```ASCII``` characters are displayed properly
```
[mysqld]
collation-server     = utf8_unicode_ci
character-set-server = utf8   
```

### Recommended System Requirements

Recommended! This was the configuration 

- Apache 2.4 
    - ```.htaccess``` files must be enabled. We use Apache's ```mod_rewrite``` to process URLs, without which the backend API will not function properly. 
- PHP 7.1
    - ```post_max_size = 64M``` and ```upload_max_filesize = 64M``` - These option constrains file upload size over ```POST```. Increase them so you can upload larger media files. I'd recommend increasing it to at least ```64M```.
    - ```default_charset = "UTF-8"``` - Make sure that PHP uses ```UTF-8``` so that non ```ASCII``` characters display correctly.
    - ```extension=php_openssl.dll``` - OpenSSL extension must be installed and enabled
    - ```extension=php_pdo_mysql.dll``` - PDO MySQL driver must be installed and enabled
- MySQL 5.7
    - You must edit/add the following lines to the relavent section of your ```my.cnf``` or ```my.ini``` (MySQL configuration file) to ensure that non ```ASCII``` characters are displayed properly
```
[mysqld]
collation-server     = utf8_unicode_ci
character-set-server = utf8   
```

# Requirements (frontend)

- Google Chrome 57+

CLSP Frontend probably runs on most modern web browsers (Internet Explorer, Microsoft Edge, and Firefox). We only used Chrome during development however, so we don't guarantee that any of those browesers actually work.

# Installation Dependencies

These instructions assume you're installing CLSP on an Ubuntu 16.04 x64 server. Chance these instructions accordingly depending on your host operating system.
 - git
```sudo apt-get install git```
#### backend
- Composer 
```sudo apt-get install composer```
- OpenSSL
```sudo apt-get install openssl```
#### frontend
- NodeJS
```sudo apt-get install nodejs```
- npm
```sudo apt-get install npm```
- Angular CLI 1.0.0
```npm install -g @angular/cli```

# Installation (from source)

1. Download the backend source files

```git clone git@github.com:TeamCloud-CLSP/clsp.git```

2. ```cd``` to the ```clsp``` directory you just cloned

```cd clsp```

3. Use OpenSSL to generate certificates for signing the JWT tokens

```openssl genrsa -out var/jwt-keys/private.pem -aes256 4096```

```openssl rsa -pubout -in var/jwt-keys/private.pem -out var/jwt-keys/public.pem```

Remember the passphrase you used for your private key! That passphrase must be entered when your run ```composer install```
More resources on how to setup authentication can be found here [LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation)

4. Use ```composer``` to install dependencies and define configuration parameters

```composer install```

5. Create the database CLSP will use. Skip this step if you've already created your database. Note: this command will only work if the uesr that you entered into your composer configuration has permission to create the database.

```php bin/console doctrine:database:create```

6. Setup the database schema

```php bin/console doctrine:schema:update --force```

7. Validate the database schema

```php bin/console doctrine:schema:validate```

8. Load a default admin user

```php bin/console doctrine:fixtures:load```

9. Set your webroot for this project to ```./web```

10. That's it! Your CLSP backend should now work. 

11. Now let's setup the frontend. ```cd``` to the directory where you originall cloned CLSP

```cd ..```

12. Download the frontend source files

```git clone git@github.com:TeamCloud-CLSP/clsp-frontend.git```

13. ```cd``` to the ```clsp-frontend``` directory you just cloned

```cd clsp-frontend```

14. Use ```npm``` to install frontend dependencies

```npm install```

15. Build the front end

```ng build -prod```

16. Copy the contents of the of the ```clsp-frontend/dist``` directory into the ```clsp/dist``` directory
TODO: actually add the command here

17. You're done! Use ```admin/admin``` to login to CLSP









