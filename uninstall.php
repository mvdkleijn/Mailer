<?php

	if (Plugin::deleteAllSettings('mailer') === false) {
		Flash::set('error', __('We had a problem uninstalling the plugin settings.'));
		redirect(get_url('setting'));
	}
	else {
		Flash::set('success', __('You\'ve succesfully uninstalled the Mailer plugin.'));
		redirect(get_url('setting'));
	}