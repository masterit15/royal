$(function () {
    const tl = gsap.timeline()
    var priceMid = { score: 0 };
    var productId = 51;
    var formFiles = [];
    // цены на продукты
    let visitPrice = '' // визитки
    const labelsPrice = '' // этикетки
    const postersPrice = '' // плакаты
    const packagePrice = '' //упаковка
    const bookletsPrice = '' // буклеты
    const packageIsCardboardPrice = ''//упаковка из картона
    const sections = document.querySelectorAll('section')
    const windowHeight = $(window).height();

    sections.forEach(section => {
        if(section.id != 'hero'){
            $('.menu').append(`<li><a href="#${section.id}" data-section="#${section.id}">${section.dataset.name}</a></li>`) 
        }
        $('.section_nav').append(`<li><a href="#${section.id}" data-section="#${section.id}">${section.dataset.name}</a></li>`)
    });
    $('.menu>li>a').on('click', function(){
        animateScroll($(this).data('section'))
    })
    $('.section_nav>li').on('click', function(){
        let link = $(this).children('a')
        animateScroll($(link).data('section'))
    })
    
	$(document).on('scroll', function() {
		$('section').each(function() {
			var self = $(this),
			height = self.offset().top + self.height()/2 - windowHeight/2 ;
			if ($(document).scrollTop() >= height) {
                $(`.section_nav>li>a`).parent().removeClass('active')
                $(`.section_nav>li>a[href="#${self.attr('id')}"]`).parent().addClass('active')
			}
		});
	});
    function animateScroll(el){
        console.log($(el).offset().top + $(el).height()/2 - windowHeight/2)
        $('html, body').animate({
            scrollTop: $(el).offset().top + $(el).height()/2 - windowHeight/2 + 100
        }, 800, function(){
        });
    }
    window.onload = function() {
        tl.to('.video-hero', { scale: 1, opacity: 1, duration: 2 })
        tl.to('.section_nav li', {opacity: 1, translateX: '0px', duration: .2, stagger: .1})
        //tl.to(".grid_item", 1.5, {scale:2, y:50, force3D:true, ease:Elastic.easeOut, rotationY:-90}, 0.08)
    }
    function addElAnimation(el = null, change = false){
        let img = el.data('img')
        let content = el.children('.grid_item_content').clone()
        $('.work_content .work_content_left').html(content)
        $('.work_content .work_content_right').html(`<div class="grid_item_media" style="background-image: url(${img});"></div>`)
        if(el.hasClass('active') && !change){
            tl.to('.work_content', 0.6, { translateX: '0%'}).then(()=>{
                tl.to('.work_content_right .grid_item_media', 0.5, { opacity: 1, translateX: '0px', ease: Power4.easeOut})
                tl.to('.work_content_left .grid_item_content', 0.5, { opacity: 1, ease: Power4.easeOut})
            })
        }else if(el.hasClass('active') && change){
            tl.to('.work_content_right .grid_item_media', 0.5, { opacity: 1, translateX: '0px', ease: Power4.easeOut})
            tl.to('.work_content_left .grid_item_content', 0.5, { opacity: 1, ease: Power4.easeOut})
        }
    }
    $('.grid_item').on('click', function(){
        $(this).addClass('active')
        let workContent = `<div class="work_content">
                            <span class="close"><i class="fa fa-times"></i></span>
                            <div class="work_content_nav">
                                <span class="left ${$(this).prev().length > 0 ? 'show' : ''}" data-direction="left"><i class="fa fa-chevron-left"></i></span>
                                <span class="right ${$(this).next().length > 0 ? 'show' : ''}" data-direction="right"><i class="fa fa-chevron-right"></i></span>
                            </div>
                            <div class="work_content_left"></div>
                            <div class="work_content_right"></div>
                        </div>`
        $('.work_content').remove()
        $('#works').append(workContent)
        addElAnimation($('.grid_item.active'))
        $('.work_content .close').on('click', function(){
            tl.to('.work_content_left .grid_item_content', 0.5, { opacity: 0, ease: Power4.easeOut})
            tl.to('.work_content_right .grid_item_media', 0.5, { opacity: 0, translateX: '-250px', ease: Power4.easeOut})
            .then(()=>{
                tl.to('.work_content', { translateX: '-100%',  duration: 0.6 })
                $('.work_content').remove()
                $('.grid_item').removeClass('active')
            }) 
        })

        $('.work_content_nav span').on('click', function(){
            let direction = $(this).data('direction')
            if(direction == 'left'){
                $('.grid_item.active').removeClass('active').prev().addClass('active')
                tl.to('.work_content_left .grid_item_content', 0.5, { opacity: 0, ease: Power4.easeOut})
                tl.to('.work_content_right .grid_item_media', 0.5, { opacity: 0, translateX: '-250px', ease: Power4.easeOut})
                .then(()=>{
                    addElAnimation($('.grid_item.active'), true)
                }) 
                prevNext()
            }else if(direction == 'right'){
                $('.grid_item.active').removeClass('active').next().addClass('active')
                tl.to('.work_content_left .grid_item_content', 0.5, { opacity: 0, ease: Power4.easeOut})
                tl.to('.work_content_right .grid_item_media', 0.5, { opacity: 0, translateX: '-250px', ease: Power4.easeOut})
                .then(()=>{
                    addElAnimation($('.grid_item.active'), true)
                }) 
                prevNext()
            }
            
        })
        function prevNext(){
            let prev = $('.grid_item.active')
            let next = $('.grid_item.active')
            if($(prev).prevAll().length > 0){
                $('.work_content_nav .left').addClass('show')
            }else if($(prev).prevAll().length == 0){
                $('.work_content_nav .left').removeClass('show')
            }
            if($(next).nextAll().length > 0){
                $('.work_content_nav .right').addClass('show')
            }else if($(next).nextAll().length == 0){
                $('.work_content_nav .right').removeClass('show')
            }
        }
    })
    
    $('.mmenu_btn').on('click', function(){
        $(this).toggleClass('active')
        if($(this).hasClass('active')){
            tl.to($(this), {backgroundColor: '#fff', duration: .4})
            tl.to('.menu', {width: '200px', translate: '0px, 0px', duration: .2}).then(()=>{
                tl.to('.menu li', {opacity: 1, duration: .2, stagger: .1})
            })
        }else{
            tl.to('.menu li', {opacity: 0, translate: '0px, -30px', duration: .2, stagger: .1}).then(()=>{
                tl.to('.menu', {width: '0px', duration: .2})
                tl.to($(this), {backgroundColor: 'transparent', duration: .2})
            })
        } 
    })
    function get_name_browser() {
        var ua = navigator.userAgent;
        if (ua.search(/Edge/) > 0) return 'Edge';
        if (ua.search(/Opera/) > 0) return 'Opera';
        if (ua.search(/Firefox/) > 0) return 'Firefox';
        if (ua.search(/Chrome/) > 0) return 'Google Chrome';
        if (ua.search(/MSIE/) > 0) return 'Internet Explorer';
        if (ua.search(/Safari/) > 0) return 'Safari';

        return 'Не определен';
    }
    var browser = get_name_browser();

    if (browser == 'Edge' || browser == 'MSIE') {
        //alert('У Тебя говно, а не браузер, установи google chrome, хули ты как дурак? ')
        $('.overlay').show()
    }
    // animate
    function animateCss(el = '', animName = '', timeOut = 0) {
        $(el).removeClass(animName)
        $(el).animated(animName, timeOut)
    }
    // tabs
    $('.tabs_item').on('click', function () {
        $('.tabs_item').removeClass('active')
        $(this).addClass('active')
        let index = $(this).data('tab')
        $('.tabs_content').removeClass('active')
        // animateCss('.tabs_content', 'animate__fadeIn')
        $('#tab-' + index).addClass('active')
    })
    // header fixed
    window.addEventListener('scroll', function () {
        let top = $(this).scrollTop()
        if (top >= 50) {
            $('.header').addClass('fixed')
        } else {
            $('.header').removeClass('fixed')
        }
    })

    // fileupload 
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
                    let index = formFiles.find( ( f, index) => {
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
    // wow animated
    new WOW().init();
    // функция определения значения в поле ввода Телефон/Email
    function validateEmailOrPhone(val) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (expr.test(val)) {
            return '<span class="fa">@</span>'
        } else {
            expr = /[2-9]{1}\d{2}/;
            if (expr.test(val)) {
                return '<i class="fa fa-phone"></i>'
            } else {
                return false
            }
        }
        ;
    }
    // функция обновления стоимости
    function priceCange(productId, productPrice, productEdition, design = 500) {
        let price = (productPrice * productEdition) + design
        // switch (productId) {
        //     case 51: // Рекламные буклеты
        //         price = (productPrice * productEdition) + design
        //         break;
        //     case 49: // Визитки
        //         price = (0.80 * val) + design
        //         break;
        //     case 47: // Упаковка из картона
        //         price = (1.50 * val) + design
        //         break;
        //     case 45: // Этикетки
        //         price = (3.5 * val) + design
        //         break;
        //     case 37: // Плакаты
        //         price = (5.0 * val) + design
        //         break;
        //     case 25: // Упаковка
        //         price = (35.0 * val) + design
        //         break;
        //     default: // Визитки
        //         price = (0.80 * val) + design
        //         break;
        // }
        TweenMax.to(priceMid, 1, { score: `${price}`, onUpdate: updateHandler });

    }
    // функция анимирования стоимости
    function updateHandler() {
        let formatPrice = numberWithCommas(priceMid.score.toFixed(0))
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
                $('.loader').fadeIn(200)
            },
            complete: function () {
            },
            success: function (res) {
                setTimeout(()=>{
                    applicationForm(res)
                }, 200)
                $('.loader').fadeOut(200)
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mainToast(time = 5000, 'error', "Произошла ошибка отправки, попробуйте еще раз.", text = '')
                console.log(xhr.responseText)
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        })
        return false;
    })
    function roundStep(val1, val2){
        return Math.ceil(val1/val2)*val2
    }
    function applicationForm(form){
         var minQuantity = 1000//минимальный тираж
         var maxQuantity = 9000//максимальный тираж
         var stepQuantity = 1000 // интервал тиража
         fileUpload = `<div class="form_row__photo-previews">
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
        $('.ofer .forms').append(form);
        $('.ofer_text').hide();
        $('.select').select2({
            language: 'ru',
            minimumResultsForSearch: -1
        });
        let productOption = $('option:selected', $('#product_form_select'));
        let productPrice = Number($(productOption).data('price'))
        let productEdition = Number($(productOption).data('min-edition'))//минимальный тираж
        // функция обработки выбора продукта
        $('#product_form_select').on("select2:select", function (e) {
            let id = e.params.data.id.split('-')[1]
            productId = Number(id)
            productOption = $('option:selected', this);
            productPrice = $(productOption).data('price')
            productEdition = $(productOption).data('min-edition')//минимальный тираж
            $('.product_params').remove()
            // если выбраны этикетки
            if(productId == 45){
                // $('.product_select').after(`
                //     <div class="product_params">
                //         <select name="product_params" id="product_params">
                //         <option value="#">Выбор бумаги</option>
                //         <option value="1">Офсетная бумага</option>
                //         <option value="2">Флексо бумага</option>
                //         <option value="3">Офсетная бумага</option>
                //         </select>
                //         <span class="question">
                //             <i class="fa fa-question-circle-o"></i>
                //             <span class="question_text">Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Большой свой, переулка вопрос она рукопись не инициал что. Города которое буквоград по всей всемогущая текст деревни свое до заголовок страну.</span>
                //         </span>
                //     </div>
                // `)
                // $('#product_params').select2({
                //     language: 'ru',
                //     minimumResultsForSearch: -1
                // })
                // если выбраны визитки
            }else if(productId == 49){
                $('.product_select').after(`
                    <div class="product_params">
                        <div class="form_item">
                            <label class="checkbox" for="product_form_visit_param">
                            <input type="checkbox" name="visit_param" id="product_form_visit_param">
                            <span>Бумага с теснением</span>
                            </label>
                        </div>
                        <span class="question">
                            <i class="fa fa-question-circle-o"></i>
                            <span class="question_text">Далеко-далеко за словесными горами в стране гласных и согласных живут рыбные тексты. Большой свой, переулка вопрос она рукопись не инициал что. Города которое буквоград по всей всемогущая текст деревни свое до заголовок страну.</span>
                        </span>
                    </div>
                `)
                $('#product_form_visit_param').on('change', function () {
                    if ($(this).is(':checked')) {
                        priceCange(productId, productPrice, productEdition, 500);
                    } else {
                        priceCange(productId, productPrice, productEdition);
                    }
        
                })
            }
            priceCange(productId, productPrice, productEdition);

        });
        function rangeValid(){
            //console.log(Number($('.value').val()) +`-`+ Number(productEdition))
            $('.error_text').remove()
            if(Number($('.value').val()) < stepQuantity){
                $('.range').addClass('error').after(`<span class="error_text">Ошибка, тираж должен быть кратным ${productEdition}</span>`)
                return false
            }else{
                $('.range').removeClass('error').next('.error_text')
                return true
            }
        }
        $('#product_form_edition').slider({
            range: "min",
            max: 10000,
            min: productEdition,
            step: productEdition,
            value: productEdition,
            slide: function (e, ui) {
                productEdition = ui.value
                $('#product_form_edition_number').val(ui.value)
                priceCange(productId, productPrice, productEdition)
                rangeValid()
            }
        });
        $('#product_form_edition_number').val(productEdition);
        
        // функция обработки клика по стрелкам поля тираж
        (function quantityProducts() { 
            let $quantityArrowMinus = $(".arrow-minus");
            let $quantityArrowPlus = $(".arrow-plus");
            let $quantityNum = $('#product_form_edition_number') // поле тираж
            
            $quantityArrowMinus.on('click', quantityMinus);
            $quantityArrowPlus.on('click', quantityPlus);
            $('#product_form_edition_number').on('input', function(){
                rangeValid()
            })
            
            
            function quantityMinus() {
                if ($quantityNum.val() >= minQuantity) {
                    $quantityNum.val(+$quantityNum.val() - stepQuantity);
                    if(rangeValid()){
                        $('#product_form_edition').slider("value", $quantityNum.val())
                        productEdition = $quantityNum.val()
                        priceCange(productId, productPrice, productEdition);
                    }
                }
            }

            function quantityPlus() {
                if ($quantityNum.val() <= maxQuantity) {
                    $quantityNum.val(+$quantityNum.val() + stepQuantity);
                    if(rangeValid()){
                        $('#product_form_edition').slider("value", $quantityNum.val())
                        productEdition = $quantityNum.val()
                        priceCange(productId, productPrice, productEdition);
                    }
                }
            }
            $quantityNum.on('change', function () {
                if(rangeValid()){
                    $('#product_form_edition').slider("value", $quantityNum.val())
                    productEdition = $quantityNum.val()
                    priceCange(productId, productPrice, productEdition);
                }
            })
            // $('#product_form_edition_number').on('change', function(){
            //     if($quantityNum.val() % stepQuantity){
            //         $(this).val(roundStep($quantityNum.val(), stepQuantity))
            //     }
            // })
        })();
        
        $('#product_form_mail_or_phone').on('input', function () {
            let res = validateEmailOrPhone($(this).val())
            if (res) {
                $('.mail_or_phone_val').html('')
                $('.mail_or_phone_val').append(res)
            } else {
                $('.mail_or_phone_val').html('')
            }
        });
        $('#product_form .close').on('click', function () {
            $('.ofer #product_form').remove()
            $('.ofer_text').show()
        });
        $('#product_form_design').on('change', function () {
            if ($(this).is(':checked')) {
                $('.fileuploader').html('')
                priceCange(productId, productPrice, productEdition, 500)
            } else {
                priceCange(productId, productPrice, productEdition)
                $('.fileuploader').html(fileUpload)
                uploaderImg('.add_photo-item', '#js-photo-upload', '#uploadImagesList', false, false);
            }
        })
        grecaptcha.ready(function() {
            grecaptcha.execute('6Ld-_vkZAAAAAKBfA3ZcdBimYvqFjpV2jLSYoiZ6', {action: 'homepage'}).then(function(token) {
                document.getElementById('token').value = token
            });
        });
        $('.price').on('click', function (e) {
            e.preventDefault()
            $('input[name="price"]').val($('.prices span').text())
            let data = new FormData($('#product_form')[0]);
            formFiles.map(file =>{
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
                        mainToast(time = 5000, param = 'warning', res.message, text = '')
                    }
                    $('.forms').fadeIn(200)
                    $('.loader').fadeOut(200)
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    mainToast(time = 5000, 'error', "Произошла ошибка отправки, попробуйте еще раз.", text = '')
                    console.log(xhr.responseText)
                    console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            })
        });
        priceCange(productId, productPrice, productEdition);
    }
    // feedback
    $('.app_form').on('submit', function (e) {
        renderInvisibleReCaptcha = null
        e.preventDefault()
        e.stopPropagation()
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                // NProgress.start();
                $('.loader').fadeIn(200)
            },
            complete: function () {
                // NProgress.done();
            },
            success: function (res) {
                //console.log(res)
                if (res.rechaptcha && res.success) {
                    mainToast(time = 5000, param = 'success', res.message, text = '')
                } else {
                    mainToast(time = 5000, param = 'warning', res.message, text = '')
                }
                $('.loader').fadeOut(200)
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mainToast(time = 5000, 'error', "Произошла ошибка отправки, попробуйте еще раз.", text = '')
                console.log(xhr.responseText)
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        })
        return false;
    })
    $('.feedback_trigger').on('click', function () {
        $('.feedback').addClass('open')
        setTimeout(() => {
            $('.loader').fadeOut(200)
        }, 700)
        $('#wrapper').addClass('active')
        $('.grecaptcha-badge').css({ 'z-index': '130' })
        $('.close').on('click', function () {
            $('#wrapper').removeClass('active')
            $('.feedback').removeClass('open')
            $('.grecaptcha-badge').css({ 'z-index': '0' })
        })
        // document.addEventListener('click', (evt) => {
        //     const feedback = document.querySelector('.feedback')
        //     const feedback_trigger = document.querySelector('.feedback_trigger')
        //     let targetElement = evt.target
        //     do {
        //         if (targetElement == feedback || targetElement == feedback_trigger) {
        //             // если клик внутри блока
        //             return;
        //         }
        //         targetElement = targetElement.parentNode
        //     } while (targetElement)
        //     // если клик снаружи блока
        //     $('#wrapper').removeClass('active')
        //     $('.feedback').removeClass('open')
        // });
    })

    $('.slider_carousel').owlCarousel({
        loop: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplay: false,
        margin: 40,
        center: false,
        responsiveClass:true,
        responsive: {
            0: {
                nav: false,
                dots: true,
                items: 1,
            },
            580: {
                nav: false,
                dots: true,
                items: 1,
            },
            960: {
                nav: false,
                dots: true,
                items: 2,
            },
            1200: {
                nav: true,
                dots: true,
                items: 3,
            },
        },
        onChanged: () => {},
        onTranslated: () => {},
    });
    
    $('.partner_carousel').owlCarousel({
        loop: true,
        items: 3,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplay: false,
        margin: 0,
        center: true,
        nav: true,
        dots: true,
        responsive: {
            0: {
                nav: true,
                items: 1,
                autoplay: false,
            },
            580: {
                nav: false,
                dots: true,
                items: 1,
            },
            960: {
                nav: false,
                dots: true,
                items: 2,
            },
            1200: {
                nav: true,
                dots: true,
                items: 3,
            },
        },
        onChanged: () => {},
        onTranslated: () => {},
    });
    
    function animateOWL(el = '', animName = '', timeOut = 0) {
        $(el).removeClass(animName)
        $(el).animated(animName, timeOut)
    }
    $('.partner_carousel').owlCarousel({
        nav: true,
        dots: false,
        loop: true,
        autoplay: true,
        margin: 15,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
            },
            480: {
                items: 2,
            },
            768: {
                items: 4,
            },
            980: {
                items: 5,
            }
        }
    })
    // toltip
    $('[data-toggle="tooltip"]').tooltip({
        animated: 'fade',
        html: true
    })
    // popover
    $('[data-toggle="popover"]').popover({
        trigger: 'hover',
        html: true,
        placement: 'bottom',
        container: 'body'
    })
    // modal
    // $("#modal_app_form").iziModal({
    //     headerColor: "#ff6347",
    //     width: 840,
    //     top: 50,
    //     bottom: 50,
    //     radius: 5,
    //     onFullscreen: function () {
    //         $('.modal_loader').fadeIn("slow");
    //     },
    //     onResize: function () {
    //         $('.modal_loader').fadeOut("slow");
    //     },
    //     onOpening: function () {
    //         $('.modal_loader').fadeIn("slow");
    //     },
    //     onOpened: function () {
    //         $('.user_consent_buttons .btn').on('click', function () {
    //             let res = $(this).attr('data-consent')
    //             if (res == 'Y') {
    //                 $('input#user_consent').attr('checked', "");
    //                 $('input#user_consent').val('Y');
    //                 $('#modal_app_form').iziModal('close');
    //             } else {
    //                 $('input#user_consent').removeAttr('checked');
    //                 $('input#user_consent').val('N');
    //                 $('#modal_app_form').iziModal('close');
    //             }
    //         })
    //         $('.modal_loader').fadeOut("slow");
    //     },
    //     onClosing: function () { },
    //     onClosed: function () { },
    //     afterRender: function () { }
    // });
    // $('.app_form').validate({
    //     rules: {
    //         email: {
    //             email: true,
    //         },
    //     }
    // });
    // popup 
    $('.popup_trigger').hover(function () {
        $(this).toggleClass('active')
        let popupContent = $(this).children('div.popup_content')
        if ($(this).hasClass('active')) {
            $(popupContent).addClass('active')
        } else {
            $(popupContent).removeClass('active')
        }
    })
    // toast
    function mainToast(time = 5000, param = '', title = '', text = '') {
        /*
        param: info, success, warning, error
        */
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": time,
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        toastr[param](title, text)
    }
    //get color
    // $('.grid_item').each(function () {
    //     getAlphaColor($(this))
    //         .then(res => {
    //             $(this).parent().css('bac')
    //             console.log(res)
    //         })
    //         .catch(err => console.log(err))

    // })
    // function getAlphaColor(imgEl) {
    //     return new Promise((resolve, reject) => {
    //         try {
    //             const colorThief = new ColorThief()
    //             let image = new Image();
    //             let bg = $(imgEl).css('background-image');
    //             bg = bg.replace('url(', '').replace(')', '').replace(/\"/gi, "");
    //             image.src = bg
    //             let color
    //             let palate
    //             if (image.complete) {
    //                 color = colorThief.getColor(image);
    //                 palate = colorThief.getPalette(image, 3)
    //                 resolve({ color, palate })
    //             } else {
    //                 image.addEventListener('load', function () {
    //                     color = colorThief.getColor(image);
    //                     palate = colorThief.getPalette(image, 3)
    //                     resolve({ color, palate })
    //                 })
    //             }
    //         } catch (error) {
    //             reject(error)
    //         }
    //     })
    // }
});