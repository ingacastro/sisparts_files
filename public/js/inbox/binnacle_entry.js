 var root_url = $('#root_url').attr('content');

$('#custom_binnacle_entry').click(function(){
	clearModalMessages();
});

function clearModalMessages() {
	$('#binnacle_entry_error_messages').html('');
	$('#binnacle_entry_success_message').html('');
}

function destroyBinnacleEntryDataTable() {
	$('#new_binnacle_entry_supplies_table').DataTable().destroy(); 
	$('#new_binnacle_entry_supplies_table').hide();
}

var new_binnacle_entry_supplies_table;
function initBinnacleEntryDataTable()
{
	let doc_id = $('#document_id').attr('content');

	$('#new_binnacle_entry_supplies_table').show();

    new_binnacle_entry_supplies_table = $('#new_binnacle_entry_supplies_table').DataTable({
        ajax: {
            url: root_url + '/inbox/document-supplies',
            data: {'document_id': doc_id}
        },
        iDisplayLength: 6,
        lengthChange: false,
        bSort: true,
        destroy: true,
        info: false,
        columns: [
            { data: "checkbox", name: "checkbox", orderable: false, searchable: false},
            { data: "number", name: "number" }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
}


$('#binnacle_entry_form').submit(function(e){
	e.preventDefault();
	clearModalMessages();

	let form = this;
	let entity = $('input[name=entity]:checked').val();
	if(entity == 2) {
		$('.ctz-hidden-checkboxes').remove();
		// Iterate over all checkboxes in the table
	    new_binnacle_entry_supplies_table.$('input[type="checkbox"]').each(function(){
	        // If checkbox is checked
	        if(this.checked){
	           // Create a hidden element
	           $(form).append(
	              $('<input>')
	                 .addClass('ctz-hidden-checkboxes')
	                 .attr('type', 'hidden')
	                 .attr('name', 'supplies[]')
	                 .val(this.value)
	           );
	        }
	    });
	}

	let token = $('input[name=_token]').val();
	let serialized_form = $(this).serialize();
	

    $.ajax({
        url: root_url + '/inbox/binnacle-entry',
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data: serialized_form,
        success: function(response) {

            if(response.errors) {
                $('#binnacle_entry_error_messages').html(response.errors_fragment);
                return;
            }
            
            $('#binnacle_entry_success_message').html(response.success_fragment);
        }
    });

});

