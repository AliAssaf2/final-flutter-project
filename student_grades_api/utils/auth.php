<?php
include_once '../utils/response.php';
function authenticate()
{
    $headers = getallheaders();
    if (!isset($headers['Authorization'])) {
        jsonResponse(401, null, 'Unauthorized: No token provided.');
    }

    $jwt = str_replace('Bearer ', '', $headers['Authorization']);

    $secret_key = '1234';


    if ($jwt !== $secret_key) {
        jsonResponse(403, null, 'Unauthorized: Invalid token.');
    }
}
?>