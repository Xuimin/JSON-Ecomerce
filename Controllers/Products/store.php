<?php
    session_start();
    // var_dump($_FILES);
    
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = intval($_POST['price']);

    // get all image properties and store it as variables.
    $img_name = $_FILES['image']['name'];
    $img_size = $_FILES['image']['size'];
    $img_tmpname = $_FILES['image']['tmp_name'];

    $img_type = pathinfo($img_name, PATHINFO_EXTENSION); // jpg, svg, png, gif, jpeg
    $is_img = false;
    $has_details = false;

    $extensions = ['jpg', 'svg', 'png', 'gif', 'jpeg'];
    if(in_array($img_type, $extensions)) {
        $is_img = true;
    } else {
        echo 'Please upload an image file';
    }

    // intval == parseInt
    if(strlen($product_name) > 0 && intval($price) > 0 && strlen($description) > 0) {
        $has_details = true;
    }

    if($has_details && $is_img && $img_size > 0) {
        $product['id'] = uniqid();
        $product['name'] = $product_name;
        $product['price'] = $price;
        $product['description'] = $description;
        $product['image'] = '/Public/' . time() . '-' . $img_name ;
        $product['isActive'] = true;

        // 123456789324-filename.jpg
        move_uploaded_file($img_tmpname, '../../Public/' . time() . '-' . $img_name);

        $json_file = file_get_contents('../../Data/products.json');
        $products = json_decode($json_file, true);
        $products[] = $product;
        file_put_contents('../../Data/products.json', json_encode($products, JSON_PRETTY_PRINT));

        $_SESSION['class'] = 'success';
        $_SESSION['message'] = 'Product was successfully added';

        header('Location: /');
    }
?>

