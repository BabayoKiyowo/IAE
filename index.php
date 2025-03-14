<?php
$weatherData = null;
$error = null;

if (isset($_GET['city'])) {
    $city = htmlspecialchars($_GET['city']);
    $apiKey = 'ce441a2caba61d289c20fba57dca8f7d'; 
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

    $data = file_get_contents($apiUrl);
    $weather = json_decode($data, true);

    if ($weather['cod'] == 200) {
        $weatherData = [
            'kota' => $weather['name'],
            'suhu' => $weather['main']['temp'] . "°C",
            'kelembaban' => $weather['main']['humidity'] . "%",
            'cuaca' => $weather['weather'][0]['description']
        ];
    } else {
        $error = "Kota tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Cuaca</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Aplikasi Info Cuaca</h2>
        <form method="GET" action="index.php">
            <input type="text" name="city" placeholder="Masukkan nama kota..." required>
            <button type="submit">Cari</button>
        </form>

        <?php if ($weatherData): ?>
            <div class="result">
                <h3>Cuaca di <?= $weatherData['kota'] ?></h3>
                <p>Suhu: <?= $weatherData['suhu'] ?></p>
                <p>Kelembaban: <?= $weatherData['kelembaban'] ?></p>
                <p>Deskripsi Cuaca: <?= $weatherData['cuaca'] ?></p>
            </div>
        <?php elseif ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</body>
</html>