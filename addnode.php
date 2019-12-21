<?php

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
$hostname = getenv("HOSTNAME");

$name = $_POST["name"];

$service_url = 'http://localhost:8888/entity/store';
$curl = curl_init($service_url);


$curl_post_data = array(
        'name' => $name,
        'phone_number' => '69696969669',
        'links' => null,
);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);

$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (isset($decoded->meta->status_code) && $decoded->meta->status_code == 'ERROR') {
    die('error occured: ' . $decoded->meta->message[0]);
}
echo 'response ok!';
echo $decoded->meta->message[0];


header("Location: $hostname/Argus/index.php");
die();
