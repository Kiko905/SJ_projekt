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

// Get all blog posts from db
$result = $post->getAll();

// Include header
require_once 'header.php';
?>

<main>
    <div class="container mt-4">
        <h1 class="text-center mb-4" style="color: white;">Blog</h1>

        <?php if (count($result) > 0) : ?>
            <?php foreach ($result as $row) : ?>
                <div id="post-<?php echo $row['id']; ?>" class="card mb-4">
                    <?php if (!empty($row['image'])) : ?>
                        <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="...">
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-title"><a href="#post-<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
                        <p class="card-text"><?php echo $row['content']; ?></p>
                        <p class="card-text"><small class="text-muted">By <?php echo $row['author']; ?> on <?php echo date('F j, Y', strtotime($row['created_at'])); ?></small></p>
                    <?php if ($_SESSION['user_id'] == $row['user_id'] || $_SESSION['role'] === 'admin') : ?>
                        <a href="edit_post.php?id=<?php echo $row['id']; ?>" class="btn button-farba">Edit</a>
                        <a href="delete_post.php?id=<?php echo $row['id'];?>" class="btn button-farba" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                    <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No blog posts found.</p>
        <?php endif; ?>
    </div>
</main>

<?php
// Include footer
require_once 'footer.php';
?>