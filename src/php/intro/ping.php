<?

// executar o ping no shell
function requestICMP($domain, $count=4, $packetsize=56, $interval=1, $timeout=5, $ttl=64){
	$result = shell_exec("ping -c $count -s $packetsize -i $interval -W $timeout -t $ttl $domain");
	return $result;
}

function requestICMPbyArray(values){
	$domain = $value["domain"];
	$count=4; 
	$packetsize=56;
	$interval=1;
	$timeout=5;
	$ttl=64
	$result = shell_exec("ping -c $count -s $packetsize -i $interval -W $timeout -t $ttl $domain");
	return "";
}

// echo requestICMP("8.8.8.8");
echo requestICMPbyArray(["domain"=>"8.8.8.8", "interval"=>10]);