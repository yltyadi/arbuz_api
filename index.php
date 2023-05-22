<?php

// Note: This project was ran and tested on APACHE SERVER using XAMPP on MacOS

require "controllerFunctions.php";

// header indicating that we are receiving response in JSON format
header('Content-type: json/application');

// connecting to MySQL database
$connect = mysqli_connect('localhost', 'root', '', 'arbuz_db');

$method = $_SERVER['REQUEST_METHOD'];
$fullpath = explode('/', $_GET['q']);
$path = $fullpath[0];
$id = $fullpath[1];

if ($path === "products") {
    switch ($method) {
        case "GET":
            if (isset($id)) {
                getProductById($connect, $id);
            } else {
                getProducts($connect);
            }
            break;
        case "POST": 
            addProduct($connect, $_POST);
            break;
        case "PATCH": // PATCH method only accepts data in raw json format when updating in postman
            if (isset($id)) {
                $data = json_decode(file_get_contents('php://input'), true);
                updateProduct($connect, $id, $data);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => false,
                    'message' => 'Missing id'
                ]);
            }
            break;
        case "DELETE":
            if (isset($id)) {
                deleteProduct($connect, $id);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => false,
                    'message' => 'Missing id'
                ]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode([
                'status' => false,
                'message' => 'Request method not found'
            ]);
    }
} elseif ($path === "orders") {
    $duration = $fullpath[2];
    switch ($method) {
        case "GET":
            if (isset($id)) {
                getOrderById($connect, $id);
            } else {
                getOrders($connect);
            }
            break;
        case "POST":
            if (isset($id) && isset($duration)) {
                addOrder($connect, $id, $duration);;
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => false,
                    'message' => 'Client id or Duration are missing'
                ]);
            }
            break;
        case "DELETE":
            if (isset($id)) {
                deleteOrder($connect, $id);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => false,
                    'message' => 'Missing id'
                ]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode([
                'status' => false,
                'message' => 'Request method not found'
            ]);
    }
} elseif ($path === "order_items") {
    $product_id = $fullpath[2];
    $quantity = $fullpath[3];
    switch ($method) {
        case "GET":
            if (isset($id)) {
                getItemById($connect, $id);
            } else {
                getItems($connect);
            }
            break;
        case "POST":
            if (isset($id) && isset($product_id) && isset($quantity)) {
                addItem($connect, $id, $product_id, $quantity);;
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => false,
                    'message' => 'Client id, Product id, or Quantity are missing'
                ]);
            }
            break;
        case "DELETE":
            if (isset($id)) {
                deleteItem($connect, $id);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => false,
                    'message' => 'Missing id'
                ]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode([
                'status' => false,
                'message' => 'Request method not found'
            ]);
    }
} elseif ($path === "clients") {
    switch ($method) {
        case "GET":
            if (isset($id)) {
                getClientById($connect, $id);
            } else {
                getClients($connect);
            }
            break;
        case "POST":
            addClient($connect, $_POST);
            break;
        case "DELETE":
            if (isset($id)) {
                deleteClient($connect, $id);
            } else {
                http_response_code(404);
                echo json_encode([
                    'status' => false,
                    'message' => 'Missing id'
                ]);
            }
            break;
        default:
            http_response_code(404);
            echo json_encode([
                'status' => false,
                'message' => 'Request method not found'
            ]);
    }
} else {
    $response = [
        'status' => false,
        'message' => 'Path not found'
    ];

    http_response_code(404);
    echo json_encode($response);
}