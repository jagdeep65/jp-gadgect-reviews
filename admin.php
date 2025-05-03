<?php
session_start();
if ($_POST['password'] == 'jagdeep@2009') {
    $_SESSION['admin'] = true;
    header("Location: admin-dashboard.php"); // Redirect to your admin dashboard
    exit();
} else {
    echo "<p style='color:red;'>Incorrect password!</p>";
}
?>
