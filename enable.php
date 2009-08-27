<?php

	global $__CMS_CONN__;
	$sql = "	INSERT INTO `".TABLE_PREFIX."plugin_settings` (`plugin_id`,`name`,`value`)
				VALUES
					('mailer','apikey',''),
					('mailer','apiUrl','http://api.mailchimp.com/1.2/'),
					('mailer','testEmail',''),
					('mailer','senderemail',''),
					('mailer','fromname',''),
					('mailer','subject',''),
					('mailer','googleDisplay','1'),
					('mailer','showLists','1'),
					('mailer','showListsBox','1'),
					('mailer','showGroups','1'),
					('mailer','showFolders','1'),
					('mailer','showCampaigns','1'),
					('mailer','showCampaignsBox','1'),
					('mailer','showMembersBox','1'),
					('mailer','showSettingsBox','1'),
					('mailer','showSearch','1'),
					('mailer','configured','0'),
					('mailer','active','1');";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

	$sql = "	UPDATE ".TABLE_PREFIX."plugin_settings
				SET	`value`='1'
				WHERE plugin_id='mailer' AND name='active'";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

	exit();