<?php
declare(strict_types=1);

function setupCurl($cookieFile): array {
    return [
        CURLOPT_URL => "http://web/login.php",
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_POST => TRUE,
        CURLOPT_POSTFIELDS => http_build_query([
            'name' => $_POST['name'],
            'pass' => $_POST['pass'],
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
        ],
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_COOKIEJAR => $cookieFile,
    ];
}

function save(string $id) : void {
    $dsn = 'mysql:host=db;dbname=db';
    $db_user = 'user';
    $db_pass = 'password';

    try {
        $query = "insert into `list` values ('" . $id . "');";
        $pdo = new PDO($dsn, $db_user, $db_pass);
        $stmt = $pdo->query($query);
    } catch (PDOException $e) {
        var_dump($query);
        exit('データベース接続失敗。' . $e->getMessage());
    }
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $cookieFile = tempnam(sys_get_temp_dir(),"cookie_test_");
    $curl = curl_init();
    curl_setopt_array($curl, setupCurl($cookieFile));
    $response = curl_exec($curl);
    $info = curl_getinfo($curl);
    unset($curl);

    if ($info['http_code'] !== 302) {
        echo $response;
        exit;
    }

    $cookie = file($cookieFile);
    preg_match('/PHPSESSID\s([^\s\n]+)/', implode(' ' ,$cookie), $match);
    save($match[1]);

    $redirect = preg_replace('/web/', 'localhost', $info['redirect_url']);
    header('Location: '. $redirect);
    setcookie('PHPSESSID', $match[1]);
    exit;
}

$html = file_get_contents("http://web/login.php");
echo $html;
