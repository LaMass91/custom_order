var $i = 0;
jQuery(window).scroll(function(){
	/*if($i == 0){
		grecaptcha.render('recaptcha1', {
                	'sitekey': '6LeGHhATAAAAAMbODsnj9DQ_-PpTePCukYwzMl02'
        	});
	}
	$i++; */

})

jQuery(document).ready(function(){
    $('body').append('<script src="https://www.google.com/recaptcha/api.js"><\/script>');
    PXControlsQuantity.init({
        container: ".js-quantity",
        input: 'input[name="quantity"]'
    });
    PXBasketTop.init();
    //PXBasketTop.update();

$.fn.setCursorPosition = function(pos) {
    if ($(this).get(0).setSelectionRange) {
      $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
      var range = $(this).get(0).createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  };
	if (jQuery('.order-site-form').length > 0) {
		jQuery('input[name=ORDER_PROP_3]').maskInput('+7 (999) 999-99-99');
		$('input[name=ORDER_PROP_3]').click(function(){
			$(this).setCursorPosition(4);
  		});
	}
	
	//$("#ORDER_PROP_1").focus();
	// $('#ORDER_PROP_1').on('keypress', function() {
	// 	var that = this;
	// 	setTimeout(function() {
	// 		var re = /[^?-??-?a-zA-Z ]/g.exec(that.value);
	// 		that.value = that.value.replace(re, '');
	// 	}, 0);
	// });
	
	$('.row input[type=submit]').removeAttr('disabled');
	$('input[name=SECURED_PRIVACY_POLICY]').change(function(){
		if ($(this).is(':checked')) {
			$('.row input[type=submit]').removeAttr('disabled');
		} else {
			$('.row input[type=submit]').attr('disabled', '');
		}
	});
	$('.js-quantity-minus').click(function(e){
		e.preventDefault();
		//console.log('minus');
		setUpdateBasket();
	});
	$('.js-quantity-plus').click(function(e){
		e.preventDefault();
		//console.log('plus');
		setUpdateBasket();
	});

	$('input[name="quantity"]').on('input', function(){
		//console.log('input');
		setUpdateBasket();
	});
	$('.site-icon-delete').click(function(e){
		e.preventDefault();
		var $id = $(this).closest('.basket-row.js-basket-item').attr('data-id'); 
		deleteIdBasket($id);
	});
	
	$('.basket-big-wr .delete_all').on('click', function(e){
		e.preventDefault();
		$('.modal-action').show();
	});
	
	$('#yes').on('click', function(e){
		e.preventDefault();
		deleteBasket();
		$('.modal-action').hide();
	});
	
	$('.js_close, #no').on('click', function(e){
		e.preventDefault();
		$('.modal-action').hide();
	});
});
function getProfile(email){
	$.ajax({
		contentType: false,
		processData: false,
		type: 'POST',
		url: '/ajax/getprofile.php?email=' + email,
		success: function(result){
			//console.log(result);
			if(result != ''){
				var $profile = result.split(':');
				$('input[name="PROFILE_ID_OLD"]').val($profile[0]);
				$('select[name="PROFILE_ID"]').append('<option value="'+$profile[0]+'" selected="">'+$profile[1]+'</option>');
			}			
		}
	});

}

function deleteBasket(){
	
	$.ajax({
		contentType: false,
		processData: false,
		type: 'POST',
		url: '/ajax/basket_all.php',
		success: function(result){
			if(result == 'OK') window.location.reload();			
		}
	});
}

function deleteIdBasket(id){
	var $id = id;
	$.ajax({
		contentType: false,
		processData: false,
		type: 'POST',
		url: '/ajax/basket_d.php?id=' + $id,
		success: function(result){
			//console.log(result);
			if(result == 'OK') window.location.reload();			
		}
	});

}
function setUpdateBasket(){
	var $ids = [];
	$('#order_form_div .basket-row.js-basket-item').each(function(){
		var $id = $(this).attr('data-product');
		var $count = $(this).find('input[name="quantity"]').val();
		$ids[$id] = $count;
	});
	var $param_ids = '';
	$ids.forEach(function(value,key) {
            if( value >= 1 ){
  		$param_ids = $param_ids + key + ',' + value + ',';    
            }
	});
	$user_type = $('input[name="PERSON_TYPE"]').val();
	$param_ids = $param_ids.slice(0, -1);
	//console.log($param_ids);
        if ( $param_ids.length >= 3 ){
            $.ajax({
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    url: '/ajax/basket3.php?ids=' + $param_ids + '&user_type=' + $user_type,
                    success: function(result){
						//console.log(result);
						var $data = JSON.parse(result); var $sum = 0;
						//console.log($data);
						$('#order_form_div .basket-row.js-basket-item').each(function(){
								var $id = $(this).attr('data-product');
								$(this).find('.b-total-price').text($data[$id] + ' руб.');
								$(this).find('.b-price.js-price').attr('data-price',$data[$id]/$(this).find('input[name="quantity"]').val());
								$(this).find('.ins_p').text($data[$id]/$(this).find('input[name="quantity"]').val() + ' руб.');
								$sum = $sum + $data[$id];
						});
						$('#top-basket .basket-title, #top-basket-fixed .basket-title').text($sum + ' руб.');
						$('.right-col .total-price span:not(.basket-big-wr2)').text($sum.toFixed(2) + ' руб.');

                    }
            });
        }
}
(function($) {
	$(function() {

		if (  $('input[name=PERSON_TYPE]').val() == 2 && $('body #ORDER_PROP_6').val() == '' ) {
			$('input[name="BasketOrder"]').attr('disabled', 'disabled');
		}		

		$('body').on('change', 'input#ORDER_PROP_6', function() {

			if( $(this).val() != '' ) {
				$('input[name="BasketOrder"]').attr('disabled', false);
			} else {
				$('input[name="BasketOrder"]').attr('disabled', 'disabled');
			}
		});
/* 	  $('ul.tabs__caption').on('click', 'li:not(.active)', function() {
		$(this)
		  .addClass('active').siblings().removeClass('active')
		  .closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
	  }); */
	  if (localStorage.getItem('PERSON_TYPE') == '2') {
		$('.tabs__caption li').removeClass('active');
		$('.tabs__caption li:eq(1)').addClass('active');
		const pp = +localStorage.getItem('PERSON_TYPE');
		$('input[name="PERSON_TYPE"]').val(pp);
		console.log(pp);
		$.ajax({
			type: 'POST',
			url: '/ajax/order_prop.php',
			dataType: 'html',
			data:{user_type: pp},
			success: function(result){
					$('.tabs__content.active').html(result);
					$("#ORDER_PROP_5").suggestions({
						token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
						type: "PARTY",
						onSelect: function(suggestion) {
							$('#ORDER_PROP_6').val(suggestion.data.inn)
							$('input[name="BasketOrder"]').attr('disabled', false);
						}
						
						
					});
					$("#ORDER_PROP_6").suggestions({
						token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
						type: "PARTY",
						onSelect: function(suggestion) {
							$('#ORDER_PROP_5').val(suggestion.data.name.short_with_opf);
							$('#ORDER_PROP_6').val(suggestion.data.inn);
							$('input[name="BasketOrder"]').attr('disabled', false);
						}
						
					});	

					if (  $('input[name=PERSON_TYPE]').val() == 2 && $('body #ORDER_PROP_6').val() == '' ) {
						// ORDER_PROP_11
						$('input[name="BasketOrder"]').attr('disabled', 'disabled');
						
					} else if ($('input[name=PERSON_TYPE]').val() == 1) {
						$('input[name="BasketOrder"]').attr('disabled', false);
					}

					jQuery('input[name=ORDER_PROP_3]').maskInput('+7 (999) 999-99-99');
					setUpdateBasket();
			}
		});
	  }
	  if (localStorage.getItem('PERSON_TYPE') == '1') {
		$('.tabs__caption li').removeClass('active');
		$('.tabs__caption li:eq(0)').addClass('active');
		const pp = +localStorage.getItem('PERSON_TYPE');
		$('input[name="PERSON_TYPE"]').val(pp);
		console.log(pp);
		$.ajax({
			type: 'POST',
			url: '/ajax/order_prop.php',
			dataType: 'html',
			data:{user_type: pp},
			success: function(result){
					$('.tabs__content.active').html(result);
					$("#ORDER_PROP_5").suggestions({
						token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
						type: "PARTY",
						onSelect: function(suggestion) {
							$('#ORDER_PROP_6').val(suggestion.data.inn)
							$('input[name="BasketOrder"]').attr('disabled', false);
						}
						
						
					});
					$("#ORDER_PROP_6").suggestions({
						token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
						type: "PARTY",
						onSelect: function(suggestion) {
							$('#ORDER_PROP_5').val(suggestion.data.name.short_with_opf);
							$('#ORDER_PROP_6').val(suggestion.data.inn);
							$('input[name="BasketOrder"]').attr('disabled', false);
						}
						
					});	

					if (  $('input[name=PERSON_TYPE]').val() == 2 && $('body #ORDER_PROP_6').val() == '' ) {
						// ORDER_PROP_11
						$('input[name="BasketOrder"]').attr('disabled', 'disabled');
						
					} else if ($('input[name=PERSON_TYPE]').val() == 1) {
						$('input[name="BasketOrder"]').attr('disabled', false);
					}

					jQuery('input[name=ORDER_PROP_3]').maskInput('+7 (999) 999-99-99');
					setUpdateBasket();
			}
		});
	  }
	  $('.tabs__caption li').on('click',function(){
		$('.tabs__caption li').removeClass('active');
		$(this).addClass('active');
		$('input[name="PERSON_TYPE"]').val($(this).attr('data-type'));
		var $type = $(this).attr('data-type');

		localStorage.setItem('PERSON_TYPE', $type);
		
			
			$.ajax({
				type: 'POST',
				url: '/ajax/order_prop.php',
				dataType: 'html',
				data:{user_type: $type},
				success: function(result){
						$('.tabs__content.active').html(result);
						$("#ORDER_PROP_5").suggestions({
							token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
							type: "PARTY",
							onSelect: function(suggestion) {
								$('#ORDER_PROP_6').val(suggestion.data.inn)
								$('input[name="BasketOrder"]').attr('disabled', false);
							}
							
							
						});
						$("#ORDER_PROP_5").suggestions({
							token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
							type: "PARTY",
							onSelect: function(suggestion) {
								$('#ORDER_PROP_5').val(suggestion.data.name.short_with_opf);
								$('#ORDER_PROP_6').val(suggestion.data.inn);
								$('input[name="BasketOrder"]').attr('disabled', false);
							}
							
						});	

						if (  $('input[name=PERSON_TYPE]').val() == 2 && $('body #ORDER_PROP_6').val() == '' ) {
							// ORDER_PROP_11
							$('input[name="BasketOrder"]').attr('disabled', 'disabled');
							
						} else if ($('input[name=PERSON_TYPE]').val() == 1) {
							$('input[name="BasketOrder"]').attr('disabled', false);
						}

						jQuery('input[name=ORDER_PROP_3]').maskInput('+7 (999) 999-99-99');
						setUpdateBasket();
				}
			});


		
	  	});

	$("#ORDER_PROP_5").suggestions({
        token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
        type: "PARTY",
        onSelect: function(suggestion) {
            $('#ORDER_PROP_6').val(suggestion.data.inn)
			$('input[name="BasketOrder"]').attr('disabled', false);
        }
		
		
    });
	$("#ORDER_PROP_6").suggestions({
        token: "77abb527ebae5b88c8d714d02e503dabc4a000fc",
        type: "PARTY",
        onSelect: function(suggestion) {
            $('#ORDER_PROP_5').val(suggestion.data.name.short_with_opf);
			$('#ORDER_PROP_6').val(suggestion.data.inn);
			$('input[name="BasketOrder"]').attr('disabled', false);
        }
		
    });	

/* $('.basket-site-form').on('submit', function(e){
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: '/ajax/sale_order_ajax.php',
		//dataType: 'html',
		data:$('.basket-site-form').serialize(),
		success: function(result){
			//var $data = JSON.parse(result);
			//console.log($data); 
		}
});
}); */
	
	});
	})(jQuery);