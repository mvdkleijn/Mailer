<?php

	global $__CMS_CONN__;
	$sql = "DELETE FROM ".TABLE_PREFIX."plugin_settings WHERE plugin_id='mailer'";
	$pdo = $__CMS_CONN__->prepare($sql);
	$pdo->execute();

	exit();