<?php

    session_start();
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $admin = $_POST['admin'];
    // var_dump($admin);

    $errors = 0;
    $existing = false;
    
    $json_file = file_get_contents('../../Data/users.json');
    $users = json_decode($json_file, true);

    $user = [
        'id' => uniqid(),
        'fullname' => $fullname,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    // conditions
    if(strlen($username) < 8){
        $errors++;
        echo '<h4>Username should be at least 8 characters</h4>';
    }

    if($password != $password2) {
        $errors++;
        echo '<h4>Password do not match</h4>';
    }

    if(strlen($password) < 8 || strlen($password2) < 8){
        $errors++;
        echo '<h4>Password should be at least 8 characters</h4>';
    }

    foreach($users as $indiv_user) {
        if($indiv_user['username'] == $username) {
            $existing = true;
            break;
        }
    }

    if($existing) {
        $errors++;
        echo 'Username already exists';
    }

    else if($errors === 0 && !$existing && $admin) {
        $user['isAdmin'] = true;
        $users[] = $user;
        // array_push($users, $user);
        file_put_contents('../../Data/users.json', json_encode($users, JSON_PRETTY_PRINT));

        $_SESSION['message'] = 'Registered succesfully';
        $_SESSION['class'] = 'success';

        header('Location: ../../Views/login.php');
        // header('Location: /');
    }

    else if($errors === 0 && !$existing && !$admin) {
        $user['isAdmin'] = false;
        $users[] = $user;
        // array_push($users, $user);
        file_put_contents('../../Data/users.json', json_encode($users, JSON_PRETTY_PRINT));

        $_SESSION['message'] = 'Registered succesfully';
        $_SESSION['class'] = 'success';

        header('Location: ../../Views/login.php');
        // header('Location: /');
    }  
?>