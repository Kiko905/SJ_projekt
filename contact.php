    <?php
    session_start();
    require_once 'header.php';
    require_once 'db_connection.php';
    require_once 'classes.php';

    $user = new User($conn);

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $user_id = $_SESSION['user_id'];

        $messageStatus = $user->saveMessage($subject, $message, $user_id) ? 'Správa úspešne odoslaná.' : 'Správu sa nepodarilo odoslať.';
        echo "<script>$(function() {
            $('#messageModalBody').text('$messageStatus');
            $('#messageModal').modal('show');
        });</script>";
    }
    ?>

    <h2>Kontaktný formulár</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="subject">Predmet:</label>
        <input type="text" name="subject" id="subject" required><br><br>

        <label for="message">Správa:</label>
        <textarea name="message" id="message" rows="5" required></textarea><br><br>

        <input type="submit" value="Odoslať">
    </form>

    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Stav správy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="messageModalBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavrieť</button>
                </div>
            </div>
        </div>
    </div>

    </body>

    <?php
    require_once 'footer.php';
    ?>