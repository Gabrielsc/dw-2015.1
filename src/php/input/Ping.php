<?php

class Ping{

	private $domain;
	private $count = 4; 
	private $packetsize = 56;
	private $interval = 1;
	private $timeout = 5;
	private $ttl = 64;

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
		// return $result;
		return $this->resultToJson($result);
	}

	public function resultToJson($resultString){
		$resultJson = [];

		// ip
		preg_match("/\(([\d\.]+)\)/", $resultString, $matches);
		$resultJson["ip"] = $matches[1];

		// icmps
		preg_match_all("/icmp_seq=(\d+)/", $resultString, $sequence);
		preg_match_all("/ttl=(\d+)/", $resultString, $ttl);
		preg_match_all("/time=(\d+)/", $resultString, $time);

		$resultJson["icmps"] = [];
		for($flag = 0; $flag < sizeof($sequence[1]);$flag++){
			$icmp = [];
			$icmp["sequence"] = $sequence[1][$flag];
			$icmp["ttl"] = $ttl[1][$flag];
			$icmp["time"] = $time[1][$flag];
			$resultJson["icmps"][] = $icmp;
		}

		//statistics
		$resultJson["statistics"] = [];
		preg_match("/(\d+)ms/", $resultString, $time);
		$resultJson["statistics"]["time"] = $time[1];
		preg_match("/(\d+) packets transmitted/", $resultString, $packetsTransmitted);
		$resultJson["statistics"]["packetsTransmitted"] = $packetsTransmitted[1];
		preg_match("/(\d+) received/", $resultString, $packetsReceived);
		$resultJson["statistics"]["packetsReceived"] = $packetsReceived[1];
		preg_match("/([\d\.]+)\/([\d\.]+)\/([\d\.]+)\/([\d\.]+) ms/", $resultString, $rtt);
		$resultJson["statistics"]["rtt_min"] = $rtt[1];
		$resultJson["statistics"]["rtt_avg"] = $rtt[2];
		$resultJson["statistics"]["rtt_max"] = $rtt[3];
		$resultJson["statistics"]["rtt_mdev"] = $rtt[4];

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