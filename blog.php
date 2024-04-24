<?php
session_start();
require_once 'db_connection.php';
require_once 'classes.php';
require_once 'delete_post.php';
require_once 'edit_post.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$post = new Post($conn);
$result = $post->getAll();

require_once 'header.php';
?>

<main>
    <div class="container mt-4">
        <h1 class="text-center mb-4" style="color: white;">Blog</h1>

        <?php if (count($result) > 0) : ?>
            <?php foreach ($result as $row) : ?>
                <div id="post-<?php echo $row['id']; ?>" class="card mb-4">
                    <?php if (!empty($row['image'])) : ?>
                        <div class="card-image">
                        <img src="<?php echo $row['image']; ?>" class="card-img-top blog-image" alt="...">
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h2 class="card-title"><a href="#post-<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
                        <p class="card-text"><?php echo $row['content']; ?></p>
                        <p class="card-text"><small class="text-muted">Od <?php echo $row['author']; ?> dňa <?php echo date('j. F Y', strtotime($row['created_at'])); ?></small></p>
                    <?php if ($_SESSION['user_id'] == $row['user_id'] || $_SESSION['role'] === 'admin') : ?>
                        <a href="#deleteModal-<?php echo $row['id']; ?>" class="btn button-farba" data-toggle="modal">Delete</a>
                        <a href="#editModal-<?php echo $row['id']; ?>" class="btn button-farba" data-toggle="modal">Edit</a>
                    <?php endif; ?>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="blog.php">
                                <div class="modal-body">
                                    Are you sure you want to delete this post?
                                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal-<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" action="blog.php" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" value="<?php echo $row['title']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content</label>
                                        <textarea class="form-control" id="content" name="content"><?php echo $row['content']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Neboli nájdené žiadne blogové príspevky.</p>
        <?php endif; ?>
    </div>
</main>

<?php
require_once 'footer.php';
?>