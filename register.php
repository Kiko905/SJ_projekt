<?php 
require_once 'header.php'; 
require_once 'db_connection.php'; 
require_once 'classes.php';


        $user = new Register($conn);

        if (isset($_POST['submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (empty($username) || empty($email) || empty($password)) {
                echo '<p>Please fill in all fields.</p>';
            } else {
                $result = $user->register($username, $email, $password);
                echo "<p>$result</p>";
            }
        }
?>

<main class="main">
    <div class="container">
        <h1>Registrácia</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="username">Používateľské meno:</label>
            <input type="text" name="username" id="username">
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
            <br>
            <label for="password">Heslo:</label>
            <input type="password" name="password" id="password">
            <br>
            <input type="submit" name="submit" value="Registrovať sa" class="btn button-farba">
        </form>
    </div>
</main>

<?php require_once 'footer.php'; ?>