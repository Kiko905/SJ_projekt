<?php
// Začni session
session_start();

// Zahrň db_connection.php a classes.php
require_once 'header.php';
require_once 'db_connection.php';
require_once 'classes.php';

// Skontroluj, či je používateľ prihlásený
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Vytvor nový objekt Post
$post = new Post($conn);

// Odoslať
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Získaj dáta
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $author = $_SESSION['username'];

    // Nahraj obrázok
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_path = $post->uploadImage($_FILES['image']);

        if ($image_path === 'Upload directory is not writable' || $image_path === 'Failed to move uploaded file') {
            // Chyba pri nahrávaní
            echo "Chyba pri nahrávaní obrázka: " . $image_path;
            exit();
        }
    }

    // Vlož príspevok do db
    if ($post->create($title, $content, $image_path, $author, $user_id)) {
        // Presmeruj na blog
        header('Location: blog.php'); 
        exit();
    } else {
        // Chyba pri vytváraní príspevku
        echo "Chyba pri vytváraní príspevku.";
    }
}
?>

<main>
    <div class="container mt-4">
        <h1 style="color: white;">Vytvoriť príspevok</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title" style="color: white;">Názov</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content" style="color: white;">Obsah</label>
                <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="image" style="color: white;">Obrázok</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn button-farba">Vytvoriť príspevok</button>
        </form>
    </div>

<?php
// Zahrň pätičku
require_once 'footer.php';
?>