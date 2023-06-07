# php-api
Search events using a term or date or both. Demonstrating php api, documentation with swagger and unit testing with phpunit

## Table of contents
* [General info](#general-info)
* [Setup](#setup)

## General info 
PHP Restful Api implementaion to search events using a term or date or both. Demonstrating php api, documentation with swagger and unit testing with phpunit

### Features
<li>Search events base on a term, date or both </li>

## Setup
```
Git clone the repo
cd to your project root from the console
```
### Setup database 
```
Create your local database (There is a testdb sql file under tests)
Enter your default database information in the Database.php file 
or 
Send DB properties as arguments when creating an instance of the Database from index.php.
```
Install phpunit (composer require --dev phpunit/phpunit) <br>
Setup Swagger <a href='https://github.com/zircote/swagger-php' target='_blank'>Zircote/swagger-php</a>

```
You can access the app via localhost/{your root folder}/v1
Access Swagger documentation via localhost/{your root folder}/v1/documentation
```
### Testing
```
run ./vendor/bin/phpunit tests
```
