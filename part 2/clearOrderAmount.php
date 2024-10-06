<?php
require_once '../connection.php';

header('Content-Type: application/json');

$conn->select_db('alkopricelist');

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['number'])) {
    $number = (int)$data['number'];

    $query = $conn->prepare("UPDATE product
                             SET orderAmount = 0 
                             WHERE number = ? ");


    $query->bind_param('i', $number);

    $query->execute();

    $query->close();

    echo json_encode(['success' => true, 'message' => 'Order amount updated successfully.']);
}else{
    echo json_encode(['success' => false, 'message' => 'No body given']);
}

