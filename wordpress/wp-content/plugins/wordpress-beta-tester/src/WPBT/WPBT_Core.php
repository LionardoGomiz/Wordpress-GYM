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
 * WPBT_Core
 */
class WPBT_Core {
	/**
	 * Placeholder for saved options.
	 *
	 * @var array
	 */
	protected static $options;

	/**
	 * Holds the WP_Beta_Tester instance.
	 *
	 * @var WP_Beta_Tester
	 */
	protected $wp_beta_tester;

	/**
	 * Constructor.
	 *
	 * @param  WP_Beta_Tester $wp_beta_tester Instance of class WP_Beta_Tester.
	 * @param  array          $options        Site options.
	 * @return void
	 */
	public function __construct( WP_Beta_Tester $wp_beta_tester, $options ) {
		self::$options        = $options;
		$this->wp_beta_tester = $wp_beta_tester;
	}

	/**
	 * Load hooks.
	 *
	 * @return void
	 */
	public function load_hooks() {
		add_filter( 'wp_beta_tester_add_settings_tabs', array( $this, 'add_settings_tab' ) );
		add_action( 'wp_beta_tester_add_settings', array( $this, 'add_settings' ) );
		add_action( 'wp_beta_tester_add_admin_page', array( $this, 'add_admin_page' ), 10, 2 );
		add_action( 'wp_beta_tester_update_settings', array( $this, 'save_settings' ) );
	}

	/**
	 * Add settings tab for class.
	 *
	 * @param  array $tabs Settings tabs.
	 * @return array
	 */
	public function add_settings_tab( $tabs ) {
		return array_merge( (array) $tabs, array( 'wp_beta_tester_core' => esc_html__( 'WP Beta Tester Settings', 'wordpress-beta-tester' ) ) );
	}

	/**
	 * Setup Settings API.
	 *
	 * @return void
	 */
	public function add_settings() {
		register_setting(
			'wp_beta_tester',
			'wp_beta_tester_core',
			array( 'WPBT_Setting', 'sanitize' )
		);

		add_settings_section(
			'wp_beta_tester_core',
			esc_html__( 'Core Settings', 'wordpress-beta-tester' ),
			array( $this, 'print_core_settings_top' ),
			'wp_beta_tester_core'
		);

		add_settings_field(
			'core_settings',
			null,
			array( $this, 'core_radio_group' ),
			'wp_beta_tester_core',
			'wp_beta_tester_core',
			array( esc_html__( 'Choose an update branch', 'wordpress-beta-tester' ) )
		);
	}

	/**
	 * Save settings.
	 *
	 * @param  mixed $post_data $_POST data.
	 * @return void
	 */
	public function save_settings( $post_data ) {
		if ( isset( $post_data['option_page'] )
			&& 'wp_beta_tester_core' === $post_data['option_page']
		) {
			$options                 = isset( $post_data['wp-beta-tester'] )
				? $post_data['wp-beta-tester']
				: array();
			self::$options['stream'] = WPBT_Settings::sanitize( $options );

			// set an option when picking 'point' release stream.
			// used to ensure correct mangled version is returned.
			self::$options['revert'] = 'point' === $options;
			update_site_option( 'wp_beta_tester', (array) self::$options );
			add_filter( 'wp_beta_tester_save_redirect', array( $this, 'save_redirect_page' ) );
		}
	}

	/**
	 * Redirect page/tab after saving options.
	 *
	 * @param  array $option_page Settings tabs.
	 * @return array
	 */
	public function save_redirect_page( $option_page ) {
		return array_merge( $option_page, array( 'wp_beta_tester_core' ) );
	}

	/**
	 * Print settings section information.
	 *
	 * @return void
	 */
	public function print_core_settings_top() {
		$this->wp_beta_tester->action_admin_head_plugins_php(); // Check configuration.
		$preferred = $this->wp_beta_tester->get_preferred_from_update_core();
		if ( 'development' !== $preferred->response ) {
			echo '<div class="updated fade">';
			echo '<p>' . wp_kses_post( __( '<strong>Please note:</strong> There are no development builds available for the beta stream you have chosen, so you will receive normal update notifications.', 'wordpress-beta-tester' ) ) . '</p>';
			echo '</div>';
		}

		$preferred->version = $this->get_next_version( $preferred->version );

		echo '<div><p>';
		printf(
			/* translators: 1: link to backing up database, 2: link to make.wp.org/core, 3: link to beta support forum */
			wp_kses_post( __( 'By their nature, these releases are unstable and should not be used anyplace where your data is important. So please <a href="%1$s">back up your database</a> before upgrading to a test release. In order to hear about the latest beta releases, your best bet is to watch the <a href="%2$s">development blog</a> and the <a href="%3$s">beta forum</a>.', 'wordpress-beta-tester' ) ),
			esc_url( _x( 'https://codex.wordpress.org/Backing_Up_Your_Database', 'URL to database backup instructions', 'wordpress-beta-tester' ) ),
			'https://make.wordpress.org/core/',
			esc_url( _x( 'https://wordpress.org/support/forum/alphabeta', 'URL to beta support forum', 'wordpress-beta-tester' ) )
		);
		echo '</p><p>';
		printf(
			/* translators: %s: link to new trac ticket */
			wp_kses_post( __( 'Thank you for helping test WordPress. Please <a href="%s">report any bugs you find</a>.', 'wordpress-beta-tester' ) ),
			'https://core.trac.wordpress.org/newticket'
		);
		echo '</p><p>';
		echo wp_kses_post( __( 'By default, your WordPress install uses the stable update stream. To return to this, please deactivate this plugin and re-install from the <a href="update-core.php">WordPress Updates</a> page.', 'wordpress-beta-tester' ) );
		echo '</p><p>';
		printf(
			/* translators: %s: update version */
			wp_kses_post( __( 'Currently your site is set to update to %s.', 'wordpress-beta-tester' ) ),
			'<strong>' . esc_attr( $preferred->version ) . '</strong>'
		);
		echo '</p><p>';
		esc_html_e( 'Please select the update stream you would like this website to use:', 'wordpress-beta-tester' );
		echo '</p></div>';
	}

	/**
	 * Create settings radio button options.
	 *
	 * @return void
	 */
	public function core_radio_group() {
		$wp_version = get_bloginfo( 'version' );
		$preferred  = $this->wp_beta_tester->get_preferred_from_update_core();

		$beta_rc                = 1 === preg_match( '/alpha|beta|RC/', $wp_version );
		$point                  = 1 === preg_match( '/point/', static::$options['stream'] );
		$unstable               = 1 === preg_match( '/unstable/', static::$options['stream'] );
		list( $wp_base )        = explode( '-', $wp_version );
		list( $preferred_base ) = explode( '-', $preferred->version );

		// Odd bug where Core API returns 'version <version_number>' instead of just the <version_number>.
		// I can't explain it, but it showed up on my server at least once.
		$preferred_base = explode( ' ', $preferred_base );
		$preferred_base = array_pop( $preferred_base );

		$show_beta_rc = $wp_base === $preferred_base || 'latest' === $preferred->response;

		?>
		<fieldset>
		<tr>
			<th><label><input name="wp-beta-tester" id="update-stream-point-nightlies"   type="radio" value="point" class="tog" <?php checked( 'point', self::$options['stream'] ); ?> />
			<?php esc_html_e( 'Point release nightlies', 'wordpress-beta-tester' ); ?>
			</label></th>
			<td><?php esc_html_e( 'This contains the work that is occurring on a branch in preparation for a x.x.x point release. This should also be fairly stable but will be available before the branch is ready for release.', 'wordpress-beta-tester' ); ?></td>
		</tr>
		<?php if ( $point && $beta_rc && $show_beta_rc ) : ?>
		<tr>
			<th><label><input name="wp-beta-tester" id="update-stream-beta-rc-point"    type="radio" value="beta-rc-point" class="tog" <?php checked( 'beta-rc-point', self::$options['stream'] ); ?> />
			<?php esc_html_e( 'Beta/RC - Point release', 'wordpress-beta-tester' ); ?>
			</label></th>
			<td><?php echo( wp_kses_post( __( 'This is for the Beta/RC releases only of the x.x.x point release. It will only update to beta/RC releases of point releases.', 'wordpress-beta-tester' ) ) ); ?></td>
		</tr>
		<?php endif ?>
		<tr>
			<th><label><input name="wp-beta-tester" id="update-stream-bleeding-nightlies"    type="radio" value="unstable" class="tog" <?php checked( 'unstable', self::$options['stream'] ); ?> />
			<?php esc_html_e( 'Bleeding edge nightlies', 'wordpress-beta-tester' ); ?>
			</label></th>
			<td><?php echo( wp_kses_post( __( 'This is the bleeding edge development code from `trunk` which may be unstable at times. <em>Only use this if you really know what you are doing</em>.', 'wordpress-beta-tester' ) ) ); ?></td>
		</tr>
		<?php if ( $unstable && $beta_rc && $show_beta_rc ) : ?>
		<tr>
			<th><label><input name="wp-beta-tester" id="update-stream-beta-rc-unstable"    type="radio" value="beta-rc-unstable" class="tog" <?php checked( 'beta-rc-unstable', self::$options['stream'] ); ?> />
			<?php esc_html_e( 'Beta/RC - Bleeding edge', 'wordpress-beta-tester' ); ?>
			</label></th>
			<td><?php echo( wp_kses_post( __( 'This is for the Beta/RC releases only of development code from `trunk`. It will only update to beta/RC releases of `trunk`.', 'wordpress-beta-tester' ) ) ); ?></td>
		</tr>
		<?php endif ?>
		</fieldset>
		<?php
	}

	/**
	 * Create core settings page.
	 *
	 * @param  array  $tab    Settings tab.
	 * @param  string $action Settings form action.
	 * @return void
	 */
	public function add_admin_page( $tab, $action ) {
		?>
		<div>
			<?php if ( 'wp_beta_tester_core' === $tab ) : ?>
			<form method="post" action="<?php esc_attr_e( $action ); ?>">
				<?php settings_fields( 'wp_beta_tester_core' ); ?>
				<?php do_settings_sections( 'wp_beta_tester_core' ); ?>
				<?php submit_button(); ?>
			</form>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Get the next version the site will be updated to.
	 *
	 * @since 2.2.0
	 *
	 * @param  string $preferred_version The preferred version.
	 * @return string
	 */
	public function get_next_version( $preferred_version ) {
		if ( ! ( 0 === strpos( static::$options['stream'], 'beta-rc' )
				|| ! preg_match( '/alpha|beta|RC/', get_bloginfo( 'version' ) ) ) ) {
			// site is not running a development version or not on a beta/RC stream.
			// So use the preferred version.
			/* translators: %s: version number */
			return sprintf( __( 'version %s', 'wordpress-beta-tester' ), $preferred_version );
		}

		$next_version = $this->wp_beta_tester->beta_rc->get_found_version();
		if ( $next_version ) {
			// the next beta/RC package was found, return that version.
			/* translators: %s: version number */
			return sprintf( __( 'version %s', 'wordpress-beta-tester' ), $next_version );
		}

		// the next beta/RC package was not found.
		$next_version = $this->wp_beta_tester->beta_rc->next_package_versions();
		if ( 1 === count( $next_version ) ) {
			$next_version = array_shift( $next_version );
		} elseif ( empty( $next_version ) ) {
			$next_version = __( 'next development version', 'wordpress-beta-tester' );
		} else {
			// show all versions that may come next.
			add_filter( 'wp_sprintf_l', array( $this, 'wpbt_sprintf_or' ) );
			$next_version = wp_sprintf( __( 'version %l', 'wordpress-beta-tester' ), $next_version ) . ', ' . __( 'whichever is released first', 'wordpress-beta-tester' );
			remove_filter( 'wp_sprintf_l', array( $this, 'wpbt_sprintf_or' ) );
		}

		return $next_version;
	}

	/**
	 * Change the delimiters used by wp_sprintf_l().
	 *
	 * Placeholders (%s) are included to assist translators and then
	 * removed before the array of strings reaches the filter.
	 *
	 * Please note: Ampersands and entities should be avoided here.
	 *
	 * @since 2.2.1
	 *
	 * @param array $delimiters An array of translated delimiters.
	 */
	public function wpbt_sprintf_or( $delimiters ) {
		$delimiters = array(
			/* translators: Used to join items in a list with more than 2 items. */
			'between'          => sprintf( __( '%1$s, %2$s', 'wordpress-beta-tester' ), '', '' ),
			/* translators: Used to join last two items in a list with more than 2 times. */
			'between_last_two' => sprintf( __( '%1$s, or %2$s', 'wordpress-beta-tester' ), '', '' ),
			/* translators: Used to join items in a list with only 2 items. */
			'between_only_two' => sprintf( __( '%1$s or %2$s', 'wordpress-beta-tester' ), '', '' ),
		);

		return $delimiters;
	}
}
