<?php
    session_start();

    $json_file = file_get_contents('../../Data/products.json');
    $products = json_decode($json_file, true);

    $products = array_filter($products, function($product) {
        return $product['id'] != $_GET['id'];
    });
    
    $_SESSION['class'] = 'success';
    $_SESSION['message'] = 'Product was successfully deleted';
    
    file_put_contents('../../Data/products.json', json_encode($products, JSON_PRETTY_PRINT));
    header('Location: /');

?>