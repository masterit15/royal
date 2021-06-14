<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RoyalPrint
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <script src='https://www.google.com/recaptcha/api.js?render=6Ld-_vkZAAAAAKBfA3ZcdBimYvqFjpV2jLSYoiZ6'></script>
	<?php wp_head(); ?>
</head>
<?// body_class(); ?>
<body>
<?php wp_body_open(); ?>
<!-- begin wrapper -->
<div id="wrapper">
  <ul class="section_nav"></ul>
	<section id="hero" data-name="Главная">
    <header class="header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-6 col-xl-2 p-xl-0">
						<a href="/" class="logo">
						<?php 
						$name = explode('/', get_bloginfo('name')); 
						echo  $name[0].'<br>'.$name[1];
						?>
					</a>
          </div>
          <div class="col-6 col-xl-6 d-none d-xl-block">
            <ul class="top_menu menu"></ul>
          </div>
          <div class="col-6 col-xl-4 d-none d-xl-block">
          <div class="contact_top">
            <?php dynamic_sidebar( 'Контакты-вверху' ); ?>
          </div>
            
          </div>
          <div class="col-6 col-xl-2 offset-xl-8 p-xl-0 d-xl-none">
            <div class="mmenu_btn" @click="toggleMenu" ref="menu">
              <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
              </div>
							<!-- <ul class="menu"></ul> -->
              <ul class="menu"></ul>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="col-12 col-xl-6 p-xl-0">
      <div class="ofer">
          <div class="loader">
            <div class="dots">
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
              <div class="dot"></div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
              <defs>
                <filter id="goo">
                  <feGaussianBlur in="SourceGraphic" stdDeviation="12" result="blur" />
                  <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo" />
                  <feBlend in="SourceGraphic" in2="goo" />
                </filter>
              </defs>
            </svg>
          </div>
          <div class="forms"></div>
          <div class="ofer_text">
            <?php dynamic_sidebar( 'Контакты-адрес' ); ?>
            <h1>Полиграфия высшего класса</h1>
            <p>
            Оказываем весь комплекс полиграфических услуг:<br> каталоги,
            листовки, плакаты, календари, журналы, упаковку, и, конечно же,
            этикетки.
            </p>
            <div class="ofer_action">
              <button type="button" id="price_form_get" data-form="<?=get_template_directory_uri()?>/ajax-form.php" class="btn btn-secondary">Заказать</button>
              <!-- <a href="te" class="btn btn-outline-secondary" >Подробнее</a> -->
              <a href="tel:+79280704011" class="btn btn-outline-secondary">Позвонить</a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="ofer_soc">
        Будем рады видеть Вас в наших социальных сетях:
        <?
        wp_nav_menu( [
          'theme_location'  => 'socmenu',
          'menu'            => '', 
          'container'       => '', 
          'container_class' => '', 
          'container_id'    => '',
          'menu_class'      => 'socicon', 
          'menu_id'         => '',
          'echo'            => true,
          'fallback_cb'     => 'wp_page_menu',
          'before'          => '',
          'after'           => '',
          'link_before'     => '',
          'link_after'      => '',
          'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
          'depth'           => 0,
          'walker'          => '',
        ] );
        ?>
      </div>
  <div class="video-hero">
    <video class="video" loop="loop" autoplay="" muted="">
      <source src="#" type="video/mp4" />
      <source src="#" type="video/ogv" />
      <source src="<?=get_template_directory_uri()?>/video/video.webm" type="video/webm" />
    </video>
  </div>
  <div class="mouse">
    <span></span>
    <i class="fa fa-chevron-down"></i>
  </div>
</section>
