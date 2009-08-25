<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);

?>
<h1>Viewing Group: "<?php echo $_GET['name']; ?>"</h1>
<?php

	$members = $api->listMembers($_GET['list'], 'subscribed', null, 0, 15000);

?>

<table id="subscribers" class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th class="fname">First Name</th>
			<th class="lname">Last Name</th>
			<th class="email">Email</th>
			<th class="timestamp">Signed up on</th>
			<th class="edit">Edit</th>
		</tr>
	</thead>
	<tbody>
<?php
		foreach ($members as $member) {
			$memberinfo = $api->listMemberInfo($_GET['list'], $member['email']);
			$interests = $memberinfo['merges']['INTERESTS'];
			$thisgroup = $_GET['name'];
			$pos = strpos($interests, $thisgroup);
			if ($pos === false) {
			} else {
?>
		<tr class="<?php echo odd_even(); ?>">
			<td><?php echo $memberinfo['merges']['FNAME']; ?></td>
			<td><?php echo $memberinfo['merges']['LNAME']; ?></td>
			<td><?php echo $memberinfo['email']; ?></td>
			<td><?php
						$time = $memberinfo['timestamp'];
						$time = substr($time, 0, 10);
						echo $time;
			?></td>
			<td><a href="<?php echo get_url('plugin/mailer/members/edit?userid='.$memberinfo['id'].'&email='.$memberinfo['email'].''); ?>"><img src="../wolf/plugins/mailer/images/membersLink.png" align="middle" alt="Edit User" /></a> <a href="<?php echo get_url('plugin/mailer/members/unsubscribe?listid='.$_GET['list'].'&email='.$memberinfo['email'].'&name='.$_GET['name'].''); ?>" onclick="return confirm('Unsubscribing a member is irreversible. Are you sure you want to do this?')"><img src="images/icon-remove.gif" align="middle" alt="Unsubscribe this user" /></a></td>
		</tr>
<?php	}
} ?>
	</tbody>
</table>

<p><a href="<?php echo get_url('plugin/mailer/groups'); ?>"><img src="../wolf/plugins/mailer/images/backButton.png" align="middle" alt="Back Button" /> Back to Groups</a></p>