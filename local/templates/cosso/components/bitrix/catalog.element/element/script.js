$(function() {
	$('.js-offer-select').change(function () {
		let productId = $('a.add-cart').data('productId'),
			color = '',
			clothesSize = '',
			shoesSize = '';
		$('#select_color_ref option').each(function () {
			if ($(this).prop('selected')) {
				color = $(this).data('onevalue');
			}
		});
		$('#select_sizes_clothes option').each(function () {
			if ($(this).prop('selected')) {
				clothesSize = $(this).data('onevalue');
			}
		});
		$('#select_sizes_shoes option').each(function () {
			if ($(this).prop('selected')) {
				shoesSize = $(this).data('onevalue');
			}
		});

		$.ajax({
			type: "POST",
			url: "/ajax/getOfferId.php",
			data: {
				color: color,
				cloth_size: clothesSize,
				shoes_size: shoesSize,
				product_id: productId
			},
			success: function (result) {
				if (result) {
					$('a.add-cart').attr('data-offer', result);
				}
			}
		});
	});

	$(".add-cart").click(function () {
		let quantity = $(this).data('quantity');
		let productId = $(this).data('offer');
		$.ajax({
			type: "POST",
			url: '/ajax/addToCart.php',
			data: {
				product_id: productId,
				quantity: quantity
			},
			success: function () {
				window.location.href = "/personal/cart/";
			}
		});

	});

	$(".btn-number").click(function (){
		let type = $(this).data('type'),
			container = $(this).closest('.quantity'),
			valInput = container.find('.js-number'),
			val = valInput.val();
		if (type == 'plus') {
			val = +val + 1;
			valInput.val(val);
		} else if (type == 'minus' && val > 1) {
			val = +val - 1;
			valInput.val(val);
		}
		$('a.add-cart').attr('data-quantity', val);
	});

	$(".js-number").change(function (){
		$('a.add-cart').attr('data-quantity', $(this).val());
	});
});