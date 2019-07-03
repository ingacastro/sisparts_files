$(document).on('click', '.replacement-observation', function() {

	$('#replacement_observation_form_description').val('');
	let type = $(this).data('type');
	let supply_id = $(this).data('supply_id');
	$('#replacement_observation_form').data('type', type);

	$('#replacement_observation_modal_title').html(type == 1 ? 'Reemplazo' : 'Observación');
	$('#replacement_observation_modal_supplies_id').val(supply_id);

	$('#replacement_observation_table').DataTable({
        ajax: '/supply/' + supply_id + '/get-replacements-observations/' + type,
        bSort: true,
        destroy: true,
        iDisplayLength: 6,
        lengthChange: false,
        processData: false,
        serverSide: true,
        columns: [
            { data: "description", name: "description" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }
	});
});

$('#replacement_observation_form').submit(function(e) {
	e.preventDefault();
    let token = $('#replacement_observation_form > input[name=_token]').val();

    let type = $(this).data('type');
    let serialized_form = $(this).serialize();

    $.ajax({
        url: '/supply/store-replacement-observation/' + type,
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data: serialized_form,
        iDisplayLength: 6,
        lengthChange: false,
        processData: false,
        serverSide: true,
        success: function(response) {
            if(response.errors) {
                $('#replacement_observation_error_messages').html(response.errors_fragment);
                return;
            }
            let obj = response.obj;

            $('#replacement_observation_error_messages').hide();

            //Only on create we add a new row
            if(response.action == 1) {
	            let actions = '<a class="btn btn-circle btn-icon-only red" onclick="deleteReplacementObservation(event,' + obj.id + ',' + type + ')">' +
	                '<i class="fa fa-times"></i></a>';
	            if(type == 1)
	            	actions = '<a class="btn btn-circle btn-icon-only default replacement-edit" data-id="' + obj.id + '"' +
	            'data-description="' + obj.description + '">' +
	            '<i class="fa fa-edit"></i></a>' + actions;

	            $('#replacement_observation_table').DataTable().row.add({
	                'description': obj.description,
	                'actions': actions
	            });
	        }

			replacementObservationSaveUI();

            $('#replacement_observation_table').DataTable().draw(false);
            $('#replacement_observation_success_message').html(response.success_fragment);
            $('#replacement_observation_success_message').fadeIn('fast').delay(2200).fadeOut('fast');
        }
    });
});


$(document).on('click', '.replacement-edit', function() {
	$('#replacement_observation_form_description').val($(this).data('description'));
	$('#replacement_observation_cancel_btn').show();
	$('#replacement_observation_save_btn').html('Actualizar');
	$('#replacement_observation_modal_replacement_id').val($(this).data('id'));
});

$('#replacement_observation_cancel_btn').click(function() { replacementObservationSaveUI(); });

function replacementObservationSaveUI() {

	$('#replacement_observation_save_btn').html('Guardar');
	$('#replacement_observation_cancel_btn').hide();
	$('#replacement_observation_form_description').val('');

	$('#replacement_observation_modal_replacement_id').val('');
	$('#replacement_observation_modal_observation_id').val('');
}


/*Replacement or observation delete*/
function deleteReplacementObservation(e, id, type) {
    e.preventDefault();

    let type_name = type == 1 ? 'reemplazo' : 'observación';

    swal({
      title: "Eliminar " + type_name,
      text: "¿Seguro que deseas eliminar este " + type_name + "?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true
    },
    function(isConfirm) {
      if (isConfirm) { deleteReplacementObservationRequest(id, type); }
    });
}

function deleteReplacementObservationRequest(id, type) {
    let token = $('meta[name=_token]').attr('content');
    $.ajax({
        url: '/supply/replacement-observation/' + id +'/' + type,
        method: 'delete',
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            if(response.errors) {
                $('#replacement_observation_error_messages').html(response.errors_fragment);
                return;
            }

            $('#replacement_observation_error_messages').hide();

            $('#replacement_observation_table').DataTable().draw(false);
            $('#replacement_observation_success_message').html(response.success_fragment);
            $('#replacement_observation_success_message').fadeIn('fast').delay(2200).fadeOut('fast');
            replacementObservationSaveUI();
        }
    });
}

$(document).on('click', '.pcts', function() {

	let supply_id = $(this).data('supply_id');

	$('#pcts_table').DataTable({
        ajax: '/supply/' + supply_id + '/pcts/',
        sort: false,
        destroy: true,
        iDisplayLength: 6,
        lengthChange: false,
        processData: false,
        serverSide: true,
        columns: [
            { data: "created_at", name: "created_at" },
            { data: "number", name: "number" },
            { data: "rfq", name: "rfq" },
            { data: "products_amount", name: "products_amount" },
            { data: "unit_total_cost", name: "unit_total_cost" },
            { data: "unit_total_price", name: "unit_total_price" },
            { data: "supplier", name: "supplier" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }
	});
});