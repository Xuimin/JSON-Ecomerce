<?php 
    $title = 'Transactions';
    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }

        $products_json_file = file_get_contents('../Data/products.json');
        $products = json_decode($products_json_file, true);

        $transactions_json_file = file_get_contents('../Data/transactions.json');
        $transaction;
    
        // If we are login AND we are an admin else in login and in a customer/ normal user
        if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin']) {
            $transactions = json_decode($transactions_json_file, true);
        } else {
            $transactions = json_decode($transactions_json_file, true);
            $transactions = array_filter($transactions, function($transaction) {
                return $transaction['username'] === $_SESSION['user_data']['username']; // show own transactions
            }); 
        }
?>

<div class="container py-5">
    <?php if(count($transactions) > 0 ): ?>
        
    <span class="badge bg-secondary">Pending</span>
    <span class="badge bg-success">Completed</span>
    <span class="badge bg-danger">Cancelled</span>
        
    <div class="accordion py-3">
        <?php foreach($transactions as $transaction): ?>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <?php
                        $status;
                        // if($transaction['status'] == 'pending') {
                        //     $status = 'bg-secondary';
                        // } else if($transaction['status'] == 'completed') {
                        //     $status = 'bg-success';
                        // } else {
                        //     $status = 'bg-danger';
                        // }
                        switch($transaction['status']) {
                            case 'pending':
                                $status = 'bg-secondary';
                                break;
                            case 'completed':
                                $status = 'bg-success';
                                break;
                            default:
                                $status = 'bg-danger';
                        }
                    ?>
                    <button class="accordion-button text-white <?php echo $status;?>"
                    data-bs-toggle="collapse"
                    data-bs-target="#tc-<?php echo $transaction['id']?>">
                    <span><?php echo $transaction['id']; ?></span>
                    <span><?php echo $transaction['datePurchased']; ?></span>
                    </button>
                </h2>

                <div id="tc-<?php echo $transaction['id']?>" 
                class="accordion-collapse collapse show">
                    <div class="accordion-body">
                        <h5>Total: RM<?php echo $transaction['total']; ?></h5>

                        <?php foreach($products as $product): ?>
                            <?php if(isset($transaction['items'][$product['id']])): ?>
                                <h6>
                                    <?php echo $product['name']; ?> x 
                                    <?php echo $transaction['items'][$product['id']]; ?> 
                                </h6>
                            <?php endif; ?>
                        <?php endforeach; ?>

                        <img src="<?php echo $transaction['payment']?>" 
                        alt=""
                        class="img-fluid mb-2">

                        <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin'] && $transaction['status'] == 'pending' && $transaction['payment'] != ""): ?>
                            <a href="/Controllers/Transactions/update_status.php?id=<?php echo $transaction['id']; ?>&s=completed" 
                            class="btn btn-primary">
                                Complete
                            </a>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin'] && $transaction['status'] == 'pending'): ?>
                            <form method="POST"
                            action="/Controllers/Transactions/add_payment.php"
                            enctype="multipart/form-data">
                                <div class="input-group w-75 mb-3">
                                    <input type="hidden"
                                    name="id"
                                    value="<?php echo $transaction['id']?>">
                                    <input type="file" 
                                    name="image" 
                                    class="form-control">
                                    <button class="btn btn-primary">Upload Payment</button>
                                </div>
                            </form>
                        <?php endif; ?>

                        <?php if(isset($_SESSION['user_data']) && $transaction['status'] == 'pending'): ?>
                            <a href="/Controllers/Transactions/update_status.php?id=<?php echo $transaction['id']; ?>&s=cancel" 
                            class="btn btn-warning">
                                Cancel
                            </a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
        <h2>No Transactions Found</h2>
        <a href="/" 
        class="btn btn-primary"> 
            << Go back to home page
        </a>
    <?php endif; ?>
</div>
  
<?php
    };
    require_once 'layout.php'
?>