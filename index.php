<?php
$gameData = null;
$error = null;

if (isset($_GET['game'])) {
    $game = htmlspecialchars($_GET['game']);
    $apiKey = 'bf79f2f4e0aa486ea15577a2025773b7'; // Ganti dengan API Key RAWG Anda
    $apiUrl = "https://api.rawg.io/api/games?key={$apiKey}&search=" . urlencode($game);

    $data = file_get_contents($apiUrl);
    $response = json_decode($data, true);

    if (!empty($response['results'])) {
        $gameInfo = $response['results'][0];
        $gameData = [
            'nama' => $gameInfo['name'],
            'rating' => $gameInfo['rating'],
            'platforms' => implode(", ", array_map(function($platform) {
                return $platform['platform']['name'];
            }, $gameInfo['platforms'])),
            'gambar' => $gameInfo['background_image']
        ];
    } else {
        $error = "Game tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Info Game</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Aplikasi Info Game</h2>
        <form method="GET" action="index.php">
            <input type="text" name="game" placeholder="Masukkan nama game..." required>
            <button type="submit">Cari</button>
        </form>

        <?php if ($gameData): ?>
            <div class="result">
                <h3>Game: <?= $gameData['nama'] ?></h3>
                <p><strong>Rating:</strong> <?= $gameData['rating'] ?></p>
                <p><strong>Platform:</strong> <?= $gameData['platforms'] ?></p>
                <img src="<?= $gameData['gambar'] ?>" alt="<?= $gameData['nama'] ?>" width="300">
            </div>
        <?php elseif ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
