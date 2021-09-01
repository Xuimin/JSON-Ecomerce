<?php
    session_start();

    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    if($quantity < 1) {
        $_SESSION['class'] = 'warning';
        $_SESSION['message'] = 'Please input at least 1';
        header('Location: /');
    } else {
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'][$id] = $quantity;
        } else {
            $_SESSION['cart'][$id] += $quantity;
        }
        // $_SESSION['cart] = [
        // product_id => quantity;
        // ]
    
        $_SESSION['class'] = 'primary';
        $_SESSION['message'] = "$quantity was successfully added to cart";
        header('Location: /');
    }
?>

