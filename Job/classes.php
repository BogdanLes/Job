
<?php

class nameValue {
	public $name;
	public $value;
	function __construct($name, $value) {
		$this->name=$name;
		$this->value=$value;
	}
	public function set_value($value) {
		$this->value=$value;
	}
	public function get_value() {
		return $this->value;
	}
}

class Sys {
	private $snr;
	private $stitle;
	private $sdir;
	private $sfile;
	private $sdate;
	private $sorg;
	private $sdes;
	
	function __construct($snr, $stitle, $sdir, $sfile, $sdate, $sorg, $sdes)
	{
		$this->snr=$snr;
		$this->stitle=$stitle;
		$this->sdir=$sdir;
		$this->sfile=$sfile;
		$this->sdate=$sdate;
		$this->sorg=$sorg;
		$this->sdes=$sdes;
	}
	
	public function get_snr() { return $this->snr; }
	public function get_stitle() { return $this->stitle; }
	public function get_sdir() { return $this->sdir; }
	public function get_sfile() { return $this->sfile; }
	public function get_sdate() { return $this->sdate; }
	public function get_sorg() { return $this->sorg; }
	public function get_sdes() { return $this->sdes; }
	
	public static function loadsites($sys_file)
	{
		$z=0;
		$a=[];
		$xml= simplexml_load_file($sys_file);
		$nrs= (int) $xml->snr;
		
		for($i=1; $i<=$nrs; $i++)
		{
			$node_name="ss".$i;
			$k=0;
			$ss=$xml->sites->$node_name;
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
			$a[$z]=new Sys($jnr, $jtitle, $jdir, $jfile, $jdate, $jorg, $jdes);
			$z++;
		}
		return $a;
	}
	
}



?>






