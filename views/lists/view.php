<?php

	$settings = Plugin::getAllSettings('mailer');

	$api = new MCAPI($settings['apikey']);

	$lists = $api->lists();

	foreach ($lists as $list){
		if($list['id'] == $id) {
			$listName = $list['name'];
			$listid = $list['id'];
		}
	}

?>

<h1>Viewing List: "<?php echo $listName ?>"</h1>

<?php

	$reports = $api->listAbuseReports($id);
	$count = count($reports);

	if($count == 0) {
		echo '<div class="abuseClear"><img src="../wolf/plugins/mailer/images/misc/abuseClear.png" align="center" alt="Clear!" /> There are no Abuse Reports for this list</div>';
	}
	else {
		echo '<div class="abuseReports"><img src="../wolf/plugins/mailer/images/misc/abuseProblem.png" align="center" alt="Clear!" /> There have been Abuse Reports for this list:';
		foreach($reports as $rpt) {
			$campaignUrl = get_url('plugin/mailer/viewcampaign/');
			echo 'Reported by '.$rpt['email'].' on '.$rpt['date'].' about <a href="'.$campaignUrl.''.$rpt['campaign_id'].'">one of your campaigns</a>';
		}	
		echo '</div>';
	}

	$members = $api->listMembers($id, 'subscribed', null, 0, 15000 );
	$history = $api->listGrowthHistory($id);
	$history = array_slice($history, 0, 11);
?>

<hr />

<h3>List Growth over last 12 months</h3>


<ul class="timeline">
<?php

	$i = 0;
	$additions = array();
	foreach($history as $month) {
		$additions[$i] = $month['imports'] + $month['optins'];
		$i = $i + 1;
	}
	$highest = max($additions);
	$multiple = 100 / $highest;

	foreach($history as $h) {
		$date = $h['month'];
		$date = explode('-', $date);
		$year = $date['0'];
		$month = $date['1'];
		switch($month) {
			case '01':
				$month = 'January';
				break;
			case '02':
				$month = 'February';
				break;
			case '03':
				$month = 'March';
				break;
			case '04':
				$month = 'April';
				break;
			case '05':
				$month = 'May';
				break;
			case '06':
				$month = 'June';
				break;
			case '07':
				$month = 'July';
				break;
			case '08':
				$month = 'August';
				break;
			case '09':
				$month = 'September';
				break;
			case '10':
				$month = 'October';
				break;
			case '11':
				$month = 'November';
				break;
			case '12':
				$month = 'December';
				break;
		}
		$existing = $h['existing'];
		$imports = $h['imports'];
		$optins = $h['optins'];
		$totalMonth = $imports + $optins;
		$percentage = $totalMonth * $multiple;

?>
	<li>
		<a href="<?php echo get_url('plugin/mailer/viewlist/'.$id.''); ?>#" title="<?php echo $month ?> <?php echo $year ?>: <?php echo $totalMonth ?> new subscribers (<?php echo ($existing + $totalMonth); ?> total)">
		<span class="label"><?php echo $month ?></span>
		<span class="count" style="height: <?php echo $percentage ?>%">(<?php echo $totalMonth ?>)</span>
		</a>
	</li>
<?php
	}
?>
</ul>

<hr />

<h3>Subscribers</h3>

<p>There are <?php echo sizeof($members); ?> subscribers on "<?php echo $listName ?>"</p>

<table id="subscribers" class="index" cellpadding="0" cellspacing="0" border="0">
	<thead>
		<tr>
			<th class="fname">First Name</th>
			<th class="lname">Last Name</th>
			<th class="email">Email</th>
			<th class="prefs">Pref</th>
			<th class="timestamp">Signed up on</th>
			<th class="group">Group(s)</th>
			<th class="edit">Edit</th>
		</tr>
	</thead>
	<tbody>
<?php
		foreach ($members as $member) {
			$memberinfo = $api->listMemberInfo($id, $member['email']);
?>
		<tr class="<?php echo odd_even(); ?>">
			<td><?php echo $memberinfo['merges']['FNAME'] ?></td>
			<td><?php echo $memberinfo['merges']['LNAME'] ?></td>
			<td><?php echo $memberinfo['email']; ?></td>
			<td><?php echo $memberinfo['email_type']; ?></td>
			<td><?php 
						$time = $memberinfo['timestamp'];
						$time = substr($time, 0, 10);
						echo $time;
				 ?></td>
			<td><?php
			 			$membersgroups = explode(', ', $memberinfo['merges']['INTERESTS']);
						foreach($membersgroups as $group) {
							if($group != '') {
								echo '<a href="'.get_url('plugin/mailer/groups/view?name='.$group.'&list='.$id.'">'.$group.'</a> ');
							}
						}
			?></td>
			<td><a href="<?php echo get_url('plugin/mailer/members/edit?userid='.$memberinfo['id'].'&email='.$memberinfo['email'].''); ?>"><img src="../wolf/plugins/mailer/images/membersLink.png" align="middle" alt="Edit User" /></a> <a href="<?php echo get_url('plugin/mailer/members/unsubscribe?listid='.$id.'&email='.$memberinfo['email'].'&list='.$listid.''); ?>" onclick="return confirm('Unsubscribing a member is irreversible. Are you sure you want to do this?')"><img src="images/icon-remove.gif" align="middle" alt="Delete" /></a></td>
		</tr>
<?php	} ?>
	</tbody>
</table>

<p>&nbsp;</p>
<p><a class="backButton" href="<?php echo get_url('plugin/mailer/lists'); ?>"><img src="../wolf/plugins/mailer/images/backButton.png" align="middle" alt="Back Button" /> Back to Lists</a></p>