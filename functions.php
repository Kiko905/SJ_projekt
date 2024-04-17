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
                header('Location: login.php');
            } else {
                return '<div class="error-message">Registrácia zlyhala</div>';
            }
        }
    }
}
?>
<?php
class Order {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getOrders() {
        $sql = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrder($user_id) {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createOrUpdateOrder($user_id, $product_id, $quantity) {
        $sql = "SELECT * FROM orders WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
        $order = $stmt->fetch();
    
        if ($order) {
            $sql = "UPDATE orders SET product_id = :product_id, quantity = :quantity WHERE user_id = :user_id";
        } else {
            $sql = "INSERT INTO orders (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        }
    
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':product_id', $product_id);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->execute();
    }

    public function deleteOrder($user_id) {
        $sql = "DELETE FROM orders WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->execute();
    }
    public function handleDeleteRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
            $this->order->deleteOrder($_POST['user_id']);
            header('Location: orders.php');
            exit;
        }
    }
}