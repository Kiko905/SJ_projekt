<?php
require_once 'db_connection.php';
require_once 'classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit'])) {
        $postId = $_POST['post_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];

        // Get the current image URL
        $post = new Post($conn);
        $currentPost = $post->getPost($postId);
        $imageURL = $currentPost['image'];

        // Handle the uploaded file
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $image = $_FILES['image'];
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($image["name"]);
            move_uploaded_file($image["tmp_name"], $targetFile);
            $imageURL = $targetFile;
        }

        $post->editPost($postId, $title, $content, $imageURL);
    }
}