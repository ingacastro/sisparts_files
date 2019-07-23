 var root_url = $('#root_url').attr('content');
$(document).on('click', '.set-rejection', function(){
	$('#rejection_modal_set_id').val($(this).attr('data-set_id'));
});

$('#set_rejection_form').submit(function(e){
	e.preventDefault();

	let serialized_form = $(this).serialize();
	let token = $('input[name=_token]').val();

	$.ajax({
		url: root_url + '/inbox/reject-set',
		method: 'post',
		data: serialized_form,
		headers: {'X-CSRF-TOKEN': token},
		dataType: 'json',
		success: function(response) {
            $('#set_rejection_modal_error_messages').empty();
            $('#pct_edit_modal_success_message').empty();
            
            if(response.errors) 
                $('#set_rejection_modal_error_messages').html(response.errors_fragment);
            else {
                $('#pct_edit_modal_success_message').html(response.success_fragment);
                $('#authorization_btns_container').hide();
                $('#set_rejection_modal').modal('hide');
            }
		}
	});
});