
## Dev Test Email App

### Requirements
- docker
- docker-compose
- curl
- php8.0
- php-curl
- phpunit
- zip
- unzip
- php-zip
- composer (below shows using composer.par from the install dir)

---

### NOTEs:
- You could run this without the container as well, if you commented out the DB code in `app/Console/Commands/ProcessEmails.php` on Line 84. The only real difference is no docker, and no MySQL being used. 
- It uses Laravel Sail for creating docker services/containers. https://laravel.com/docs/8.x/sail

---

### Install (Mac or Linux)

- Clone git repo from bitbucket `git clone https://github.com/rpacker/dev-test-sail.git` 
- cd into the code dir `cd ./dev-test-sail`
#### In hindsight I should have set this up to be able to pull in the laravel project, and then installed Sail via composer from the docker environment. 
It seemed excessive retrofit it for this, so pay attention to the requirements.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
- run `php composer.phar update`
- Create docker containers `./vendor/bin/sail up`
- In another terminal enter the container `docker exec -it dev-test-sail_laravel.test_1 bash`
- Create the env file `cp .env.example .env`
- Create the migration table  `php artisan migrate:install`
- Run migrations `php artisan migrate`
- Run the test app `php artisan email:process`

---

#### Running the above (php artisan email:process) will:

- print out the results
- log the results to `storage/logs/laravel.log`
- save the results to the db (see below)

---

#### If you'd like to see the results in the db, run these commands, also from within the container: 

```
mysql -h mysql -u sail -ppassword
USE dev_test_sail
SELECT * FROM email_data\G
```


