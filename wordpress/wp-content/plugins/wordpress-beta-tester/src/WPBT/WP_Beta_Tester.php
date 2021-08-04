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
 * WP_Beta_Tester
 */
class WP_Beta_Tester {

	/**
	 * Holds main plugin file.
	 *
	 * @var $file
	 */
	public $file;

	/**
	 * Holds Beta/RC class instance.
	 *
	 * @since 2.2.0
	 *
	 * @var WPBT_Beta_RC
	 */
	public $beta_rc;

	/**
	 * Constructor.
	 *
	 * @param string $file Main plugin file.
	 * @return void
	 */
	public function __construct( $file ) {
		$this->file = $file;
	}

	/**
	 * Rev up the engines.
	 *
	 * @param array $options Plugin options.
	 * @return void
	 */
	public function run( $options ) {
		$this->load_hooks();
		// TODO: I really want to do this, but have to wait for PHP 5.4
		// TODO: ( new WPBT_Settings( $this, $options ) )->run();
		$settings = new WPBT_Settings( $this, $options );
		$settings->run();
		// TODO: ( new WPBT_Beta_RC() )->load_hooks();
		$this->beta_rc = new WPBT_Beta_RC();
		$this->beta_rc->load_hooks();
	}

	/**
	 * Load hooks.
	 *
	 * @return void
	 */
	protected function load_hooks() {
		add_action(
			'update_option_wp_beta_tester_stream',
			array(
				$this,
				'action_update_option_wp_beta_tester_stream',
			)
		);
		add_filter( 'pre_http_request', array( $this, 'filter_http_request' ), 10, 3 );
	}

	/**
	 * Check and display notice if 'update' really downgrade.
	 *
	 * @return void
	 */
	public function action_admin_head_plugins_php() {
		// Workaround the check throttling in wp_version_check().
		$st = get_site_transient( 'update_core' );
		if ( is_object( $st ) ) {
			$st->last_checked = 0;
			set_site_transient( 'update_core', $st );
		}
		wp_version_check();

		// Can output an error here if current config drives version backwards.
		if ( $this->check_if_settings_downgrade() ) {
			echo '<div id="message" class="notice notice-warning"><p>';
			$admin_page = is_multisite() ? network_admin_url( 'settings.php' ) : admin_url( 'tools.php' );
			$admin_page = add_query_arg(
				array(
					'page' => 'wp-beta-tester',
					'tab'  => 'wp_beta_tester_core',
				),
				$admin_page
			);
			/* translators: %s: link to setting page */
			printf(
				/* translators: %s: WordPress Beta Tester Settings page URL */
				wp_kses_post( __( '<strong>Warning:</strong> Your current <a href="%s">WordPress Beta Tester plugin configuration</a> will downgrade your install to a previous version - please reconfigure it.', 'wordpress-beta-tester' ) ),
				esc_url( $admin_page )
			);
			echo '</p></div>';
		}
	}

	/**
	 * Filter 'pre_http_request' to add beta-tester API check.
	 *
	 * @param mixed  $result $result from filter.
	 * @param array  $args Array of filter args.
	 * @param string $url URL from filter.
	 * @return /stdClass Output from wp_remote_get().
	 */
	public function filter_http_request( $result, $args, $url ) {
		if ( $result || isset( $args['_beta_tester'] ) ) {
			return $result;
		}
		if ( false === strpos( $url, '//api.wordpress.org/core/version-check/' ) ) {
			return $result;
		}

		// It's a core-update request.
		$args['_beta_tester'] = true;

		$wp_version = get_bloginfo( 'version' );
		$url        = str_replace( 'version=' . $wp_version, 'version=' . $this->mangle_wp_version(), $url );

		return wp_remote_get( $url, $args );
	}

	/**
	 * Our option has changed so update the cached information pronto.
	 *
	 * @return void
	 */
	public function action_update_option_wp_beta_tester_stream() {
		do_action( 'wp_version_check' );
	}

	/**
	 * Get preferred update version from core.
	 *
	 * @return /stdClass
	 */
	public function get_preferred_from_update_core() {
		if ( ! function_exists( 'get_preferred_from_update_core' ) ) {
			require_once ABSPATH . 'wp-admin/includes/update.php';
		}

		// Validate that we have api data and if not get the normal data so we always have it.
		$preferred = get_preferred_from_update_core();
		if ( false === $preferred ) {
			wp_version_check();
			$preferred = get_preferred_from_update_core();
		}

		return $preferred;
	}

	/**
	 * Get modified WP version to pass to API check.
	 *
	 * @return string $wp_version
	 */
	protected function mangle_wp_version() {
		$options    = get_site_option(
			'wp_beta_tester',
			array(
				'stream' => 'point',
				'revert' => true,
			)
		);
		$preferred  = $this->get_preferred_from_update_core();
		$wp_version = get_bloginfo( 'version' );

		// If we're getting no updates back from get_preferred_from_update_core(),
		// let an HTTP request go through unmangled.
		if ( ! isset( $preferred->current ) ) {
			return $wp_version;
		}

		if ( 0 === strpos( $options['stream'], 'beta-rc' )
			&& version_compare( $preferred->current, $wp_version, 'lt' ) ) {
			$versions = array_map( 'intval', explode( '.', $wp_version ) );
		} else {
			$versions = array_map( 'intval', explode( '.', $preferred->current ) );
		}

		// ensure that a downgrade correctly gets mangled version.
		if ( isset( $options['revert'] ) && $options['revert'] ) {
			$versions = $this->correct_versions_for_downgrade( $versions );
		}

		switch ( $options['stream'] ) {
			case 'point':
			case 'beta-rc-point':
				$versions[2] = isset( $versions[2] ) ? $versions[2] + 1 : 1;
				break;
			case 'unstable':
			case 'beta-rc-unstable':
				++ $versions[1];
				if ( 10 === $versions[1] ) {
					++ $versions[0];
					$versions[1] = 0;
				}
				break;
		}
		$wp_version = implode( '.', $versions ) . '-wp-beta-tester';

		return $wp_version;
	}

	/**
	 * Ensure that a downgrade to a point release returns a version array that
	 * will properly get the correct offer.
	 *
	 * @param array $versions Array containing the semver arguments of the currently
	 *                        installed version.
	 *
	 * @return array
	 */
	private function correct_versions_for_downgrade( $versions ) {
		$wp_version      = get_bloginfo( 'version' );
		$current         = array_map( 'intval', explode( '.', $wp_version ) );
		$release_version = 0 === preg_match( '/alpha|beta|RC/', $wp_version );

		if ( version_compare( implode( '.', $versions ), implode( '.', $current ), '>=' ) ) {
			$versions[1] = $versions[1] - 1;
		}
		if ( ( $release_version || isset( $current[2] ) ) && $versions[1] < $current[1] ) {
			$versions[1] = $current[1];
		}

		// Add an obscenely high value to always get the point release offer.
		$versions[2] = 100;

		return $versions;
	}

	/**
	 * Returns whether beta is really downgrade.
	 *
	 * @return bool
	 */
	protected function check_if_settings_downgrade() {
		$wp_version         = get_bloginfo( 'version' );
		$wp_real_version    = explode( '-', $wp_version );
		$wp_mangled_version = explode( '-', $this->mangle_wp_version() );

		return version_compare( $wp_mangled_version[0], $wp_real_version[0], 'lt' );
	}
}
