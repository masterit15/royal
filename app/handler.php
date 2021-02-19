<?php
/* Define these, So that WP functions work inside this file */
define('WP_USE_THEMES', false);
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header("Content-type: application/json; charset=utf-8");

// Функция для получения данных reCaptcha
function returnReCaptcha($token) {
    // URL куда отправлять токин и секретный ключ
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    
    // Параметры отправленных данных
    $params = [
        'secret' => '6Ld-_vkZAAAAAH70kkvuFX7HZbYlsnAhEPLM0PR6', // Секретный ключ
        'response' => $token, // Токин
        'remoteip' => $_SERVER['REMOTE_ADDR'], // IP-адрес пользователя
    ];
    
    // Делаем запрос
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Отправляем запрос 
    $response = curl_exec($ch);
    
    // Возвращаем массив полученных данных
    return json_decode($response, true);
}
 
// Проверка, что есть POST запрос
if ($_POST) {
  $is_valid = returnReCaptcha($_POST['token']);
  $res = array(
    'success' => false,
    'message'=> '',
    'rechaptcha' => '',
    'postres' => $_POST,
    'postfiles' => $_FILES
  );
  if($is_valid['success']){
    $feed = array(
      'first_name' => $_POST['first_name'],
      'name' => $_POST['name'],
      'last_name' => $_POST['last_name'],
      'contact' => $_POST['contact'],
      'product' => $_POST['product'],
      'edition' => $_POST['edition'],
      // 'design' => $_POST['design'] ? 'Да' : 'Нет',
      'price' => $_POST['price']
    );
    $postContent =  'ФИО заказчика: ' .' '. $feed['first_name'] .' '. $feed['name'] .' '. $feed['last_name'] .'<br>'.
                    'Выбранный продукт: ' . $feed['product'] . '<br>' .
                    'Тираж: ' . $feed['edition'] . ' шт. <br>' .
                    'Контактные данные: ' . $feed['contact'] . '<br>' .
                    // 'Дизайн: ' . $feed['design'] . '<br>' .
                    'Сумма: ' . $feed['price'] . ' руб.';

    if($feed['contact'] and $feed['product'] and $feed['first_name'] and $feed['name'] and $feed['last_name']) {
      $new_post = array(
      'ID'             => "", // Вы обновляете существующий пост?
      'menu_order'     => "", // Если запись "постоянная страница", установите её порядок в меню.
      'comment_status' => 'closed' | 'open', // 'closed' означает, что комментарии закрыты.
      'ping_status'    => 'closed' | 'open', // 'closed' означает, что пинги и уведомления выключены.
      'pinged'         => "",  //?
      'post_author'    => 1, // ID автора записи
      'post_content'   => $postContent, // Полный текст записи.
      'post_date'      => date('Y-m-d H:i:s'), // Время, когда запись была создана.
      'post_date_gmt'  => date('Y-m-d H:i:s'), // Время, когда запись была создана в GMT.
      'post_excerpt'   => "", // Цитата (пояснительный текст) записи.
      'post_name'      => "", // Альтернативное название записи (slug) будет использовано в УРЛе.
      'post_parent'    => "", // ID родительской записи, если нужно.
      'post_password'  => "", // Пароль для просмотра записи.
      'post_status'    => 'publish', // Статус создаваемой записи. 'draft' | 'publish' | 'pending'| 'future' | 'private'
      'post_title'     => $feed['first_name'] . ' ' . $feed['name'] . ' '.$feed['last_name'], // Заголовок (название) записи.
      'post_type'      => 'application',// Тип записи.
      'post_category'  => array(), // Категория к которой относится пост (указываем ярлыки, имена или ID).
      'tags_input'     => array(), // Метки поста (указываем ярлыки, имена или ID).
      // 'tax_input'      => array( 'taxonomy_name' => array() ), // К каким таксам прикрепить запись (указываем ярлыки, имена или ID).
      'to_ping'        => "", //?
      // 'meta_input'     => [ 'meta_key'=>'meta_value' ], // добавит указанные мета поля. По умолчанию: ''. с версии 4.4.
      );
      
      $post_id = wp_insert_post($new_post);

      $post = get_post($post_id);

      if ( $_FILES ) { 
        $files = $_FILES["more_photos"];  
            foreach ($files['name'] as $key => $value) {            
                if ($files['name'][$key]) { 
                    $file = array( 
                        'name' => $files['name'][$key],
                        'type' => $files['type'][$key], 
                        'tmp_name' => $files['tmp_name'][$key], 
                        'error' => $files['error'][$key],
                        'size' => $files['size'][$key]
                    ); 
                    $_FILES = array ("my_file_upload" => $file); 
                    foreach ($_FILES as $file => $array) {              
                        $newupload = my_handle_attachment($file,$post->ID); 
                    }
                } 
            } 
        }

        if($post->ID){
          $res['success'] = true;
          $res['message'] = '<div class="success_message"> <div class="success_title"> <img src="'.get_template_directory_uri().'/img/Vector.svg"> <h3>Спасибо за заказ!</h3></div>'.
          '<p>Ваш заказ принят и будет обработан нашим менеджером в течении 10 минут. Оставайтесь на связи. Хорошего дня!</p></div>';
          $res['rechaptcha'] = $is_valid;
          // sendEmail($feed, $post->ID);
        }else{
          $res['success'] = false;
          $res['message'] = 'Возникла ошибка, сообщение не доставлено! Попробуйте отправить еще раз.';
          $res['rechaptcha'] = $is_valid;
        }
        echo json_encode($res);
    }
  }else{
    $res['success'] = false;
    $res['message'] = 'Извините, но Вы не прошли каптчу.';
    $res['rechaptcha'] = $is_valid;
    echo json_encode($res);
  }
}
?>