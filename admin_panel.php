<link rel="stylesheet" href="css/style.css">
<?php
// Start session
session_start();

// Include db_connection.php and functions.php
require_once 'db_connection.php';
require_once 'functions.php';

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Create a new User object
$user = new User($conn);

// Get all users from db
$result = $user->getAll();

// Include header
require_once 'header.php';
?>

<main>
    <div class="container mt-4">
        <h1 class="text-center mb-4" style="color: white;">Manage Users</h1>

        <?php if (count($result) > 0) : ?>
            <?php foreach ($result as $row) : ?>
                <div id="user-<?php echo $row['id']; ?>" class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title"><?php echo $row['username']; ?></h2>
                        <p class="card-text"><?php echo $row['email']; ?></p>
                        <p class="card-text"><?php echo $row['role']; ?></p>
                        <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn button-farba">Edit</a>
                        <a href="delete_user.php?id=<?php echo $row['id'];?>" class="btn button-farba" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        <?php if ($row['role'] !== 'admin') : ?>
                            <a href="make_admin.php?id=<?php echo $row['id'];?>" class="btn button-farba" onclick="return confirm('Are you sure you want to make this user an admin?')">Make Admin</a>
                        <?php endif; ?>   
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No users found.</p>
        <?php endif; ?>
    </div>
</main>

<?php
// Include footer
require_once 'footer.php';
?>