<?php
    $title = 'Cart';
    function get_content() {
        if(!isset($_SESSION['user_data'])) {
            header('Location: /');
        }

        $json_file = file_get_contents('../Data/products.json'); 
        $products = json_decode($json_file, true);
?>

<div class="container">
    <?php if(isset($_SESSION['message'])):?>
        <div class="alert alert-<?php echo $_SESSION['class']?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <?php if(isset($_SESSION['cart'])): ?>
        <h2 class="py-4">My Cart</h2>
        <table class="table table-responsive">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $total = 0;
                    foreach($products as $product): 
                        if(isset($_SESSION['cart'][$product['id']])):
                            $subtotal = $product['price'] * $_SESSION['cart'][$product['id']];
                            $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo 'RM ' . $product['price']; ?></td>

                    <td>
                        <form method="POST"
                        action="/Controllers/Cart/update.php">
                            <input type="hidden"
                            name="id"
                            value="<?php echo $product['id']?>">
                            <input type="number" 
                            min="1"
                            name="quantity"
                            class="form-control quantity-input"
                            value="<?php echo $_SESSION['cart'][$product['id']];?>">
                        </form>
                    </td>
                    
                    <td><?php echo 'RM ' . $subtotal; ?></td>
                    <td>
                        <a href="/Controllers/Cart/delete.php?id=<?php echo $product['id'] ?>"
                        class="btn btn-danger">
                            Delete
                        </a>
                    </td>   
                </tr>
                
                <?php 
                    endif;
                    endforeach;
                ?>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <button class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#checkoutModal">
                            Checkout
                        </button>
                        <div class="modal fade"
                        id="checkoutModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Checkout
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to checkout?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <form method="POST"
                                        action="/Controllers/Cart/checkout.php">
                                            <input type="hidden" 
                                            name="total" 
                                            value="<?php echo $total; ?>">
                                            <button class="btn btn-success">
                                                Confirm
                                            </button>
                                        </form>
                                        <button class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>Total: 
                        <strong>
                            <?php echo 'RM ' . $total; ?>
                        </strong>
                    </td>
                    <td>
                        <button class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEmpty">
                            Empty Cart
                        </button>
                        <div class="modal fade"
                        id="modalEmpty">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Empty Cart
                                        </h5>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you should you wanna to empty cart</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button 
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <a href="/Controllers/Cart/empty.php" 
                                        class="btn btn-danger">
                                            Empty Cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </td>
                </tr>
            </tbody>
        </table>

        <?php var_dump($_SESSION['cart']);?>
    <?php else: ?>
        <h2 class="py-4">Your cart is empty!</h2>
        <a href="/" 
        class="btn btn-primary mb-3"> 
            <i class="bi-arrow-bar-left"></i>
             Go Back Shopping 
            <i class="bi-bag"></i>
        </a>
    <?php endif; ?>
</div>

<?php
    };
    require_once 'layout.php';
?>

<script type="text/javascript">
     document.addEventListener('DOMContentLoaded', () => {
        let alert = document.querySelector('.alert');
        setTimeout(() => {
            <?php unset($_SESSION['class']); ?>
            <?php unset($_SESSION['message']); ?>
            alert.classList.toggle('d-none');
        }, 3000);
    })

//  this is to change each time without pressing enter
    let quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.onchange = () => {
            input.parentElement.submit();
        }
        // input.onkeyup = () => {
        //     input.parentElement.submit();
        // }
    })
</script>