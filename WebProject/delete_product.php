<?php
include 'connect.php';
session_start();


if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "Access denied. Admins only.";
    exit();
}


if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $sql = "DELETE FROM product WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Product deleted successfully!";
        header('Location: admin.php');
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
}
?>
