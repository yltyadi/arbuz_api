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

function getOrders($connect) {
    $orders = mysqli_query($connect, "SELECT * FROM `orders`");
    $ordersArr = [];

    if ($connect) {
        while ($order = mysqli_fetch_assoc($orders)) {
            $ordersArr[] = $order;
        }

        echo json_encode($ordersArr);
    } else {
        echo "Error! Failed to connect to database!";
    }
}

function getOrderById($connect, $id) {
    $order = mysqli_query($connect, "SELECT * FROM `orders` WHERE `order_id`='$id'");
    
    if (mysqli_num_rows($order) !== 0) {
        $order = mysqli_fetch_assoc($order);
        echo json_encode($order);
    } else {
        $response = [
            'status' => false,
            'message' => 'Order not found'
        ];

        http_response_code(404);
        echo json_encode($response);
    }
}

function addOrder($connect, $id, $duration) {
    mysqli_query($connect, "INSERT INTO `Orders` (`order_id`, `client_id`, `duration_weeks`) VALUES (NULL, '$id', '$duration')");

    $response = [
        'status' => true,
        'message' => mysqli_insert_id($connect)
    ];

    http_response_code(201);
    echo json_encode($response);
}

function deleteOrder($connect, $id) {
    mysqli_query($connect, "DELETE FROM `Orders` WHERE `Orders`.`order_id` = '$id'");

    $response = [
        'status' => true,
        'message' => 'Order was deleted'
    ];

    http_response_code(200);
    echo json_encode($response);
}

function getItems($connect) {
    $items = mysqli_query($connect, "SELECT * FROM `order_items`");
    $itemsArr = [];

    if ($connect) {
        while ($item = mysqli_fetch_assoc($items)) {
            $itemsArr[] = $item;
        }

        echo json_encode($itemsArr);
    } else {
        echo "Error! Failed to connect to database!";
    }
}

function getItemById($connect, $id) {
    $item = mysqli_query($connect, "SELECT * FROM `order_items` WHERE `order_id`='$id'");
    
    if (mysqli_num_rows($item) !== 0) {
        $item = mysqli_fetch_assoc($item);
        echo json_encode($item);
    } else {
        $response = [
            'status' => false,
            'message' => 'Item not found'
        ];

        http_response_code(404);
        echo json_encode($response);
    }
}

function addItem($connect, $client_id, $product_id, $quantity) {
    mysqli_query($connect, "INSERT INTO `Order_Items` (`item_id`, `order_id`, `product_id`, `quantity`) VALUES (NULL, '$client_id', '$product_id', '$quantity')");

    $response = [
        'status' => true,
        'message' => mysqli_insert_id($connect)
    ];

    http_response_code(201);
    echo json_encode($response);
}

function deleteItem($connect, $id) {
    mysqli_query($connect, "DELETE FROM `Order_Items` WHERE `Order_Items`.`item_id` = '$id'");

    $response = [
        'status' => true,
        'message' => 'Order Item was deleted'
    ];

    http_response_code(200);
    echo json_encode($response);
}

function getClients($connect) {
    $clients = mysqli_query($connect, "SELECT * FROM `clients`");
    $clientsArr = [];

    if ($connect) {
        while ($client = mysqli_fetch_assoc($clients)) {
            $clientsArr[] = $client;
        }

        echo json_encode($clientsArr);
    } else {
        echo "Error! Failed to connect to database!";
    }
}

function getClientById($connect, $id) {
    $client = mysqli_query($connect, "SELECT * FROM `clients` WHERE `client_id`='$id'");
    
    if (mysqli_num_rows($client) !== 0) {
        $client = mysqli_fetch_assoc($client);
        echo json_encode($client);
    } else {
        $response = [
            'status' => false,
            'message' => 'Client not found'
        ];

        http_response_code(404);
        echo json_encode($response);
    }
}

function addClient($connect, $data) {
    $client_name = $data['client_name'];
    $phone_number = $data['phone_number'];
    $address = $data['address'];

    mysqli_query($connect, "INSERT INTO `Clients` (`client_id`, `client_name`, `phone_number`, `address`) VALUES (NULL, '$client_name', '$phone_number', '$address')");

    $response = [
        'status' => true,
        'message' => mysqli_insert_id($connect)
    ];

    http_response_code(201);
    echo json_encode($response);
}

function deleteClient($connect, $id) {
    mysqli_query($connect, "DELETE FROM `Clients` WHERE `Clients`.`client_id` = '$id'");

    $response = [
        'status' => true,
        'message' => 'Client was deleted'
    ];

    http_response_code(200);
    echo json_encode($response);
}