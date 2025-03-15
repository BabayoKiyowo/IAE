<?php
header('Content-Type: application/json');

if (isset($_GET['game'])) {
    $game = htmlspecialchars($_GET['game']);
    $apiKey = 'bf79f2f4e0aa486ea15577a2025773b7'; // Ganti dengan API Key RAWG Anda
    $apiUrl = "https://api.rawg.io/api/games?key={$apiKey}&search=" . urlencode($game);

    $data = file_get_contents($apiUrl);
    $response = json_decode($data, true);

    if (!empty($response['results'])) {
        $gameInfo = $response['results'][0];

        $result = [
            'nama' => $gameInfo['name'],
            'rating' => $gameInfo['rating'],
            'platforms' => array_map(function($platform) {
                return $platform['platform']['name'];
            }, $gameInfo['platforms']),
            'gambar' => $gameInfo['background_image']
        ];
    } else {
        $result = [
            'status' => 'error',
            'pesan' => 'Game tidak ditemukan.'
        ];
    }
} else {
    $result = [
        'status' => 'error',
        'pesan' => 'Masukkan parameter game terlebih dahulu.'
    ];
}

echo json_encode($result, JSON_PRETTY_PRINT);
