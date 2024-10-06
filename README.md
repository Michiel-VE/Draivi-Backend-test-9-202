# Draivi-Backend-test-9-202

## Technologies Used

- PHP 8.2
- MySQL
- JavaScript
- HTMLS
- [PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/) for reading Excel files
- cURL for making API requests
- XAMPP

## Environment
### XAMPP
1. Download XAMPP & install
2. Double check php.ini and verify following extensions are enabled
```
extension=mysqli
extension=gd
extension=zip
```


### PhpStorm
1. In project settings navigate to PHP and look for CLI interpreter
2. Use XAMPP php interpreter


### Composer
1. Download composer
2. verify installation with these commands
```
composer --version
```
3. Install phpoffice/phpspreadsheet Note php version need to be above 8.1
```
composer require phpoffice/phpspreadsheet
```
OR run
```
composer install
```

### env
Make sure to add your own .env file so the database credentials can be stored

## Running the code
1. Make sure XAMPP MySQL module is running
2. In editor run the script as normal
3. To see FE, open the browser through the editor, and it functions as a normal website 
