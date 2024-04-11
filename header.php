<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Môj blog</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <header>
  <nav class="navbar navbar-expand-lg m-3 fixed-top" id="main-navbar">
      <div class="container-fluid py-3">
          <a class="navbar-brand text-dark font-italic fw-bold fs-3 mx-3 mx-lg-5" href="index.php">
              <img src="img/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
              <span class="d-none d-lg-inline">GymCold</span>
              <span class="d-inline d-lg-none logo-small">GymCold</span>
          </a>
          <button class="navbar-toggler mx-3 mx-lg-5 border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
              <div class="navbar-nav mr-auto">
                  <a class="nav-link fs-5 mx-2" href="index.php ">Domov</a>
                  <a class="nav-link fs-5 mx-2" href="blog.php">Blog</a>
                  <a class="nav-link fs-5 mx-2" href="create_post.php">Vytvoriť príspevok</a>
                  <a class="nav-link fs-5 mx-2" href="contact.php">Contact</a>
              </div>
              <div class="navbar-nav ml-auto">
                  <a class="nav-link fs-5 mx-2" href="login.php">Login</a>
                  <a class="nav-link fs-5 mx-2" href="profile.php">Signed in as: <span id="username">Username</span></a>
              </div>
          </div>
      </div>
  </nav>
</header> 