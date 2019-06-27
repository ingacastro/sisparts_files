$(document).on('click', '.edit-set', function() {

    let set_id = $(this).attr('data-id');
    let total_cost = $(this).attr('data-total_cost');
    let total_price = $(this).attr('data-total_price');
    let unit_price = $(this).attr('data-unit_price');
    let total_profit = $(this).attr('data-total_profit');
    let set_number = $(this).attr('data-set_number');
    let supply_number = $(this).attr('data-supply_number');

    $('#edit_set_modal_title').html(
        '<div style="font-size: 15px"> Editar&nbsp;&nbsp;<strong>Número de partida:</strong>' + set_number + 
        '&nbsp;&nbsp;<strong>Número de parte:</strong> ' + supply_number + '</div>' );
    
    //Set tabs
    $.ajax({
        url: '/inbox/get-set-tabs/' + set_id,
        method: 'get',
        dataType: 'json',
        success: function(response) {
            $('#tab_budget_content').html(response.budget_tab);
            applyFieldsMasks();
            $('#budget_total_cost').html(total_cost);
            $('#budget_total_price').html(total_price);
            $('#budget_unit_price').html(unit_price);
            $('#budget_total_profit').html(total_profit);
            
            $('#tab_conditions_content').html(response.conditions_tab);
            $('#tab_files_content').html(response.files_tab);
            $('#files_table_container').css('display', 'block');

            let set_auto_id = $('#set_auto_id').val();
            $('#files_table').DataTable({
                serverSide: true,
                ajax: '/inbox/set-files/' + set_auto_id,
                iDisplayLength: 6,
                destroy: true,
                lengthChange: false,
                columns: [
                    { data: "created_at", name: "created_at" },
                    { data: "supplier", name: "supplier" },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
            });
        }
    });
});

/*Budget form*/
$(document).on('submit', '#edit_budget_form', function(e){
    e.preventDefault();

    let custom_utility_percentage = $('#custom_utility_percentage').val();
    let custom_utility_checkbox = $('#utility_checkbox_0'); //Other

    if(custom_utility_checkbox.is(':checked')) custom_utility_checkbox.val('0_' + custom_utility_percentage);

    let token = $('input[name=_token]').val();
    let set_id = $('#set_id').val();
    let serialized_form = $(this).serialize();

    $.ajax({
        url: '/inbox/update-set-budget/' + set_id,
        method: 'post',
        dataType: 'json',
        data: serialized_form,
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            $('#pct_edit_modal_error_messages').empty();
            $('#pct_edit_modal_success_message').empty();
            
            if(response.errors)
                $('#pct_edit_modal_error_messages').html(response.errors_fragment);
            else 
                $('#pct_edit_modal_success_message').html(response.success_fragment);
        }
    });
    
});

$(document).on('click', '.set-checklist', function(){
    let checked = $(this).is(':checked');
    let classes = $(this).attr('class');
    let item_second_class = classes.split(' ')[1];
    $('.' + item_second_class).attr('checked', checked);

    let set_id = $(this).attr('data-set_id');
    let field = $(this).attr('data-field');
    checkChecklistItem(set_id, field);
});

function checkChecklistItem(checklist_id, field)
{
    let token = $('#meta_token').attr('content');
    $.ajax({
        url: '/inbox/check-checklist-item',
        method: 'post',
        dataType: 'json',
        data: {'checklist_id': checklist_id, 'field': field},
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            $('#pct_edit_modal_error_messages').empty();
            
            if(response.errors)
                $('#pct_edit_modal_error_messages').html(response.errors_fragment);

        }
    }); 
}
$(document).on('click', '.set-status-change', function() {
    let doc_id = $(this).attr('data-document_id');
    let set_id = $(this).attr('data-set_id');
    let status = $(this).attr('data-status');

    let token = $('#meta_token').attr('content');
    $.ajax({
        url: '/inbox/change-set-status',
        method: 'post',
        dataType: 'json',
        data: {'document_id': doc_id, 'set_id': set_id, 'status': status},
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            $('#pct_edit_modal_error_messages').empty();
            $('#pct_edit_modal_success_message').empty();
            
            if(response.errors)
                $('#pct_edit_modal_error_messages').html(response.errors_fragment);
            else {
                $('#pct_edit_modal_success_message').html(response.success_fragment);
                if(status == 6) {
                    $('#in_authorization_btn').hide();
                    $('#authorization_btns_container').css('display', 'block');
                }
            }
        }
    });
});

/*Conditions form*/
$(document).on('submit', '#edit_conditions_form', function(e){
    e.preventDefault();

    let token = $('input[name=_token]').val();
    let conditions_id = $('#conditions_id').val();
    let serialized_form = $(this).serialize();

    $.ajax({
        url: '/inbox/update-set-conditions/' + conditions_id,
        method: 'post',
        dataType: 'json',
        data: serialized_form,
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            $('#pct_edit_modal_error_messages').empty();
            $('#pct_edit_modal_success_message').empty();
            
            if(response.errors)
                $('#pct_edit_modal_error_messages').html(response.errors_fragment);
            else 
                $('#pct_edit_modal_success_message').html(response.success_fragment);
        }
    }); 
});

$(document).on('click', '.condition-checkbox', function(){
    let item = $(this);
    let id = item.attr('data-id');
    let field = item.attr('data-field');

    $.get('/inbox/get-condition-value/' + id + '/'+ field, function(value) {
        $('#' + field + '_input').val(value);
    });
    
});