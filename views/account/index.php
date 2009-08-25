<?php

	$settings = Plugin::getAllSettings('mailer');
	$api = new MCAPI($settings['apikey']);
	$account = $api->getAccountDetails($settings['apikey']);

?>
<h1>MailChimp Account Details</h1>

<table class="fieldset" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="2" class="help"><strong>User Details</strong></td>
	</tr>
	<tr>
		<td class="label"><small>Username</small></td>
		<td class="field"><?php echo $account['username']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>User ID</small></td>
		<td class="field"><?php echo $account['user_id']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Your Affiliate Link</small></td>
		<td class="field"><a href="<?php echo $account['affiliate_link']; ?>" target="_blank">Click Here</a></td>
	</tr>
	<tr>
		<td colspan="2" class="help"><strong>Your Contact Details</strong></td>
	</tr>
<?php foreach($account['contact'] as $key => $value) { ?>
	<tr>
		<td class="label"><small><?php echo ucwords($key); ?></small></td>
		<td class="field"><?php echo $value; ?></td>
	</tr>

<?php } ?>
	<tr>
		<td colspan="2" class="help"><strong>Your Account</strong></td>
	</tr>
	<tr>
		<td class="label"><small>Plan Type</small></td>
		<td class="field"><?php echo $account['plan_type']; ?></td>
	</tr>
<?php if($account['plan_type'] != 'monthly') { ?>
	<tr>
		<td class="label"><small>Emails Left</small></td>
		<td class="field"><?php echo $account['emails_left']; ?></td>
	</tr>
<?php } ?>
<?php if($account['plan_type'] == 'monthly') { ?>
	<tr>
		<td class="label"><small>Plan Start Date</small></td>
		<td class="field"><?php echo $account['plan_start_date']; ?></td>
	</tr>
	<tr>
		<td colspan="2" class="help"><strong>Payment Info</strong></td>
	</tr>
	<tr>
		<td class="label"><small>Most Recent Payment</small></td>
		<td class="field"><?php echo $account['last_payment']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>First Payment</small></td>
		<td class="field"><?php echo $account['first_payment']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Times Logged in / API Calls</small></td>
		<td class="field"><?php echo $account['times_logged_in']; ?></td>
	</tr>
	<tr>
		<td class="label"><small>Last Login</small></td>
		<td class="field"><?php echo $account['last_login']; ?></td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="2" class="help"><strong>Addons</strong></td>
	</tr>
<?php foreach($account['addons'] as $key => $value) { ?>
	<tr>
		<td class="label"><small><?php echo ucwords($key); ?></small></td>
		<td class="field"><?php echo $value; ?></td>
	</tr>
<?php } ?>
	<tr>
		<td colspan="2" class="help"><strong>Orders</strong></td>
	</tr>
<?php foreach($account['orders'] as $key => $value) { ?>
	<tr>
		<td class="label"><small><?php echo ucwords($key); ?></small></td>
		<td class="field"><?php echo $value; ?></td>
	</tr>
<?php } ?>
</table>
