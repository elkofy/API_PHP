<?php
$url = 'http://127.0.0.1/api/produits';
$data = array('nom' => 'test', 'description' => 'test', 'token' => 'test', 'prix' => '10', 'stock' => '10', 'categoriy_id' => '1', 'createdat' => '2020-01-01', 'modified' => '2020-01-01');
// utilisez 'http' même si vous envoyez la requête sur https:// ...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */
    
}
var_dump($result);
