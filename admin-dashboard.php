<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include("includes/db.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Add Review</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <h2>Admin Dashboard - Add Gadget Review <a href="logout.php" style="float:right; color:red;">Logout</a></h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Gadget Title" required>
        <input type="text" name="image_url" placeholder="Image URL" required>
        <textarea name="description" placeholder="Description" rows="5" required></textarea>
        <input type="text" name="affiliate_link" placeholder="Affiliate Link" required>
        <input type="number" name="rating" placeholder="Rating (1-5)" min="1" max="5" required>
        <input type="text" name="category" placeholder="Category (smartphones, laptops, etc.)" required>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    if (isset($_POST['submit'])) {
        $title = $conn->real_escape_string($_POST['title']);
        $img = $conn->real_escape_string($_POST['image_url']);
        $desc = $conn->real_escape_string($_POST['description']);
        $link = $conn->real_escape_string($_POST['affiliate_link']);
        $rating = isset($_POST['rating']) ? $_POST['rating'] : 0;
        $category = isset($_POST['category']) ? $conn->real_escape_string($_POST['category']) : '';

        $sql = "INSERT INTO reviews (title, image_url, description, affiliate_link, rating, category)
                VALUES ('$title', '$img', '$desc', '$link', '$rating', '$category')";
        if ($conn->query($sql)) {
            echo "<p style='color:green;'>✅ Review added!</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
        }
    }
    ?>
</div>
</body>
</html>

