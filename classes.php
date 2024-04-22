<?php
class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    
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
    public function deleteAccount() {
        // Check if the delete button was clicked
        if (isset($_POST['delete_account'])) {
            // Delete the user's account from the database
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $_SESSION['user_id']);
            $stmt->execute();
    
            // Log out the user and redirect to the login page
            session_destroy();
            header('Location: login.php');
            exit;
        }
    }
    
    public function updateProfilePicture($user_id, $profile_picture) {
        $sql = "UPDATE users SET profile_picture = :profile_picture WHERE id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':profile_picture', $profile_picture);
        $stmt->execute();
    
        // Update the profile picture in the session
        $_SESSION['profile_picture'] = $profile_picture;
    }
}
class Register {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($username, $email, $password) {
        $sql = "SELECT * FROM users WHERE username=:username OR email=:email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if (count($result) > 0) {
            return 'Username or email already exists.';
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

    public function getAll() {
        $query = 'SELECT * FROM posts ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function create($title, $content, $image_path, $author, $user_id) {
        $query = "INSERT INTO posts (title, content, image, author, user_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$title, $content, $image_path, $author, $user_id]);

        // Check if it inserted correctly
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

    public function getAll() {
        $query = 'SELECT * FROM users';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>