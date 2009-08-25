<h1>Campaigns</h1>

<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);
	$campaigns = $api->campaigns();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else {
?>

<p>You have ran <?php echo sizeof($campaigns); ?> campaigns to date.</p>

<?
		foreach($campaigns as $campaign){
			echo "<p>Campaign Id: ".$campaign['id']." <br /> ".$campaign['title']."<br />";
			echo "\tStatus: ".$campaign['status']." <br /> type = ".$campaign['type']."<br />";
			echo "\tsent: ".$campaign['send_time']." to ".$campaign['emails_sent']." members</p>";
		}
	}