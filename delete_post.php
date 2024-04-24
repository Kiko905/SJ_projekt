<?php
require_once 'db_connection.php';
require_once 'classes.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $postId = $_POST['post_id'];

        $post = new Post($conn);
        $post->deletePost($postId);
    }
}
?>