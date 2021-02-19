<?php
// Добавляем кастомный тип записи Партнеры
add_action('init', 'my_custom_partner');
function my_custom_partner() {
	register_post_type('partner', array(
		'labels' => array(
			'name' => 'Партнеры',
			'singular_name' => 'Партнер',
			'add_new' => 'Добавить новый',
			'add_new_item' => 'Добавить нового партнера',
			'edit_item' => 'Редактировать партнера',
			'new_item' => 'Новый партнер',
			'view_item' => 'Посмотреть партнера',
			'search_items' => 'Найти партнера',
			'not_found' => 'Партнеров не найдено',
			'not_found_in_trash' => 'В корзине партнеров не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Партнеры',

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
		'rest_base' => 'partner',
	));

	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"partner-cat",
		array("partner"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'partner', 'with_front' => false),
		)
	);
}
