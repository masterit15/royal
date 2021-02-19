<?php
/* Define these, So that WP functions work inside this file */
define('WP_USE_THEMES', false);
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
?>
<form id="product_form" action="<?=get_template_directory_uri()?>/handler.php" method="post" enctype="multipart/form-data">
  <div class="form_col_left">
    <div class="form_item">
      <div class="product_select">
        <label for="product_form_select">Выбор продуции</label>
        <select class="select" name="product" id="product_form_select">
          <?
          $reviews = new WP_Query(
          array(
          'post_type' => 'product',
          'post_status' => 'publish',
          ));
          if ($reviews->have_posts()) {while ($reviews->have_posts()) {$reviews->the_post();
          $custom = get_post_custom($post->ID);
          ?>
            <option data-price="<?=$custom['product_price'][0]?>" data-min-edition="<?=$custom['product_edition'][0]?>" value="<?php the_title();?>-<?=$post->ID?>"><?php the_title();?> - <?=$custom['product_price'][0]?> р.ш.</option>
          <?}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
        </select>
      </div>
    </div>
    <div class="form_item">
      <label for="edition">Тираж</label>
      <div class="range">
        <div class="range_input">
          <div id="product_form_edition" class="js-range"></div>
        </div>
        <div class="range_value">
          <div class="arrow"> 
            <span class="arrow-plus"><i class="fa fa-angle-up"></i></span>
            <span class="arrow-minus"><i class="fa fa-angle-down"></i></span>
          </div>
          <input id="product_form_edition_number" name="edition" class="value" type="text" value="2000"/>
        </div>
      </div>
    </div>
    <div class="form_item">
      <label class="checkbox" for="product_form_design">
        <input type="checkbox" name="design" id="product_form_design" checked>
        <span>Разработка дизайна</span>
      </label>
      <div class="fileuploader"></div>
    </div>
  </div>
  <div class="form_col_right">
    <div class="form_item">
      <label for="product_form_fname">Фамилия</label>
      <input class="input" type="text" name="first_name" id="product_form_fname">
    </div>
    <div class="form_item">
      <label for="product_form_name">Имя</label>
      <input class="input" type="text" name="name" id="product_form_name">
    </div>
    <div class="form_item">
      <label for="product_form_lname">Отчество</label>
      <input class="input" type="text" name="last_name" id="product_form_lname">
    </div>
    <div class="form_item">
        <label for="product_form_mail_or_phone">Номер телефона или email:</label>
        <div class="mail_or_phone">
          <div class="mail_or_phone_val"></div>
          <input class="input" type="text" name="contact" id="product_form_mail_or_phone">
        </div>
    </div>
    </div>
    <div class="form_bottom">        
      <div class="price">
        <div class="price_left">
          <img src="<?=get_template_directory_uri()?>/img/price_left.png">
        </div>
        <div class="price_mid">
          <div class="prices"><i class="fa fa-rub"></i><span>0</span></div>
          Стоимость
        </div>
        <div class="price_right">
          <img src="<?=get_template_directory_uri()?>/img/price_right.png">
        </div>
        <input type="hidden" name="price">
      </div>
      <span class="close">Отмена</span>
    </div>
    <input id="token" type="hidden" name="token">
</form>