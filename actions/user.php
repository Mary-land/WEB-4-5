<?php
require_once(dirname(__FILE__,2)."/utils/errors.php");
require_once(dirname(__FILE__,2)."/internal/available-users.php");
if(empty($_GET)) {api_response_error("Data is not enough!");}
//elseif($_GET!="method") {api_response_error("Unknown action!");}
else
{
	if($_GET["method"]=="login")
	{
		if(!isset($_GET["username"])) {api_response_error("No username entered!");}
		elseif (!isset($_GET["pass"])) {api_response_error("Password not entered!");}
		else login($_GET["username"], $_GET["pass"]);
	}
	elseif($_GET["method"]=="logout")
	{
	if(!isset($_GET["sessionid"])) {api_response_error("Data is not enough!");}
	else session_out($_GET["sessionid"]);
	}
	else {api_response_error("Unknown method!!!");}
}
?>