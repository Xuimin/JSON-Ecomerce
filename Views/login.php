<?php 
    $title = "Login";
    function get_content() {
        if(isset($_SESSION['user_data'])) {
            header('Location: /');
        } 
?>
<div class="container my-3">
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['class']; ?>">
            <?php echo $_SESSION['message']; ?>
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto py-5">
            <form method="POST"
            action="/Controllers/Users/process_login.php">
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
                <button class="btn btn-primary mt-2">Login</button>
            </form>
        </div>
    </div>
</div>

<?php
    };
    require_once 'layout.php';
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