$(document).on('click', '.edit-set', function() {

    let set_id = $(this).attr('data-id');
    
    //Set tabs
    $.ajax({
        url: '/inbox/get-set-tabs/' + set_id,
        method: 'get',
        dataType: 'json',
        success: function(response) {
            $('#tab_budget_content').html(response.budget_tab);
            applyFieldsMasks();
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