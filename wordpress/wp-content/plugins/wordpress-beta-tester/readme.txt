# WordPress Beta Tester

Tags: beta, advanced, testing
Contributors: westi, mlteal, afragen, pbiron
Tested up to: 5.4
Requires at least: 3.1
Stable Tag: 2.2.10
License: GPLv2
License URI: https://www.opensource.org/licenses/GPL-2.0
Requires PHP: 5.2.4

Allows you to easily upgrade to Beta releases.

## Description
This plugin provides an easy way to get involved with Beta testing WordPress.

Once installed it will enable you to upgrade your website to the latest Beta or Release candidate at the click of a button using the built in upgrader.

By default once enabled it switches your website onto the point release development track.

For the more adventurous there is the option to switch to the bleeding edge (trunk) of development.

Don't forget to backup before you start!

### Extra Settings

There is a setting to **Skip successful autoupdate emails**.  It functions to disable sending emails to the admin user for successful autoupdates. Only emails indicating failures of the autoupdate process are sent.

The **Extra Settings** tab may contain choices for testing new features in trunk that require constants to be set. A checked feature will add a constant to the user's `wp-config.php` file in the format as follows:

`define( 'WP_BETA_TESTER_{$feature}', true );`

Unchecking the feature will remove the constant.

This plugin resets the constants in `wp-config.php` on plugin activation and removes them on plugin deactivation. Use the filter `wp_beta_tester_config_path` to return a non-standard `wp-config.php` file path.

If no settings are present there is no testing to be done that requires this feature.

PRs are welcome on [GitHub](https://github.com/afragen/wordpress-beta-tester).

## Changelog

#### 2.2.10 / 2020-05-01
* sanitize, escape & ignore
* move multiline boolean operator to front of line, new guidelines in WPCS
* fix `correct_versions_for_downgrade()` for being on current release version

#### 2.2.9 / 2020-03-24
* delete development RSS feed transient after core upgrade

#### 2.2.8 / 2020-03-17 🍀
* add Dev Notes and Field Guide links to dashboard
* add text/link for bug reporting to trac
* add help tabs to screen
* arbitrarily changed settings page id from `wp_beta_tester` to `wp-beta-tester` 😏

#### 2.2.7 / 2020-03-02
* update trac link in callout for _closed_ or _reopened_ tickets on the milestone
* only show Beta Tester Settings page link in callout with appropriate privileges, using `manage_network_options` and `manage_options`
* menu to Settings page also checks privileges as above

#### 2.2.6 / 2020-02-25
* removed extra `</li>` in dashboard callout, 4th time's the charm 😭

#### 2.2.5 / 2020-02-25
* less greedy regex for matching release posts in RSS for dashboard callout

#### 2.2.4 / 2020-02-25 🤦‍♂️
* added dashboard widget for network dashboard

#### 2.2.3 / 2020-02-25
* add dashboard widget callout for testing

#### 2.2.2 / 2020-02-22
* fix for strange Core API response where preferred version response contained the word 'version'. We now grab the last word of that response

#### 2.2.1 / 2020-02-20
* fix some i18n strings, thanks @pedro-mendonca

#### 2.2.0 / 2020-02-19
* added support for updating to the _beta/RC offer_. Based on and with tons of help from @pbrion, thanks Paul 👏🏻
* fixed so a downgrade from 'unstable' to 'point' serves the correct download
* test and exit from **Extra Settings** if `wp-config.php` is not writeable

#### 2.1.0 / 2019-09-17
* add extra setting to skip successful autoupdate emails
* add description to checkbox settings
* composer update

#### 2.0.4
* add update version information to settings page text

#### 2.0.3
* a11y fixes for settings tabs
* update `wp-cli/wp-config-transformer`

#### 2.0.2
* a11y fixes for checkbox, thanks @audrasjb

#### 2.0.1
* fix for incorrect last updated message

#### 2.0.0
* near complete re-write to use more OOPy practices
* put distinct process into separate classes
* allows for multiple settings tabs for addtional settings

#### 1.2.6
* remove extraneous code
* add GitHub Plugin URI header

#### 1.2.5
* fixed error message for downgrading version, thanks @andreas-andersson

#### 1.2.4
* don't use $GLOBALS

#### 1.2.3
* updated a few strings and correct typos
* run through WPCS linter
* fixed translation strings to include HTML in context and properly escape with `wp_kses_post()`
* fixed link to settings page under Multisite

#### 1.2.2
* change wording from blog to website

#### 1.2.0
* Escape output
* Indicate that _Bleeding edge nightlies_ are _trunk_
* new screenshot
* code improvements from linter

#### 1.1.2
* Remove anonymous function for PHP 5.2 compatibility.

#### 1.1.1
* fixed PHP notice for PHP 7.1
* made URL scheme agnostic

#### 1.1.0
* Fixed to work properly under Multisite.

#### 1.0.2
* Update tested up to version to 4.7.
* Fix the location of the settings screen in Multisite (moved under Settings in Network Admin).
* Minor text fixes.

#### 1.0.1
* Update tested up to version to 4.5.
* Fix PHP7 deprecated constructor notice.
* Change text domain to match the plugin slug.
* Update WordPress.org links to use HTTPS.
* Remove outdated bundled translations in favor of language packs.

#### 1.0
* Update tested up to version to 4.2.
* Update screenshot.
* Fix a couple typos.

#### See old-changelog.txt for previous changelog items

## Installation

1. Upload to your plugins folder, usually `wp-content/plugins/`
2. Activate the plugin on the plugin screen.
3. Navigate to Tools ... Beta Testing to configure the plugin.
4. Under Mulitsite, navigate to Settings ... Beta Testing to configure the plugin.
5. Visit Dashboard ... Upgrade (Or Tools ... Upgrade in versions before 3.0) and update to the latest Beta Release.

## Screenshots

1. This shows the main administration page for the plugin
2. This shows the Extra Settings page for the plugin
3. This shows the Dashboard callout
