<?php 
require_once 'header.php'; 
require_once 'db_connection.php'; // Include db_connection.php here
?>

<main class="main">
    <div class="container">
        <?php
        // Check if form was submitted
        if (isset($_POST['submit'])) {
            // Get data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate form data
            if (empty($username) || empty($email) || empty($password)) {
                echo '<p>Please fill in all fields.</p>';
            } else {

                $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll();
                
                if (count($result) > 0) {
                    echo '<p>Username or email already exists.</p>';
                } else {
                    // Hash password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert user into db
                    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                    $stmt = $conn->prepare($sql);
                    $result = $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

                    if ($result) {
                        echo '<p>You have successfully registered.</p>';
                        echo '<a href="login.php" class="btn">Login</a>';
                    } else {
                        echo '<p>Failed to register.</p>';
                    }
                }
            }
        } else {
            // Display registration form
            echo '<h1>Register</h1>';
            echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">';
            echo '<label for="username">Username:</label>';
            echo '<input type="text" name="username" id="username">';
            echo '<br>';
            echo '<label for="email">Email:</label>';
            echo '<input type="email" name="email" id="email">';
            echo '<br>';
            echo '<label for="password">Password:</label>';
            echo '<input type="password" name="password" id="password">';
            echo '<br>';
            echo '<input type="submit" name="submit" value="Register" class="btn button-farba">';
            echo '</form>';
        }
        ?>
    </div>
</main>

<?php require_once 'footer.php'; ?>