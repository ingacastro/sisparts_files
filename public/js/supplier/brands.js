 var root_url = $('#root_url').attr('content');
$(document).ready(function(){
    $('#brands_select2').select2({
        tags: true,
        ajax: {
        	url: root_url + '/supplier/brands-id-name',
        	dataType: 'json',
        	type: "get",
        	delay: 250,
        	data: function(params) {
	            return {
	                term: params.term
	            };
			},
			processResults: function (data) {
	            return {
	                results: data
	            };
	        },
	        cache: true
        }
    });
});

$('#add_brand').click(function(){

	let select2_val = $('#brands_select2').val();
	let token = $('#brands_form > input[name=_token]').val();
	let model_id = $('#model_id').val();
	let auth_user_is_admin = $('#auth_user_is_admin').attr('content');
	if(select2_val == null) return;
	
	$.ajax({
		url: root_url + '/supplier/create-brand',
		type: 'post',
		dataType: 'json',
		headers: {'X-CSRF-TOKEN': token},
		data: {value: select2_val},
		success: function(brand) {
			let row_query = $('#row_' + brand.id);
			if(row_query.length > 0) return;

			$('#brands_table').DataTable().row.add({
				'id': brand.id, 
				'name': brand.name, 
				'actions': (auth_user_is_admin == 1) ? '<a class="remove-brand" id="' + brand.id +'">Eliminar</a>' : ''
			}).node().id = 'row_' + brand.id;
			$('#brands_table').DataTable().draw(false);
		}
	});
});

$(document).on('click', 'a.remove-brand', function(){
	    $('#brands_table').DataTable()
        .row($(this).parents('tr'))
        .remove()
        .draw();
});

$('#brands_form').submit(function(e){
	let rows = $('#brands_table').DataTable().rows();
	let ids = JSON.stringify($('#brands_table').DataTable().cells(rows.nodes(), 0).data().toArray());
	$('#supplier_brands').val(ids);
});
