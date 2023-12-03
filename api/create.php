<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode('Method Not Allowed');
    return;
}

include_once '../db/Database.php';
include_once '../models/Todo.php';

$database = new Database();
$dbConnection = $database->connect();

$todo = new Todo($dbConnection);

$data = json_decode(file_get_contents("php://input"), true);
if(!$data || !isset($data['task'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameter task in the JSON body.')
    );
    return;
}

$todo->setTask($data['task']);

if ($todo->create()) {
    echo json_encode(
        array('message' => 'A todo item was created')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a todo item was not created')
    );
}
?>
