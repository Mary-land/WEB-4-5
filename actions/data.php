<?php
require_once(dirname(__FILE__,2)."/utils/errors.php");
require_once(dirname(__FILE__,2)."/internal/available-users.php");
if(empty($_GET)) {api_response_error("Data is not enough!");}
//elseif($_GET!="method") {api_response_error("Unknown action!!!");}
else
{
	if($_GET["method"]=="get")
	{
		if(!isset($_GET["sessionid"])) {api_response_error("Data is not enough!");}
		else session($_GET["sessionid"]);
	}
	elseif($_GET["method"]=="set")
	{
		if(!isset($_GET["sessionid"])) {api_response_error("Data is not enough!");}
		elseif(!isset($_GET["text"])) {api_response_error("Data is not enough!");}
		else session_set($_GET["sessionid"], $_GET["text"]);
	}
	else {api_response_error("Unknown method!!!");}
}
?>