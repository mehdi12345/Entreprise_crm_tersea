<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Build Setup for Back-end

```bash
# 1- Clone this project to the folder you want, by running the command below : 
$ git clone https://github.com/mehdi12345/Entreprise_crm_tersea.git

# 2- Access the folder cloned, and open it in a editor code, run the two commands below : 
$ cd entreprise_crm_tersea
$ code .

# 3- Install libraries, by running the command below : 
$ composer install

# 4- Copy .env.example to .env file, by running the command :
$ cp .env.example .env

# 5- Start your apache/laragon :
open the database manager (phpadmin for example) and create a new database.

# 6- In .env file :
Change the database name created (DB_DATABASE), same for DB_USERNAME and DB_PASSWORD

# 7- For sending Emails, please set the follow variables in the .env file : 
MAIL_MAILER, MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION, MAIL_FROM_ADDRESS

# 8- Generate the key for your laravel application, run :
$ php artisan key:generate

# 9- create the tables and initial data, by running the command : 
$ php artisan migrate --seed

# 10- run the server, runthe commmand : 
$ php artisan serve
```


## Build Setup for Front-end

```bash
# 1- Clone this project to the folder you want, by running the command below : 
$ git clone https://github.com/mehdi12345/Entreprise_crm_tersea_ui.git

# 2- Access the folder cloned, and open it in a editor code, run the two commands below : 
$ cd entreprise_crm_tersea_ui
$ code .

# 3- install dependencies
$ npm install

# 4- serve with hot reload at localhost:3000
$ npm run dev
```
