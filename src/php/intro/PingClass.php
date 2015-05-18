<pre>
<?php

class PingClass{

	private $domain;
	private $count=4; 
	private $packetsize=56;
	private $interval=1;
	private $timeout=5;
	private $ttl=64;

	public function __construct(){
	}

	public function loadData($domain, $count=4, $packetsize=56, $interval=1, $timeout=5, $ttl=64){
		$this->domain = $domain;
		$this->count = $count;
		$this->packetsize = $packetsize;
		$this->interval = $interval;
		$this->timeout = $timeout;
		$this->ttl = $ttl;
	}

	public function loadDataByArray($values){
		foreach($values as $key=>$value){
			$this->$key = $value;
		}
	}

	public function request(){
		$command = "ping -c {$this->count} -s {$this->packetsize} -i {$this->interval} -W {$this->timeout} -t {$this->ttl} {$this->domain}";
		$result = shell_exec($command);
		return $this->resultToJson($result);
	}

	public function resultToJson($resultString){
		$resultJson = [];

		// ip
		preg_match("/\(([\d\.]*)\)/", $resultString, $matches);
		$resultJson["ip"] = $matches[1];

		// icmps
		preg_match_all("/icmp_seq=(\d+)/", $resultString, $sequence);
		preg_match_all("/ttl=(\d+)/", $resultString, $ttl);
		preg_match_all("/time=(\d+)/", $resultString, $time);
		// print_r($time);

		$resultJson["icmps"] = [];
		for($flag = 0; $flag < sizeof($sequence[1]);$flag++){
			$icmp = [];
			$icmp["sequence"] = $sequence[1][$flag];
			$icmp["ttl"] = $ttl[1][$flag];
			$icmp["time"] = $time[1][$flag];
			$resultJson["icmps"][] = $icmp;
		}

		//statistics
		$resultJson["statistis"] = [];
		$resultJson["statistis"]["time"] = 1;
		$resultJson["statistis"]["packets_transmitted"] = 1;
		$resultJson["statistis"]["packets_received"] = 1;
		$resultJson["statistis"]["rtt_min"] = 1;
		$resultJson["statistis"]["rtt_avg"] = 1;
		$resultJson["statistis"]["rtt_max"] = 1;
		$resultJson["statistis"]["rtt_mdev"] = 1;

		return json_encode($resultJson);
	}

	public function toString(){
		return "domain {$this->domain}\n".
		"count {$this->count}\n".
		"packetsize {$this->packetsize}\n".
		"interval {$this->interval}\n".
		"timeout {$this->timeout}\n".
		"ttl {$this->ttl}";
	}

}

$ping = new PingClass();
// $ping->loadData("8.8.8.8");
$ping->loadDataByArray(["domain"=>"8.8.8.8", "count"=>3, "interval"=>1]);
// echo $ping->toString();
echo $ping->request();
?>
</pre>