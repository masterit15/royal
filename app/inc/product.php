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
// require get_template_directory() . '/vendor/autoload.php';
// use ColorThief\ColorThief;
// Добавляем кастомный тип записи Продукты
add_action('init', 'my_custom_product');
function my_custom_product() {
	register_post_type('product', array(
		'labels' => array(
			'name' => 'Продукты',
			'singular_name' => 'Продукт',
			'add_new' => 'Добавить новый',
			'add_new_item' => 'Добавить новый продукт',
			'edit_item' => 'Редактировать продукт',
			'new_item' => 'Новый продукт',
			'view_item' => 'Посмотреть продукт',
			'search_items' => 'Найти продукт',
			'not_found' => 'Продуктов не найдено',
			'not_found_in_trash' => 'В корзине продуктов не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Продукты',

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
		'rest_base' => 'product',
	));

	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"product-cat",
		array("product"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'product', 'with_front' => false),
		)
	);
}
//Дополнительные поля продукта
add_action("admin_init", "product_field_init");
add_action('save_post', 'save_product_field');
function product_field_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("product_field", "Свойства продукта", "product_field", 'product', "normal", "low");
	}
}



	function admin_style() {
		if(get_post_type() == 'product'){
			wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin.css');
		}
	}
	add_action('admin_enqueue_scripts', 'admin_style');
	function admin_js() {
		if(get_post_type() == 'product'){
			wp_enqueue_script( 'jquery-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js' );
			wp_enqueue_script( 'jquery-script-mask', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js' );
			wp_enqueue_script( 'admin-script', get_template_directory_uri() . '/admin.js' );
		}
	}
	add_action('admin_enqueue_scripts', 'admin_js');

//Дополнительные поля продукта html
function product_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	$stringArr = explode(',', $custom["_link"][0]);
	if(count($stringArr) > 1){
		$link    = str_replace("NaN,", "", $custom["_link"][0]);
	}else{
		$link    = str_replace("NaN", "", $custom["_link"][0]);
	}
	if(get_post_type() == 'product'){
	?>
	<div class="product">
		<div class="product_fields">
				<?if (isset($custom['product_priceparam']) and $custom['product_priceparam'][0] == 'on') {?>
					<label class="switch" for="product_priceparam">
						<input type="checkbox" id="product_priceparam" checked>
						<span class="priceparam">Цена <span>фиксированная</span></span>
					</label>
				<?} else {?>
					<label class="switch" for="product_priceparam">
						<input type="checkbox" id="product_priceparam">
						<span class="priceparam">Цена <span>индивидуальная</span></span>
					</label>
				<?}?>
				<input type="hidden" name="priceparam" value="<?=$custom['product_priceparam'][0]?>">
			<div class="group">
				<label>Цена 0.00 р:</label>
				<?if (isset($custom['product_price'])) {?>
					<input class="input product_fields_price" name="price" value="<?=$custom['product_price'][0]?>">
				<?} else {?>
					<input class="input product_fields_price" name="price">
				<?}?>
			</div>
			<div class="group">
				<label>Тираж:</label>
				<?if (isset($custom['product_edition'])) {?>
					<input class="input product_fields_edition" name="edition" type="number" value="<?=$custom['product_edition'][0]?>">
				<?} else {?>
					<input class="input product_fields_edition" name="edition" type="number">
				<?}?>
			</div>
			<div class="group">
				<label>Цена с тиснением:</label>
				<?if (isset($custom['product_embossing_price'])) {?>
					<input class="input product_fields_embossing-price product_fields_price" name="embossingprice" min="0" value="<?=$custom['product_embossing_price'][0]?>">
				<?} else {?>
					<input class="input product_fields_embossing-price product_fields_price" name="embossingprice" min="0">
				<?}?>
			</div>
			<div class="group">
				<label>Цена дизайна:</label>
				<?if (isset($custom['product_design'])) {?>
					<input class="input product_fields_price" name="design" min="0" value="<?=$custom['product_design'][0]?>">
				<?} else {?>
					<input class="input product_fields_price" name="design" min="0" placeholder="">
				<?}?>
			</div>
		</div>
		<div class="product_images">
			<div class="frame"></div>
			<input type="hidden" name="link" class="field" value="<?=$link?>" />
			<div class="images_edition">
				<div class="load_more" 
				data-url="<?php echo site_url ()?>/wp-admin/admin-ajax.php" 
				data-post="<?=$post->ID?>"
				data-selectcount="<?=count(explode(',', $link))?>" 
				>Показать еще</div>
				<div class="edition-selected"></div>
			</div>
			
		</div>
	</div>
<?
	}
}

add_action('wp_ajax_moreimage', 'moreimage_filter_function'); // wp_ajax_{ACTION HERE} 
function moreimage_filter_function(){
		global $post;
		$ppp = (isset($_POST["ppp"])) ? $_POST["ppp"] : 3;
    $page = (isset($_POST['pageNumber'])) ? $_POST['pageNumber'] : 0;
		$custom = get_post_custom($_REQUEST['post']);
		$link    = $custom["_link"][0];
		$thelinks = explode(',', $link);
		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' => array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif' => 'image/gif',
				'png' => 'image/png',
			),
			'post_status' => 'inherit',
			'posts_per_page' => $ppp,
			'paged'    => $page,
		);
		$query_images = new WP_Query( $args );
		foreach ($query_images->posts as $file) {
			$img = $file->ID;
		if (in_array($file->ID, $thelinks)) {?>
			<label class="checked" for="images_<?=$file->ID?>">
				<input type="checkbox" group="images" value="<?=$file->ID?>" checked />
				<div class="img" style="background-image: url('<?=$file->guid?>')"></div>
			</label>
		<?} else {?>
			<label for="images_<?=$file->ID?>">
				<input id="images_<?=$file->ID?>" type="checkbox" group="images" value="<?=$file->ID?>" />
				<div class="img" style="background-image: url('<?=$file->guid?>')"></div>
			</label>
		<?}
		$edition++;
		}?>
		<?
		die();
}
// Функция сохранения полей продукта "Цена" и "Тираж"
function save_product_field() {
	global $post;
	if(get_post_type() == 'product'){
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "product_price", $_POST["price"]);
		update_post_meta($post->ID, "product_design", $_POST["design"]);
		update_post_meta($post->ID, "product_edition", $_POST["edition"]);
		update_post_meta($post->ID, "product_embossing_price", $_POST["embossingprice"]);
		if(isset($_POST["priceparam"]))
		update_post_meta($post->ID, "product_priceparam", $_POST["priceparam"]);
		if(isset($_POST["link"]))
		update_post_meta($post->ID, "_link", $_POST["link"]);
	}
}


// функция получения полей категории
function get_price($object, $field_name, $request) {
	global $post;
	$price = get_post_meta($post->ID, 'product_price', true);
	return $price;
}

add_action('rest_api_init', 'add_edition');
function add_edition() {
	register_rest_field(
		'product',
		'edition', // название поля в json ответе
		array(
			'get_callback' => 'get_edition', // функция получения полей категории
			'update_callback' => null,
			'schema' => null,
		)
	);
}

// функция получения полей категории
function get_edition($object, $field_name, $request) {
	global $post;
	$edition = get_post_meta($post->ID, 'product_edition', true);
	return $edition;
}

// Добавляем категории в rest_api ответ
add_action('rest_api_init', 'add_cat');
function add_cat() {
	register_rest_field(
		'product',
		'cat', // название поля в json ответе
		array(
			'get_callback' => 'get_cat', // функция получения полей категории
			'update_callback' => null,
			'schema' => null,
		)
	);
}

// функция получения полей категории
function get_cat($object, $field_name, $request) {
	global $post;
	$cat = get_the_terms($post->ID, 'product-cat');
	$res = array(
		'id' => $cat[0]->term_id, // ИД категории
		'name' => $cat[0]->name, // Название категории
		'slug' => $cat[0]->slug, // Ярлык категории
		'desc' => $cat[0]->description, // Описание категории (задается на странице редактирования категории)
		'edition' => $cat[0]->edition, // Количество записей в категории
	);
	return $res;
}

// Добавляем картинку продукта в rest_api ответ
add_action('rest_api_init', 'add_product_thumbnail');
function add_product_thumbnail() {
	register_rest_field(
		'product',
		'thumbnail', // название поля в json ответе
		array(
			'get_callback' => 'get_product_thumbnail', // функция получения картинки продукта
			'update_callback' => null,
			'schema' => null,
		)
	);
}

// Добавляем дополнительные картинки продукта в rest_api ответ
add_action('rest_api_init', 'add_custom_fields');
function add_custom_fields() {
	register_rest_field(
		'product',
		'moreImages', // название поля в json ответе
		array(
			'get_callback' => 'get_custom_fields', // функция получения дополнительных картинок продукта
			'update_callback' => null,
			'schema' => null,
		)
	);
}

// функция получения дополнительных картинок продукта
function get_custom_fields($object, $field_name, $request) {
	global $post;
	$image = get_post_meta($post->ID, '_link', true);
	$image = explode(",", $image);
	$res = array();
	foreach ($image as $images) {
		$url = wp_get_attachment_image_src($images, 1, 1);
		$res[] = $url[0];
		// echo wp_get_attachment_image($images, 'thumbnail', false, 1);
	}
	return $res;
}

function show_thumbnails_list() {
	global $post;
	$image = get_post_meta($post->ID, '_link', true);
	$image = explode(",", $image);
	foreach ($image as $images) {
		$url = wp_get_attachment_image_src($images, 1, 1);
		echo '<div class="col-md-2 np"><a class="img-responsive" href="';
		echo $url[0];
		echo '" data-lightbox="roadtrip">';
		echo wp_get_attachment_image($images, 'thumbnail', false, 1);
		echo '</a></div>';
	}
}