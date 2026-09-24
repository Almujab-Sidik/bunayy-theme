<?php

/**
 * bunayy-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bunayy-theme
 */

if (! defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.3');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bunayy_theme_setup()
{
    /*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on bunayy-theme, use a find and replace
		* to change 'bunayy-theme' to the name of your theme in all the template files.
		*/
    load_theme_textdomain('bunayy-theme', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
    add_theme_support('title-tag');

    /*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'bunayy-theme'),
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
            'bunayy_theme_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

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
            'flex-width'  => true,
            'flex-height' => true,
        )
    );
}
add_action('after_setup_theme', 'bunayy_theme_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bunayy_theme_content_width()
{
    $GLOBALS['content_width'] = apply_filters('bunayy_theme_content_width', 640);
}
add_action('after_setup_theme', 'bunayy_theme_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bunayy_theme_widgets_init()
{
    register_sidebar(
        array(
            'name'          => esc_html__('Sidebar', 'bunayy-theme'),
            'id'            => 'sidebar-1',
            'description'   => esc_html__('Add widgets here.', 'bunayy-theme'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'bunayy_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function bunayy_theme_scripts()
{
    wp_enqueue_style('bunayy-fonts', 'https://fonts.googleapis.com/css2?family=Fira+Sans:wght@600;700;800&family=Montserrat:wght@400;500;600&display=swap', array(), null);
    wp_enqueue_style('bunayy-theme-style', get_stylesheet_uri(), array('bunayy-fonts'), filemtime(get_stylesheet_directory() . '/style.css'));
    wp_style_add_data('bunayy-theme-style', 'rtl', 'replace');

    wp_enqueue_script('bunayy-theme-navigation', get_template_directory_uri() . '/js/navigation.js', array(), filemtime(get_template_directory() . '/js/navigation.js'), true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bunayy_theme_scripts');

/**
 * Style the WordPress login screen to match the theme.
 */
function bunayy_theme_login_assets()
{
    wp_enqueue_style('bunayy-login-fonts', 'https://fonts.googleapis.com/css2?family=Fira+Sans:wght@600;700;800&family=Montserrat:wght@400;500;600&display=swap', array(), null);
    wp_enqueue_style('bunayy-login', get_template_directory_uri() . '/css/login.css', array('bunayy-login-fonts'), filemtime(get_template_directory() . '/css/login.css'));
    wp_add_inline_style('bunayy-login', '.login h1 a{background-image:url("' . esc_url(content_url('/uploads/2026/09/logo-bunayy.webp')) . '");}');
}
add_action('login_enqueue_scripts', 'bunayy_theme_login_assets');

add_filter('login_headerurl', static fn(): string => home_url('/'));
add_filter('login_headertext', static fn(): string => get_bloginfo('name'));

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
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Check for theme updates from the Bunayy GitHub repository.
 *
 * Define BUNAYY_THEME_REPOSITORY_URL and, for private repositories,
 * BUNAYY_GITHUB_TOKEN in wp-config.php.
 */
require_once get_template_directory() . '/vendor/autoload.php';

if (defined('BUNAYY_THEME_REPOSITORY_URL') && BUNAYY_THEME_REPOSITORY_URL) {
    $bunayy_update_checker = YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        BUNAYY_THEME_REPOSITORY_URL,
        get_template_directory()
    );
    $bunayy_update_checker->setBranch('main');

    if (defined('BUNAYY_GITHUB_TOKEN') && BUNAYY_GITHUB_TOKEN) {
        $bunayy_update_checker->setAuthentication(BUNAYY_GITHUB_TOKEN);
    }
}

/**
 * Contact form storage and dashboard display.
 */
require get_template_directory() . '/inc/contact-form.php';
