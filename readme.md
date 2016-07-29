STEPS:
## Composer :
1. Install composer

## configuration
1. 	create database in MySQL
2 	Rename .env.example to .env
3. 	Change database name, user name and password in .env file.
4. 	add folder => ./bootstrap/cache

## Open bas
1.	$ php artisan key:generate
2.	$ php artisan migrate:install
3.	$ php artisan migrate
4.	$ php artisan vendor:publish

## Install Dummy data
1.	$ php artisan db:seed --class=UserSeeder	//path of file jobs/database/seeds/
2.	$ php artisan db:seed --class=JobSeeder		//path of file jobs/database/seeds/
3.	$ php artisan db:seed --class=SkillsSeeder	//path of file jobs/database/seeds/

## To enable registered users
1. Go to jobs/storage/logs/laravel.log
2.	Copy last line and paste in browser to enable.