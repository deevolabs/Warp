<?php 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');


require "facebook.php";
$facebook = new Facebook(array(
    'appId'  => '640415886035222',
    'secret' => '229e33b4925c0384c52aab93104c5a8a',
));

$user = $facebook->getUser();

//echo $user;

$pageFeed = $facebook->api('simbioseventures' . '/feed');


echo json_encode($pageFeed), "\n";

?>