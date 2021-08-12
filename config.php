<?php

@session_start();
$_SESSION['uid'] = 12345;


define('TMDB_URL','https://api.themoviedb.org');
define('TMDB_IMAGE_PATH','https://image.tmdb.org/t/p/');

require __DIR__.'/credentials.php';
require __DIR__.'/functions.php';
require __DIR__.'/model/Main.php';
require __DIR__.'/model/MovieDB.php';

$GLOBALS['MovieDB'] = new MagentoModule\MovieDB();

?>