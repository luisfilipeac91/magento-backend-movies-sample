<?php

require 'json.php';

switch($GLOBALS['_a'])
{
    case 'tmdb-busca':
        $GLOBALS['_r'] = $GLOBALS['MovieDB']->ListIMDB($_GET);
        break;
    case 'favoritar':
        $GLOBALS['_r'] = $GLOBALS['MovieDB']->Favoritar($_POST);
        break;
    default:
        $GLOBALS['_r'] = array('status'=>501,'mensagem'=>'erro');
        break;
}

_json_output($GLOBALS['_r']);

?>