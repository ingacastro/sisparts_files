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

/* Archive or cancel a Document/PCT */
function archiveOrLockDocument(e, id, action) {
    e.preventDefault();

    let action_name = action == 1 ? 'archivar' : 'cancelar';

    swal({
      title: action_name.charAt(0).toUpperCase() + action_name.slice(1),
      text: "¿Está seguro de " + action_name + " el documento seleccionado?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",     
      cancelButtonText: "Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: false
    },
    function(isConfirm) {
      if (isConfirm) { archiveOrLockRequest(id, action); }
    });
}

function archiveOrLockRequest(id, action) {
    let token = $('meta[name=_token]').attr('content');
    $.ajax({
        url: '/inbox/' + id + '/archive-lock/' + action,
        method: 'post',
        headers: {'X-CSRF-TOKEN': token},
        success: function() {
            document.location.reload();
        }
    });
}

/*Removes cancel mark*/
function unlockDocument(e, id) {
    e.preventDefault();

    swal({
      title: 'Reactivar',
      text: "¿Está seguro de reactivar el documento seleccionado?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",     
      cancelButtonText: "Cancelar",
      confirmButtonText: "Aceptar",
      closeOnConfirm: false
    },
    function(isConfirm) {
      if (isConfirm) { unlockRequest(id); }
    });
}

function unlockRequest(id) {
    let token = $('meta[name=_token]').attr('content');
    $.ajax({
        url: '/inbox/' + id + '/unlock',
        method: 'post',
        headers: {'X-CSRF-TOKEN': token},
        success: function() {
            document.location.reload();
        }
    });
}
