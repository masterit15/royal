<?php
/**
 * RoyalPrint Theme Advantages fields
 *
 * @package RoyalPrint
 */

/**
 * Add postMessage support for site title and description for the Theme Advantages fields.
 *
 * @param WP_Customize_Manager $wp_customize Theme Advantages fields object.
 */

// Добавляем кастомный тип записи Преимущества
add_action('init', 'my_custom_аdvantages');
function my_custom_аdvantages() {
	register_post_type('аdvantages', array(
		'labels' => array(
			'name' => 'Преимущества',
			'singular_name' => 'Преимущества',
			'add_new' => 'Добавить новое',
			'add_new_item' => 'Добавить новое преимущество',
			'edit_item' => 'Редактировать преимущество',
			'new_item' => 'Новое преимущество',
			'view_item' => 'Посмотреть преимущество',
			'search_items' => 'Найти преимущество',
			'not_found' => 'Преимуществ не найдено',
			'not_found_in_trash' => 'В корзине преимуществ не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Преимущества',

		),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
		'show_in_rest' => true,
		'rest_base' => 'аdvantages',
	));
	// Добавляем для кастомных типо записей Категории
		register_taxonomy(
			"аdvantages-cat",
			array("dvantages"),
			array(
				"hierarchical" => true,
				"label" => "Категории",
				"singular_label" => "Категория",
				"rewrite" => array('slug' => 'dvantages', 'with_front' => false),
			)
		);
}

// Добавляем картинку преимущества в rest_api ответ
add_action('rest_api_init', 'add_аdvantages_thumbnail');
function add_аdvantages_thumbnail() {
	register_rest_field(
		'аdvantages',
		'thumbnail', // название поля в json ответе
		array(
			'get_callback' => 'get_аdvantages_thumbnail', // функция получения картинки преимущества
			'update_callback' => null,
			'schema' => null,
		)
	);
}

// функция получения картинки преимущества
function get_аdvantages_thumbnail($object, $field_name, $request) {
	global $post;
	return get_the_post_thumbnail_url($post->ID, 'large');
}