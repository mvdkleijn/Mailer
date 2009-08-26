<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);

	// to do - add abuse header
	$abuse = $api->campaignAbuseReports($cid);




echo '<pre>';
	$campaignStats = $api->campaignStats($cid);
	print_r($campaignStats);
echo '<hr />';
	$campaignClickStats = $api->campaignClickStats($cid);
	print_r($campaignClickStats);
echo '<hr />';
	$campaigns = $api->campaigns();
	print_r($campaigns);
echo '</pre>';




//	$campaignContent = $api->campaignContent($cid);

	$advice = $api->campaignAdvice($cid);



	echo $advice['0']['type'];
echo '<br />';
	echo $advice['0']['msg'];

?>
