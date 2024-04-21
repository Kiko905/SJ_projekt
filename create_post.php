<?php
// Start session
session_start();

// Include db_connection.php and functions.php
require_once 'db_connection.php';
require_once 'functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Create a new Post object
$post = new Post($conn);

// Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $author = $_SESSION['username'];

    // Upload image
    $image_path = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $upload_dir = 'uploads/';

        // Move image
        if (move_uploaded_file($tmp_name, $upload_dir . $image_name)) {
            $image_path = $upload_dir . $image_name;
        } else {
            // Error uploading
            echo "Error uploading image.";
        }
    }

    // Insert post into db
    if ($post->create($title, $content, $image_path, $author, $user_id)) {
        // Redirect to blog
        header('Location: blog.php'); 
        exit();
    } else {
        // Error inserting post
        echo "Error creating post.";
    }
}

// Include header
require_once 'header.php';
?>

<main>
    <div class="container mt-4">
        <h1 style="color: white;">Create Post</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title" style="color: white;">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="content" style="color: white;">Content</label>
                <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="image" style="color: white;">Image</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <button type="submit" class="btn button-farba">Create Post</button>
        </form>
    </div>

<?php
// Include footer
require_once 'footer.php';
?>