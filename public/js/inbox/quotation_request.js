 var root_url = $('#root_url').attr('content');
$(document).on('click', '.quotation-request', function(){

	cleanQuotationRequestMessages();
	let item = $(this);
	var manufacturer_name = item.attr('data-manufacturer');

	let manufacturer_title = 'Fabricante: <strong>' + manufacturer_name + '</strong>';
	$('#quotation_request_manufacturer').html(manufacturer_title);
	$('#quotation_request_manufacturer_hidden').val(manufacturer_title);
	$('#documents_supplies_id').val(item.attr('data-id'));

	$.get(root_url + '/inbox/get-manufacturer-suppliers-and-supplies/' + item.attr('data-documents_id') + '/' + item.attr('data-manufacturer_id'), 
		function(response){
			console.log(response.manufacturer_name);
		$('#left_suppliers').html('');
		$('#right_suppliers').html('');
		$('#left_supplies').html('');
		$('#right_supplies').html('');
		$.each(response.suppliers, function(key, supp) {
			let side = (key != 0 && key % 2 != 0) ? 'right_suppliers' : 'left_suppliers';
			let item = '<label>' +
			'<input class="material-specifications" style="margin-right: 5px" type="checkbox" name="suppliers_ids[]" value="' + supp.id + '">' +
			supp.trade_name +
			'</label>';
			$('#' + side).append(item);
		});
		let sets = response.sets;
		$.each(response.supplies, function(key, supply) {

			var set_obj = { number: supply.number, description: sets[key].product_description, 
			manufacturer: response.manufacturer_name, quantity: sets[key].products_amount };
			let set =  "'" + JSON.stringify(set_obj) +  "'";
			
			let side = (key != 0 && key % 2 != 0) ? 'right_supplies' : 'left_supplies';
			let item = '<label>' +
			'<input class="material-specifications" style="margin-right: 5px" type="checkbox" name="sets[]" value=' + set + '>' +
			supply.number +
			'</label>';
			$('#' + side).append(item);
		});
	});
});

$('#quotation_request_form').submit(function(e){
	e.preventDefault();
	cleanQuotationRequestMessages();

	let token = $('input[name=_token]').val();
	let serialized_form = $(this).serialize();
	
    $.ajax({
        url: root_url + '/inbox/send-suppliers-quotation',
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data: serialized_form,
        success: function(response) {
            if(response.errors) {
                $('#quotation_request_error_messages').html(response.errors_fragment);
                return;
            }
            
            location.reload();
        }
    });
});

function cleanQuotationRequestMessages()
{
	$('#quotation_request_error_messages').html('');
	$('#quotation_request_success_message').html('');
}