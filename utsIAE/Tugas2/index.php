<?php
$apiKey = "bf79f2f4e0aa486ea15577a2025773b7"; // Ganti dengan API Key RAWG Anda
$searchQuery = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Endpoint API RAWG
$apiUrl = "https://api.rawg.io/api/games?key={$apiKey}&page_size=20";

// Jika pengguna mencari game, tambahkan query pencarian
if (!empty($searchQuery)) {
    $apiUrl .= "&search=" . urlencode($searchQuery);
}

// Mengambil data dari API
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

// Mengambil daftar game
$games = isset($data['results']) ? $data['results'] : [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Game - RAWG API</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Daftar Game</h1>
        <form method="GET" action="index.php" class="search-form">
            <input type="text" name="search" placeholder="Cari game..." value="<?= $searchQuery ?>">
            <button type="submit">Cari</button>
        </form>

        <div class="game-list">
            <?php if (!empty($games)): ?>
                <?php foreach ($games as $game): ?>
                    <div class="game-card">
                        <img src="<?= $game['background_image'] ?>" alt="<?= $game['name'] ?>">
                        <h3><?= $game['name'] ?></h3>
                        <p>Rating: <?= $game['rating'] ?> ⭐</p>
                        <p>Released: <?= $game['released'] ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="error">Game tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
