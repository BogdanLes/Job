<?php header("Content-Type: application/json; charset=UTF-8");?>

<?php

require 'classes.php';

$obj=json_decode($_GET["x"], false);

//load sites in objects
$sys_file="system.xml";
$aJob=[];
$aJob=Sys::loadsites($sys_file);

// select what to verifie job/directory
$opt=$obj->option;
if($opt=="o1")
{
	//code for verifying project name
	$val=$obj->title;
	$val=trim($val);
	$val=strtolower($val);
	
	for($i=0; $i<count($aJob); $i++)
	{
		$title_nodes=$aJob[$i]->get_stitle();
		$vtitle_nodes=strtolower($title_nodes);
		if($val==$vtitle_nodes)
		{
			$rx=$title_nodes." - <span style='color: darkred;'>Job Title already exists!!!</span>";
			$res=array("sres"=>$rx);
			echo json_encode($res);
			die();
		}
	}
	
	$res=array("sres"=>"<span style='color: darkblue;'>Job Title is valid</span>");
	echo json_encode($res);
}
else
{
	//cod for verifying directory
	$val=$obj->directory;
	$val=trim($val);
	$val=strtolower($val);
	
	for($i=0; $i<count($aJob); $i++)
	{
		$dir_nodes=$aJob[$i]->get_sdir();
		$vdir_nodes=strtolower($dir_nodes);
		if($val==$vdir_nodes)
		{
			$rx=$dir_nodes." - <span style='color: darkred;'>Directory already exists!!!</span>";
			$res=array("sres"=>$rx);
			echo json_encode($res);
			die();
		}
	}
	
	$res=array("sres"=>"<span style='color: darkblue;'>Directory is valid</span>");
	echo json_encode($res);
}	


?>






