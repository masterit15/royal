<?
add_action('customize_register', function($customizer) {
	$customizer->add_section(
		'section_one', array(
			'title' => 'Настройки сайта',
			'description' => '',
			'priority' => 11,
		)
	);
  // телефон общий
	$customizer->add_setting('phone', 
		array('default' => '+78672517679')
	);
	$customizer->add_control('phone', array(
    'label' => 'Телефон',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // телефон офсетная печать
	$customizer->add_setting('phone_offset', 
    array('default' => '+79891317745')
  );
  $customizer->add_control('phone_offset', array(
    'label' => 'Телефон (офсетная печать)',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // телефон флексопечать
  $customizer->add_setting('phone_flex', 
    array('default' => '+79284984445')
  );
  $customizer->add_control('phone_flex', array(
    'label' => 'Телефон (флексопечать)',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // Е-почта флексопечать
  $customizer->add_setting('email_flex', 
    array('default' => 'flexa.royalprint@inbox.ru')
  );
  $customizer->add_control('email_flex', array(
    'label' => 'Е-почта (флексопечать)',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // Е-почта офсетная
  $customizer->add_setting('email_offset', 
    array('default' => 'royalprint@inbox.ru')
  );
  $customizer->add_control('email_offset', array(
    'label' => 'Е-почта (флексопечать)',
    'section' => 'section_one',
    'type' => 'text',
  ));
  // адрес
  $customizer->add_setting('address', 
		array('default' => 'РСО-Алания, г.Владикавказ, ул.Николаева 4')
	);
	$customizer->add_control('address', array(
    'label' => 'Адрес',
    'section' => 'section_one',
    'type' => 'text',
	));
  // копирайт сайта
  $customizer->add_setting('copyright', 
    array('default' => 'RoyalPrint © 2021. Все права защищены')
  );
  $customizer->add_control('copyright', array(
    'label' => 'Копирайт сайта (copyright ©)',
    'section' => 'section_one',
    'type' => 'text',
  ));
  //======================================================
  $customizer->add_section(
		'section_two', array(
    'title' => 'Настройка секций сайта',
    'description' => '',
    'priority' => 11,
	));
  // Заголовок секции (оффер)
  $customizer->add_setting('offer_title', 
		array('default' => 'Полиграфия высшего класса')
	);
	$customizer->add_control('offer_title', array(
    'label' => 'Заголовок секции (оффер)',
    'section' => 'section_two',
    'type' => 'text',
	));
  // Описание секции (оффер)
  $customizer->add_setting('offer_text', 
		array('default' => 'Оказываем весь комплекс полиграфических услуг: каталоги, листовки, плакаты, календари, журналы, упаковку, и, конечно же, этикетки.')
	);
	$customizer->add_control('offer_text', array(
    'label' => 'Описание секции (оффер)',
    'section' => 'section_two',
    'type' => 'textarea',
  ));

  // Заголовок секции (продукты)
  $customizer->add_setting('product_title', 
		array('default' => 'Что мы можем Вам предложить')
	);
	$customizer->add_control('product_title', array(
    'label' => 'Заголовок секции (продукты)',
    'section' => 'section_two',
    'type' => 'text',
	));
  // Описание секции (продукты)
  $customizer->add_setting('product_text', 
		array('default' => '')
	);
	$customizer->add_control('product_text', array(
    'label' => 'Описание секции (продукты)',
    'section' => 'section_two',
    'type' => 'textarea',
  ));
  
  // Заголовок секции (преимущесва)
  $customizer->add_setting('advantages_title', 
		array('default' => 'Почему Вам стоит работать с нами')
	);
	$customizer->add_control('advantages_title', array(
    'label' => 'Заголовок секции (преимущесва)',
    'section' => 'section_two',
    'type' => 'text',
	));
  // Описание секции (преимущесва)
  $customizer->add_setting('advantages_text', 
		array('default' => '')
	);
	$customizer->add_control('advantages_text', array(
    'label' => 'Описание секции (преимущесва)',
    'section' => 'section_two',
    'type' => 'textarea',
  ));
  // Заголовок секции (работы)
  $customizer->add_setting('works_title', 
		array('default' => 'Результаты нашей работы')
	);
	$customizer->add_control('works_title', array(
    'label' => 'Заголовок секции (работы)',
    'section' => 'section_two',
    'type' => 'text',
	));
  // Описание секции (работы)
  $customizer->add_setting('works_text', 
		array('default' => 'Дизайн-бюро нашей компании поможет разработать специальную упаковку и дизайн в соответствии с пожеланиями и в фирменном стиле компании-заказчика.')
	);
	$customizer->add_control('works_text', array(
    'label' => 'Описание секции (работы)',
    'section' => 'section_two',
    'type' => 'textarea',
  ));

  // Заголовок секции (партнеры)
  $customizer->add_setting('partner_title', 
		array('default' => 'С кем мы сотрудничаем')
	);
	$customizer->add_control('partner_title', array(
    'label' => 'Заголовок секции (партнеры)',
    'section' => 'section_two',
    'type' => 'text',
	));
  // Описание секции (партнеры)
  $customizer->add_setting('partner_text', 
		array('default' => '')
	);
	$customizer->add_control('partner_text', array(
    'label' => 'Описание секции (партнеры)',
    'section' => 'section_two',
    'type' => 'textarea',
  ));
  //==========================================================
  // $customizer->add_section(
	// 	'section_sec', array(
  //   'title' => 'Низ сайта (footer)',
  //   'description' => '',
  //   'priority' => 11,
	// ));
});