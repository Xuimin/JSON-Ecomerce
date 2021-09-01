<?php
    session_start();

    $total = $_POST['total'];
    $json_file = file_get_contents('../../Data/transactions.json');
    $transactions = json_decode($json_file, true);

    date_default_timezone_set('Asia/Kuala_Lumpur');

    /* Characters that commonly used for dates
        d - represents the day of the month (01 to 31)
        D - represents the day of the month in words (mon-sun)
        m - represents a month (01 to 12)
        M - represents the month in words (Jan - Dec)
        Y - represents a year in for digits 2021
        y - lowercase (Y) represents a year in 2 digits 21
        l - lowercase (L) represents the day of the week

        Characters commonly used for time
        H - 24 hour format of an hour (00 to 23)
        h - 12 hour format of an hour with the lending zeros (01 to 12)
        i - minutes with leading zeroes (00 to 59)
        s - seconds with leading zeroes (00 to 59)
        a - lowercase ante meridiem or post meridiem (am or pm)
    */

    $transaction = [
        'id' => uniqid(),
        'username' => $_SESSION['user_data']['username'],
        'items' => $_SESSION['cart'],
        'total' => $total,
        'datePurchased' => date('Y/m/d h:i:sa'), // 2021/08/30 11:43:35am a represent am/pm
        'status' => 'pending',
        'payment' => ''
    ];

    // array_push($transactions, $transaction)
    $transactions[] = $transaction;
    file_put_contents('../../Data/transactions.json', json_encode($transactions, JSON_PRETTY_PRINT));
    unset($_SESSION['cart']);
    
    $_SESSION['class'] = 'success';
    $_SESSION['message'] = 'Checkout successfully';

    header('Location: /');
?>
