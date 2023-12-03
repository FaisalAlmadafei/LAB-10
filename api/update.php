<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // No Content
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
    header('Allow: PUT');
    http_response_code(405); // Method Not Allowed
    echo json_encode('Method Not Allowed');
    exit;
}

include_once '../db/Database.php';
include_once '../models/Todo.php';

$database = new Database();
$dbConnection = $database->connect();

$todo = new Todo($dbConnection);

$data = json_decode(file_get_contents("php://input"));

if (!$data || !isset($data->id) || !isset($data->done)) {
    http_response_code(422); // Unprocessable Entity
    echo json_encode(array('message' => 'Error: Missing required parameters id and done in the JSON body.'));
    exit;
}

$todo->setId($data->id);
$todo->setDone($data->done);

if ($todo->update()) {
    echo json_encode(array('message' => 'A todo item was updated.'));
} else {
    echo json_encode(array('message' => 'Error: A todo item was not updated.'));
}
?>
