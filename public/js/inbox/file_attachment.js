 var root_url = $('#root_url').attr('content');
$('#file_attachment').click(function(){

    $('#sets_select2').select2({
        width: '100%',
        placeholder: 'Partes...'
    });

    initDocAttachmentsTable();

});

$(document).on('click', '.set-file-attachment', function() {
    let supply_id = $(this).attr('data-supply_id');
    $('#set_file_attachment_modal_supply_id').val(supply_id);
});

function initDocAttachmentsTable()
{
    let doc_id = $('#document_id').attr('content');
    $('#file_attachment_table').DataTable({
        destroy: true,
        serverSide: true,
        ajax: root_url + '/inbox/document-sets-files/' + doc_id,
        bSort: true,
        iDisplayLength: 6,
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

function initSetAttachmentsTable()
{
    let set_auto_id = $('#set_auto_id').val();
    $('#files_table').DataTable({
        serverSide: true,
        ajax: root_url + '/inbox/set-files/' + set_auto_id,
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

$('#set_file_attachment_from_pct_form').submit(function(e){
    e.preventDefault();
    let token = $('#set_file_attachment_from_pct_form > input[name=_token]').val();

    let form = document.getElementById('set_file_attachment_from_pct_form');
    let formData = new FormData(form);

    $.ajax({
        url: root_url + '/inbox/sets-file-attachment',
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
                $('#set_file_attachment_from_pct_error_messages').html(response.errors_fragment);
                return;
            }
            let file_obj = response.file;

            $('#set_file_attachment_from_pct_error_messages').css('display', 'none');
            $('#file_attachment_table').DataTable().row.add({
                'created_at': file_obj.created_at,
                'supplier': file_obj.supplier, 
                'actions': '<a href="/' + file_obj.path + '"' +
                                'class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air" download>' +
                                '<i class="fa fa-download"></i></a> ' +
                                '<button type="button" onClick="deleteDocument(event,' + file_obj.id +')"' + 
                                'class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air remove-document">' +
                                '<i class="fa fa-times"></i></button>'
            });
            $('#file_attachment_table').DataTable().draw(false);
            $('#set_file_attachment_from_pct_success_message').html(response.success_fragment);
            $('#set_file_attachment_from_pct_success_message').fadeIn('fast').delay(2000).fadeOut('fast');
        }
    });
});

$('#set_file_attachment_form').submit(function(e){
    e.preventDefault();
    let token = $('#set_file_attachment_form > input[name=_token]').val();

    let form = document.getElementById('set_file_attachment_form');
    let formData = new FormData(form);

    $.ajax({
        url: root_url + '/inbox/sets-file-attachment',
        method: 'post',
        dataType: 'json',
        headers: {'X-CSRF-TOKEN': token},
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.errors) {
                $('#set_file_attachment_error_messages').html(response.errors_fragment);
                return;
            }

            $('#set_file_attachment_error_messages').css('display', 'none');

            $('#set_file_attachment_success_message').html(response.success_fragment);
            $('#set_file_attachment_success_message').fadeIn('fast').delay(2000).fadeOut('fast');
        }
    });
});

function detachFile(e, files_id, type)
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
      if (isConfirm) { deleteRequest(files_id, type); }
    });
}

function deleteRequest(files_id, type) {
    let token = $('#meta_token').attr('content');
    $.ajax({
        url: root_url + '/inbox/supply-file-delete/' + files_id,
        method: 'delete',
        headers: {'X-CSRF-TOKEN': token},
        success: function(response) {
            if(response.errors) {
                $('#set_file_attachment_from_pct_error_messages').html(response.errors_fragment);
                return;
            }
            
            if(type == 1)
                initDocAttachmentsTable();
            else
                initSetAttachmentsTable();

            $('#set_file_attachment_from_pct_success_message').html(response.success_fragment);
            $('#set_file_attachment_from_pct_success_message').fadeIn('fast').delay(2000).fadeOut('fast');
        }
    });
}