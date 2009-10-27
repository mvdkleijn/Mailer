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

Dispatcher::addRoute(array(

	'/mailer'						=>	'/plugin/mailer/index',
	'/mailer/'						=>	'/plugin/mailer/index',

	'/mailer/settings'				=>	'/plugin/mailer/settings',
	'/mailer/saveSettings'			=>	'/plugin/mailer/saveSettings',

	'/mailer/campaigns'				=>	'/plugin/mailer/campaigns',
	'/mailer/campaigns/'			=>	'/plugin/mailer/campaigns',
	'/mailer/campaigns/:any'		=>	'/plugin/mailer/campaigns/$1',
	
	'/mailer/viewcampaign'			=>	'/plugin/mailer/viewcampaign',
	'/mailer/viewcampaign/'			=>	'/plugin/mailer/viewcampaign',
	'/mailer/viewcampaign/:any'		=>	'/plugin/mailer/viewcampaign/$1',

	'/mailer/campaignDelete/:any'	=>	'/plugin/mailer/campaignDelete/$1',

	'/mailer/sendtest/:any'			=>	'/plugin/mailer/sendtest/$1',
	'/mailer/sendcampaign/:any'		=>	'/plugin/mailer/sendcampaign/$1',

	'/mailer/folders'				=>	'/plugin/mailer/folders',
	'/mailer/folders/:any'			=>	'/plugin/mailer/folders/$1',
	'/mailer/folderAdd'				=>	'/plugin/mailer/folderAdd',

	'/mailer/lists'					=>	'/plugin/mailer/lists',
	'/mailer/lists/'				=>	'/plugin/mailer/lists',
	'/mailer/viewlist/:any'			=>	'/plugin/mailer/viewlist/$1',

	'/mailer/groups'				=>	'/plugin/mailer/groups',
	'/mailer/groups/'				=>	'/plugin/mailer/groups',
	'/mailer/groups/:any'			=>	'/plugin/mailer/groups/$1',
	'/mailer/groupAdd'				=>	'/plugin/mailer/groupAdd',
	'/mailer/groupUpdate'			=>	'/plugin/mailer/groupUpdate',
	'/mailer/groupDelete/:any'		=>	'/plugin/mailer/groupDelete/$1',

	'/mailer/members'				=>	'/plugin/mailer/members',
	'/mailer/members/'				=>	'/plugin/mailer/members',
	'/mailer/members/:any'			=>	'/plugin/mailer/members/$1',
	'/mailer/memberAdd'				=>	'/plugin/mailer/memberAdd',
	'/mailer/memberUpdate'			=>	'/plugin/mailer/memberUpdate',
	'/mailer/memberDelete/:any'		=>	'/plugin/mailer/memberDelete/$1',

	'/mailer/viewgroups'			=>	'/plugin/mailer/viewgroups',
	'/mailer/viewgroups/'			=>	'/plugin/mailer/viewgroups',
	'/mailer/viewgroups/:any'		=>	'/plugin/mailer/viewgroups/$1',

	'/mailer/documentation'			=>	'/plugin/mailer/documentation',

	'/mailer/setupAnalytics'		=>	'/plugin/mailer/setupAnalytics',
	'/mailer/saveAnalyticsState'	=>	'/plugin/mailer/saveAnalyticsState',

));