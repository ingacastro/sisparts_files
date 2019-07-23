var sets_turn_ctz_table;
 var root_url = $('#root_url').attr('content');
$('#sets_turn_ctz').click(function(){
    initSetsCTZTable();
});

function initSetsCTZTable()
{
    let doc_id = $('#document_id').attr('content');

    sets_turn_ctz_table = $('#sets_turn_ctz_table').DataTable({
        ajax: {
            url: root_url + '/inbox/document-supplies',
            data: {'document_id': doc_id, 'status': 8}
        },
        iDisplayLength: 8,
        lengthChange: false,
        bSort: true,
        destroy: true,
        columns: [
            { data: "checkbox", name: "checkbox", orderable: false, searchable: false},
            { data: "number", name: "number" },
            { data: "supplier", name: "supplier" },
            { data: "products_amount", name: "products_amount" },
            { data: "measurement_unit_code", name: "measurement_unit_code" },
            { data: "total_cost", name: "total_cost" },
            { data: "total_price", name: "total_price" },
            { data: "status", name: "status" }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
}

$('#sets_turn_ctz_form').submit(function(e){
    e.preventDefault();
    let token = $('input[name=_token]').val();
    let form = this;

    $('.ctz-hidden-checkboxes').remove();
    
    // Iterate over all checkboxes in the table
    sets_turn_ctz_table.$('input[type="checkbox"]').each(function(){
        // If checkbox is checked
        if(this.checked){
           // Create a hidden element
           $(form).append(
              $('<input>')
                 .addClass('ctz-hidden-checkboxes')
                 .attr('type', 'hidden')
                 .attr('name', 'sets[]')
                 .val(this.value)
           );
        }
    });

    let serialized_form = $(form).serialize();

    $.ajax({
        url: root_url + '/inbox/sets-turn-ctz',
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data: serialized_form,
        success: function(response) {

            if(response.errors) {
                $('#sets_turn_ctz_error_messages').html(response.errors_fragment);
                return;
            }
            
            $('#sets_turn_ctz_success_message').html(response.success_fragment);
            initSetsCTZTable();
        }
    });

});
