<?php
session_start();

require_once 'header.php'; 
require_once 'db_connection.php';
require_once 'classes.php';

$user = new User($conn);

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if delete account button was clicked
    if (isset($_POST['delete_account'])) {
        $user->deleteUser($_SESSION['user_id']);
        // Destroy session and redirect to login page
        session_destroy();
        header('Location: login.php');
        exit();
    }

    // Get new name and email from form data
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];

    // Handle profile picture upload
    $profilePicturePath = null;
    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $name = $_FILES['profile_picture']['name'];
        move_uploaded_file($tmp_name, 'profile_pictures/' . $name);
        $profilePicturePath = 'profile_pictures/' . $name;
        $_SESSION['profile_picture'] = $profilePicturePath;
    }

    // Update user's name, email, and profile picture in the database
    $user->updateProfile($_SESSION['user_id'], $newName, $newEmail, $profilePicturePath);
    header('Location: profile.php');
}

// Get user data from database
$userData = $user->getUserById($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<h1>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <i class="fas fa-hammer"></i>
    <?php endif; ?>
    <i class="fas fa-user"></i>Profil
</h1>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="admin_panel.php" class="btn btn-light btn-lg">Administrátorský panel</a>
    <?php endif; ?><br>
    <label for="name"><i class="fas fa-user"></i> Meno:</label>
    <input type="text" name="name" value="<?php echo $userData['username']; ?>"><br>

    <label  for="email"><i class="fas fa-envelope"></i> E-mail:</label>
    <input type="email" name="email" value="<?php echo $userData['email']; ?>"><br>

    <label  for="profile_picture"><i class="fas fa-image"></i> Profilový obrázok:</label>
    <label for="profile_picture">
        <?php if (!empty($userData['profile_picture'])): ?>
            <img class="profile-picture" src="<?php echo $userData['profile_picture']; ?>" alt="Profilový obrázok">
        <?php else: ?>
            <img class="profile-picture" src="img/default.jpg" alt="Predvolený profilový obrázok">
        <?php endif; ?>
        <input type="file" id="profile_picture" name="profile_picture" style="display: none;">
    </label>
    <br>
    <input type="submit" class="btn btn-light btn-lg" value="Uložiť zmeny">
</form>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Ste si istý, že chcete vymazať svoj účet? Táto akcia je nevratná.');">
    <input type="submit" class="btn delete-button" name="delete_account" value="Vymazať účet">
</form>

</body>
</html>