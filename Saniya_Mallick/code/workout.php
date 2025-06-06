<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "music_db";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add to cart logic
if (isset($_POST['add_to_cart'])) {
    $user_id = $_SESSION['user_id'];
    $track_id = $_POST['track_id'];
    $track_name = $_POST['track_name'];
    $track_url = $_POST['track_url'];
    $price = $_POST['price'];
    $type = $_POST['type']; // 'music' or 'artwork'

    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND track_id = ? AND type = ?");
    $stmt->bind_param("iss", $user_id, $track_id, $type);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($quantity);
        $stmt->fetch();
        $stmt->close();

        $new_quantity = $quantity + 1;
        $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND track_id = ? AND type = ?");
        $update->bind_param("iiss", $new_quantity, $user_id, $track_id, $type);
        $update->execute();
        $update->close();
    } else {
        $stmt->close();
        $insert = $conn->prepare("INSERT INTO cart (user_id, track_id, track_name, track_url, quantity, price, type) VALUES (?, ?, ?, ?, 1, ?, ?)");
        $insert->bind_param("isssds", $user_id, $track_id, $track_name, $track_url, $price, $type);
        $insert->execute();
        $insert->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Workout - Artwave</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
      color: #422F48;
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .cover-image {
      width: 100%;
      height: 300px;
      object-fit: cover;
    }

    h1 {
      margin: 20px 0 10px;
      font-size: 2rem;
      color: #422F48;
    }

    .artwork-btn {
      margin-bottom: 30px;
    }

    .music-container {
      display: flex;
      justify-content: center;
      gap: 30px;
      margin-top: 30px;
      flex-wrap: wrap;
      padding: 0 20px;
    }

    .song-box {
      background-color: #f8f4f9;
      border-radius: 20px;
      padding: 20px;
      width: 300px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .song-title {
      font-size: 1.2rem;
      margin-bottom: 10px;
      color: #422F48;
    }

    audio {
      width: 100%;
      outline: none;
    }

    button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #422F48;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
    }

    button:disabled {
      background-color: #aaa;
      cursor: not-allowed;
    }

    footer {
      margin-top: 50px;
      padding: 20px;
      font-size: 0.9rem;
      color: #888;
    }
  </style>
</head>
<body>

  <!-- Cover Image -->
  <img class="cover-image" src="https://plus.unsplash.com/premium_photo-1670505062582-fdaa83c23c9e?w=1200&auto=format&fit=crop&q=60" alt="Workout Mood Cover" />

  <h1>Workout Music</h1>

  <!-- Add artwork to cart -->
  <div class="artwork-btn">
    <form method="POST" action="workout.php">
      <input type="hidden" name="track_id" value="workout_cover">
      <input type="hidden" name="track_name" value="Workout Mood Artwork">
      <input type="hidden" name="track_url" value="https://plus.unsplash.com/premium_photo-1670505062582-fdaa83c23c9e?w=1200&auto=format&fit=crop&q=60">
      <input type="hidden" name="price" value="3.49">
      <input type="hidden" name="type" value="artwork">
      <button type="submit" name="add_to_cart">Add Artwork to Cart - ₹3.49</button>
    </form>
  </div>

  <!-- Music Tracks -->
  <div class="music-container">

    <div class="song-box">
      <div class="song-title">High Energy</div>
      <audio controls>
        <source src="https://github.com/saniya-mallick/artwave-music/raw/main/audio/workout1.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
      </audio>
      <form method="POST" action="workout.php">
        <input type="hidden" name="track_id" value="workout1">
        <input type="hidden" name="track_name" value="High Energy">
        <input type="hidden" name="track_url" value="https://github.com/saniya-mallick/artwave-music/raw/main/audio/workout1.mp3">
        <input type="hidden" name="price" value="2.99">
        <input type="hidden" name="type" value="music">
        <button type="submit" name="add_to_cart">Add to Cart - ₹2.99</button>
      </form>
    </div>

    <div class="song-box">
      <div class="song-title">Pump Up</div>
      <audio controls>
        <source src="https://github.com/saniya-mallick/artwave-music/raw/main/audio/workout2.mp3" type="audio/mpeg">
        Your browser does not support the audio element.
      </audio>
      <form method="POST" action="workout.php">
        <input type="hidden" name="track_id" value="workout2">
        <input type="hidden" name="track_name" value="Pump Up">
        <input type="hidden" name="track_url" value="https://github.com/saniya-mallick/artwave-music/raw/main/audio/workout2.mp3">
        <input type="hidden" name="price" value="2.49">
        <input type="hidden" name="type" value="music">
        <button type="submit" name="add_to_cart">Add to Cart - ₹2.49</button>
      </form>
    </div>

  </div>

  <footer>
    &copy; 2025 Artwave. All rights reserved.
  </footer>

</body>
</html>
