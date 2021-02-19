<?php
/**
 * RoyalPrint Theme Product fields
 *
 * @package RoyalPrint
 */

/**
 * Add postMessage support for site title and description for the Theme Product fields.
 *
 * @param WP_Customize_Manager $wp_customize Theme Product fields object.
 */

// Добавляем кастомный тип записи Продукты
add_action('init', 'my_custom_works');
function my_custom_works() {
	register_post_type('works', array(
		'labels' => array(
			'name' => 'Работы',
			'singular_name' => 'Работа',
			'add_new' => 'Добавить новую',
			'add_new_item' => 'Добавить новую работу',
			'edit_item' => 'Редактировать работу',
			'new_item' => 'Новая работа',
			'view_item' => 'Посмотреть работу',
			'search_items' => 'Найти работу',
			'not_found' => 'Работ не найдено',
			'not_found_in_trash' => 'В корзине работ не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Работы',

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
		'supports' => array('title', 'editor', 'author', 'thumbnail'),
		'show_in_rest' => true,
		'rest_base' => 'works',
	));

	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"works-cat",
		array("works"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'works', 'with_front' => false),
		)
	);
}