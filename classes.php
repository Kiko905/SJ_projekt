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

}
?>