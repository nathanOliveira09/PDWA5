<?php

/*$curl_handle=curl_init();
curl_setopt($curl_handle, CURLOPT_URL,'http://localhost:3000/api/product/readProducts.php');
curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
$json = curl_exec($curl_handle);
curl_close($curl_handle);*/

$url = "http://localhost:3000/api/product/readProducts.php";
$ch = curl_init($url);
$resultado = json_decode(curl_exec($ch));
var_dump($resultado);


?>