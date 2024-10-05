<?php

$env = parse_ini_file('.env');
$priceListUrl= "https://www.alko.fi/INTERSHOP/static/WFS/Alko-OnlineShop-Site/-/Alko-OnlineShop/fi_FI/Alkon%20Hinnasto%20Tekstitiedostona/alkon-hinnasto-tekstitiedostona.xlsx";

$serverName = $env['SERVER_NAME'];
$userName = $env['USER_NAME'];
$password = $env['PASSWORD'];



$conn = new mysqli($serverName, $userName, $password);
if ($conn->connect_error) {
    die("can't connect to db" . $conn->connect_error);
}


// create db
$create_db = "CREATE DATABASE IF NOT EXISTS alkopricelist";

if ($conn->query($create_db) === true) {
    echo "DB created\n";
} else {
    echo "Error creating" . ' '. $conn->error;
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

if ($conn->query($table_query) === true){
    echo "table created";
} else {
    echo "Error creating table" . ' ' . $conn->error;
}


try {
    $excelData = readExcelFromUrl($priceListUrl);
    echo $excelData;

//    // Output the data
//    foreach ($excelData as $row) {
//        echo implode(", ", $row) . "\n"; // Print each row
//    }
} catch (Exception $e) {
    echo 'Error: ', $e->getMessage();
}
