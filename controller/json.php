<?php

require __DIR__.'/../config.php';

header('Content-Type: application/json');

$GLOBALS['_a'] = isset($_GET['a'])?$_GET['a']:'';
$GLOBALS['_r'] = '';

?>