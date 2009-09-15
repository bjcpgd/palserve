<?php 
/* Host Controller */

$_REQUEST['layout'] = 'main';


function hosts_index() {
	
	hosts_list();
	
}


function hosts_list() {
	$_GET['action'] = 'list';
	global $hosts;
	global $baseurl;
	$h = new Host;
	$hosts = $h->find();
	

	
	if($_POST) {
			$user_id = $_POST['user_id'];
		foreach($_POST['prefs'] as $pref=>$value) {
			
			$prefArgs = split('_',$pref);
			
			$host_id = $prefArgs[0];
			$port = $prefArgs[1];
			
			$host = new Host;
			$host = $host->find($host_id);
			
			
			$uap = new user_alert_preference;
			
			//Figure out if a preference for this user, host and port exist
			
			if($uap = $uap->find("WHERE host_id = $host_id AND port = $port and user_id = $user_id")) {
				$uap[0]->preference = $value;
				$uap[0]->save();
				header("Location: $baseurl");
			} else {
				//Create a new one
				$uap = new user_alert_preference;
				$uap->host_id = $host_id;
				$uap->user_id = $user_id;
				$uap->port = $port;
				$uap->preference = $value;
				$uap->save();
					header("Location: $baseurl");
			
			}
			
			//echo $host_id." | ".$port." | ".$user_id."<br/>";
			
		}
	}
	
   	render();
}

function hosts_new() {

	if($_POST) {
		$h = new Host;
		$h->save($_POST);
		update_scan_script();
		render('show',$h->id);
		
	}	
	
	render();
}


function hosts_show() {
	
	global $host;
	$host = new Host;
	$host = $host->find($_GET['id']);
	
	
	render();
}


function hosts_edit() {
	
	global $host;
	$host = new Host;
	$host = $host->find($_GET['id']);
	
	if($_POST) {
	
		if($host->save($_POST)) {
			
			//We need to update the bash script
			
			update_scan_script();
			
			render('show',$_GET['id']);
		}
	}
	
	render();
}

function hosts_delete() {
	global $host;
	$host = new Host;
	$host = $host->find($_GET['id']);
	
	if($host->delete()) {
		render('list');
	}
}




function update_scan_script() {
	
	//We are going to create an nmap script for every host and all their ports, and save the results in XML
	global $hosts;
	$h = new Host;
	$hosts = $h->find();
	foreach($hosts as $host) {
		
		$ports = $host->ports;
		$name = $host->name;
		
		$cmd[] = "#!/bin/bash
cd /var/www/admin/scan/commands
#SCAN for $name
nmap -P0 -O -p $ports $name -oX ../results/$name.xml -oG ../results/$name.txt --stylesheet ../nmap.xsl > /dev/null
";
	
	}
	
	$script = "#!/bin/bash\n
#The nmap commands
".implode('',$cmd)."
### END of COMMANDS ###\n";
	
	file_put_contents('commands/run_scan.sh',$script);
	
}



?>
