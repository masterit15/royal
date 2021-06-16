<?php
/**
 * RoyalPrint functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package RoyalPrint
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}
@ini_set( 'upload_max_size' , '256M' );
@ini_set( 'post_max_size', '256M');
@ini_set( 'max_execution_time', '300' );
function PR($var, $all = false, $die = false) {
	$bt = debug_backtrace();
	$bt = $bt[0];
	$dRoot = $_SERVER["DOCUMENT_ROOT"];
	$dRoot = str_replace("/", "\\", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	$dRoot = str_replace("\\", "/", $dRoot);
	$bt["file"] = str_replace($dRoot, "", $bt["file"]);
	?>
		<div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;z-index: 999'>
		<div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?=$bt["file"]?> [<?=$bt["line"]?>]</div>
		<pre style='padding:10px;'><?print_r($var)?></pre>
		</div>
		<?
	if ($die) {
		die;
	}
}

if (!function_exists('royalprint_setup')):
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function royalprint_setup() {
		/*
			 * Make theme available for translation.
			 * Translations can be filed in the /languages/ directory.
			 * If you're building a theme based on RoyalPrint, use a find and replace
			 * to change 'royalprint' to the name of your theme in all the template files.
		*/
		load_theme_textdomain('royalprint', get_template_directory() . '/languages');

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
				'menu-1' => esc_html__('Primary', 'royalprint'),
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
				'royalprint_custom_background_args',
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
				'height' => 250,
				'width' => 250,
				'flex-width' => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action('after_setup_theme', 'royalprint_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function royalprint_content_width() {
	$GLOBALS['content_width'] = apply_filters('royalprint_content_width', 640);
}
add_action('after_setup_theme', 'royalprint_content_width', 0);

add_action( 'after_setup_theme', 'theme_register_socmenu' );
function theme_register_socmenu() {
	register_nav_menu( 'socmenu', 'Мы в соцсетях' );
}
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function royalprint_widgets_init() {
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'royalprint'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'royalprint'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Контакты-вверху', 'royalprint' ),
			'id'            => 'contact-top',
			'description'   => esc_html__( 'Добавить виджет.', 'royalprint' ),
			'before_widget' => '<div class="contact_top_item">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="contact_top_title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Контакты-внизу', 'royalprint' ),
			'id'            => 'contact-bottom',
			'description'   => esc_html__( 'Добавить виджет.', 'royalprint' ),
			'before_widget' => '<div class="contact_top_item">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="contact_top_title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Контакты-адрес', 'royalprint' ),
			'id'            => 'contact-address',
			'description'   => esc_html__( 'Добавить виджет.', 'royalprint' ),
			'before_widget' => '<div class="contact_top_item">',
			'after_widget'  => '</div>',
			'before_title'  => '',
			'after_title'   => '',
		)
	);
}
add_action('widgets_init', 'royalprint_widgets_init');


// область виджета на страницах
if (function_exists('register_sidebar')){
	register_sidebar( array(
			 'name'          => 'Низ сайта', //название виджета в админ-панели
			 'id'            => 'footer', //идентификатор виджета
			 'description'   => 'Контактная информация', //описание виджета в админ-панели
			 'before_widget' => '<div id="%1$s" class="footer_item %2$s">', //открывающий тег виджета с динамичным идентификатором
			 'after_widget'  => '<div class="clear"></div></div>', //закрывающий тег виджета с очищающим блоком
			 'before_title'  => '<h3 class="footer_item_title">', //открывающий тег заголовка виджета
			 'after_title'   => '</h3>',//закрывающий тег заголовка виджета
			 ) );
}

/**
 * Enqueue scripts and styles.
 */
function royalprint_scripts() {
	wp_enqueue_style('royalprint-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_enqueue_style('libs-style', get_template_directory_uri() . '/css/main.min.css', array(), _S_VERSION);

	wp_enqueue_script('libs', get_template_directory_uri() . '/js/libs.js', array(), _S_VERSION, true);
	wp_enqueue_script('mainjs', get_template_directory_uri() . '/js/common.js', array(), _S_VERSION, true);
	wp_enqueue_script('pricejs', get_template_directory_uri() . '/libs/calculator/price.js', array(), _S_VERSION, true);


	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'royalprint_scripts');

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
 *	Кастомный тип записи Продукты
 */
require get_template_directory() . '/inc/product.php';

/**
 *	Кастомный тип записи Преимущества
 */
require get_template_directory() . '/inc/advantages.php';

/**
 *	Кастомный тип записи Работы
 */
require get_template_directory() . '/inc/works.php';

/**
 *	Кастомный тип записи Партнеры
 */
require get_template_directory() . '/inc/partner.php';

/**
 *	Кастомный тип записи Партнеры
 */
require get_template_directory() . '/inc/application.php';

/**
 *	Функция копирования постов в списке
 */
require get_template_directory() . '/inc/post_dublicate.php';

/**
 *	Функция вывода в постах прикрепленной картинки
 */
require get_template_directory() . '/inc/add_post_thumbs.php';

/**
 *	Функция вывода в постах прикрепленной картинки
 */
require get_template_directory() . '/inc/mycustomizer.php';




/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

function my_handle_attachment($file_handler, $post_id, $set_thu = false)
{
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) {
        __return_false();
    }
    require_once ABSPATH . "wp-admin" . '/includes/image.php';
    require_once ABSPATH . "wp-admin" . '/includes/file.php';
    require_once ABSPATH . "wp-admin" . '/includes/media.php';

    $attach_id = media_handle_upload($file_handler, $post_id);
    if (is_numeric($attach_id)) {
        update_post_meta($post_id, '_link', $attach_id);
    }
    return $attach_id;
}