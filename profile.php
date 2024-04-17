<?php
session_start();

require_once 'header.php'; 
require_once 'db_connection.php';
require_once 'functions.php';

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
    }

    // Redirect to the profile page after updating the data
    header('Location: profile.php');
    exit;
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
    <h1><i class="fas fa-user"></i> Profile</h1>
    <div class="form-container">
        <?php 
        var_dump($user['profile_picture']);
        if (!empty($user['profile_picture'])): ?>
            <img class="profile-picture" src="<?php echo $user['profile_picture']; ?>" alt="Profile Picture">
        <?php endif; ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
            <!-- Display the user's data in input fields -->
            <label class="zmena" for="name"><i class="fas fa-user"></i> Name:</label>
            <input type="text" name="name" value="<?php echo $user['username']; ?>"><br>

            <label class="zmena" for="email"><i class="fas fa-envelope"></i> Email:</label>
            <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>

            <!-- Add file input field for profile picture -->
            <label class="zmena" for="profile_picture"><i class="fas fa-image"></i> Profile Picture:</label>
            <input type="file" name="profile_picture"><br>

            <!-- Add more input fields for other user data -->

            <input type="submit" value="Save">
        </form>
    </div>
</body>
</html>

<?php require_once 'footer.php'; ?>