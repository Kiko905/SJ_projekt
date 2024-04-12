<?php
class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function login($pouzivatelskeMeno, $heslo) {
        $sql = "SELECT * FROM pouzivatelia WHERE pouzivatelske_meno=:pouzivatelskeMeno";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':pouzivatelskeMeno', $pouzivatelskeMeno, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            if (password_verify($heslo, $result['heslo'])) {
                $_SESSION['user_id'] = $result['id'];
                $_SESSION['pouzivatelske_meno'] = $result['pouzivatelske_meno'];
                header('Location: index.php');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>

<?php
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
                return '<div class="success-message">Registrácia úspešná</div>';
            } else {
                return '<div class="error-message">Registrácia zlyhala</div>';
            }
        }
    }
}
?>
