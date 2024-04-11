<?php 
require_once 'header.php'; 
require_once 'db_connection.php';
session_start();
?>

<main class="main">
    <div class="container">
        <?php
        // Check if user is logged in
        if (isset($_SESSION['user_id'])) {
            echo '<p>You are already logged in.</p>';
            echo '<a href="logout.php">Logout</a>';
        } else {
            // Check if form was submitted
            if (isset($_POST['submit'])) {
                // Get form data
                $username = $_POST['username'];
                $password = $_POST['password'];

                // Validate form data
                if (empty($username) || empty($password)) {
                    echo '<p>Please enter both username and password.</p>';
                } else {
                    // Query the database
                    $sql = "SELECT * FROM users WHERE username=:username";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch();

                    // Check if user exists and if password is correct
                    if ($result) {
                        if (password_verify($password, $result['password'])) {
                            // Login successful
                            $_SESSION['user_id'] = $result['id'];
                            $_SESSION['username'] = $result['username'];
                            echo '<p>You have successfully logged in.</p>';
                            echo '<a href="logout.php">Logout</a>';
                        } else {
                            // Incorrect password
                            echo '<p>Incorrect password.</p>';
                        }
                    } else {
                        // User not found
                        echo '<p>User not found.</p>';
                    }
                }
            } else {
                // Display login form
                echo '<h1>Login</h1>';
                echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">';
                echo '<label for="username">Username:</label>';
                echo '<input type="text" name="username" id="username">';
                echo '<br>';
                echo '<label for="password">Password:</label>';
                echo '<input type="password" name="password" id="password">';
                echo '<br>';
                echo '<input type="submit" name="submit" value="Login" class="btn button-farba">';
                echo '</form>';
            }
        }
        ?>
    </div>
</main>

<?php require_once 'footer.php'; ?>