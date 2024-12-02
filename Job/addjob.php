<?php header('Content-type: text/html; charset=utf-8');?>

<?php

$jtitle=trim($_POST["addjobtitle"]);
$jdir=trim($_POST["addjobdir"]);
$jfile=trim($_POST["addjobfile"]);
$jdate=trim($_POST["addjobdate"]);
$jorg=trim($_POST["addjoborg"]);
$jdes=trim($_POST["addjobdes"]);


$xmlfile="system.xml";
$xml= simplexml_load_file($xmlfile);
$nrj=(int)$xml->snr;
$nrj++;
$xml->snr=$nrj;

$newnode="ss".$nrj;

$as=$xml->sites->addChild($newnode,'');
$nnr="nr".$nrj;
$as->addChild($nnr,$nrj);
$ntitle="title".$nrj;
$as->addChild($ntitle,$jtitle);
$ndir="dir".$nrj;
$as->addChild($ndir,$jdir);
$nfile="file".$nrj;
$as->addChild($nfile,$jfile);
$ndate="date".$nrj;
$as->addChild($ndate,$jdate);
$norg="organization".$nrj;
$as->addChild($norg,$jorg);
$ndes="description".$nrj;
$as->addChild($ndes,$jdes);


$dom = new DOMDocument('1.0');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
$dom->loadXML($xml->asXML());
$dom->save("system.xml");


?>

<!DOCTYPE html>
<html lang="ro">
<head>

<script type="text/javascript">
function loadraddj()
{

}
</script>

</head>

<body class="brbodycl" onload="loadraddj();">

<div>Server response done!</div>


</body>
</html>





