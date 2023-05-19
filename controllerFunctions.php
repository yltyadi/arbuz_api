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
