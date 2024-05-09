<?php
ini_set('display_errors', 1);
require('class.pdofactory.php');
require('TwitterAPIExchange.php');

$strDSN = "pgsql:dbname=usuaris;host=localhost;port=5432";
$objPDO = PDOFactory::GetPDO($strDSN, "postgres", "root", array());
$objPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$settings = array(
    'oauth_access_token' => "",
    'oauth_access_token_secret' => "",
    'consumer_key' => "",
    'consumer_secret' => ""
);

// Obtener datos del API de Twitter
$url = 'https://publish.twitter.com/oembed';
$getfield = '?url=https://twitter.com/Interior/status/507185938620219395';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$responseJson = $twitter->setGetfield($getfield)
                   ->buildOauth($url, $requestMethod)
                   ->performRequest();

$json = json_decode($responseJson, true);

// Guardar los datos obtenidos en variables
$url = $json['url'];
$author_name = $json['author_name'];
$provider_name = $json['provider_name'];
$type = $json['type'];

// Insertar datos en la tabla datosTwitter
$stmt = $objPDO->prepare("INSERT INTO datosTwitter (url, author_name, provider_name, photo) VALUES (:url, :author_name, :provider_name, :photo)");
$stmt->bindParam(':url', $url);
$stmt->bindParam(':author_name', $author_name);
$stmt->bindParam(':provider_name', $provider_name);
$stmt->bindParam(':photo', $type);
$stmt->execute();

echo "Se han insertado los valores correctamente";

// Datos adicionales a insertar
$additional_data = array(
    array(
        'url' => 'https://twitter.com/user/status/123456789',
        'author_name' => 'User1',
        'provider_name' => 'Twitter',
        'photo' => 'tweet'
    ),
    array(
        'url' => 'https://twitter.com/user/status/987654321',
        'author_name' => 'User2',
        'provider_name' => 'Twitter',
        'photo' => 'tweet'
    ),
    array(
        'url' => 'https://twitter.com/user/status/456789123',
        'author_name' => 'User3',
        'provider_name' => 'Twitter',
        'photo' => 'tweet'
    )
);

// Insertar datos adicionales en la tabla datosTwitter
foreach ($additional_data as $data) {
    $stmt = $objPDO->prepare("INSERT INTO datosTwitter (url, author_name, provider_name, photo) VALUES (:url, :author_name, :provider_name, :photo)");
    $stmt->bindParam(':url', $data['url']);
    $stmt->bindParam(':author_name', $data['author_name']);
    $stmt->bindParam(':provider_name', $data['provider_name']);
    $stmt->bindParam(':photo', $data['photo']);
    $stmt->execute();
}

?>
