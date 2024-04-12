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
          <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item <?php if ($currentPage === 'index.php') echo 'active'; ?>">
         <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="blog.php">Blog</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="create_post.php">Vytvoriť príspevok</a>
      </li>
    </ul>
    <ul class="navbar-nav">
      <?php if (isset($_SESSION['username'])) { ?>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a href="profile.php" class="nav-link">Logged in as: <?php echo $_SESSION['username']; ?></a>
        </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>
      <?php } ?>
          </div>
      </div>
  </nav>
</header> 