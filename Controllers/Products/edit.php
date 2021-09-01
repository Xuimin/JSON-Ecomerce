<?php
    session_start();

    $json_file = file_get_contents('../../Data/products.json');
    $products = json_decode($json_file, true);

    // echo'<pre>';
    // var_dump($products);
    // echo '</pre>';

    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    $img_name = $_FILES['image']['name'];
    $img_temp = $_FILES['image']['tmp_name'];
    $img_size = $_FILES['image']['size'];

    $img_type = pathinfo($img_name, PATHINFO_EXTENSION);
    $is_img = false;

    $extensions = ['jpg', 'svg', 'png', 'gif', 'jpeg'];

    if(strlen($product_name) < 1) {
        $_SESSION['class'] = 'warning';
        $_SESSION['message'] = 'Please check product name and price';
        header('Location:' . $_SERVER['HTTP_REFERER']);
    } else if($price < 1) {
        $_SESSION['class'] = 'warning';
        $_SESSION['message'] = 'Please check product name and price';
        header('Location:' . $_SERVER['HTTP_REFERER']);
    } else {
        foreach($products as $i => $product) {
            if($product['id'] == $_GET['id']) {
                $products[$i]['name'] = $product_name;
                $products[$i]['description'] = $description;
                $products[$i]['price'] = $price;
                
                // If admin adds a new image else remains the original image
                if($_FILES && $img_size && in_array($img_type, $extensions)) {
                    $products[$i]['image'] = '/Public/' . time() . '-' . $img_name;
    
                    move_uploaded_file($img_temp, '../../Public/' . time() . '-' . $img_name);
                }
            }
        }
        file_put_contents('../../Data/products.json', json_encode($products, JSON_PRETTY_PRINT));
        $_SESSION['class'] = 'info';
        $_SESSION['message'] = 'Product was successfully edited';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
?>