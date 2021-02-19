<?php
define('WP_USE_THEMES', false);
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
// функция отправки оповещения на Е-почту
$postContent =  'ФИО заказчика: ' .' '. $feed['first_name'] .' '. $feed['name'] .' '. $feed['last_name'] .'<br>'.
                'Выбранный продукт: ' . $feed['product'] . '<br>' .
                'Тираж: ' . $feed['edition'] . '<br>' .
                'Контактные данные: ' . $feed['contact'] . '<br>' .
                'Дизайн: ' . $feed['design'] . '<br>' .
                'Сумма: ' . $feed['price'];
function sendEmail($feed, $post_id){
	global $phpmailer;
		if ( !is_object( $phpmailer ) || !is_a( $phpmailer, 'PHPMailer' ) ) { // проверяем, существует ли объект $phpmailer и принадлежит ли он классу PHPMailer
			// если нет, то подключаем необходимые файлы с классами и создаём новый объект
			require_once ABSPATH . WPINC . '/class-phpmailer.php';
			require_once ABSPATH . WPINC . '/class-smtp.php';
			$phpmailer = new PHPMailer( true );
		}
		$attachments = get_attached_media( '', $post_id); // получаем прикрепленные файлы по ИД сообщения
		$phpmailer->ClearAttachments(); // если в объекте уже содержатся вложения, очищаем их
		$phpmailer->ClearCustomHeaders(); // то же самое касается заголовков письма
		$phpmailer->ClearReplyTos(); 
		$phpmailer->From = $feed['contact']; // от кого, Email
		$phpmailer->FromName = $feed['first_name'].' '.$feed['name'].' '.$feed['last_name']; // от кого, Имя
		$phpmailer->Subject = 'Сообщение с сайта от: '.$feed['first_name'].' '.$feed['name'].' '.$feed['last_name']; // тема
		$phpmailer->SingleTo = true; // это означает, что если получателей несколько, то отображаться будет всё равно только один (если непонятно, спросите, я вам подробно объясню в комментариях)
		$phpmailer->ContentType = 'text/html'; // тип содержимого письма
		$phpmailer->IsHTML( true );
		$phpmailer->CharSet = 'utf-8'; // кодировка письма
		$phpmailer->ClearAllRecipients(); // очищаем всех получателей
		$phpmailer->AddAddress('info@ittehgroup.ru'); // добавляем новый адрес получателя
		$phpmailer->Body = 	$postContent;
		foreach ($attachments as $k => $file) { // перебираем массив файлов
			$attachment_url = get_attached_file($file->ID); // получаем полный путь к файлу
			$phpmailer->AddAttachment($attachment_url); // добавляем вложение
		}
		$phpmailer->Send(); // отправка письма
}