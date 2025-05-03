<?php
session_start();

// Connect to database
$conn = new mysqli("localhost", "root", "", "gadget_review");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM reviews WHERE title LIKE '%$search%' OR category LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM reviews ORDER BY created_at DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1c1c1c;
            color: white;
            padding: 40px;
        }

        .search-box {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: none;
        }

        button {
            padding: 10px 20px;
            border: none;
            background: #28a745;
            color: white;
            border-radius: 5px;
        }

        .review {
            background: #2e2e2e;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
        }

        a {
            color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Gadget Reviews</h1>

    <div class="search-box">
        <form method="GET">
            <input type="text" name="search" placeholder="Search reviews..." value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="review">
                <h2><?= htmlspecialchars($row['title']) ?></h2>
                <p><strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></p>
                <p><strong>Rating:</strong> <?= htmlspecialchars($row['rating']) ?>/5</p>
                <p><strong>Review:</strong> <?= htmlspecialchars($row['content']) ?></p>
                <p><a href="<?= htmlspecialchars($row['affiliate_link']) ?>" target="_blank">Buy Now</a></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No reviews found.</p>
    <?php endif; ?>

    <a href="index.php">Back to Home</a>
</body>
</html>
