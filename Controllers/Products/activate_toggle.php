<?php
    session_start();

    $id = $_GET['id'];

    $json_file = file_get_contents('../../Data/products.json');
    $products = json_decode($json_file, true);

    foreach($products as $i => $product) {
        if($product['id'] == $id) {
            if($products[$i]['isActive']) {
                $products[$i]['isActive'] = false;
                $_SESSION['class'] = 'warning';
                $_SESSION['message'] = 'Product out of stock';
            } else {
                $products[$i]['isActive'] = true;
                $_SESSION['class'] = 'info';
                $_SESSION['message'] = 'Product is in stock';
            }
        }
    }
    file_put_contents('../../Data/products.json', json_encode($products, JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER']);
?>