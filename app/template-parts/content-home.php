<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package RoyalPrint
 */
function kFormatter($num) {
  $formatter = new NumberFormatter('ru_RU',  NumberFormatter::CURRENCY);
  echo $formatter->formatCurrency($num, 'RUB'), PHP_EOL;
}
 // product cat
$productCat = get_term( 6 );
$productOffsetCat = get_term( 5 );
$productFlexCat = get_term( 4 );

// advantages cat
$advantagesCat = get_term( 8 );

// works cat
$worksCat = get_term( 7 );

// partner cat
$partnerCat = get_term( 9 );
?>
<section id="services" data-name="<?=$productCat->name?>">
  <div class="section_title">
  <h1>Что мы можем Вам предложить</h1>
  </div>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <ul class="tabs">
          <li class="tabs_item active" data-tab="1"><?=$productOffsetCat->name?></li>
          <li class="tabs_item" data-tab="2"><?=$productFlexCat->name?></li>
        </ul>
      </div>
      <div class="col-12">
        <div class="tabs_content active" id="tab-1">
          <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
            <?=$productOffsetCat->description?>
            </div>
            <div class="col-12 col-xl-8">
              <div class="slider_carousel owl-carousel">
                <?
                $reviews = new WP_Query(
                array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'tax_query' => array(
                array(
                'taxonomy' => 'product-cat', //double check your taxonomy name in you dd
                'field' => 'id',
                'terms' => 4,
                ),
                ),
                ));
                if ($reviews->have_posts()) {while ($reviews->have_posts()) {$reviews->the_post();
                $custom = get_post_custom($post->ID);
                ?>
                <div class="slider_item" data-select="<?php the_title();?>-<?=$post->ID?>" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>')">
                  <div class="slider_item_imgwrap">
                    <div class="slider_item_img" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>')"></div>
                  </div>
                  <div class="slider_item_content">
                    <h3 class="slider_item_title"><?php the_title();?></h3>
                    <p class="slider_item_desc"><?php the_content();?></p>
                    <ul class="slider_item_list">
                      <li class="slider_item_list_item">
                        <span><i class="fa fa-tag"></i> Цена</span>
                        <?if(isset($custom['product_priceparam'][0]) and $custom['product_priceparam'][0] == 'on'){?>
                          <span>
                            <?=kFormatter($custom['product_price'][0] * $custom['product_edition'][0])?> 
                            <i class="fa fa-rub"></i></span>
                        <?}else{?>
                          <span>Индивидуальная <i class="fa fa-rub"></i></span>
                        <?}?>
                      </li>
                      <?if(isset($custom['product_priceparam'][0]) and $custom['product_priceparam'][0] == 'on'){?>
                        <li class="slider_item_list_item">
                          <span><i class="fa fa-archive"></i> Тираж</span>
                          <span><?=$custom['product_edition'][0]?> шт.</span>
                        </li>
                      <?}?>
                    </ul>
                  </div>
                </div>
                <?}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
              </div>
            </div>
          </div>
        </div>
        <div class="tabs_content" id="tab-2">
          <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
            <?=$productFlexCat->description?>
            </div>
            <div class="col-12 col-xl-8">
              <div class="slider_carousel owl-carousel">
                <?
                $product = new WP_Query(
                array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'tax_query' => array(
                array(
                'taxonomy' => 'product-cat', //double check your taxonomy name in you dd
                'field' => 'id',
                'terms' => 5,
                ),
                ),
                ));
                if ($product->have_posts()) {while ($product->have_posts()) {$product->the_post();
                $product_custom = get_post_custom($post->ID);
                ?>
                <div class="slider_item" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>')">
                  <div class="slider_item_imgwrap">
                    <div class="slider_item_img" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>')"></div>
                  </div>
                  <div class="slider_item_content">
                    <h3 class="slider_item_title"><?php the_title();?></h3>
                    <p class="slider_item_desc"><?php the_content();?></p>
                    <ul class="slider_item_list">
                      <li class="slider_item_list_item">
                        <span><i class="fa fa-tag"></i> Цена</span>
                        <?if(isset($custom['product_priceparam'][0]) and $custom['product_priceparam'][0] == 'on'){?>
                          <span>
                            <?=kFormatter($custom['product_price'][0] * $custom['product_edition'][0])?> 
                            <i class="fa fa-rub"></i></span>
                        <?}else{?>
                          <span>Индивидуальная <i class="fa fa-rub"></i></span>
                        <?}?>
                      </li>
                      <?if(isset($custom['product_priceparam'][0]) and $custom['product_priceparam'][0] == 'on'){?>
                        <li class="slider_item_list_item">
                          <span><i class="fa fa-archive"></i> Тираж</span>
                          <span><?=$custom['product_edition'][0]?> шт.</span>
                        </li>
                      <?}?>
                    </ul>
                  </div>
                </div>
                <?}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="decor_img">
    <img src="<?=get_template_directory_uri()?>/img/visit_card.png" alt="">
  </div>
</section>
<section id="advantages" data-name="<?=$advantagesCat->name?>">
  <div class="section_title">
      <h1>Почему Вам стоит работать с нами</h1>
  </div>
  <div class="container">
    <div class="row">
    <?
    $advantages = new WP_Query(
    array(
    'post_type' => 'dvantages',
    'post_status' => 'publish',
    ));
    if ($advantages->have_posts()) {while ($advantages->have_posts()) {$advantages->the_post();
    ?>
      <div class="col-12 col-xl-4 align-self-center">
        <div class="advantages_item">
          <img class="advantages_item_img" src="<?=get_the_post_thumbnail_url($post->ID, 'large')?>" alt="">
          <h3 class="advantages_item_title"><?php the_title();?></h3>
          <div class="advantages_item_desc"><?php the_content();?></div>
        </div>
      </div>
      <?}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
    </div>
  </div>
</section>
<section id="works" data-name="<?=$worksCat->name;?>">
  <div class="section_title">
    <h1>Результаты нашей работы</h1>
  </div>
  <div class="decor_img">
    <img src="<?=get_template_directory_uri()?>/img/color_btl.png" alt="">
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12 col-xl-6 offset-xl-3">
        <div class="section_desc">
        <?=$worksCat->description;?>
        </div>
      </div>
        <div class="parent">
          <?
          $product = new WP_Query(
          array(
          'post_type' => 'works',
          'post_status' => 'publish',
          'posts_per_page'=> -1
          ));
          if ($product->have_posts()) {while ($product->have_posts()) {
            $product->the_post();
            $product_custom = get_post_custom($post->ID);
          ?>
            <div class="grid_item" style="background-image: url('<?=get_the_post_thumbnail_url($post->ID, 'large')?>');" data-img="<?=get_the_post_thumbnail_url($post->ID, 'large')?>">
            <!-- <div class="grid_item_media" style="background-image: url('<?//=get_the_post_thumbnail_url($post->ID, 'large')?>');"></div> -->
              <div class="grid_item_content">
                <h3 class="grid_item_content_title"><?php the_title();?></h3>
                <?php the_content();?>
              </div>
            </div>
          <?}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
        </div>
    </div>
  </div>
</section>
<section id="partner" data-name="<?=$partnerCat->name;?>">
  <div class="section_title">
    <h1>С кем мы сотрудничаем</h1>
  </div>
  <div class="container">
    <div class="row">
      <div class="partner_carousel owl-carousel">
        <?
        $product = new WP_Query(
        array(
        'post_type' => 'partner',
        'post_status' => 'publish',
        'posts_per_page'=> -1
        ));
        if ($product->have_posts()) {while ($product->have_posts()) {$product->the_post();
        $product_custom = get_post_custom($post->ID);
        ?>
        <div class="partner_item">
          <div class="partner_item_imgwrap">
            <img class="partner_item_img" src="<?=get_the_post_thumbnail_url($post->ID, 'large')?>" alt="">
          </div>
        </div>
        <?}} else {echo 'Ничего не найдено';}wp_reset_postdata();?>
      </div>
    </div>
  </div>
</section>

