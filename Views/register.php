<?php 
    $title = "Register";
    function get_content() {
        if(isset($_SESSION['user_data'])) {
            header('Location: /');
        } 
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto py-5">
            <form method="POST"
            action="/Controllers/Users/process_register.php">
                <div class="form-group">
                    <label for="">Fullname:</label>
                    <input type="text" 
                    name="fullname"
                    class="form-control"
                    required>
                </div>

                <div class="form-group">
                    <label for="">Username:</label>
                    <input type="text" 
                    name="username"
                    class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Password:</label>
                    <input type="password"
                    name="password"
                    class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Confirm password:</label>
                    <input type="password"
                    name="password2"
                    class="form-control">
                </div>

                <div class="form-group">
                    <input type="checkbox" 
                    name="admin">
                    <label for="">
                        Admin 
                    </label>
                    <small>(If you want to be an admin)</small>
                </div>

                <button class="btn btn-primary mt-2">
                    Register
                </button>
            </form>
        </div>
    </div>
</div>

<?php
    };
    require_once 'layout.php';
?>