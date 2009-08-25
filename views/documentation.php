<?php

	AuthUser::load();
	$username = AuthUser::getRecord()->username;
	$propername = AuthUser::getRecord()->name;

?><h1>Documentation</h1>

<p>You'll need to set up this plugin properly before you can use it.</p>

<p>You're also going to have to <a href="http://www.mailchimp.com/signup/">sign up to MailChimp</a> if you haven't already. Once you have, you need only perform a couple of actions when you're account is live. First of all you need to set yourself up a new list. See this video for instructions:</p>

<embed src="http://blip.tv/play/gtRe6ulMk8cS%2Em4v" type="application/x-shockwave-flash" width="380" height="266" allowscriptaccess="always" allowfullscreen="true"></embed> 

<p>Then you need to <a href="http://admin.mailchimp.com/account/api">apply for a developer key</a> which you can then <a href="<?php echo get_url('plugin/mailer/settings'); ?>">paste into your settings</a> along with some more information about how you want to set up your system. Be sure to complete ALL of the settings, otherwise his plugin may not behave as expected.</p>