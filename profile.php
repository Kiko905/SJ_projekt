<?php
session_start();

require_once 'header.php'; 
require_once 'db_connection.php';
require_once 'classes.php';


$login = new Login($conn);
$login->deleteAccount();
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the new name and email from the form data
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];

    // Update the user's name and email in the database
    $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':username', $newName);
    $stmt->bindValue(':email', $newEmail);
    $stmt->bindValue(':id', $_SESSION['user_id']);
    $stmt->execute();

    // Handle profile picture upload
    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $name = $_FILES['profile_picture']['name'];
        move_uploaded_file($tmp_name, 'profile_pictures/' . $name);

        // Update the user's profile picture in the database
        $sql = "UPDATE users SET profile_picture = :profile_picture WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':profile_picture', 'profile_pictures/' . $name);
        $stmt->bindValue(':id', $_SESSION['user_id']);
        $stmt->execute();

        // Update the profile picture in the session
        $_SESSION['profile_picture'] = 'profile_pictures/' . $name;
        header('Location: profile.php'); // Add a semicolon at the end of this line
    }
}

// Fetch the user's data from the database
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<h1>
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <i class="fas fa-hammer"></i>
    <?php endif; ?>
    <i class="fas fa-user"></i>Profile
</h1>


        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <!-- Add button for admin panel -->
<?php if ($_SESSION['role'] === 'admin'): ?>
    <a href="admin_panel.php" class="btn btn-light btn-lg">Admin Panel</a>
<?php endif; ?><br>
            <!-- Display the user's data in input fields -->
            <label for="name"><i class="fas fa-user"></i> Name:</label>
            <input type="text" name="name" value="<?php echo $user['username']; ?>"><br>

            <label  for="email"><i class="fas fa-envelope"></i> Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>

            <!-- Add file input field for profile picture -->
            <label  for="profile_picture"><i class="fas fa-image"></i> Profile Picture:</label>
            <label for="profile_picture">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img class="profile-picture" src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
                <?php else: ?>
                    <img class="profile-picture" src="default.jpg" alt="Default Profile Picture">
                <?php endif; ?>
                <input type="file" id="profile_picture" name="profile_picture" style="display: none;">
            </label>
            <br>
            <input type="submit" class="btn"value="Save">
        </form>

        <!-- Add a delete account button -->
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
            <input type="submit" class="delete-button" name="delete_account" value="Delete Account">
        </form>
</form>
</body>
</html>
<?php require_once 'footer.php'; ?>