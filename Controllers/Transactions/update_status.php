<?php
    $id = $_GET['id']; // transaction id
    $status = $_GET['s']; // new status

    $json_file = file_get_contents('../../Data/transactions.json');
    $transactions = json_decode($json_file, true);

    foreach($transactions as $i => $transaction) {
        if($transactions[$i]['id'] == $id) {
            $transactions[$i]['status'] = $status;
        }
    }

    file_put_contents('../../Data/transactions.json', json_encode($transactions, JSON_PRETTY_PRINT));
    header('Location:' . $_SERVER['HTTP_REFERER'])

?>