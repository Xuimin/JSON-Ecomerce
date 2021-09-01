<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a href="/" 
        class="navbar-brand">ECommerce</a>
        <button 
        class="navbar-toggler" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" 
        id="menu">
            <div class="navbar-nav">
                <a class="nav-link" 
                href="/">
                    <i class="bi-house"></i>
                    Home
                </a>

                <?php if(!isset($_SESSION['user_data'])): ?>
                <a class="nav-link" 
                href="/Views/register.php">Register</a>
                <a class="nav-link" 
                href="/Views/login.php">Login</a>
                <?php endif ?>

                <!-- If you are login and you are a consumer -->
                <?php if(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin']): ?>
                    <a class="nav-link" 
                    href="/Views/cart.php">
                        Cart
                        <span class="badge bg-primary">
                            <i class="bi-cart4"></i>
                            <?php if(!isset($_SESSION['cart'])): ?>
                                <?php echo 0; ?>
                            <?php else: ?>
                                <?php echo array_sum($_SESSION['cart']); ?>
                            <?php endif; ?>
                        </span>
                    </a>
                    <a class="nav-link" 
                    href="../Views/transactions.php">My Transactions</a>
                <?php endif; ?>

                <!-- If you are login and you are an admin -->
                <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin']): ?>
                    <a class="nav-link" 
                    href="../Views/transactions.php">All Transactions</a>
                <?php endif; ?>
                
                <?php if(isset($_SESSION['user_data'])): ?>
                <a class="nav-link"
                 href="/Controllers/Users/process_logout.php">Logout</a>
                 <?php endif; ?>

            </div>
        </div>
    </div>
</nav>

