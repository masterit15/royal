$(function() {
  // $('.product_fields_price').mask('000.000.000.000.000.00', {reverse: true});
  if(!$('#product_priceparam').is(':checked')){
    $('.product_fields_price[name="price"]').parent().hide()
  }
  $('#product_priceparam').on('change', function(){
    let span = $(this).parent().find('.priceparam span')
    if($(this).is(':checked')){
      $(span).text('фиксированная')
      $('input[name="priceparam"]').val('on')
      $('.product_fields_price[name="price"]').parent().show()
    }else{
      $(span).text('индивидуальная')
      $('input[name="priceparam"]').val('off')
      $('.product_fields_price[name="price"]').parent().hide()
    }
  })
  function initMoreImages() {
    if($('.frame label')){
        let result = [...$('input.field').val().split(',').map(Number)].filter(n=>n!==0)
        $('.edition-selected').text('Выбрано: ' + result.length);
        $('.frame label').on('click', function(e) {
            $(this).toggleClass('checked')
            if ($(this).hasClass('checked')) {
                result.push(Number($(this).find('input:not(:checked)').val()))
            } else {
                result = result.filter(id => Number(id) !== Number($(this).children('input').val()))
            }
            result = result.filter(id => Number(id) != 0)
            $('.field').val(result.join(','));
            $('.edition-selected').text('Выбрано: ' + result.length);
            return false
        })
      }
  }
  $('.load_more').on('click', function() {
      loadMoreImages($(this).data('url'))
  })
  let selectcount = $('.load_more').data('selectcount')
  let ppp = selectcount > 10 ? selectcount : 10; // Post per page
  let pageNumber = 1;
  loadMoreImages($('.load_more').data('url'))

  function loadMoreImages(url) {
      $.ajax({
          type: "POST",
          url: url,
          data: { action: 'moreimage', pageNumber, ppp, post: $('.load_more').data('post') },
          beforeSend: function() {},
          success: function(res) {
              $('.frame').append(res)
          },
          complete: function() {
              initMoreImages()
              pageNumber++
          },
          error: function(err) {
              console.error('success', err);
          }
      })
  }
})