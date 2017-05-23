<?php
function api_response($value)
{
	echo json_encode($value);
	exit();
}
function api_response_session($id)
{
	api_response(array("SessionId"=>$id, "Error"=>null));
}
function api_session($text)
{
	api_response(array("Result: "=>$text, "Error"=>null));
}
?>