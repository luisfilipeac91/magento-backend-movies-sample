<?php

require 'json.php';

switch($GLOBALS['_a'])
{
    case 'tmdb-busca':
        $GLOBALS['_r'] = $GLOBALS['MovieDB']->ListIMDB($_GET);
        break;
    case 'salvar-tmdb':
        $GLOBALS['_r'] = $GLOBALS['MovieDB']->SaveIMDB($_POST);
        break;
    case 'remover-movie':
        $GLOBALS['_r'] = $GLOBALS['MovieDB']->RemoverMovie($_POST['id']);
        break;
    default:
        $GLOBALS['_r'] = array('status'=>501,'mensagem'=>'erro');
        break;

}

_json_output($GLOBALS['_r']);

?>