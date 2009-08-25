<?php

Plugin::setInfos(array(
	'id'  			=> 'mailer',
	'title'   		=> 'Mailer',
	'description'	=> 'Newsletter Plugin using MailChimp\'s API',
	'version' 		=> '0.1',
   	'license' 		=> 'GPL',
	'author'  		=> 'Andrew Waters',
	'website' 		=> 'http://www.band-x.org/',
	'require_wolf_version' => '0.5.5'
));

Plugin::addController('mailer', 'Mailer', 'administrator', true);

include('models/mcapi.php');