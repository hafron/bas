<?php
require_once 'BasAPI.class.php';
// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {
    $API = new BasAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode(
				array(
					'error' => $e->getMessage(),
					'code' => $e->getCode(),
					'file' => $e->getFile(),
					'line' => $e->getLine(),
					'trace' => $e->getTrace()
				));
}
