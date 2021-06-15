$(function () {
    const tl = gsap.timeline()
    const sections = document.querySelectorAll('section')
    const windowHeight = $(window).height();
    // кнопка вверх
    let hero = $('#hero').outerHeight(true)
    let services = $('#services').outerHeight(true)
    $(window).on('scroll',function () {
        if ($(this).scrollTop() >= hero + services) {
        $('#toTop').fadeIn();
        } else {
        $('#toTop').fadeOut();
        }
    });
    $('#toTop').on('click',function () {
        $('body,html').animate({ scrollTop: 0 }, 800);
    });
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
        //console.log($(el).offset().top + $(el).height()/2 - windowHeight/2)
        $('html, body').animate({
            scrollTop: $(el).offset().top + $(el).height()/2 - windowHeight/2 + 100
        }, 800, function(){
        });
    }
    
    window.onload = function() {
        tl.to('.video-hero', { scale: 1, opacity: 1, translateY: '50px', duration: 2 })
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
                $('#toTop').addClass('hide')
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
                $('#toTop').removeClass('hide')
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

    // wow animated
    new WOW().init();

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

});