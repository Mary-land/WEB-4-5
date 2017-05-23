<?php
require_once("functions.php");
function api_response_error($message)
{
	api_response(array("Error"=>$message));
}
?>