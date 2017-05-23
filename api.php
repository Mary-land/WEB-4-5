<?php
require_once(dirname(__FILE__)."/utils/errors.php");
if(empty($_GET)){
	api_response_error("Nothing has been entered!");
}
//elseif($_GET!="action") {api_response_error("Unknown action!");}
else
{
	if($_GET["action"]=="user")
	{
		require_once(dirname(__FILE__)."/actions/user.php");
	}
	elseif ($_GET["action"]=="data") {
		require_once(dirname(__FILE__)."/actions/data.php");
	}
	else {api_response_error("Unknown action!");}
}
?>