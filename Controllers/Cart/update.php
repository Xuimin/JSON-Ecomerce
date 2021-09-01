<?php
    session_start();

    $id = $_POST['id'];
    $quantity = intval($_POST['quantity']);

    if($quantity < 1) {
        $_SESSION['class'] = 'warning';
        $_SESSION['message'] = 'Please input at least 1';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['cart'][$id] = $quantity;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>