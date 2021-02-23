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
		add_meta_box("product_field", "Дополнительные поля", "product_field", 'product', "normal", "low");
	}
}
//Дополнительные поля продукта html
function product_field() {
	global $post;
	$custom = get_post_custom($post->ID);
	?>
  <div class="product_fields">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.js"></script>

    <?if ($custom['product_price']) {?>
      <input class="product_fields_price" name="price" step="0.01" min="0" placeholder="Цена 0.00 р." value="<?=$custom['product_price'][0]?>">
    <?} else {?>
      <input class="product_fields_price" name="price" type="number" step="0.01" min="0" placeholder="Цена 0.00 р.">
    <?}?>

    <?if ($custom['product_edition']) {?>
      <input class="product_fields_edition" name="edition" type="number" value="<?=$custom['product_edition'][0]?>" placeholder="Тираж">
    <?} else {?>
      <input class="product_fields_edition" name="edition" type="number" placeholder="Тираж">
    <?}?>
		<script>
			$('.product_fields_price').mask('000.000.000.000.000.00', {reverse: true});
		</script>
  </div>
<?
}
// Функция сохранения полей продукта "Цена" и "Тираж"
function save_product_field() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "product_price", $_POST["price"]);
		update_post_meta($post->ID, "product_edition", $_POST["edition"]);
	}
}
// Добавляем js  для редактирования полей продукта
add_action('admin_head-post.php', 'product_js');
add_action('admin_head-post-new.php', 'product_js');
function product_js() {?>
  <script type="text/javascript">
      jQuery(document).ready(function($){
        $('.product_fields_price').on('input',function() {
          console.log($(this).val())
        });
        $('.product_fields_edition').on('input',function() {
          console.log($(this).val())
        });
      });
  </script>
<?php }

// Добавляем категории в rest_api ответ
add_action('rest_api_init', 'add_price');
function add_price() {
	register_rest_field(
		'product',
		'price', // название поля в json ответе
		array(
			'get_callback' => 'get_price', // функция получения полей категории
			'update_callback' => null,
			'schema' => null,
		)
	);
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
function getBGcolor($id){
	$img = get_the_post_thumbnail_url($id, 'large');
	$palate = ColorThief::getPalette($img, 6);
	$bg = 'linear-gradient(140deg,
          rgb(' . implode(",", $palate[0]) . '),
          rgb(' . implode(",", $palate[1]) . '),
          rgb(' . implode(",", $palate[2]) . '),
          rgb(' . implode(",", $palate[3]) . '),
          rgb(' . implode(",", $palate[4]) . '),
          rgb(' . implode(",", $palate[5]) . '))';
	return $bg;
}
// функция получения картинки продукта
function get_product_thumbnail($object, $field_name, $request) {
	global $post;
	$img = get_the_post_thumbnail_url($post->ID, 'large');
	$palate = ColorThief::getPalette($img, 6);

	$bg = 'linear-gradient(140deg,
          rgb(' . implode(",", $palate[0]) . '),
          rgb(' . implode(",", $palate[1]) . '),
          rgb(' . implode(",", $palate[2]) . '),
          rgb(' . implode(",", $palate[3]) . '),
          rgb(' . implode(",", $palate[4]) . '),
          rgb(' . implode(",", $palate[5]) . '))';
	$res = array(
		'img' => $img,
		'bg' => $bg,
	);
	return $res;
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

// Дополнительные изображения продукта
add_action("admin_init", "images_init");
add_action('save_post', 'save_images_link');
function images_init() {
	$post_types = get_post_types();
	foreach ($post_types as $post_type) {
		add_meta_box("my-images", "Дополнительные изображения", "images_link", 'product', "normal", "low");
	}
}

//Дополнительные изображения продукта html
function images_link() {
	global $post;
	$custom = get_post_custom($post->ID);
	$link = $custom["_link"][0];
	$edition = 0;
	echo '<div class="link_header">';
	$query_images_args = array(
		'post_type' => 'attachment',
		'post_mime_type' => array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'gif' => 'image/gif',
			'png' => 'image/png',
		),
		'post_status' => 'inherit',
		'posts_per_page' => -1,
	);
	$query_images = new WP_Query($query_images_args);
	$images = array();
	echo '<div class="frame">';
	$thelinks = explode(',', $link);
	foreach ($query_images->posts as $file) {
		if (in_array($images[] = $file->ID, $thelinks)) {
			echo '<label><input type="checkbox" group="images" value="' . $images[] = $file->ID . '" checked /><img src="' . $images[] = $file->guid . '" width="60" height="60" /></label>';
		} else {
			echo '<label><input type="checkbox" group="images" value="' . $images[] = $file->ID . '" /><img src="' . $images[] = $file->guid . '" width="60" height="60" /></label>';
		}
		$edition++;
	}
	echo '<br /><br /></div></div>';
	echo '<input type="hidden" name="link" class="field" value="' . $link . '" />';
	echo '<div class="images_edition"><span>Files: <b>' . $edition . '</b></span> <div class="edition-selected"></div></div>';
}

// Функция сохранения изображений продукта
function save_images_link() {
	global $post;
	if ($post) {
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {return $post->ID;}
		update_post_meta($post->ID, "_link", $_POST["link"]);
	}
}

// Добавляем css  для редактирования изображений продукта
add_action('admin_head-post.php', 'images_css');
add_action('admin_head-post-new.php', 'images_css');
function images_css() {
	echo '<style type="text/css">
        #my-images .inside{padding:0px !important;margin:0px !important;}
    .frame{
        width:100%;
        height:320px;
        overflow:auto;
        background:#e5e5e5;
        padding-bottom:10px;
    }
    .field{width:800px;}
        #results {
    width:100%;
    overflow:auto;
    background:#e5e5e5;
    padding:0px 0px 10px 0px;
    margin:0px 0px 0px 0px;
    }
            #results img{
    border:solid 5px #FDD153;
    -moz-border-radius:3px;
    margin:10px 0px 0px 10px;
    }
    .frame label{
        margin:10px 0px 0px 10px;
        padding:5px;
        background:#fff;
        -moz-border-radius:3px;
        border:solid 1px #B5B5B5;
        height:60px;
        display:block;
        float:left;
        overflow:hidden;
    }
    .frame label:hover{
        background:#74D3F2;
    }
    .frame label.checked{background:#FDD153 !important;}
    .frame label input{
        opacity:0.0;
        position:absolute;
        top:-20px;
    }
    .images_edition{
        font-size:10px;
        color:#666;
        text-transform:uppercase;
        background:#f3f3f3;
        border-top:solid 1px #ccc;
        position:relative;
    }
    .selected_title{border-top:solid 1px #ccc;}
    .images_edition span{
        color:#666;
        padding:10px 6px 6px 12px;
        display:block;
    }
    .edition-selected{
        font-size:9px;
        font-weight:bold;
        text-transform:normal;
        position:absolute;
        top:10px;
        right:10px;
    }
    </style>';
}

// Добавляем js  для редактирования изображений продукта
add_action('admin_head-post.php', 'images_js');
add_action('admin_head-post-new.php', 'images_js');
function images_js() {?>
  <script type="text/javascript">
      jQuery(document).ready(function($){
        $('.frame input').change(function() {
          var values = new Array();
          $("#results").empty();
          var result = new Array();
          $.each($(".frame input:checked"), function() {
              result.push($(this).attr("value"));
              $(this).parent().addClass('checked');
          });
          $('.field').val(result.join(','));
          $('.edition-selected').text('Selected: '+result.length);
          $.each($(".frame input:not(:checked)"), function() {
              $(this).parent().removeClass('checked');
          });
      });
        var result = new Array();
        $.each($(".frame input:checked"), function() {
          result.push($(this).attr("value"));
          $(this).parent().addClass('checked');
      });
        $('.field').val(result.join(','));
        $('.edition-selected').text('Selected: '+result.length);
        $.each($(".frame input:not(:checked)"), function() {
          $(this).parent().removeClass('checked');
      });
    });
  </script>
<?php }
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