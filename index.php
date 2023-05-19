<?php

function getProducts($connect) {
    $products = mysqli_query($connect, "SELECT * FROM `products`");
    $productsArr = [];

    if ($connect) {
        while ($product = mysqli_fetch_assoc($products)) {
            $productsArr[] = $product;
        }

        echo json_encode($productsArr);
    } else {
        echo "Error! Failed to connect to database!";
    }
}

function getProductById($connect, $id) {
    $product = mysqli_query($connect, "SELECT * FROM `products` WHERE `product_id`='$id'");
    
    if (mysqli_num_rows($product) !== 0) {
        $product = mysqli_fetch_assoc($product);
        echo json_encode($product);
    } else {
        $response = [
            'status' => false,
            'message' => 'Product not found'
        ];

        http_response_code(404);
        echo json_encode($response);
    }
}

function addProduct($connect, $data) {
    $product_name = $data['product_name'];
    $price = $data['price'];
    $is_available = $data['is_available'];

    mysqli_query($connect, "INSERT INTO `Products` (`product_id`, `product_name`, `price`, `is_available`) VALUES (NULL, '$product_name', '$price', '$is_available')");

    $response = [
        'status' => true,
        'message' => mysqli_insert_id($connect)
    ];

    http_response_code(201);
    echo json_encode($response);
}

function updateProduct($connect, $id, $data) {
    $product_name = $data['product_name'];
    $price = $data['price'];
    $is_available = $data['is_available'];

    mysqli_query($connect, "UPDATE `Products` SET `product_name`='$product_name', `price`='$price', `is_available`='$is_available' WHERE `Products`.`product_id`='$id'");

    $response = [
        'status' => true,
        'message' => 'Product was updated'
    ];

    http_response_code(200);
    echo json_encode($response);
}

function deleteProduct($connect, $id) {
    mysqli_query($connect, "DELETE FROM `Products` WHERE `Products`.`product_id` = '$id'");

    $response = [
        'status' => true,
        'message' => 'Product was deleted'
    ];

    http_response_code(200);
    echo json_encode($response);
}

header('Content-type: json/application');

// .htdocs RewriteRule ^(.+)$ index.php?q=$1 [L,QSA]
$connect = mysqli_connect('localhost', 'root', '', 'arbuz_db');

$method = $_SERVER['REQUEST_METHOD'];
$fullpath = explode('/', $_SERVER["REQUEST_URI"]); // $_GET['q']
$path = $fullpath[2];
$id = $fullpath[3];

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
                $data = file_get_contents('php://input');
                $data = json_decode($data, true);
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