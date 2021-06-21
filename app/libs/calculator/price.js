$(function () {
  var priceMid = { score: 0 };
  var productSelected = '';
  var formFiles = [];
  const fileUpload = `<div class="form_row__photo-previews">
                        <p class="form_row_text">Подгрузите файлы собственного дизайна, один вайл не должен привышать <strong>2мб</strong>, допустимый форматы <strong>"png,jpg,tif,pdf,psd,ai,svg"</strong>!</p>
                        <input type="file" name="more_photos[]" multiple id="js-photo-upload">
                        <div class="add_photo-content">
                        <div class="add_photo-item"></div>
                        <ul id="uploadImagesList">
                            <li class="item">
                                <span class="icon-wrap">
                                    <i class="fa"></i>
                                </span>
                                <span class="img-wrap">
                                    <img src="" alt="">
                                </span>
                                <span class="delete-link" title="Удалить">
                                    <i class="fa fa-times"></i>
                                </span>
                            </li>
                        </ul>
                        </div>
                        <div class="errormassege"></div>
                      </div>`
  // формируем объект пустых свойств продукта
  let product = {
    id: null,
    price: null,
    edition: null,
    designPrice: null,
    embossingPrice: null,
  }
  // отслеживаем изменения в свойствах продукта
  let productProxied = new Proxy(product, {
    get: function (target, prop) {
      // console.log({
      // 	type: "get",
      // 	target,
      // 	prop
      // });
      return Reflect.get(target, prop);
    },
    set: function (target, prop, value) {
      // console.log({
      //   type: "set",
      //   target,
      //   prop,
      //   value
      // });
      setTimeout(() => {
        priceCange(target);
      }, 10)

      return Reflect.set(target, prop, value);
    }
  });
  // функция определения значения в поле ввода Телефон/Email
  function validateEmailOrPhone(val) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (expr.test(val)) {
      return '<i class="fas fa-at"></i>'
    } else {
      expr = /[2-9]{1}\d{2}/;
      if (expr.test(val)) {
        return '<i class="fas fa-phone"></i>'
      } else {
        return false
      }
    }
    ;
  }
  // подгрузка формы при клике на продукт
  $('.slider_item').on('click', function () {
    if ($('#product_form').length > 0) {
      $('#product_form_select').select2('val', [$(this).data('select')])
      $('body,html').animate({ scrollTop: 0 }, 500)
    } else {
      $('.ofer #product_form').remove()
      $('.ofer_text').show()
      $('#price_form_get').trigger('click')
      productSelected = $(this).data('select')
      $('body,html').animate({ scrollTop: 0 }, 500)
    }
  })
  // функция обновления стоимости
  function priceCange(target) {
    let design
    if ($('#product_form_design').is(':checked')) {
      $('.fileuploader').html('')
      design = productProxied.designPrice
    } else {
      design = 0
      $('.fileuploader').html(fileUpload)
      uploaderImg('.add_photo-item', '#js-photo-upload', '#uploadImagesList', false, false);
    }
    // let edition = Number($('#product_form_edition_number').val())

    let price = (target.edition * target.price ) + design
    if (target.price && target.price > 0) {
      $('.price_mid').html(`<div class="price_mid">
                                      <div class="prices"><i class="fas fa-ruble-sign"></i> <span></span></div>
                                      Стоимость
                              </div>`)
      TweenMax.to(priceMid, 1, { score: `${price}`, onUpdate: updateHandler });
    } else {
      $('.price_mid').html(`<div class="price_mid"><h3>Отправить</h3></div>`)
    }
  }
  // функция анимирования стоимости
  function updateHandler() {
    let score = Number(priceMid.score)
    let formatPrice = numberWithCommas(score.toFixed(0))
    $('.price_mid span').html(formatPrice);
  }
  // функция форматирования стоимости "1000" "1,000"
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  // функция подгрузки формы заказа и расчета
  $('#price_form_get').on('click', function (e) {
    e.preventDefault()
    $.ajax({
      url: $(this).data('form'),
      type: 'GET',
      beforeSend: function () {
        $('.loader').fadeIn(100)
      },
      complete: function () {
      },
      success: function (res) {
        setTimeout(() => {
          applicationForm(res)
        }, 200)
        $('.loader').fadeOut(300)
      },
      error: function (xhr, ajaxOptions, thrownError) {
        mainToast(time = 5000, 'error', "Произошла ошибка отправки, попробуйте еще раз.", text = '')
        console.log(xhr.responseText)
        console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
      }
    })
    return false;
  })
  // округляем тираж в боьшую сторону 
  function roundStep(val1, val2) {
    // return Math.ceil(val1 / val2) * val2
    let startStep = Number($('option:selected', $('#product_form_select')).data('min-edition'))
    let res = Math.round(Number(val1) / Number(val2)) * Number(val2)
    return Number(val1) < startStep ? startStep : res
  }
  // функция добавления данных 
  function addData(Option){
    productProxied.id = Number($(Option).data('id'))
    productProxied.price = Number($(Option).data('price'))
    productProxied.edition = Number($(Option).data('min-edition'))
    productProxied.designPrice = Number($(Option).data('design-price'))
    productProxied.embossingPrice = Number($(Option).data('embossing-price'))
    $('#product_form_design').data('price', productProxied.designPrice)
    // если выбраны этикетки
    if (productProxied.id == 45) {
      // $('.product_params').remove()
      // $('.product_select').after(`
      //     <div class="product_params">
      //         <select name="product_params" id="product_params">
      //         <option value="#">Выбор бумаги</option>
      //         <option value="1">Офсетная бумага</option>
      //         <option value="2">Флексо бумага</option>
      //         <option value="3">Офсетная бумага</option>
      //         </select>
      //         <span class="question">
      //             <i class="far fa-question-circle"></i>
      //             <span class="question_text">Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Большой свой, переулка вопрос она рукопись не инициал что. Города которое буквоград по всей всемогущая текст деревни свое до заголовок страну.</span>
      //         </span>
      //     </div>
      // `)
      // $('#product_params').select2({
      //     language: 'ru',
      //     minimumResultsForSearch: -1
      // })
      // если выбраны визитки
    } else if (productProxied.id == 49) {
      // $('.product_select').after(`
      //     <div class="product_params">
      //         <div class="form_item">
      //             <label class="checkbox" for="product_form_visit_param">
      //             <input type="checkbox" name="visit_param" id="product_form_visit_param" data-price="${embossingPrice}">
      //             <span>Бумага с теснением</span>
      //             </label>
      //         </div>
      //         <span class="question">
      //             <i class="far fa-question-circle"></i>
      //             <span class="question_text">Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Большой свой, переулка вопрос она рукопись не инициал что. Города которое буквоград по всей всемогущая текст деревни свое до заголовок страну.</span>
      //         </span>
      //     </div>
      // `)
      
    }
  }
  // инициализируем всю ворму заказа продукта
  function applicationForm(form) {
    $('.ofer .forms').append(form);
    $('.ofer_text').hide();
    $('.select').select2({
      language: 'ru',
      minimumResultsForSearch: -1
    });
    var stepQuantity = $('option:selected', $('#product_form_select')).data('min-edition')
    addData($('option:selected', $('#product_form_select')))
    // инициализируем слайдер тиража
    function initSlider(step){
      $('#product_form_edition').slider({
        range: "min",
        max: productProxied.edition > 10000 ? productProxied.edition * 10 : 10000,
        min: stepQuantity,
        step: step,
        value: step,
        slide: function (e, ui) {
          productProxied.edition = ui.value
          stepQuantity = ui.value
          $('#product_form_edition_number').val(ui.value)
          rangeValid()
        },
        // change: function(event, ui) {
        //   productProxied.edition = ui.value
        // }
      });
    }
    // функция обработки выбора продукта
    if (productSelected != '') {
      $('#product_form_select').select2('val', [productSelected])
      addData($('option:selected', $('#product_form_select')))
      stepQuantity = Number($('option:selected', $('#product_form_select')).data('min-edition'))
      initSlider(stepQuantity)
      if(Number($('option:selected', $('#product_form_select')).data('min-edition')) == 0){
        $('.form_range').hide()
      }else{
        $('.form_range').show()
      }
    }
    // отслеживаем изменения списка продуктов
    $('#product_form_select').on("change", function (e) {
      addData($('option:selected', this))
      $('#product_form_edition_number').val(Number($('option:selected', this).data('min-edition')));
      stepQuantity = Number($('option:selected', $('#product_form_select')).data('min-edition'))
      initSlider(stepQuantity)
      if(Number($('option:selected', this).data('min-edition')) == 0){
        $('.form_range').hide()
      }else{
        $('.form_range').show()
      }
    })
    // проверям тираж на валидность
    function rangeValid() {
      $('.error_text').remove()
      if (Number($('.value').val()) < productProxied.id) {
        $('.range').addClass('error').after(`<span class="error_text">Ошибка, тираж должен быть кратным ${stepQuantity}</span>`)
        return false
      } else {
        $('.range').removeClass('error').next('.error_text')
        
        return true
      }
    }
    $('#product_form_edition_number').val(productProxied.edition);
    initSlider(productProxied.edition)
    // функция обработки клика по стрелкам поля тираж
    let $quantityArrowMinus = $(".arrow-minus");
    let $quantityArrowPlus = $(".arrow-plus");
    let $quantityNum = $('#product_form_edition_number').data('edition', stepQuantity) // поле тираж
    $quantityArrowMinus.on('click', quantityMinus);
    $quantityArrowPlus.on('click', quantityPlus);
    $quantityNum.on('input', function(){
        rangeValid()
    })
    // отслеживаем нажатие на стрелку вниз
    function quantityMinus() {
      let val = Number($quantityNum.val())
      $quantityNum.val(val - stepQuantity);
      if(rangeValid()){ 
        initSlider(Number($quantityNum.val()))
        productProxied.edition = Number($quantityNum.val())
      }
    }
    // отслеживаем нажатие на стрелку вверх
    function quantityPlus() {
      let val = Number($quantityNum.val())
      $quantityNum.val(val + stepQuantity);
      if(rangeValid()){ 
        initSlider(Number($quantityNum.val()))
        productProxied.edition = Number($quantityNum.val())
      }
    }
    /* отлеживам изменения в поле тираж если не соответствует 
     минимальному тиражу округляем в большую сторону до валидного значения
    */
    $('#product_form_edition_number').on('change', function () {
      if ($quantityNum.val() % productProxied.edition) {
        $(this).val(roundStep($quantityNum.val(), productProxied.edition))
      }
    })
    // меняем поле контактоа в зависимости от контекста 
    $('#product_form_mail_or_phone').on('input', function () {
      let res = validateEmailOrPhone($(this).val())
      if (res) {
        $('.mail_or_phone_val').html('')
        $('.mail_or_phone_val').append(res)
      } else {
        $('.mail_or_phone_val').html('')
      }
    });
    // закрываем форму при нажатии отмена
    $('#product_form .close').on('click', function () {
      $('.ofer #product_form').remove()
      $('.ofer_text').show()
    });
    // отслеживаем изменения галочки дизайн
    $('#product_form_design').on('change', function () {
      productProxied.designPrice = $(this).data('price')
    })
    // обновление токена каптчи
    grecaptcha.ready(function () {
      grecaptcha.execute('6Ld-_vkZAAAAAKBfA3ZcdBimYvqFjpV2jLSYoiZ6', { action: 'homepage' }).then(function (token) {
        document.getElementById('token').value = token
      });
    });
    // валидация формы
    $('input[required]').on('change', function () {
      let firstName = $('#product_form_fname').val()
      let name = $('#product_form_name').val()
      let mailOrphone = $('#product_form_mail_or_phone').val()
      if (firstName.length > 0 && name.length > 0 && validateEmailOrPhone(mailOrphone)) {
        $('.price').removeAttr('disabled')
      } else {
        $('.price').attr('disabled', '')
      }
    })
    // отправка заявки во внутрянку и на почту
    $('.price').on('click', function (e) {
      e.preventDefault()
      $('input[name="price"]').val($('.prices span').text())
      let data = new FormData($('#product_form')[0]);
      formFiles.map(file => {
        data.append('more_photos[]', file)
      })
      $.ajax({
        url: $('#product_form').attr('action'),
        type: 'POST',
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
          $('.forms').fadeOut(200)
          $('.loader').fadeIn(200)

        },
        complete: function () {
          //$('.loader').fadeOut(200)
        },
        success: function (res) {
          if (res.rechaptcha && res.success) {
            $('.forms').html(res.message)
            // mainToast(time = 5000, param = 'success', res.message, text = '')
          } else {
            $('.forms').html(res.message)
            mainToast(time = 5000, param = 'warning', res.message, text = '')
          }
          $('.forms').fadeIn(200)
          $('.loader').fadeOut(200)
        },
        error: function (xhr, ajaxOptions, thrownError) {
          console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
      })
    });
  }
  // функция подгрузки файлов дизайна в форму заказа продукта
  function uploaderImg(addButton, addInput, imgList, reset = false, edit = false) {
    $(addButton).on('click', function () {
      $(addInput).trigger('click');
    })
    var maxFileSize = 2 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
    var queue = {};
    var imagesList = $(imgList);
    var filelist = $('.file_list').children().length;
    // 'detach' подобно 'clone + remove'
    var itemPreviewTemplate = imagesList.find('.item').detach();
    // Вычисление лимита
    function limitUpload() {
      if (filelist > 0 || edit) {
        return 3 - filelist;
      } else if (filelist == 0 || !edit) {
        return 3 - imagesList.children().length;
      }
    }
    // Отображение лимита
    function limitDisplay() {
      let sTxt;
      switch (limitUpload()) {
        case 3:
          sTxt = '<span class="text">Прикрепить ' + limitUpload() + ' файлов</span> <span class="plus">+</span>';
          break;
        case 0:
          sTxt = 'Достигнут лимит';
          break;
        default:
          sTxt = '+ (можно добавить ещё ' + limitUpload() + ')';
      }
      $(addButton).html(sTxt);
    }
    function limitSize() {
      $(addInput).on('change', function () {
        var total = 0;
        for (var i = 0; i < this.files.length; i++) {
          total = total + this.files[i].size;
        }
        return total;
      });
    }
    limitSize();
    $(addInput).on('change', function () {
      var files = this.files;
      var fileTypeArr = [
        'jpeg',
        'jpg',
        'png',
        'pdf',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'zip',
        'rar',
      ];
      // Перебор файлов до лимита
      for (var i = 0; i < limitUpload(); i++) {
        let file = files[i];
        if (file !== undefined) {
          formFiles.push(file)
          let fileType = file.name.split('.').pop()
          if ($.inArray(fileType, fileTypeArr) < 0) {
            $(".errormassege").text('')
            $(".errormassege").append('Файлы должны быть в формате jpg, jpeg, png, zip, doc, docx, xls, xlsx, pdf');
            continue;
          }
          if (file.size > maxFileSize) {
            $(".errormassege").append("Размер файла не должен превышать 2 Мб")
            continue;
          }
          $(".errormassege").html('');
          preview(file, fileType);
        }
      }
      this.value = '';
    });

    function preview(file, fileType) {

      var reader = new FileReader();
      reader.addEventListener('load', function (event) {
        if (fileType == 'jpeg' || fileType == 'jpg' || fileType == 'png') {
          var img = document.createElement('img');
          var itemPreview = itemPreviewTemplate.clone();
          itemPreview.find('.img-wrap img').attr('src', event.target.result);
          itemPreview.data('id', file.name);
          imagesList.append(itemPreview);
        } else {
          var itemPreview = itemPreviewTemplate.clone();
          $(itemPreview).find('.img-wrap').remove();
          let icon = 'fa-file'
          switch (fileType) {
            case 'xls':
              icon = 'fa-file-excel-o'
              break;
            case 'xlsx':
              icon = 'fa-file-excel-o'
              break;
            case 'rar':
              icon = 'fa-file-archive-o'
              break;
            case 'zip':
              icon = 'fa-file-archive-o'
              break;
            case 'docx':
              icon = 'fa-file-word-o'
              break;
            case 'doc':
              icon = 'fa-file-word-o'
              break;
            case 'pdf':
              icon = 'fa-file-pdf-o'
              break;
            default:
              icon = 'fa-file'
              break;
          }
          itemPreview.find('.icon-wrap i').addClass(icon);
          itemPreview.data('id', file.name);
          imagesList.append(itemPreview);
        }
        // Обработчик удаления
        itemPreview.on('click', function () {
          delete queue[file.name];
          let index = formFiles.find((f, index) => {
            return f.name == file.name ? index : ''
          })
          formFiles.splice(index, 1)
          $(this).remove();
          limitDisplay();
        });
        queue[file.name] = file;
        // Отображение лимита при добавлении
        limitDisplay();
      });
      reader.readAsDataURL(file);
    }
    // Очистить все файлы
    function resetFiles() {
      $(addInput)[0].value = "";
      limitDisplay();
    }
    if (reset) {
      resetFiles();
    }
    // Отображение лимита при запуске
    limitDisplay();
  }
})