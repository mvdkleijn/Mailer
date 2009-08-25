<?php

	global $__CMS_CONN__;
	$sql = "	UPDATE ".TABLE_PREFIX."plugin_settings
				SET	`value`='0'
				WHERE plugin_id='mailer' AND name='active'";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

	exit();