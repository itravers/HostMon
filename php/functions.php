<?php
	function getDBOptions(){
		$dbOptions = array();
		$lines = file('../cfg/db.cfg');
		foreach ($lines as $line_num => $line) {
			if (strpos($line, 'DB:') !== FALSE){
				$end = strpos($line, ';');
				$start = strpos($line, ':')+1;
				$length = $end - $start;
				$dbName = substr($line, $start, $length);
				$dbOptions["DB"] = $dbName;
			}else if (strpos($line, 'USER:') !== FALSE){
				$end = strpos($line, ';');
				$start = strpos($line, ':')+1;
				$length = $end - $start;
				$user = substr($line, $start, $length);
				$dbOptions["USER"] = $user;
			}else if (strpos($line, 'PASS:') !== FALSE){
				$end = strpos($line, ';');
				$start = strpos($line, ':')+1;
				$length = $end - $start;
				$pass = substr($line, $start, $length);
				$dbOptions["PASS"] = $pass;
			}else if (strpos($line, 'IP:') !== FALSE){
				$end = strpos($line, ';');
				$start = strpos($line, ':')+1;
				$length = $end - $start;
				$ip = substr($line, $start, $length);
				$dbOptions["IP"] = $ip;
			}else{
				//any other lines including blanks will be skipped
			}
		}
		return $dbOptions;
	}
?>