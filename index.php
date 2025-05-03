<?php
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['role'])) {
        $_SESSION['role'] = $_POST['role'];

        if ($_POST['role'] === 'admin') {
            if (isset($_POST['password']) && $_POST['password'] === 'jagdeep@2009') {
                $_SESSION['admin_logged_in'] = true;
                header("Location: index.php");
                exit();
            } else {
                $error = "Incorrect admin password.";
            }
        } else {
            header("Location: index.php");
            exit();
        }
    }
}

// Clear session (for testing logout)
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gadget Review App</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            text-align: center;
            padding-top: 100px;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.75);
            display: inline-block;
            padding: 40px;
            border-radius: 15px;
        }

        input, select {
            padding: 10px;
            margin: 10px;
            width: 250px;
            border-radius: 5px;
            border: none;
        }

        button {
            padding: 10px 30px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            color: #f8f9fa;
            text-decoration: none;
            display: block;
            margin-top: 20px;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome to Gadget Review App</h1>

    <?php if (!isset($_SESSION['role'])): ?>
        <form method="POST">
            <h2>Select Role</h2>
            <select name="role" required onchange="togglePassword(this.value)">
                <option value="">Choose...</option>
                <option value="viewer">Viewer</option>
                <option value="admin">Admin</option>
            </select><br>

            <div id="admin-password" style="display:none;">
                <input type="password" name="password" placeholder="Enter Admin Password"><br>
            </div>

            <button type="submit">Continue</button>
        </form>

        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
        <h2>Welcome, Admin!</h2>
        <a href="add-review.php">Add New Review</a>
        <a href="view-reviews.php">View Reviews</a>
        <a href="index.php?logout=true">Logout</a>

    <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'viewer'): ?>
        <h2>Welcome, Viewer!</h2>
        <a href="view-reviews.php">View Reviews</a>
        <a href="index.php?logout=true">Logout</a>
    <?php endif; ?>
</div>

<script>
    function togglePassword(role) {
        document.getElementById('admin-password').style.display = (role === 'admin') ? 'block' : 'none';
    }
</script>

</body>
</html>
