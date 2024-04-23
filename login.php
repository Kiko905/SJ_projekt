<?php 
// Zapnúť všetky hlásenia o chybách
error_reporting(E_ALL);

// Zobraziť chyby výstupu
ini_set('display_errors', 1);
require_once 'header.php'; 
require_once 'db_connection.php';
require_once 'classes.php';
session_start();

$user = new Login($conn);


if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo '<p>Prosím, zadajte používateľské meno a heslo.</p>';
    } else {
        if ($user->login($username, $password)) {
            echo '<p>Boli ste úspešne prihlásený.</p>';
            echo '<a href="logout.php">Odhlásiť sa</a>';

        } else {
            echo '<p>Nesprávne používateľské meno alebo heslo.</p>';
        }
    }
}
?>

<main class="main">
    <div class="container">
    <h1>Prihlásenie</h1>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <label for="username">Používateľské meno:</label>
        <input type="text" name="username" id="username">
        <br>
        <label for="password">Heslo:</label>
        <input type="password" name="password" id="password">
        <br>
        <input type="submit" name="submit" value="Prihlásiť sa" class="btn button-farba">
    </form>
    </div>
</main>

<?php require_once 'footer.php'; ?>