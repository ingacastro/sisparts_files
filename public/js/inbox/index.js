$(document).on('click', '.change-dealership', function(){
    let current_dealership = $(this).attr('data-buyer');
    $('#current_dealership').html('Cotizador actual: ' + current_dealership);
    let document_id = $(this).attr('data-document_id');
    $('#document_id').val(document_id);
});

$('#change_dealership_form').submit(function(e){
    e.preventDefault();
    let serialized_form = $(this).serialize();
    let token = $('meta[name=_token]').attr('content');
    $.ajax({
        url: '/inbox/change-dealership',
        dataType: 'json',
        method: 'post',
        headers: {'X-CSRF-TOKEN': token},
        data: serialized_form,
        success: function(response) {
            if(response.errors)
                $('#error_messages').html(response.errors_fragment);
            else
                location.reload();
        }
    });
});

function archiveDocument(e, id) {
    e.preventDefault();
    swal({
      title: "Archivar",
      text: "¿Está seguro de archivar el elemento seleccionado?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",     
      cancelButtonText: "Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: false
    },
    function(isConfirm) {
      if (isConfirm) { archiveRequest(id); }
    });
}

function archiveRequest(id) {
    let token = $('meta[name=_token]').attr('content');
    $.ajax({
        url: '/inbox/' + id + '/archive',
        method: 'post',
        headers: {'X-CSRF-TOKEN': token},
        success: function() {
            document.location.reload();
        }
    });
}

