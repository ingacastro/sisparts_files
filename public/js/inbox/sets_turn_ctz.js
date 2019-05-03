$('#sets_turn_ctz').click(function(){
    initSetsCTZTable();
});

function initSetsCTZTable()
{
    let doc_id = $('#document_id').attr('content');

    $('#sets_turn_ctz_table').DataTable({
        serverSide: true,
        ajax: {
            url: '/inbox/document-supplies',
            data: {'document_id': doc_id}
        },
        iDisplayLength: 6,
        lengthChange: false,
        bSort: true,
        destroy: true,
        columns: [
            { data: "number", name: "number" },
            { data: "supplier", name: "supplier" },
            { data: "products_amount", name: "products_amount" },
            { data: "measurement_unit_code", name: "measurement_unit_code" },
            { data: "total_cost", name: "total_cost" },
            { data: "total_price", name: "total_price" },
            { data: "status", name: "status" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        }, 
    });
}

/*$('#file_attachment_form').submit(function(e){
    e.preventDefault();
    let token = $('#file_attachment_form > input[name=_token]').val();

    let form = document.getElementById('file_attachment_form');
    let formData = new FormData(form);

    $.ajax({
        url: '/inbox/sets-file-attachment',
        type: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data: formData,
        iDisplayLength: 6,
        lengthChange: false,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.errors) {
                $('#file_attachment_error_messages').html(response.errors_fragment);
                return;
            }

            let file_obj = response.file;

            $('#error_messages').css('display', 'none');
            $('#file_attachment_table').DataTable().row.add({
                'created_at': file_obj.created_at,
                'manufacturer': file_obj.manufacturer, 
                'actions': '<a href="/' + file_obj.path + '"' +
                                'class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air" download>' +
                                '<i class="fa fa-download"></i></a> ' +
                                '<button type="button" onClick="deleteDocument(event,' + file_obj.id +')"' + 
                                'class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air remove-document">' +
                                '<i class="fa fa-times"></i></button>'
            });
            $('#file_attachment_table').DataTable().draw(false);
            $('#file_attachment_success_message').html(response.success_fragment);
            $('#file_attachment_success_message').fadeIn('fast').delay(2000).fadeOut('fast');
        }
    });
});*/
