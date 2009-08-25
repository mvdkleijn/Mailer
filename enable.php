<?php

	global $__CMS_CONN__;
	$sql = "	INSERT INTO `".TABLE_PREFIX."plugin_settings` (`plugin_id`,`name`,`value`)
				VALUES
					('mailer','apikey',''),
					('mailer','username',''),
					('mailer','password',''),
					('mailer','apiUrl','http://api.mailchimp.com/1.2/'),
					('mailer','testEmail',''),
					('mailer','bossEmail',''),
					('mailer','senderemail',''),
					('mailer','fromname',''),
					('mailer','subject',''),
					('mailer','showLists','1'),
					('mailer','showGroups','1'),
					('mailer','showCampaigns','1'),
					('mailer','configured','0');";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

	exit();