<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
      <link rel="stylesheet" 
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

      <title>Ecommerce | <?php echo $title; ?></title>
  </head>
  <body>
      <?php session_start(); ?>
      <?php require_once 'Template/nav.php'; ?>

      <h3 class="mx-3">
        <i class="bi-person"></i>
        <?php 
          if(isset($_SESSION['user_data'])) {
            echo $_SESSION['user_data']['username'] . "'s"; 
          } else echo 'Please login/create an account' 
        ?>
      </h3>

      <h1 class="text-center mt-4">
        <?php echo $title; ?>
      </h1>

      <main>
        <?php get_content(); ?>
      </main>

      <?php require_once 'Template/footer.php'; ?>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" 
      crossorigin="anonymous"></script>
  </body>
</html>