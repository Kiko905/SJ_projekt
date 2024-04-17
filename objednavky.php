<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<?php
session_start();

require_once 'header.php'; 
require_once 'db_connection.php';
require_once 'functions.php';

$order = new Order($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $order->deleteOrder($_POST['user_id']);
    header('Location: objednavky.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $order->createOrUpdateOrder($_POST['user_id'], $_POST['product_id'], $_POST['quantity']);
    header('Location: objednavky.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $order->createOrUpdateOrder($_POST['user_id'], $_POST['product_id'], $_POST['quantity']);
    header('Location: objednavky.php');
    exit;
}

$orders = $order->getOrders();
$order_data = $order->getOrder($_SESSION['user_id']);
?>

<h1>Orders</h1>

<table class="orders-table">
    <tr>
        <th>User ID</th>
        <th>Product ID</th>
        <th>Quantity</th>
    </tr>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $order['user_id']; ?></td>
            <td><?php echo $order['product_id']; ?></td>
            <td><?php echo $order['quantity']; ?></td>
            <td>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="edit-form">
                    <input type="hidden" name="user_id" value="<?php echo $order['user_id']; ?>">
                    <label>
                        Product ID:
                        <input type="text" name="product_id" value="<?php echo $order['product_id']; ?>">
                    </label>
                    <label>
                        Quantity:
                        <input type="number" name="quantity" value="<?php echo $order['quantity']; ?>">
                    </label>
                    <input type="submit" name="update" value="Update">
                </form>
                <form    method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $order['user_id']; ?>">
                    <input type="submit" name="delete" value="Delete">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Create new order</h2>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="create-form">
    <label>
        User ID:
        <input type="text" name="user_id">
    </label>
    <label>
        Product ID:
        <input type="text" name="product_id">
    </label>
    <label>
        Quantity:
        <input type="number" name="quantity">
    </label>
    <input type="submit" name="create" value="Create">
</form>
