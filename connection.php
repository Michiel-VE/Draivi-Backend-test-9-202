<?php
$env = parse_ini_file('.env');
$serverName = $env['SERVER_NAME'];
$userName = $env['USER_NAME'];
$password = $env['PASSWORD'];


$conn = new mysqli($serverName, $userName, $password);
if ($conn->connect_error) {
    die("can't connect to db" . $conn->connect_error);
}

mysqli_set_charset($conn, 'utf8');

