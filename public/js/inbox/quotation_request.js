$(document).on('click', '.quotation-request', function(){
	let item = $(this);
	$('#supply_number').html('Número de parte: <strong>' + item.attr('data-number') + '</strong>');

	$('#quotation_request_messages_select2').select2({
        width: '100%',
        placeholder: 'Seleccionar...'
    });

	$.get('/inbox/get-manufacturer-suppliers/' + item.attr('data-manufacturer_id'), function(suppliers){
		$.each(suppliers, function($key, $supp){
			console.log($supp.trade_name);
		});
	});

});