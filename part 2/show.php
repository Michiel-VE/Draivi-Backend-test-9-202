<?php
require_once '../connection.php';

header('Content-Type: application/json; charset=UTF-8');

$conn->select_db('alkopricelist');

$query = $conn->query("SELECT number, name, price, bottleSize, orderAmount FROM product LIMIT 500"); // hard limit on 500 cause encoding is messed up


while ($row = $query->fetch_assoc()) {
    foreach ($row as $key => $value) {
        $row[$key] = htmlspecialchars($value);
    }

    $data[] = $row;
}

$conn->close();


echo json_encode($data);
