<?php

$servername = env('DB_HOST');
$username = env('DB_USERNAME');
$password = env('DB_PASSWORD');
$dbname = env('DB_DATABASE');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    // echo "Connection failed: " . $e->getMessage();
}

$st = $conn->query("SELECT * FROM ab_settings WHERE name='recaptcha'"); 
$st = $st->fetch();
$obj = json_decode($st['data']);

return [
    'secret' => $obj->{'secret'},
    'sitekey' => $obj->{'sitekey'},
    'options' => [
        'timeout' => 30,
    ],
];
