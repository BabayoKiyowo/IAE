<?php
header('Content-Type: application/json'); 

if (isset($_GET['city'])) {
    $city = htmlspecialchars($_GET['city']);
    $apiKey = 'ce441a2caba61d289c20fba57dca8f7d'; 
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

    
    $data = file_get_contents($apiUrl);
    $weather = json_decode($data, true);

    if ($weather['cod'] == 200) {
        
        $result = [
            'kota' => $weather['name'],
            'suhu' => $weather['main']['temp'] . "°C",
            'kelembaban' => $weather['main']['humidity'] . "%",
            'cuaca' => $weather['weather'][0]['description']
        ];
    } else {
        $result = [
            'status' => 'error',
            'pesan' => 'Kota tidak ditemukan.'
        ];
    }
} else {
    $result = [
        'status' => 'error',
        'pesan' => 'Masukkan parameter kota terlebih dahulu.'
    ];
}


echo json_encode($result, JSON_PRETTY_PRINT);