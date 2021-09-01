<?php

    $username = $_POST['username'];
    $password = $_POST['password'];

    $json_file = file_get_contents('../../Data/users.json');
    $users = json_decode($json_file, true);

    session_start();

    foreach($users as $user) {
        if($user['username'] == $username && password_verify($password, $user['password'])) {
            $_SESSION['user_data'] = $user; // for future used

            $_SESSION['message'] = 'Login succesfully';
            $_SESSION['class'] = 'success';

            header('Location: /');
            break;
        } else {
            $_SESSION['message'] = 'Wrong Credentials';
            $_SESSION['class'] = 'warning';

            header('Location: /');
        }
    }
    // echo '<h4>Wrong Credentials</h4>';
    // echo "<a href = '../../Views/login.php'>Go back to login</a>";
?>