<?php
class User {
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