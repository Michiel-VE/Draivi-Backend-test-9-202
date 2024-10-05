<?php

require_once 'readFile.php';
require_once 'getCurrencyValue.php';

$env = parse_ini_file('.env');
$priceListUrl = "https://www.alko.fi/INTERSHOP/static/WFS/Alko-OnlineShop-Site/-/Alko-OnlineShop/fi_FI/Alkon%20Hinnasto%20Tekstitiedostona/alkon-hinnasto-tekstitiedostona.xlsx";

$serverName = $env['SERVER_NAME'];
$userName = $env['USER_NAME'];
$password = $env['PASSWORD'];
$api = $env['API'];

$currencyUrl = "http://apilayer.net/api/live?access_key=$api&currencies=GBP&source=EUR&format=1";

$gbpvalue = getGBPValue($currencyUrl);

$conn = new mysqli($serverName, $userName, $password);
if ($conn->connect_error) {
    die("can't connect to db" . $conn->connect_error);
}


// create db
$create_db = "CREATE DATABASE IF NOT EXISTS alkopricelist";

if ($conn->query($create_db) === true) {
    echo "DB created\n";
} else {
    echo "Error creating" . ' ' . $conn->error . '\n';
}


// create table
$conn->select_db('alkopricelist');

$table_query = "CREATE TABLE IF NOT EXISTS product(
                number int(10) PRIMARY KEY,
                name varchar(255) not null,
                bottleSize varchar(20) not null,
                price decimal(6,2) not null,
                priceGBP decimal(6,2) not null,
                lastRetreived timestamp DEFAULT now() ON UPDATE now(),
                orderAmount int DEFAULT 0 
                )";

if ($conn->query($table_query) === true) {
    echo "table created\n";
} else {
    echo "Error creating table" . ' ' . $conn->error . '\n';
}


try {
    $excelData = readExcelFromUrl($priceListUrl);

    $insertquery = $conn->prepare("INSERT INTO product (number, name, bottleSize, price, priceGBP) VALUES (?,?,?,?,?)
                                         ON DUPLICATE KEY UPDATE 
                                             name = VALUES(name), 
                                             bottleSize = VALUES(bottleSize), 
                                             price = VALUES(price), 
                                             priceGBP = VALUES(priceGBP) ");


    for ($i = 4; $i < count($excelData); $i++) {
        $row = $excelData[$i];

        $number = $row[0];
        $name = $row[1];
        $bottleSize = $row[3];
        $price = $row[4];
        $priceGBP = (float)$price * (float)$gbpvalue;

        $insertquery->bind_param('issdd', $number, $name, $bottleSize, $price, $priceGBP);

        $insertquery->execute();
    }

    $insertquery->close();
} catch (Exception $e) {
    echo 'Error: ', $e->getMessage();
}
