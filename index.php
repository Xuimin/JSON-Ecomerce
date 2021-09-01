<?php 
    $title = "Home";
    function get_content() {

    
?>

<div class="container my-3">
    <!-- ALERT MESSAGE -->
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['class']; ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>

    <!-- ADD PRODUCTS -->
    <?php if(isset($_SESSION['user_data']) && $_SESSION['user_data']['isAdmin'] == true): ?>
    <div class="row">
        <div class="col-md-8 mx-auto py-5">
            <form method="POST"
            action="/Controllers/Products/store.php"
            enctype="multipart/form-data">
            <!-- enctype is used in a form when you have an input type file -->
            <div class="form-group">
                <label for="">Product Name:</label>
                <input type="text" 
                name="product_name" 
                class="form-control">
            </div>

            <div class="form-group">
                <label for="">Price:</label>
                <input type="number" 
                name="price" 
                class="form-control">
            </div>

            <div class="form-group">
                <label for="">Description:</label>
                <input type="text" 
                name="description" 
                class="form-control">
            </div>

            <div class="form-group">
                <label for="">Image:</label>
                <input type="file" 
                name="image" 
                class="form-control">
            </div>

            <button class="btn btn-primary mt-3">
                Add Product
                <i class="bi-plus"></i>
            </button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- SHOW PRODUCTS -->
    <div class="row">
        <h2 class="text-center">Products</h2>
        <?php 
            $json_file_product = file_get_contents('./Data/products.json');
            $products = json_decode($json_file_product, true);
            foreach($products as $product):
        ?>
        <div class="col-md-4 col-sm-6 mt-5">
            <div class="card">
                <img src="<?php echo $product['image'];?>" 
                class="img-fluid" 
                style="height: 180px">

                <div class="card-body">
                    <h5 class="card-title">
                        <a href="../../Views/products_details.php?id=<?php echo $product['id']?>">
                            <?php echo $product['name'];?>
                        </a>
                    </h5>

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
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">
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
        <?php endforeach; ?>
    </div>
</div>


<?php 
    };
    require './Views/layout.php'; 
?>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        let alert = document.querySelector('.alert');
        setTimeout(() => {
            <?php unset($_SESSION['message']); ?> 
            <?php unset($_SESSION['class']); ?> 
            alert.classList.toggle('d-none');
        }, 3000)
    })
</script>