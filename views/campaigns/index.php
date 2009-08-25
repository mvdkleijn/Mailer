<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);
	$campaigns = $api->campaigns();

?>

<h1>Campaigns</h1>

<p>You have ran <?php echo sizeof($campaigns); ?> campaigns to date.</p>

<?
	foreach($campaigns as $campaign){
		echo "<p>Campaign Id: ".$campaign['id']." <br /> ".$campaign['title']."<br />";
		echo "\tStatus: ".$campaign['status']." <br /> type = ".$campaign['type']."<br />";
		echo "\tsent: ".$campaign['send_time']." to ".$campaign['emails_sent']." members</p>";
	}