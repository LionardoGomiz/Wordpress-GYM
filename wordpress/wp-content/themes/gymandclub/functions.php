<?php
/**
 * GymAndClub functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GymAndClub
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'gymandclub_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function gymandclub_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on GymAndClub, use a find and replace
		 * to change 'gymandclub' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'gymandclub', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
        add_image_size('blog-single', 750, 310, true);
        add_image_size('blog-index', 750, 310, true);
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'gymandclub' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'gymandclub_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				//'flex-width'  => true,
				//'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'gymandclub_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function gymandclub_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'gymandclub_content_width', 640 );
}
add_action( 'after_setup_theme', 'gymandclub_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function gymandclub_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'gymandclub' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'gymandclub' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		));
    register_sidebar(
        array(
            'name'          => esc_html__( 'footer-1', 'gymandclub' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'Add widgets here-Footer Zone 1.', 'gymandclub' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    register_sidebar(
        array(
            'name'          => esc_html__( 'footer-2', 'gymandclub' ),
            'id'            => 'footer-2',
            'description'   => esc_html__( 'Add widgets here-Footer Zone 2.', 'gymandclub' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
    register_sidebar(
        array(
            'name'          => esc_html__( 'footer-3', 'gymandclub' ),
            'id'            => 'footer-3',
            'description'   => esc_html__( 'Add widgets here-Footer Zone 2.', 'gymandclub' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ));
}
add_action( 'widgets_init', 'gymandclub_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function gymandclub_scripts() {

    wp_enqueue_style( 'montserrat_font', 'https://fonts.googleapis.com/css?family=Montserrat:400,800', array(), 'all' );
    wp_enqueue_media("https://fonts.googleapis.com/css?family=Lato:400,900",false);
    wp_enqueue_style( 'gymandclub-style', get_stylesheet_uri() );

	wp_enqueue_style( 'bootstrap_4', get_template_directory_uri() . '/css/bootstrap.min.css');
    wp_enqueue_style( 'iconos_fontawesome','https://use.fontawesome.com/releases/v5.0.6/css/all.css', false);

	wp_enqueue_script( 'bootstrap_js_4', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), _S_VERSION, true );

	wp_enqueue_script( 'gymandclub-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	wp_enqueue_script( 'gymandclub-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'gymandclub_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 * @param $fields
 * @param $html5
 **/
function Comentario_Personalizado_commetn_form_defaults($fields, $html5){
    $html_req=null;
    $commenter = wp_get_current_commenter();
    $user = wp_get_current_user();
    $user_identity = $user->exists() ? $user->display_name : '';
    $req = get_option('require_name_email');
    $aria_req = ($req ? "aria-required='true'":'');

    $fields =['author' => '<div class="row"><div class="col-md-6 comment-form-author">'.
    '<input class="form-control" id="author" name="author" type="text" value="'. esc_url($commenter['comment_author']) .
        '"size="30" maxlength="245"' . $aria_req . $html_req . 'placeholder="'.__('Nombre *', 'textdomain').'"/></div>',

        'email' =>'<div class="col-md-6 comment-form-email">'.
        '<input class="form-control" id="email" name="email"' . ($html5 ? 'type="email"' : 'type="text"'). 'value="'.
            esc_attr($commenter['comment_author_email']) . '"size="30" maxlength="100" aria-describedby="email-notes"'.
            $aria_req . $html_req . 'placeholder="'.__('Su correo *', 'textdomain').'"/></div></div>',

        'url'=>'<div class="row"><div class="col-md-12 comment-form-url">'.
              '<input class="form-control" placeholder="'.__('Ti sitio', 'textdomain').'" id="url" name="url"' . ($html5 ? 'type="url"' : 'type="text"'). 'value="'.
            esc_attr($commenter['comment_author_url']) . '"size="30" maxlength="200"/></div></div>',

        'comment_field' => '<div class="row"><div class="col-md-12 comment-form-comment">
           <textarea placeholder="'.__('Su comentario', 'texdomain').'"id="comment" name="comment"
           cols="46" rows="8" maxlength="65525" aria-required="true" required="required"></textarea></div></div>',

    ];

    return $fields;

    id_filter('comment_form_default_fields','comentario_Pesonalizado_comment');
}
require get_template_directory() . '/inc/customizer.php';

// Register Custom Post Type
function custom_post_type() {

    $labels = array(
        'name'                  => _x( 'Entrenador', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Entrenador', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Entrenadores', 'text_domain' ),
        'name_admin_bar'        => __( 'Entrenador', 'text_domain' ),
        'archives'              => __( 'Item Archives', 'text_domain' ),
        'attributes'            => __( 'Item Attributes', 'text_domain' ),
        'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
        'all_items'             => __( 'Todos los Entrenadores', 'text_domain' ),
        'add_new_item'          => __( 'Agregar un nuevo entrenador ', 'text_domain' ),
        'add_new'               => __( 'Agregar Nuevo', 'text_domain' ),
        'new_item'              => __( 'New Item', 'text_domain' ),
        'edit_item'             => __( 'Edit Item', 'text_domain' ),
        'update_item'           => __( 'Update Item', 'text_domain' ),
        'view_item'             => __( 'View Item', 'text_domain' ),
        'view_items'            => __( 'View Items', 'text_domain' ),
        'search_items'          => __( 'Search Item', 'text_domain' ),
        'not_found'             => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
        'featured_image'        => __( 'Featured Image', 'text_domain' ),
        'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
        'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
        'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
        'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
        'items_list'            => __( 'Items list', 'text_domain' ),
        'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
        'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Post Type', 'text_domain' ),
        'description'           => __( 'Post Type Description', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array('title','editor','slug','thumbnail'),
        //'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'entrenador', $args );

}
add_action( 'init', 'custom_post_type', 0 );

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*----------------Trabajando con tipo de post personalizado----------------*/
function create_post_type(){
	register_post_type('acme_product',array(
		'labels' =>array(
			'name' => __('Products'),
			'singular_name' => __('Product')
		),
		'public' => true,
		'has_archive' => true,
	)
);
}
add_action('init','create_post_type');
