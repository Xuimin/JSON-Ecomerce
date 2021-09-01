<?php
    session_start();

    $id = $_POST['id'];

    // var_dump($_FILES['image']);
    $img_name = $_FILES['image']['name'];
    $img_tmpname = $_FILES['image']['tmp_name'];
    $img_size = $_FILES['image']['size'];

    $img_type = pathinfo($img_name, PATHINFO_EXTENSION);
    $extensions = ['jpeg', 'png', 'jpg'];

    $is_img = false;

    $json_file = file_get_contents('../../Data/transactions.json');
    $transactions = json_decode($json_file, true);

    if(in_array($img_type, $extensions) && $img_size > 0) {
        $is_img = true;
    } else {
        $_SESSION['message'] = 'Please upload an image';
        $_SESSION['class'] = 'warning';
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }

    if($is_img && $img_size > 0) {
        foreach($transactions as $i => $transaction) {
            if($transactions[$i]['id'] == $id) {
                $transactions[$i]['payment'] = '/Private/' . time() . '-' . $img_name;

                move_uploaded_file($img_tmpname, '../../Private/' . time() . '-' . $img_name);

                file_put_contents('../../Data/transactions.json', json_encode($transactions, JSON_PRETTY_PRINT));

                $_SESSION['class'] = 'success';
                $_SESSION['message'] = 'Payment attached successfully';

                header('Location:' . $_SERVER['HTTP_REFERER']);
            }
        }
    }

?>