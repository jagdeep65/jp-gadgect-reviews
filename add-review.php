<?php
session_start();

// Allow only logged-in admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Connect to DB
$conn = new mysqli("localhost", "root", "", "gadget_review");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$title = $content = $rating = $category = $affiliate_link = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"] ?? "");
    $content = $conn->real_escape_string($_POST["content"] ?? "");
    $rating = $conn->real_escape_string($_POST["rating"] ?? "");
    $category = $conn->real_escape_string($_POST["category"] ?? "");
    $affiliate_link = $conn->real_escape_string($_POST["affiliate_link"] ?? "");

    if ($title && $content && $rating && $category && $affiliate_link) {
        $sql = "INSERT INTO reviews (title, content, rating, category, affiliate_link)
                VALUES ('$title', '$content', '$rating', '$category', '$affiliate_link')";

        if ($conn->query($sql) === TRUE) {
            $success = "Review added successfully!";
            $title = $content = $rating = $category = $affiliate_link = "";
        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #111;
            color: white;
            padding: 50px;
        }

        .container {
            background-color: #1f1f1f;
            padding: 30px;
            border-radius: 15px;
            max-width: 600px;
            margin: auto;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: none;
        }

        button {
            background-color: #28a745;
            padding: 12px 25px;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .success { color: #3ff33f; }
        .error { color: red; }
        a { color: #ccc; text-decoration: none; display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Gadget Review</h2>

    <?php if ($success): ?>
        <p class="success"><?= $success ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>" required>

        <label>Review Content:</label>
        <textarea name="content" rows="5" required><?= htmlspecialchars($content) ?></textarea>

        <label>Rating (1–5):</label>
        <select name="rating" required>
            <option value="">Choose Rating</option>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>" <?= $rating == $i ? 'selected' : '' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>

        <label>Category:</label>
        <input type="text" name="category" value="<?= htmlspecialchars($category) ?>" required>

        <label>Affiliate Link (with http/https):</label>
        <input type="url" name="affiliate_link" value="<?= htmlspecialchars($affiliate_link) ?>" required>

        <button type="submit">Submit Review</button>
    </form>

    <a href="index.php">← Back to Home</a>
</div>

</body>
</html>
