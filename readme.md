## Blend, Online demo details

[http://blend.planup.io/login](http://blend.planup.io/login)

U: [trajanov@adevait.com](mailto:trajanov@adevait.com)

P: 123456

## Blend, Setup Guide

The application should be running on Ubuntu 16, no matter if it is on VirtualBox or not. The rest of the requrements for the application are the following: 

- Nginx or Apache 
- PHP 7.0 or above 
- MySQL 
- Composer 
- PHP Extensions (PDO PHP, Mbstring PHP, Tokenizer PHP) 

### 1. Environment setup guide

If you local environment doesn’t meet any of the requrements above here are some instructions about setting them up. 

#### Linux

Apache, PHP, MySQL

[https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-16-04)

Composer

[https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-14-04)
 

Mac OS

Apache, PHP, MySQL

[https://www.mamp.info/en/](https://www.mamp.info/en/)

Composer

[https://getcomposer.org/doc/00-intro.md](https://getcomposer.org/doc/00-intro.md)

Windows 

Apache, PHP, MySQL

[http://www.wampserver.com/en/](http://www.wampserver.com/en/)

Composer

[https://getcomposer.org/doc/00-intro.md](https://getcomposer.org/doc/00-intro.md)

 
### 2. Virtual Hosts

Once the environment is setup, you should create Virtual Hosts pointing to the application. 


For Linux users, more info about is available on the following link - 

[https://www.digitalocean.com/community/tutorials/how-to-set-up-apache-virtual-hosts-on-ubuntu-16-04](https://www.digitalocean.com/community/tutorials/how-to-set-up-apache-virtual-hosts-on-ubuntu-16-04)


For Windows users, there is more info on the following link - 

[http://www.techrepublic.com/blog/smb-technologist/create-virtual-hosts-in-a-wamp-server/](http://www.techrepublic.com/blog/smb-technologist/create-virtual-hosts-in-a-wamp-server/)


For MacOS, virtual hosts setup info here - 

[http://www.joostrap.com/blog/setting-up-local-virtual-hosts-in-mamp](http://www.joostrap.com/blog/setting-up-local-virtual-hosts-in-mamp)


### 3. Applcation Setup 

### 3.1 Database setup

1. Create a new database that would be used for the application. You could use `blend` as a database name.  
2. Rename the env.example file located on the root of the project into .env file 
3. Update the database hostname, database, username and password to match the local ones.  
4. Run php artisan migrate from the terminal to create the DB schema and seed the data.  
 

### 3.2 Generate app key 

1. Run php artisan key:generate to generate new app key. 

 
### 3.3 Install dependencies

1. Run composer install or composer.phar install to download the project dependencies 

### 3.4 Setup files & folders permissions

1. The /storage folder located on the project root should be writtable by the application; 
2. The /bootstrap/cache folder should be writtable by the application;

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
