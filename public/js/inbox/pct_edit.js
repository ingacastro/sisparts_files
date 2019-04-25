$(document).on('click', '.edit-set', function() {

    let set_id = $(this).attr('data-id');
    let total_cost = $(this).attr('data-total_cost');
    let total_price = $(this).attr('data-total_price');
    let unit_price = $(this).attr('data-unit_price');
    let total_profit = $(this).attr('data-total_profit');
    
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
        }
    });

    $('#files_table').DataTable({
        iDisplayLength: 8,
        destroy: true,
        lengthChange: false,
        columns: [
            { data: "date", name: "date", searchable: false },
            { data: "name", name: "name" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
    });
});

$(document).on('submit', '#edit_budget_form', function(e){
    //e.preventDefault();
    let custom_utility_percentage = $('#custom_utility_percentage').val();
    let custom_utility_checkbox = $('#utility_checkbox_0'); //Other

    if(custom_utility_checkbox.is(':checked')) {
        custom_utility_checkbox.val('0_' + custom_utility_percentage);
    }
});