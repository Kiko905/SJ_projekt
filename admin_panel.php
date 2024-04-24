<?php
session_start();
require_once 'db_connection.php';
require_once 'classes.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$user = new User($conn);

if (isset($_GET['delete_id'])) {
    $user->deleteUserAdmin($_GET['delete_id']);
} elseif (isset($_GET['grant_admin_id'])) {
    $user->grantAdmin($_GET['grant_admin_id']);
} elseif (isset($_POST['edit'])) {
    $user->editUser($_POST['edit_id'], $_POST['username'], $_POST['email']);
}

$result = $user->getAll();
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
                        <a href="#editUserModal-<?php echo $row['id']; ?>" class="btn button-farba" data-toggle="modal">Upraviť</a>
                        <a href="admin_panel.php?delete_id=<?php echo $row['id'];?>" class="btn delete-button" onclick="return confirm('Ste si istý, že chcete vymazať tohto používateľa?')">Vymazať</a>
                        <?php if ($row['role'] !== 'admin') : ?>
                            <a href="admin_panel.php?grant_admin_id=<?php echo $row['id'];?>" class="btn admin-button" onclick="return confirm('Ste si istý, že chcete urobiť tohto používateľa administrátorom?')">Urobiť administrátorom</a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel-<?php echo $row['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel-<?php echo $row['id']; ?>">Edit User</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="admin_panel.php">
                                <div class="modal-body">
                                    <input type="hidden" id="edit-id" name="edit_id" value="<?php echo $row['id']; ?>">
                                    <div class="form-group">
                                        <label for="edit-username">Username</label>
                                        <input type="text" class="form-control" id="edit-username" name="username" value="<?php echo $row['username']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="edit-email">Email</label>
                                        <input type="email" class="form-control" id="edit-email" name="email" value="<?php echo $row['email']; ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Nenašli sa žiadni používateľia.</p>
        <?php endif; ?>
    </div>
</main>

<?php
require_once 'footer.php';
?>