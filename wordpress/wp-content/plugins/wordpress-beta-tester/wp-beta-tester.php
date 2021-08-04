<?php
/**
 * WordPress Beta Tester
 *
 * @package WordPress_Beta_Tester
 * @author Andy Fragen, original author Peter Westwood.
 * @license GPLv2+
 * @copyright 2009-2016 Peter Westwood (email : peter.westwood@ftwr.co.uk)
 */

/**
 * Plugin Name:       WordPress Beta Tester
 * Plugin URI:        https://wordpress.org/plugins/wordpress-beta-tester/
 * Description:       Allows you to easily upgrade to Beta releases.
 * Author:            Peter Westwood, Andy Fragen
 * Version:           2.2.10
 * Network:           true
 * Author URI:        https://blog.ftwr.co.uk/
 * Text Domain:       wordpress-beta-tester
 * Domain Path:       /languages
 * License:           GPL v2 or later
 * License URI:       https://www.opensource.org/licenses/GPL-2.0
 * GitHub Plugin URI: https://github.com/afragen/wordpress-beta-tester
 * Requires at least: 3.1
 * Requires PHP:      5.2.4
 */

// Exit if called directly.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// TODO: require_once __DIR__ . '/vendor/autoload.php';
require_once dirname( __FILE__ ) . '/src/WPBT/WPBT_Bootstrap.php';
// TODO: I really want to do this, but have to wait for PHP 5.4
// TODO: ( new WPBT_Bootstrap( __FILE__ ) )->run();
$wp_beta_tester_bootstrap = new WPBT_Bootstrap( __FILE__ );
$wp_beta_tester_bootstrap->run();
