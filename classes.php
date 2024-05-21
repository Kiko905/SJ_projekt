<?php
class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Prihlásenie používateľa
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username=:username";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['profile_picture'] = $result['profile_picture'];
                $_SESSION['role'] = $result['role'];
                $_SESSION['email'] = $result['email'];
                header('Location: index.php');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Zmazanie používateľského účtu
    public function deleteAccount() {
        // Skontrolujte, či bolo kliknuté na tlačidlo "zmazať účet"
        if (isset($_POST['delete_account'])) {
            // Zmažte používateľov účet z databázy
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $_SESSION['user_id']);
            $stmt->execute();

            // Odhláste používateľa a presmerujte na prihlasovaciu stránku
            session_destroy();
            header('Location: login.php');
            exit;
        }
    }

    // Aktualizácia profilového obrázka
    public function updateProfilePicture($user_id, $profile_picture) {
        $sql = "UPDATE users SET profile_picture = :profile_picture WHERE id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':profile_picture', $profile_picture);
        $stmt->execute();

        // Aktualizujte profilový obrázok v relácii
        $_SESSION['profile_picture'] = $profile_picture;
    }
}

class Register {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Registrácia nového používateľa
    public function register($username, $email, $password) {
        $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (count($result) > 0) {
            return 'Používateľské meno alebo email už existuje.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password]);

            if ($result) {
                header('Location: login.php');
            } else {
                return '<div class="error-message">Registrácia zlyhala</div>';
            }
        }
    }
}

class Post {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Získanie všetkých príspevkov
    public function getAll() {
        $query = 'SELECT * FROM posts ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Vytvorenie nového príspevku
    public function create($title, $content, $image_path, $author, $user_id) {
        $query = "INSERT INTO posts (title, content, image, author, user_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$title, $content, $image_path, $author, $user_id]);

        // Skontrolujte, či sa vložilo správne
        if ($stmt->rowCount() == 1) {
            return true;
        } else {
            return false;
        }
    }
    public function uploadImage($image) {
        $image_name = $image['name'];
        $tmp_name = $image['tmp_name'];
        $upload_dir = 'uploads/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (!is_writable($upload_dir)) {
            return 'Upload directory is not writable';
        }

        if (move_uploaded_file($tmp_name, $upload_dir . $image_name)) {
            $image_path = $upload_dir . $image_name;
            return $image_path;
        } else {
            return 'Failed to move uploaded file';
        }
    }

    public function deletePost($postId) {
        $stmt = $this->conn->prepare("DELETE FROM posts WHERE id = :id");
        $stmt->bindValue(':id', $postId);
        return $stmt->execute();
    }

    public function editPost($postId, $title, $content, $image) {
        $stmt = $this->conn->prepare("UPDATE posts SET title = :title, content = :content, image = :image WHERE id = :id");
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':content', $content);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':id', $postId);
        return $stmt->execute();
    }

    public function getPost($postId) {
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $postId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

}

class User {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Získanie všetkých používateľov
    public function getAll() {
        $query = 'SELECT * FROM users';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateProfile($userId, $newName, $newEmail, $profilePicturePath = null) {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        if ($profilePicturePath) {
            $sql = "UPDATE users SET username = :username, email = :email, profile_picture = :profile_picture WHERE id = :id";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $newName);
        $stmt->bindValue(':email', $newEmail);
        if ($profilePicturePath) {
            $stmt->bindValue(':profile_picture', $profilePicturePath);
        }
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
    }

    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteUser($userId) {
        $sql = "DELETE FROM messages WHERE user_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
    
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
    }

    
    public function saveMessage($subject, $message, $user_id) {
        $sql = "INSERT INTO messages (subject, message, user_id) VALUES (:subject, :message, :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':subject', $subject);
        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':user_id', $user_id);
        return $stmt->execute();
    }

    
    public function editUser($userId, $username, $email) {
        $stmt = $this->conn->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $userId);
        return $stmt->execute();
    }
    
    public function getUser($userId) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $userId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function grantAdmin($userId) {
        $stmt = $this->conn->prepare("UPDATE users SET role = 'admin' WHERE id = :id");
        $stmt->bindValue(':id', $userId);
        return $stmt->execute();
    }
}
?>