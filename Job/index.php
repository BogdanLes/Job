<?php header('Content-type: text/html; charset=utf-8');?>

<?php

// load the list with jobs
$xmlfile="system.xml";
$xml= simplexml_load_file($xmlfile);
$nrs= (int) $xml->snr;

$html="";

$sites=$xml->sites;
foreach($sites->children() as $ss)
{
	$k=0;
	foreach($ss->children() as $job)
	{
		switch($k)
		{
			case 0: $jnr=$job; break;
			case 1: $jtitle=$job; break;
			case 2: $jdir=$job; break;
			case 3: $jfile=$job; break;
			case 4: $jdate=$job; break;
			case 5: $jorg=$job; break;
			case 6: $jdes=$job; break;
		}
		$k++;
	}
	$html="<div class='wwjoblistcl'><div class='wjoblistcl'>
	<div class='joblisttitlecl'>".$jnr.". ".$jtitle."</div>
	<div class='wjoblistlinkcl'><a class='joblistlinkcl' href='".$jfile."'>".$jfile."</a></div>
	<div class='joblistdatacl'>Directory: ".$jdir." - Organization: ".$jorg." - Date: ".$jdate."</div>
	<div class='joblistdescl'>Description: ".$jdes."</div>
	</div></div>".$html;
}
$html="<div class='walljobslistcl'>".$html."</div>";


//search for jobs if is the case
$htmlsh="";
if(isset($_GET["jobsh"]))
{
	$shjob=$_GET["jobsh"];
}
else {
	$shjob="";
}
$shjob=trim($shjob);

if(strlen($shjob)>0)
{
	//load jobs in array as objects
	require 'classes.php';
	$sys_file="system.xml";
	$aJob=[];
	$aJob=Sys::loadsites($sys_file);

	//search for matches
	foreach($aJob as $item)
	{
		$vshjob=$item->get_stitle()." ".$item->get_sdir()." ".$item->get_sorg()." ".$item->get_sdate()." ".$item->get_sdes();
		if(stristr($vshjob, $shjob))
		{
			$htmlsh="<div class='wwjoblistcl'><div class='wjoblistcl'>
			<div class='joblisttitlecl'>".$item->get_snr().". ".$item->get_stitle()."</div>
			<div class='wjoblistlinkcl'><a class='joblistlinkcl' href='".$item->get_sfile()."'>".$item->get_sfile()."</a></div>
			<div class='joblistdatacl'>Directory: ".$item->get_sdir()." - Organization: ".$item->get_sorg()." - Date: ".$item->get_sdate()."</div>
			<div class='joblistdescl'>Description: ".$item->get_sdes()."</div>
			</div></div>".$htmlsh;
		}
	}
}


?>

<!DOCTYPE html>
<html lang="ro">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Job</title>
<meta name="title" content="Job" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta name="robots" content="ALL" />
<meta name="googlebot" content="INDEX,FOLLOW" />
<meta name="author" content="Les Bogdan" />
<meta name="owner" content="Les Bogdan" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--
<link rel="stylesheet" type="text/css" media="screen and (min-width: 600px)" href="/css/general/bar.css" />
<link rel="stylesheet" type="text/css" media="screen and (max-width: 599px)" href="/css/general/barmobile.css" />
-->


<link rel="stylesheet" type="text/css" href="/jobcss.css" />
<script type="text/javascript">
var jf="main";
</script>

<script>
function vershj()
{
	return true;
}
</script>

<script>
function veraddtitle()
{
	var tit=document.getElementById("addjobtitle").value;
	var val={};
	val["option"]="o1";
	val["title"]=tit;
	const param=JSON.stringify(val);
	//document.getElementById("addjobtitlewar").innerHTML=param;
	
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onload = function() {
		const resObj=JSON.parse(this.responseText);
		document.getElementById("addjobtitlewar").innerHTML=resObj.sres;
	};
	xmlhttp.open("GET","veradddir.php?x=" + param);
	xmlhttp.send();
}
</script>

<script>
function veradddir()
{
	var dir=document.getElementById("addjobdir").value;
	var val={};
	val["option"]="o2";
	val["directory"]=dir;
	const param = JSON.stringify(val);
	//document.getElementById("addjobdirwar").innerHTML=param;
	
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onload = function() {
		//document.getElementById("addjobdirwar").innerHTML = this.responseText;
		const resObj=JSON.parse(this.responseText);
		document.getElementById("addjobdirwar").innerHTML = resObj.sres;
	};
	xmlhttp.open("GET","veradddir.php?x=" + param);
	xmlhttp.send();
}
</script>

<script>
function veraddjob()
{
	//alert("test");
	var v=0;
	document.getElementById("addjobsubmit").disabled=true;
	var vervalue="";
	vervalue=document.getElementById("addjobtitle").value;
	if(vervalue.length<1) { v=1; }
	vervalue=document.getElementById("addjobdir").value;
	if(vervalue.length<1) { v=1; }
	vervalue=document.getElementById("addjobfile").value;
	if(vervalue.length<1) { v=1; }
	if(v==1)
	{
		alert("Incomplet form!");
		document.getElementById("addjobsubmit").disabled=false;
		return false;
	}

	return true;
}
</script>

<script type="text/javascript">
function loadpg()
{

}
</script>

</head>

<body class="brbodycl" onload="loadpg();">
<div id="wtopbar" class="wtopbarcl">
</div>


<table id="wallt"><tr id="walltr" class="walltrcl">

<td id="walltd11" class="walltd1cl">
<h1 id="brh1" class="jh1cl">Job Dispecer</h1>

<div><?php echo $html; ?></div>
</td>

<td id="walltd21" class="walltd2cl">
<!-- search for a job form -->
<h2 id="oph2" class="jh2cl">Job Operations</h1>


<div id="wwsearch" class="wwsearchcl">
<div id="wsearch" class="wsearchcl">
<form name="searchjobform" id="searchjobform" onsubmit="return vershj()" action="/index.php" method="GET">
<table class="ajtcl">
<tr class="ajtrcl">
<td class="ajtd1cl"><div id="wajb" class="wajbcl">
<input type="text" id="jobsh" name="jobsh" class="shjboxcl" value="<?php echo $shjob; ?>" />
</div></td>
<td class="ajtd2cl"><div id="wajbtt" class="wajbttcl"><input id="shjbtt" name="shjbtt" class="shjbttcl" type="submit" value="Search Job"/>
</div></td>
</tr></table></form>
</div>
<div id="wshres" class="wshrescl"><?php echo $htmlsh; ?></div>
</div>


<!-- add new job form -->
<div id="wwaddjob" class="wwaddjobcl">
<div id="waddjob" class="waddjobcl">
<h2 id="addnewjobh2">Add New Job:</h2>

<form name="addjobform" id="addjobform" onsubmit="return veraddjob()" action="/addjob.php" method="POST" target="sresif">
<div class="waddjobfcl">
<label for="addjobtitle" class="addjobncl">Job Title:</label>
<input type="text" id="addjobtitle" name="addjobtitle" class="addjobfcl" onchange="veraddtitle()" value="" />
<div id="addjobtitlewar"><br/></div>
</div>
<div class="waddjobfcl">
<label for="addjobdir" class="addjobncl">Job Directory:</label>
<input type="text" id="addjobdir" name="addjobdir" class="addjobfcl" onchange="veradddir()" value="" />
<div id="addjobdirwar"><br/></div>
</div>
<div class="waddjobfcl">
<label for="addjobfile" class="addjobncl">Job File:</label>
<input type="text" id="addjobfile" name="addjobfile" class="addjobfcl" placeholder="CV/index.html" value="" />
</div>
<div class="waddjobfcl">
<label for="addjobdate" class="addjobncl">Job Date:</label>
<input type="text" id="addjobdate" name="addjobdate" class="addjobfcl" value="" />
</div>
<div class="waddjobfcl">
<label for="addjoborg" class="addjobncl">Job Organization:</label>
<input type="text" id="addjoborg" name="addjoborg" class="addjobfcl" value="" />
</div>
<div class="waddjobfcl">
<label for="addjobdes" class="addjobncl">Job Description:</label>
<textarea id="addjobdes" name="addjobdes" class="addjobfxcl" ></textarea>
</div>
<div class="waddjobfcl">
<input type="submit" id="addjobsubmit" name="addjobsubmit" value="Add new job" />
</div>


</form>
</div>
</div>

<div id="wsres" class="wsrescl" style="display: none;">
<iframe id="sresif" name="sresif" class="sresifcl" style="width: 90%;height: 200px;"></iframe>
</div>

</td>

</tr></table>

<br><br>

</body>
</html>





