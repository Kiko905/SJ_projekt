<?php 
require_once 'header.php'; 
require_once 'db_connection.php'; // Zahrňte db_connection.php sem
?>

<main class="main">
    <div class="container">
        <?php
        // Skontrolujte, či bola odoslaná formulár
        if (isset($_POST['submit'])) {
            // Získajte údaje
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Overte údaje z formulára
            if (empty($username) || empty($email) || empty($password)) {
                echo '<p>Prosím vyplňte všetky polia.</p>';
            } else {

                $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(':username', $username, PDO::PARAM_STR);
                $stmt->bindValue(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll();
                
                if (count($result) > 0) {
                    echo '<p>Používateľské meno alebo email už existuje.</p>';
                } else {
                    // Hash heslo
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Vložte používateľa do db
                    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                    $stmt = $conn->prepare($sql);
                    $result = $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

                    if ($result) {
                        echo '<p>Boli ste úspešne zaregistrovaný.</p>';
                        echo '<a href="login.php" class="btn">Prihlásiť sa</a>';
                    } else {
                        echo '<p>Registrácia zlyhala.</p>';
                    }
                }
            }
        } else {
            // Zobrazenie registračného formulára
            echo '<h1>Registrácia</h1>';
            echo '<form action="' . htmlspecialchars($_SERVER['PHP_SELF']) . '" method="post">';
            echo '<label for="username">Používateľské meno:</label>';
            echo '<input type="text" name="username" id="username">';
            echo '<br>';
            echo '<label for="email">Email:</label>';
            echo '<input type="email" name="email" id="email">';
            echo '<br>';
            echo '<label for="password">Heslo:</label>';
            echo '<input type="password" name="password" id="password">';
            echo '<br>';
            echo '<input type="submit" name="submit" value="Registrovať sa" class="btn button-farba">';
            echo '</form>';
        }
        ?>
    </div>
</main>

<?php require_once 'footer.php'; ?>