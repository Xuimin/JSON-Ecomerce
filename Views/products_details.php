<?php
    $title = 'Product Details';
    function get_content() {
        $id = $_GET['id'];

        $json_file = file_get_contents('../Data/products.json');
        $products = json_decode($json_file, true);
        foreach($products as $product):
            if($product['id'] == $id):
?>

<div class="container">
    <div class="col-md-8 mx-auto py-5">
        <div class="card">
            <img src="<?php echo $product['image'];?>" 
            class="img-fluid" 
            style="height: 400px">

            <div class="card-body">
                <h4 class="card-title">                        
                        <?php echo $product['name'];?>
                </h4>

                <p class="card-text">
                    <?php echo $product['description'];?>
                </p>

                <strong>
                    RM <?php echo $product['price'];?>
                </strong>
            </div>
            <!-- FOR ADMINS -->
            <div class="card-footer">
                <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin']) : ?>
                <div class="d-flex justify-content-between">
                    <!-- EDIT -->
                    <button class="btn btn-info"
                    data-bs-toggle="modal"
                    data-bs-target="#editModal-<?php echo $product['id']?>">
                        Edit
                    </button>

                    <!-- EDIT ALERT -->
                    <div class="modal fade" 
                    id="editModal-<?php echo $product['id']?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Edit Product
                                    </h5>
                                </div>

                                <div class="modal-body">
                                    <form method="POST"
                                    action="/Controllers/Products/edit.php?id=<?php echo $product['id']?>"
                                    enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text"
                                            name="product_name"
                                            class="form-control"
                                            value="<?php echo $product['name']?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <input type="text"
                                            name="description"
                                            class="form-control"
                                            value="<?php echo $product['description']?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Price</label>
                                            <input type="number"
                                            name="price"
                                            class="form-control"
                                            value="<?php echo $product['price']?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Image</label>
                                            <input type="file"
                                            name="image"
                                            class="form-control"
                                            value="<?php echo $product['image']?>">
                                        </div>

                                        <button class="btn btn-success mt-3">
                                            Confirm
                                        </button>
                                    </form>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" 
                                    data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DELETE -->
                    <button data-bs-toggle="modal"
                        data-bs-target="#deleteProduct-<?php echo $product['id']?>"
                        class="btn btn-danger">
                            Delete
                        </button>

                    <!-- DELETE ALERT -->
                    <div class="modal fade" id="deleteProduct-<?php echo $product['id']?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Delete Product
                                    </h5>
                                </div>

                                <div class="modal-body">
                                    <p>
                                        Are you sure you want to delete this product?
                                    </p>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary"data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <a href="/Controllers/Products/delete.php?id=<?php echo $product['id']?>"
                                    class="btn btn-danger">
                                        Confirm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DEACTIVATE -->
                    <a href="/Controllers/Products/activate_toggle.php?id=<?php echo $product['id']?>"
                    class="btn btn-<?php $product['isActive'] ? print('secondary'): print('success')?>">
                        <?php $product['isActive'] ? print('Deactivate'): print('Activate')?>
                    </a>
                </div>

                <!-- FOR USER -->
                <?php elseif(isset($_SESSION['user_data']) && !$_SESSION['user_data']['isAdmin'] && $product['isActive']): ?>
                <form method="POST"
                action="/Controllers/Cart/add.php">
                    <input type="hidden" 
                    name="id" 
                    value="<?php echo $product['id'];?>">

                    <div class="input-group">
                        <input type="number"
                        name="quantity"
                        class="form-control">
                        <button class="btn btn-success">
                            <i class="bi-cart"></i>
                                Add to Cart
                        </button>
                    </div>
                </form>

                <?php elseif($product['isActive'] && !isset($_SESSION['user_data'])): ?>
                    <p class="text-center fw-bold">In stock</p>

                <?php elseif(!$product['isActive']): ?>
                    <p class="text-center fw-bold">Out of stock</p>
                    
                <?php endif; ?>
            </div>
        </div>
    </div>
    <a href="/"
    class="btn btn-primary my-3">
        <<< Back to Homepage
    </a>
</div>


<?php
    endif;
    endforeach;
    };
    require_once 'layout.php'
?>