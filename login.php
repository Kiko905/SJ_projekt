<?php 
// Turn on all error reporting
error_reporting(E_ALL);

// Display errors in the output
ini_set('display_errors', 1);
require_once 'header.php'; 
require_once 'db_connection.php';
require_once 'functions.php';
session_start();
$user = new Login($conn);


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo '<p>Please enter both username and password.</p>';
    } else {
        if ($user->login($username, $password)) {
            echo '<p>You have successfully logged in.</p>';
            echo '<a href="logout.php">Logout</a>';

        } else {
            echo '<p>Incorrect username or password.</p>';
        }
    }
}
?>

<main class="main">
    <div class="container">
    <h1>Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" name="submit" value="Login" class="btn button-farba">
    </form>
    </div>
</main>

<?php require_once 'footer.php'; ?>