var brands_table = null;

$(document).ready(function(){
    $('#brands_select2').select2({
        tags: true,
        ajax: {
        	url: '/supplier/brands-id-name',
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

	brands_table = $('#brands_table').DataTable({
        searching: false,
        info: false,
        lengthChange: false,
        sDom: '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
		language: {
	        "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
	    },
	    columns: [
	    	{'data': 'id'},
	    	{'data': 'name'},
	    	{'data': 'actions', name: 'actions', orderable: false, searchable: false}
	    ]
    });
});

$('#add_brand').click(function(){
	
	let select2_val = $('#brands_select2').val();
	let token = $('#brands_form > input[name=_token]').val();
	let model_id = $('#model_id').val();

	if(select2_val == null) return;
	
	$.ajax({
		url: '/supplier/create-brand',
		type: 'post',
		dataType: 'json',
		headers: {'X-CSRF-TOKEN': token},
		data: {value: select2_val},
		success: function(brand) {
			let row_query = $('#row_' + brand.id);
			if(row_query.length > 0) return;

			brands_table.row.add({
				'id': brand.id, 'name': brand.name, 'actions': '<a class="remove-brand" id="' + brand.id +'">Eliminar</a>'
			}).node().id = 'row_' + brand.id;
			brands_table.draw(false);
		}
	});
});

$(document).on('click', 'a.remove-brand', function(){
	let row_id = 'row_' + $(this).attr('id');
	    brands_table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
});

$('#brands_form').submit(function(e){
	let rows = brands_table.rows();
	let ids = JSON.stringify(brands_table.cells(rows.nodes(), 0).data().toArray());
	$('#supplier_brands').val(ids);
});
