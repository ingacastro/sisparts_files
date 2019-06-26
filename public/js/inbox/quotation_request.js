$(document).on('click', '.quotation-request', function(){
	let item = $(this);
	
	$('#supply_number').html('Fabricante: <strong>' + item.attr('data-manufacturer') + '</strong>');
	$('#documents_supplies_id').val(item.attr('data-id'));

	$.get('/inbox/get-manufacturer-suppliers-and-supplies/' + item.attr('data-manufacturer_id'), function(response){
		$('#left_suppliers').html('');
		$('#right_suppliers').html('');
		$('#left_supplies').html('');
		$('#right_supplies').html('');
		$.each(response.suppliers, function(key, supp) {
			let side = (key != 0 && key % 2 != 0) ? 'right_suppliers' : 'left_suppliers';
			let item = '<label>' +
			'<input class="material-specifications" style="margin-right: 5px" type="checkbox" name="suppliers_emails[]" value="' + supp.email + '">' +
			supp.trade_name +
			'</label>';
			$('#' + side).append(item);
		});
		$.each(response.supplies, function(key, supp) {
			let side = (key != 0 && key % 2 != 0) ? 'right_supplies' : 'left_supplies';
			let item = '<label>' +
			'<input class="material-specifications" style="margin-right: 5px" type="checkbox" name="supplies_ids[]" value="' + supp.id + '">' +
			supp.number +
			'</label>';
			$('#' + side).append(item);
		});
	});
});

$('#file_attachment_form').submit(function(e){
	e.preventDefault();

	let token = $('input[name=_token]').val();
	let serialized_form = $(this).serialize();
	

    $.ajax({
        url: '/inbox/send-suppliers-quotation',
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data: serialized_form,
        success: function(response) {

            if(response.errors) {
                $('#quotation_request_error_messages').html(response.errors_fragment);
                return;
            }
            
            $('#quotation_request_success_message').html(response.success_fragment);
        }
    });
});