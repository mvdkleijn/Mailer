== WHAT IT IS ==

The Mailer plugin is a mailing list management plugin that uses the MailChimp API
to manage subscriptions and send email newsletters to large groups.

The aim of this plugin is to be as light as possible on the core and use as many
features as MailChimp offer through their web service.

It provides the following features:
- Group Management for list segmentation
- HTML and Plain Text newsletter creation
- Subscribe / Unsubscribe forms for the front of the site

== HOW TO USE IT ==

* First of all you need to sign up for a free (or paid) account with MailChimp
* Set up an initial "List" with MailChimp (this has to be done via their interface)
* Upload this plugin to your plugin directory
* Enable the plugin via the administration panel
* Start using the plugin!

== NOTES ==

* This plugin uses the 32px Mania icon set provided by the awesome Midtone Design:
  http://www.midtonedesign.com

* You need a MailChimp account. You can sign up for a free test account to evaluate it
  and this plugin.

* You need to set up the first list via the MailChimp interface. They do not allow lists
  to be created via their API.

* The current limit for lists is 15,000. There's no pagination built in yet.
  Maybe later folks ;)

== TODO ==

* Allow editing of email addresses
* Consider using Webhooks and integrating with Dashboard plugin or create one for Mailer
* Ability to search through Lists in admin section
* Form generation
* Emails - optin/welcome/confirm
* Batch Import/Exports of Lists from/to CSV Files
* CAMPAIGNS!

* API Calls not used but look useful:
	generateText
	createFolder
	inlineCss
	All AIM methods



== LICENSE ==

Copyright 2009, Andrew Waters <andrew@band-x.org>
This plugin is licensed under the GPLv3 License.
<http://www.gnu.org/licenses/gpl.html>