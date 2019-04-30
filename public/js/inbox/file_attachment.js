$('#file_attachment').click(function(){

    $('#sets_select2').select2({
        width: '100%',
        placeholder: 'Seleccionar...'
    });

    initDocAttachmentsTable();

});

function initDocAttachmentsTable()
{
    let doc_id = $('#document_id').attr('content');
    $('#file_attachment_table').DataTable({
        destroy: true,
        serverSide: true,
        ajax: '/inbox/document-sets-files/' + doc_id,
        bSort: true,
        iDisplayLength: 6,
        lengthChange: false,
        columns: [
            { data: "created_at", name: "created_at" },
            { data: "manufacturer", name: "manufacturer" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
    });
}

function initSetAttachmentsTable()
{
    let set_auto_id = $('#set_auto_id').val();
    $('#files_table').DataTable({
        serverSide: true,
        ajax: '/inbox/set-files/' + set_auto_id,
        iDisplayLength: 6,
        destroy: true,
        lengthChange: false,
        columns: [
            { data: "created_at", name: "created_at" },
            { data: "manufacturer", name: "manufacturer" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
        },
    });
}

$('#file_attachment_form').submit(function(e){
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
});

function detachFile(e, documents_supplies_id, files_id, type)
{
    e.preventDefault();
    swal({
      title: "Eliminar adjunto",
      text: "¿Seguro que deseas eliminar este adjunto?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: true,
    },
    function(isConfirm) {
      if (isConfirm) { deleteRequest(documents_supplies_id, files_id, type); }
    });
}

function deleteRequest(documents_supplies_id, files_id, type) {
    let token = $('#meta_token').attr('content');
    $.ajax({
        url: '/inbox/set-file-detach/' + documents_supplies_id + '/' + files_id,
        method: 'delete',
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            if(response.errors) {
                $('#file_attachment_error_messages').html(response.errors_fragment);
                return;
            }
            if(type == 1)
                initDocAttachmentsTable();
            else
                initSetAttachmentsTable();
            $('#file_attachment_success_message').html(response.success_fragment);
            $('#file_attachment_success_message').fadeIn('fast').delay(2000).fadeOut('fast');
        }
    });
}