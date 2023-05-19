<?php

// Note: This project was ran and tested on APACHE SERVER

require "controllerFunctions.php";

// header indicating that we are receiving response in JSON format
header('Content-type: json/application');

// connecting to MySQL database
$connect = mysqli_connect('localhost', 'root', '', 'arbuz_db');

$method = $_SERVER['REQUEST_METHOD'];
$fullpath = explode('/', $_GET['q']);
$path = $fullpath[0];
$id = $fullpath[1];

switch ($method) {
    case "GET":
        if ($path === 'products') {
            if (isset($id)) {
                getProductById($connect, $id);
            } else {
                getProducts($connect);
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Path not found'
            ];
        
            http_response_code(404);
            echo json_encode($response);
        }
        break;
    case "POST":
        if ($path === 'products') {
            addProduct($connect, $_POST);
        }
        break;
    case "PATCH":
        if ($path === 'products') {
            if (isset($id)) {
                $data = json_decode(file_get_contents('php://input'), true);
                updateProduct($connect, $id, $data);
            }
        }
        break;
    case "DELETE":
        if ($path === 'products') {
            if (isset($id)) {
                deleteProduct($connect, $id);
            }
        }
        break;
    default:
        http_response_code(404);
        echo json_encode([
            'status' => false,
            'message' => 'Request method not found'
        ]);
}