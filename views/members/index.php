<h1>Members</h1>

<?php

	$settings = Plugin::getAllSettings('mailer');

	$api = new MCAPI($settings['apikey']);

	$lists = $api->lists();

	if ($api->errorCode) {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There is a problem with the MailChimp API - have you set up your API key yet?<br />The plugin is receiving the response that '.$api->errorMessage.'</div>';
	} else { ?>

<p>Below is a list of all members of all your lists (in all your groups). <strong>In other words, everyone.</strong></p>

<table id="subscribers" class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th class="fname">First Name</th>
			<th class="lname">Last Name</th>
			<th class="email">Email</th>
			<th class="timestamp">Subscribed Since</th>
			<th class="group">List</th>
			<th class="group">Group(s)</th>
			<th class="edit">Edit</th>
		</tr>
	</thead>
	<tbody>

<?php
	foreach ($lists as $list){

		$members = $api->listMembers($list['id'], 'subscribed', null, 0, 15000 );		

		foreach ($members as $member) {
			$memberinfo = $api->listMemberInfo($list['id'], $member['email']);
?>
		<tr class="<?php echo odd_even(); ?>">
			<td><?php echo $memberinfo['merges']['FNAME'] ?></td>
			<td><?php echo $memberinfo['merges']['LNAME'] ?></td>
			<td><?php echo $memberinfo['email']; ?></td>
			<td><?php 
						$time = $memberinfo['timestamp'];
						$time = substr($time, 0, 10);
						echo $time;
				 ?></td>
			<td><?php echo $list['name']; ?></td>
			<td><?php
			 			$membersgroups = explode(', ', $memberinfo['merges']['INTERESTS']);
						foreach($membersgroups as $group) {
							if($group != '') {
								echo '<a href="'.get_url('plugin/mailer/groups/view?name='.$group.'&list='.$list['id'].'">'.$group.'</a> ');
							}
						}
			?></td>
			<td><a href="<?php echo get_url('plugin/mailer/members/edit?userid='.$memberinfo['id'].'&email='.$memberinfo['email'].''); ?>"><img src="../wolf/plugins/mailer/images/membersLink.png" align="middle" alt="Edit User" /></a> <a href="<?php echo get_url('plugin/mailer/members/unsubscribe?listid='.$list['id'].'&email='.$memberinfo['email'].'&list='.$list['id'].'&ref=members'); ?>" onclick="return confirm('Unsubscribing a member is irreversible. Are you sure you want to do this?')"><img src="images/icon-remove.gif" align="middle" alt="Delete" /></a></td>
		</tr>
<?php	} ?>

<?php } ?>

	</tbody>
</table>

<?php } ?>