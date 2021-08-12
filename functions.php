<?php

function _json_output($response)
{
    http_response_code($response['status']);
    echo json_encode($response);
}

?>