## Installation

### Clone the repository
    git clone https://github.com/SmartWebSource/procurex.git

## Install docker in user machine (ubuntu)

    https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-20-04

### Switch to the repo folder
    procurex
##  Edit host file

    sudo nano /etc/hosts
    add this in host file : 127.0.0.1  www.procurex-dev.com
    and save it. 

## Here we go for run project

open terminal from project folder
and type './start'


## Run seeder 
    php artisan db:seed

## Run Permission 
    php artisan generate:permissions

## npm install
    npm install
    npm run wtach

## Go to www.procurex-dev.com.  

## Setup without docker 
 

### Clone the repository

    git clone https://github.com/SmartWebSource/procurex.git
### Composer install 
    composer install

## Setup env
    config your env with database username and password 

### Migrate database  
    php artisan migrate
    php artisan db:seed

## Run Permission
    php artisan generate:permission

## Npm install 
    npm install
    npm run watch
## Run server 
    php artisan serve 

## User Credential 
    Email: admin@demo.com 
    password: password 


    

   
