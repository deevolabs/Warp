<?php 
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header('Content-Type: text/html; charset=utf-8');


require "facebook.php";
$facebook = new Facebook(array(
    'appId'  => '221163397990534',
    'secret' => '8f38d5a6a8848da73c23b4b5c2794fb8',
));

$user = $facebook->getUser();

//echo $user;

$pageFeed = $facebook->api('DpotBrasil' . '/photos');

//print_r($pageFeed);

foreach ($pageFeed['data'] as $key => $value) {
	echo $value['source'] . '<br/>';
}

//echo json_encode($pageFeed), "\n";



?>