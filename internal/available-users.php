<?php
require_once(dirname(__FILE__,2)."/utils/errors.php");
require_once(dirname(__FILE__,2)."/utils/functions.php");
function login($user,$pass){
	if($log = fopen(dirname(__FILE__,2)."/internal/log.txt", 'r'))
	{
		$temp = false;
		$a = 0;
		while(!feof($log))
		{
			$buffer = fgets($log);
			$data = preg_split("/[\s-]+/", $buffer);
			if (strcmp($data[0], $user)===0 && strcmp($data[1], $pass)===0)
			{
				$temp = true;
				$id = uniqid();
				$file=file(dirname(__FILE__,2)."/internal/session.txt");
				$fp=fopen(dirname(__FILE__,2)."/internal/session.txt", 'w');
				for($i=0;$i<sizeof($file);$i++)
				{
					$data=preg_split("/[+\r\n]+/", $file[$i]);
					if($data[0]==$user)
					{
						$file[$i]="${id}+${file[$i]}";
						$a=1;
						break;
					}
				}
				fputs($fp,implode("",$file));
				if($a==0)
				{
					fwrite($fp, "${id}+${user}\r\n");
				}
				fclose($fp);
				api_response_session($id);
			}
			elseif (strcmp($data[0], $user)===0) { 
				$temp = true;
				api_response_error("Wrong password!");
			}
		}
		if($temp === false) { api_response_error("This user does not exist");}
	}
}
function session($sessionid)
{
	if($log = fopen(dirname(__FILE__,2)."/internal/session.txt", 'r'))
	{
		$temp = false;
		while(!feof($log))
		{
			$buffer = fgets($log);
			$data = preg_split("/[+\r\n]+/", $buffer);
			if (strcmp($data[0], $sessionid)==0) {
				$temp = true;
				/*if(count($data)==3){*/api_session($data[2]);//}
				//else {api_session(" ");}
			}
		}
		if($temp === false) { api_response_error("Not logged!");}
	}
}
function session_set($sessionid, $text)
{
	$file=file(dirname(__FILE__,2)."/internal/session.txt");
	$count=0; $k=0;
	for($i=0;$i<sizeof($file);$i++)
	{
		$data=preg_split("/[+\r\n]+/", $file[$i]);
		if($data[0]==$sessionid)
		{
			$id=$data[1];
			$file[$i] = "${sessionid}+${id}+${text}\r\n";
			$count=1;
		}
	}
	if($count == 1)
	{
		for($i=0;$i<sizeof($file);$i++)
		{
			$data=preg_split("/[+\r\n]+/", $file[$i]);
			if($data[0]==$id)
			{
				if($k == 0) { 
					$file[$i] = "${id}+${text}\r\n";
					$k=1;
				}
				else { unset($file[$i]);}
			}
			elseif($data[1]==$id)
			{
				$file[$i] = "${data[0]}+${id}+${text}\r\n";
			}
		}
	}
	$fp=fopen(dirname(__FILE__,2)."/internal/session.txt", 'w');
	fputs($fp,implode("",$file));
	fclose($fp);
	api_session("done");
}
function session_out($sessionid)
{
	$file=file(dirname(__FILE__,2)."/internal/session.txt");
	$fp=fopen(dirname(__FILE__,2)."/internal/session.txt", 'w');
	for($i=0;$i<sizeof($file);$i++)
	{
		$data=preg_split("/[+\r\n]+/", $file[$i]);
		if($data[0]==$sessionid)
		{
			$file[$i]=str_replace("${sessionid}+", "", $file[$i]);
		}
	}
	fputs($fp,implode("",$file));
	fclose($fp);
	api_session("done");
}
?>