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
		array('default' => '+79280704011')
	);
	
	$customizer->add_control('phone', array(
			'label' => 'Телефон',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
  // телефон офсетная печать
	$customizer->add_setting('phone_offset', 
  array('default' => '+78672517679')
  );

  $customizer->add_control('phone_offset', array(
      'label' => 'Телефон (офсетная печать)',
      'section' => 'section_one',
      'type' => 'text',
    )
  );
  // телефон флексопечать
  $customizer->add_setting('phone_flex', 
  array('default' => '+79284984445')
  );

  $customizer->add_control('phone_flex', array(
    'label' => 'Телефон (флексопечать)',
    'section' => 'section_one',
    'type' => 'text',
  )
  );
  // адрес
  $customizer->add_setting('address', 
		array('default' => 'РСО-Алания, г.Владикавказ, ул.Николаева 4')
	);
	
	$customizer->add_control('address', array(
			'label' => 'Адрес',
			'section' => 'section_one',
			'type' => 'text',
		)
	);
  //======================================================
  $customizer->add_section(
		'section_two', array(
			'title' => 'Оффер',
			'description' => '',
			'priority' => 11,
		)
	);
  // заголовок сайта (оффера)
  $customizer->add_setting('offer_title', 
		array('default' => 'Полиграфия высшего класса')
	);
	
	$customizer->add_control('offer_title', array(
			'label' => 'Заголовок (оффера)',
			'section' => 'section_two',
			'type' => 'text',
		)
	);
  // Описание сайта (оффера)
  $customizer->add_setting('offer_text', 
		array('default' => 'Оказываем весь комплекс полиграфических услуг: каталоги, листовки, плакаты, календари, журналы, упаковку, и, конечно же, этикетки.')
	);
	
	$customizer->add_control('offer_text', array(
			'label' => 'Описание (оффера)',
			'section' => 'section_two',
			'type' => 'textarea',
		)
	);
});