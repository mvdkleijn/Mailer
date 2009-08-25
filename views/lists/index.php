<?php

	$settings = Plugin::getAllSettings('mailer');

	$apikey			=	$settings['apikey'];
	$username		=	$settings['username'];
	$password		=	$settings['password'];
	$apiUrl			=	$settings['apiUrl'];
	$my_email		=	$settings['testEmail'];
	$boss_man_email	=	$settings['bossEmail'];

?>

<h1>Available Lists</h1>

<?php

	$api = new MCAPI($apikey);	
	$lists = $api->lists();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else { ?>


<p>For most purposes there should <strong>only be one list</strong>. If you need to add different mailing groups, <a href="<?php echo get_url('plugin/mailer/groups/add'); ?>">you can do so here</a>, but they should all be part of the same list.</p>

<p>If you do need to create a list, you need to do so at <a href="http://us1.admin.mailchimp.com/lists/">MailChimp</a> - they do not, and are not planning, support for adding lists via their API so you won't be able to do so from this interface. However, if you decide to add one, you will be able to manipulate and send email to it from here.</p>

<table id="lists" class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th class="name">Name</th>
			<th class="subscribers">Subscribers</th>
		</tr>
	</thead>
	<tbody>
<?php
		foreach ($lists as $list) { ?>
		<tr class="<?php echo odd_even(); ?>">
			<td>
				<a href="<?php echo get_url('plugin/mailer/viewlist/'); echo $list['id']; ?>"><?php echo $list['name']; ?></a></td>
			<td><?php echo $list['member_count']; ?></td>
		</tr>
<?php	}
?>
	</tbody>
</table>

<p>If you'd like to learn a little more about why you should only set up one list in most circumstances please watch this video. Obviously, the interface you will be using is different but this explains the difference.</p>
<embed src="http://blip.tv/play/gtRe9KtEk8cS%2Em4v" type="application/x-shockwave-flash" width="380" height="266" allowscriptaccess="always" allowfullscreen="true"></embed>

<?php } ?>
