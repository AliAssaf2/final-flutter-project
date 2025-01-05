<?php

function jsonResponse($status, $data = null, $message = '')
{
    header('Content-Type: application/json');
    http_response_code($status);
    echo json_encode(['message' => $message, 'data' => $data]);
    exit();
}
?>