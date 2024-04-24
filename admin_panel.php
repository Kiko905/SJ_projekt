<link rel="stylesheet" href="css/style.css">
<?php
// Začni session
session_start();

// Zahrň db_connection.php a classes.php
require_once 'db_connection.php';
require_once 'classes.php';

// Skontroluj, či je používateľ prihlásený a je administrátor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Vytvor nový objekt User
$user = new User($conn);

// Získaj všetkých používateľov z db
$result = $user->getAll();

// Zahrň header
require_once 'header.php';
?>

<main>
    <div class="container mt-4">
        <h1 class="text-center mb-4" style="color: white;">Spravovať používateľov</h1>

        <?php if (count($result) > 0) : ?>
            <?php foreach ($result as $row) : ?>
                <div id="user-<?php echo $row['id']; ?>" class="card mb-4">
                    <div class="card-body">
                        <?php if (!empty($row['profile_picture'])): ?>
                            <img class="profile-picture" src="<?php echo $row['profile_picture']; ?>" alt="Profile Picture">
                        <?php else: ?>
                            <img class="profile-picture" src="img/default.jpg" alt="Default Profile Picture">
                        <?php endif; ?>
                        <h2 class="card-title"><?php echo $row['username']; ?></h2>
                        <p class="card-text"><?php echo $row['email']; ?></p>
                        <p class="card-text"><?php echo $row['role']; ?></p>
                            <a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn button-farba">Upraviť</a>
                            <a href="delete_user.php?id=<?php echo $row['id'];?>" class="btn delete-button" onclick="return confirm('Ste si istý, že chcete vymazať tohto používateľa?')">Vymazať</a>
                            <?php if ($row['role'] !== 'admin') : ?>
                                <a href="make_admin.php?id=<?php echo $row['id'];?>" class="btn admin-button" onclick="return confirm('Ste si istý, že chcete urobiť tohto používateľa administrátorom?')">Urobiť administrátorom</a>
                            <?php endif; ?>   
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Nenašli sa žiadni používateľia.</p>
        <?php endif; ?>
    </div>
</main>

<?php
// Zahrň footer
require_once 'footer.php';
?>