<?php
declare(strict_types=1);

function setupCurl($id): array {
    return [
        CURLOPT_URL => "http://web/",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: text/html',
        ],
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_COOKIE => 'PHPSESSID='. $id
    ];
}

$dsn = 'mysql:host=db;dbname=db';
$db_user = 'user';
$db_pass = 'password';

try {
    $query = "select id from `list`;";
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $stmt = $pdo->query($query);
} catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
}

foreach ($stmt as $row) {
    $id = $row['id'];

    $curl = curl_init();
    curl_setopt_array($curl, setupCurl($id));
    $response = curl_exec($curl);
    $info = curl_getinfo($curl);
    unset($curl);

    if ($info['http_code'] === 302) {
        $query = "delete from `list` where id='" . $id . "';";
        $pdo->query($query);
        continue;
    }

    echo $row['id'];
    echo '<br>';
}
$stmt = null;
$pdo = null;
