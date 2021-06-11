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
$post_types = get_post_types();
// Добавляем кастомный тип записи Продукты
add_action('init', 'my_custom_application');
function my_custom_application() {
	register_post_type('application', array(
		'labels' => array(
			'name' => 'Заявки',
			'singular_name' => 'Заявка',
			'add_new' => 'Добавить новую',
			'add_new_item' => 'Добавить новую заявку',
			'edit_item' => 'Редактировать заявку',
			'new_item' => 'Новая заявка',
			'view_item' => 'Посмотреть заявку',
			'search_items' => 'Найти заявку',
			'not_found' => 'Заявок не найдено',
			'not_found_in_trash' => 'В корзине заявок не найдено',
			'parent_item_colon' => '',
			'menu_name' => 'Заявки',

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
		'rest_base' => 'application',
	));

	// Добавляем для кастомных типо записей Категории
	register_taxonomy(
		"application-cat",
		array("application"),
		array(
			"hierarchical" => true,
			"label" => "Категории",
			"singular_label" => "Категория",
			"rewrite" => array('slug' => 'application', 'with_front' => false),
		)
	);
}
//<span class="update-plugins count-5"><span class="update-count">5</span></span>

//  функция вывода прикрепленных файлов
//metabox
if($post_types == 'application'){
	add_action("admin_init", "application_fileinit");
	function application_fileinit()
	{
			foreach ($post_types as $post_type) {
					add_meta_box("my-images", "Прикрепленные файлы", "application_filelink", $post_type, "normal", "low");
			}
	}
	function application_filelink(){
			global $post;
			$custom = get_post_custom($post->ID);
			if($custom["_link"]){
				$link = $custom["_link"][0];
				$count = 0;
				$attachments = get_attached_media( '', $post->ID );
				echo '<div class="link_header">';
				echo '<div class="frame">';
				foreach ($attachments as $file) {
					$fileType = explode('/', get_post_mime_type($file->ID));
							if($fileType[0] == 'image'){
								echo '<a href="' . $file->guid . '" class="file" target="_blank"><div class="img" style="background-image: url(' . $file->guid . ');"></div></a>';
							}else{
								echo '<a href="' . $file->guid . '" class="file" download><i class="fa fa-file-o"></i><span>'.$file->post_title.'</span></a>';
							}
						$count++;
				}
				echo '<br /></div></div>';
				echo '<input type="hidden" name="link" class="field" value="' . $link . '" />';
				// echo '<div class="application_filecount"><span>Files: <b>' . $count . '</b></span> <div class="count-selected"></div></div>';
		}
	}
	add_action('admin_head-post.php', 'application_filecss');
	add_action('admin_head-post-new.php', 'application_filecss');
	function application_filecss(){?>
		<link rel="stylesheet" href="<?=get_template_directory_uri();?>/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<style type="text/css">
			#my-images .inside{overflow: hidden; padding:0px !important;margin:0px !important;}
			.frame{
				height: auto;
				background:#e5e5e5;
				padding:15px;
			}
			.frame .file{
				display: block;
				position: relative;
				float: left;
				width: 120px;
				height: 120px;
				color: #fff;
				text-align: center;
				overflow: hidden;
				background-color: #f5cd79;
				border-radius: 12px;
				margin: 0px 0px 0px 10px;
			}
			.frame .file span{
				position: absolute;
				display: block;
				width: 100%;
				height: 100%;
				left: 0;
				top: 0;
				color: #fff;
				padding: 30px 0;
				text-align: center;
				transition: transform 0.2s ease;
				transform: translateY(-200px);
				background-color: rgba(0, 0, 0, 0.6);
			}
			.frame .file:hover span{
				transition: transform 0.2s ease;
				transform: translateY(-0px);
			}
			.frame .file .fa{
				font-size: 6rem;
				line-height: 120px;
			}
			.frame .file .img{
				position: absolute;
				width: 100%;
				height: 100%;
				background-position: 50% 50%;
				background-repeat: no-repeat;
				background-size: cover;
				display: block;
			}
		</style>
	<?php 
	}
}