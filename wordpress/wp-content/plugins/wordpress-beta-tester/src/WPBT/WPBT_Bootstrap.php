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
 * WPBT_Bootstrap
 */
class WPBT_Bootstrap {

	/**
	 * Holds main plugin file.
	 *
	 * @var $file
	 */
	protected $file;

	/**
	 * Holds main plugin directory.
	 *
	 * @var $dir
	 */
	protected $dir;

	/**
	 * Holds plugin options.
	 *
	 * @var $options
	 */
	protected static $options;

	/**
	 * Constructor.
	 *
	 * @param string $file Main plugin file.
	 * @return void
	 */
	public function __construct( $file ) {
		$this->file = $file;
		$this->dir  = dirname( $file );
	}

	/**
	 * Let's get started.
	 *
	 * @return void
	 */
	public function run() {
		$this->load_requires(); // TODO: replace with composer's autoload.
		$this->load_hooks();
		self::$options = get_site_option(
			'wp_beta_tester',
			array(
				'stream' => 'point',
				'revert' => true,
			)
		);
		// TODO: I really want to do this, but have to wait for PHP 5.4.
		// TODO: ( new WP_Beta_Tester( $this->file ) )->run( $this->options );
		$wpbt = new WP_Beta_Tester( $this->file );
		$wpbt->run( self::$options );
	}

	/**
	 * Load hooks.
	 *
	 * @return void
	 */
	public function load_hooks() {
		add_action( 'init', array( $this, 'load_textdomain' ) );
		register_activation_hook( $this->file, array( $this, 'activate' ) );
		register_deactivation_hook( $this->file, array( $this, 'deactivate' ) );
		add_filter( 'site_option_wp_beta_tester', array( $this, 'fix_stream' ) );
	}

	/**
	 * Load textdomain.
	 *
	 * @return void
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'wordpress-beta-tester' );
	}

	/**
	 * Run on plugin activation.
	 *
	 * Delete 'update_core' transient and add any saved extra settings to wp-config.php.
	 *
	 * @return void
	 */
	public function activate() {
		delete_site_transient( 'update_core' );
		$wpbt        = new WP_Beta_Tester( $this->file );
		$wpbt_extras = new WPBT_Extras( $wpbt, self::$options );
		$wpbt_extras->activate();
	}

	/**
	 * Run on plugin deactivation.
	 *
	 * Delete 'update_core' transient and remove any extras settings from wp-config.php.
	 *
	 * @return void
	 */
	public function deactivate() {
		delete_site_transient( 'update_core' );
		$wpbt = new WP_Beta_Tester( $this->file );
		// TODO: ( new WPBT_Extras( $wpbt, self::$options ) )->deactivate();
		$wpbt_extras = new WPBT_Extras( $wpbt, self::$options );
		$wpbt_extras->deactivate();
	}

	/**
	 * Fix stream option for when `beta-rc` set but current version
	 * isn't a `beta|RC` version.
	 *
	 * @param array $value Array of options values from `wp_beta_tester` option.
	 *
	 * @return array
	 */
	public function fix_stream( $value ) {
		if ( 0 === strpos( $value['stream'], 'beta-rc' )
			&& 1 !== preg_match( '/alpha|beta|RC/', get_bloginfo( 'version' ) ) ) {
			$value['stream'] = str_replace( 'beta-rc-', '', $value['stream'] );
		}

		return $value;
	}

	/**
	 * <sarcasm>Poor man's autoloader.</sarcasm>
	 * // TODO: replace with composer's autoload.
	 *
	 * @return void
	 */
	public function load_requires() {
		require_once $this->dir . '/src/WPBT/WP_Beta_Tester.php';
		require_once $this->dir . '/src/WPBT/WPBT_Settings.php';
		require_once $this->dir . '/src/WPBT/WPBT_Core.php';
		require_once $this->dir . '/src/WPBT/WPBT_Extras.php';
		require_once $this->dir . '/src/WPBT/WPBT_Beta_RC.php';
		require_once $this->dir . '/src/WPBT/WPBT_Help.php';
		require_once $this->dir . '/vendor/WPConfigTransformer.php';
	}
}
