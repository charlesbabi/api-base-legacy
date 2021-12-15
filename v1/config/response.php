<?php

class Response
{
    function send($code = 200, $status = "OK", $data, $extra_data = array())
    {
        $response = array(
            "code" => $code,
            "status" => $status,
            "data" => $data,
            "extra_data" => $extra_data
        );
        http_response_code($code);
        echo json_encode($response, JSON_PRETTY_PRINT);
    }
}
