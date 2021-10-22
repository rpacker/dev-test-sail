
## Dev Test Email App

### Local Install (Mac or Linux)

- Clone git repo from bitbucket `git clone ... ` 
- cd into the code dir```cd ./dev-test-sail```
- Create docker containers `./vendor/bin/sail up`
- In another terminal enter the container `docker exec -it dev-test-sail_laravel.test_1 bash`
- Create the env file `cp .env.example .env`
- run `composer update`
- Create the migration table  `php artisan migrate:install`
- Run migrations `php artisan migrate`
- Run the test app `php artisan email:process`

---

#### Running the above will:

- print out the results
- log the results to `storage/logs/laravel.log`
- save the results to the db (see below)

---

#### If you'd like to see the results in the db, run these commands: 

```
mysql -h mysql -u sail -ppassword
USE dev_test_sail
SELECT * FROM email_data\G
```


