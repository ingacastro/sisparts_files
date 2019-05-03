$(document).on('click', '.quotation-request', function(){
	let item = $(this);
	$('#supply_number').html('Número de parte: <strong>' + item.attr('data-number') + '</strong>');

	$.get('/inbox/get-manufacturer-suppliers/' + item.attr('data-manufacturer_id'), function(suppliers){
		$('#left_suppliers').html('');
		$('#right_suppliers').html('');
		$.each(suppliers, function(key, supp) {
			let side = key % 2 == 0 ? 'right_suppliers' : 'left_suppliers';
			let item = '<label>' +
			'<input class="material-specifications" style="margin-right: 5px" type="checkbox" name="suppliers_ids[]" value="' + supp.id + '">' +
			supp.trade_name +
			'</label>';
			$('#' + side).append(item);
		});
	});
});