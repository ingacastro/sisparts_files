 var root_url = $('#root_url').attr('content');
$(document).on('click', '.edit-set', function() {

    $('#pct_edit_modal_error_messages').html('');
    $('#pct_edit_modal_success_message').html('');

    let set_id = $(this).attr('data-set_id');
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
        url: root_url + '/inbox/get-set-tabs/' + set_id,
        method: 'get',
        dataType: 'json',
        success: function(response) {
            $('#tab_budget_content').html(response.budget_tab);
            $('#budget_tab_suppliers_select').select2({
                dropdownParent: $('#edit_set_modal')
            });
            applyFieldsMasks();
            $('#budget_total_cost').html(total_cost);
            $('#budget_total_price').html(total_price);
            $('#budget_unit_price').html(unit_price);
            $('#budget_total_profit').html(total_profit);
            
            $('#tab_conditions_content').html(response.conditions_tab);
            $('#tab_files_content').html(response.files_tab);
            $('#files_table_container').css('display', 'block');

            let set_supplies_id = $('#set_supplies_id').val();

            $('#set_edit_files_table').DataTable({
                serverSide: true,
                ajax: root_url + '/inbox/set-files/' + set_supplies_id,
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

function initSupplySetsTable() {
    let document_id = $('#document_id').attr('content');
    $('#supplies_table').DataTable({
        serverSide: true,
        ajax: {
            url: root_url + '/inbox/document-supplies',
            data: {
                'document_id': document_id,
                'route': 'inbox'
            }
        },
        bSort: true,
        destroy: true,
        columns: [
            { data: "number", name: "supplies.number" },
            { data: "supplier", name: "suppliers.trade_name" },
            { data: "manufacturer", name: "manufacturers.name" },
            { data: "products_amount", name: "documents_supplies.products_amount" },
            { data: "measurement_unit", name: "measurement", searchable: false },
            { data: "total_cost", name: "total_cost", searchable: false },
            { data: "total_price", name: "total_price", searchable: false },
            { data: "unit_price", name: "unit_price", searchable: false },
            { data: "status", name: "status" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
}


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
        url: root_url + '/inbox/update-set-budget/' + set_id,
        method: 'post',
        dataType: 'json',
        data: serialized_form,
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            $('#pct_edit_modal_error_messages').empty();
            $('#pct_edit_modal_success_message').empty();
            
            if(response.errors)
                $('#pct_edit_modal_error_messages').html(response.errors_fragment);
            else  {
                $('#budget_total_cost').html(response.budget_data.total_cost);
                $('#budget_total_price').html(response.budget_data.total_price);
                $('#budget_unit_price').html(response.budget_data.unit_price);
                $('#budget_total_profit').html(response.budget_data.total_profit);
                $('#pct_edit_modal_success_message').html(response.success_fragment);
                initSupplySetsTable();
            }
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
    checkChecklistItem(set_id, field, checked);
});

function checkChecklistItem(checklist_id, field, checked)
{
    let token = $('#meta_token').attr('content');
    let status = checked ? 'checked' : '';
    $.ajax({
        url: root_url + '/inbox/check-checklist-item',
        method: 'post',
        dataType: 'json',
        data: {'checklist_id': checklist_id, 'field': field, 'status': status},
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
    let checklist_serialized_form = $('#checklist_form').serializeArray();
    $.ajax({
        url: root_url + '/inbox/change-set-status',
        method: 'post',
        dataType: 'json',
        data: {'document_id': doc_id, 'set_id': set_id, 'status': status, 'checklist_form': checklist_serialized_form},
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            $('#pct_edit_modal_error_messages').empty();
            $('#pct_edit_modal_success_message').empty();
            
            if(response.errors)
                $('#pct_edit_modal_error_messages').html(response.errors_fragment);
            else {
                $('#pct_edit_modal_success_message').html(response.success_fragment);
                //console.log("Buttons hiding");
                $('#authorization_btns_container').hide();
                initSupplySetsTable();
/*                if(status == 6) {
                    $('#in_authorization_btn').hide();
                    $('#authorization_btns_container').css('display', 'block');
                }*/
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
        url: root_url + '/inbox/update-set-conditions/' + conditions_id,
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

    $.get(root_url + '/inbox/get-condition-value/' + id + '/'+ field, function(value) {
        $('#' + field + '_input').val(value);
    });
    
});