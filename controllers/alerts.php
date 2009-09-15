<?php
$_REQUEST['layout'] = 'main';

function alerts_list() {
	
	//Go through all the hosts and determine if any alerts should be created
	
	global $hosts;
	$h = new Host;
	$hosts = $h->find();
	
	$alerts = new Alert;
	
	foreach($hosts as $host) {
		foreach($host->ports() as $port) {
			$status = $host->get_port_status($port,true);
			if($status == 0) {
				
				
				if($alert = $alerts->find("WHERE host_id = ".$host->id." AND port = ".$port)) {
					//There is already an alert for this, go through each user and see what their preference for this port is
				
					send_user_alerts($host->id,$port,$alert->id,'all');
				} else {
					
					
					
					$alert = new alert();
					$alert->message = "HOST: ".$host->name."PORT: ".$port."";
					$alert->user_id = 1;
					$alert->host_id = $host->id;
					$alert->port = $port;
					$alert->sent_on = time();
				
					$alert->save();
						send_user_alerts($host->id,$port,$alert->id,'single');
					//Go through each user and determine what their preference for this port is.
				}
			} else {
				
				//The port is up, but we need to set up reports if there is an existing one!
					if($alert = $alerts->find("WHERE host_id = ".$host->id." AND port = ".$port)) {
						//There is already an alert for this, go through each user and see what their preference for this port is
						send_user_alerts($host->id,$port,$alert->id,'single');
					}
			}
		}
	}
		
	render();
}


function send_user_alerts($host_id,$port,$alert_id,$status) {




	$host = new Host;
	$host = $host->find($host_id);
	
	$alert = new Alert;
	$alert = $alert->find($alert_id);
	
	foreach($host->user_alert_preferences as $pref) {
		
		
		if($pref->preference == $status || $pref->preference == 'all') {
			
			if($alert[0]->validate()) {
				$alert[0]->status = 'DOWN';
				$alert[0]->message = "HOST: ". $host->name . " port: ". $alert[0]->port ." is DOWN";
			} else {
				$alert[0]->status = 'UP';
				$alert[0]->message = "HOST: ". $host->name . " port: ". $alert[0]->port . " is UP";
				$alert[0]->delete();
			}
			
			
			if(mail($pref->user->email,"HOST ".$alert[0]->status." alert",$alert[0]->message,'From: ciastech@rit.edu')) {
				global $notice;
				$notice .= 'sending a message to '.$pref->user->name. " at ". $pref->user->email. " MESSAGE: ".$alert[0]->message;
			} else {
				global $error;
				$error .= "Error sending email to ".$pref->user->email;
			}
			
			
		}
	} 
	
	
	}


?>